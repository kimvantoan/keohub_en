<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CrawlFootballNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:news {--limit=5} {--source=https://www.si.com/soccer} {--category=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl latest football news and translate via Gemini 1.5 Pro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $sourceUrl = $this->option('source');
        $categoryOption = $this->option('category');

        $this->info("Bắt đầu lấy dữ liệu từ: $sourceUrl");

        // 1. Lấy tên Category từ command option, mặc định là "Bóng đá Quốc tế" nếu không truyền
        $categoryName = $categoryOption ?: 'Bóng đá Quốc tế';
        $categorySlug = Str::slug($categoryName);

        $category = Category::firstOrCreate(
            ['slug' => $categorySlug],
            ['name' => $categoryName]
        );
        $this->info("Đã dùng chuyên mục: " . $category->name);

        // 2. Fetch RSS
        try {
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ])
                ->get($sourceUrl);
            if (!$response->successful()) {
                $this->error('Không thể truy cập RSS feed.');
                return;
            }

            $body = $response->body();
            $xml = @simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);

            $articles = [];

            if ($xml && isset($xml->channel->item)) {
                // Parse RSS XML
                foreach ($xml->channel->item as $item) {
                    $articles[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'description' => (string) $item->description,
                        'pubDate' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                        'item' => $item,
                    ];
                }
            } else if (stripos($body, '<html') !== false) {
                // Phân tích HTML để cào bài trực tiếp từ link (VD: si.com/soccer)
                $dom = new \DOMDocument();
                @$dom->loadHTML($body, LIBXML_NOERROR | LIBXML_NOWARNING);
                $xpath = new \DOMXPath($dom);
                
                $links = $xpath->query('//a');
                $seenLinks = [];
                
                foreach ($links as $link) {
                    $href = $link->getAttribute('href');
                    $title = trim(strip_tags($link->nodeValue));
                    
                    if (!empty($href) && strlen($href) > 40 && strlen($title) > 15 && Str::contains($href, '/soccer/') && substr_count($href, '-') >= 3) {
                        if (Str::contains($href, ['/archive', '/standings', '/stats', '/newsletters', '/tickets'])) continue;
                        
                        // Chuẩn hóa URL tuyệt đối
                        if (str_starts_with($href, '/')) {
                            $parsedSource = parse_url($sourceUrl);
                            $href = $parsedSource['scheme'] . '://' . $parsedSource['host'] . $href;
                        }
                        
                        if (!isset($seenLinks[$href])) {
                            $seenLinks[$href] = true;
                            $articles[] = [
                                'title' => $title,
                                'link' => $href,
                                'description' => '', // Lấy lúc cào nội dung
                                'pubDate' => now()->toDateTimeString(),
                                'item' => null,
                            ];
                        }
                    }
                }
            }

            if (empty($articles)) {
                $this->error('Không tìm thấy bài viết nào từ nguồn (RSS/HTML không hợp lệ hoặc không có dữ liệu).');
                return;
            }
            
        } catch (\Exception $e) {
            $this->error('Lỗi khi đọc Nguồn: ' . $e->getMessage());
            return;
        }

        $count = 0;

        foreach ($articles as $article) {
            if ($count >= $limit) break;

            $title = $article['title'];
            $link = $article['link'];
            $description = $article['description'];
            $pubDate = $article['pubDate'];

            $this->info("Đang xử lý: $title");

            // Cào bài viết gốc
            $htmlContent = $this->scrapeFullArticle($link);

            // Extract Image - Ưu tiên từ HTML (thường là og:image chất lượng cao)
            $imageUrl = null;
            if (strlen($htmlContent) > 50) {
                $imageUrl = $this->extractImageFromHtml($htmlContent);
            }

            // Nếu không có ảnh từ HTML, thử lấy từ RSS
            if (!$imageUrl && $article['item']) {
                $item = $article['item'];
                if (isset($item->enclosure)) {
                    $imageUrl = (string) $item->enclosure['url'];
                }
                if (!$imageUrl) {
                    $namespaces = $item->getNamespaces(true);
                    if (isset($namespaces['media'])) {
                        $media = $item->children($namespaces['media']);
                        if (isset($media->content)) {
                            $imageUrl = (string) $media->content->attributes()->url;
                        } elseif (isset($media->thumbnail)) {
                            $imageUrl = (string) $media->thumbnail->attributes()->url;
                        }
                    }
                }
            }

            // Generate content using Google Free API
            $geminiData = $this->translateWithGoogleFree($title, $description, $link, $htmlContent, $imageUrl);
            if (!$geminiData) {
                $this->error("Lỗi khi dùng Google Dịch cho bài: $title. Bỏ qua.");
                continue;
            }

            $translatedTitle = $geminiData['title'] ?? $title;
            $slug = Str::slug($translatedTitle);

            // Kiểm tra trùng lặp
            if (Article::where('slug', $slug)->exists()) {
                $this->warn("Bài viết đã tồn tại (slug: $slug). Bỏ qua.");
                continue;
            }

            // Tải hình ảnh về Storage
            $thumbnailPath = null;
            if ($imageUrl) {
                $thumbnailPath = $this->downloadImage($imageUrl, $slug);
            }

            // Lưu vào DB
            try {
                $article = Article::create([
                    'title' => $translatedTitle,
                    'slug' => $slug,
                    'content' => $geminiData['content'] ?? '',
                    'thumbnail' => $thumbnailPath,
                    'meta_title' => $geminiData['meta_title'] ?? $translatedTitle,
                    'meta_description' => $geminiData['meta_description'] ?? '',
                    'is_published' => true,
                    'published_at' => $pubDate,
                ]);

                // Gắn bài viết vào chuyên mục
                $article->categories()->sync([$category->id]);

                $this->info("Đã lưu thành công: $translatedTitle");
                $count++;
            } catch (\Exception $e) {
                $this->error("Lỗi khi lưu bài viết: " . $e->getMessage());
            }
        }

        $this->info("Hoàn tất! Đã lưu $count bài viết mới.");
    }

    private function translateWithGoogleFree($title, $summary, $link, $htmlContent, $imageUrl = null)
    {
        $translatedTitle = $this->translateText($title);
        $translatedSummary = $summary ? $this->translateText($summary) : '';

        if (!$translatedTitle) {
            return null;
        }

        $translatedContentHTML = '';
        
        if (strlen($htmlContent) > 50) {
            $extractedData = $this->extractContentFromHtml($htmlContent, $imageUrl);
            $extractedText = $extractedData['text'];
            $imageMap = $extractedData['imageMap'];

            // Dịch đoạn văn bản cào được
            $translatedContentHTML = $this->translateHtmlChunks($extractedText);
            
            // Khôi phục hình ảnh từ placeholder
            foreach ($imageMap as $placeholder => $imgHtml) {
                // Thay thế placeholder chuẩn
                $translatedContentHTML = str_replace($placeholder, $imgHtml, $translatedContentHTML);
                
                // Thay thế phòng trường hợp Google thêm khoảng trắng ví dụ: [ [ IMG_PLACEHOLDER_0 ] ]
                $pattern = '/' . str_replace(['[', ']'], ['\[\s*', '\s*\]'], $placeholder) . '/i';
                $translatedContentHTML = preg_replace($pattern, $imgHtml, $translatedContentHTML);
            }
            
            if (empty($translatedSummary)) {
                $translatedSummary = mb_substr(trim(strip_tags($translatedContentHTML)), 0, 160) . '...';
            }
        } else {
            // Nếu không cào được thì dùng summary
            $translatedContentHTML = "<p>" . nl2br(htmlspecialchars($translatedSummary)) . "</p>";
        }

        return [
            'title' => $translatedTitle,
            'content' => $translatedContentHTML,
            'meta_title' => mb_substr($translatedTitle, 0, 60),
            'meta_description' => mb_substr($translatedSummary, 0, 160)
        ];
    }

    private function scrapeFullArticle($url)
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ])
                ->get($url);
            if (!$response->successful()) return '';
            
            $html = $response->body();
            return $html;
        } catch (\Exception $e) {
            return '';
        }
    }

    private function extractContentFromHtml($html, $imageUrl = null)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);

        // Xóa các thẻ rác (video embed, author bio, ads, newsletter) trước khi lấy nội dung
        $junkSelectors = [
            '//div[contains(@class, "author")]',
            '//div[contains(@class, "bio")]',
            '//div[contains(@class, "video")]',
            '//div[contains(@id, "connatix")]',
            '//div[contains(@class, "jwplayer")]',
            '//div[contains(@class, "ad-")]',
            '//div[contains(@class, "newsletter")]',
            '//section[contains(@class, "author")]',
            '//figure[contains(@class, "author")]',
            '//iframe',
            '//script',
            '//style'
        ];
        
        foreach ($junkSelectors as $selector) {
            foreach ($xpath->query($selector) as $node) {
                if ($node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
            }
        }
        
        $elements = $xpath->query('//p | //img');
        $content = '';
        $imageMap = [];
        $imgCount = 0;
        
        foreach ($elements as $el) {
            if ($el->nodeName === 'p') {
                $text = trim($el->nodeValue);
                $lowerText = strtolower($text);
                
                // Bỏ qua các đoạn text rác ở cuối bài (author bio, copyright, betting warnings)
                $spamKeywords = ['©', 'all rights reserved', '1-800-gambler', 'is a registered trademark', 'freelance', 'journalist', 'editor for', 'subscribe to', 'fubotv', 'correspondent', 'is an expert'];
                $isSpam = false;
                foreach ($spamKeywords as $kw) {
                    if (Str::contains($lowerText, $kw)) {
                        $isSpam = true;
                        break;
                    }
                }
                
                if ($isSpam) {
                    // Xóa ảnh liền trước đó (ảnh tác giả) nếu có
                    $content = preg_replace('/<p>\[\[IMG_PLACEHOLDER_\d+\]\]<\/p>\s*$/', '', $content);
                    continue;
                }

                if (strlen($text) > 40) { 
                    $content .= "<p>" . $text . "</p>\n";
                }
            } elseif ($el->nodeName === 'img') {
                $src = $el->getAttribute('data-src');
                if (empty($src)) $src = $el->getAttribute('data-default-src');
                
                // Trích xuất ảnh lớn từ thẻ <source> nếu nằm trong <picture> (đặc biệt cho si.com, 90min)
                if (empty($src) || Str::contains($src, 'w_16')) {
                    if ($el->parentNode && $el->parentNode->nodeName === 'picture') {
                        $sources = $xpath->query('./source', $el->parentNode);
                        if ($sources->length > 0) {
                            $srcset = $sources->item($sources->length - 1)->getAttribute('srcset');
                            if (!empty($srcset)) {
                                $parts = explode(',', $srcset);
                                $lastPart = trim(end($parts));
                                $urlPart = explode(' ', $lastPart)[0];
                                if (!empty($urlPart)) {
                                    $src = $urlPart;
                                }
                            }
                        }
                    }
                }
                
                if (empty($src)) $src = $el->getAttribute('src');
                
                // Mẹo cho MinuteMedia/SI: Nếu ảnh vẫn là dạng thu nhỏ w_16, cố gắng tăng lên w_1080
                if (Str::contains($src, 'w_16')) {
                    $src = str_replace('w_16', 'w_1080', $src);
                }
                
                $width = (int) $el->getAttribute('width');
                $height = (int) $el->getAttribute('height');
                
                // Bỏ qua ảnh quá nhỏ (như icon) nếu có kích thước
                if (($width > 0 && $width < 150) || ($height > 0 && $height < 150)) {
                    continue;
                }
                
                if (!empty($src) && str_starts_with($src, 'http')) {
                    $lowerSrc = strtolower($src);
                    // Bỏ qua logo, icon, avatar, tracking pixel, bio photo
                    if (Str::contains($lowerSrc, ['logo', 'icon', 'avatar', 'profile', 'author', 'tracker', '1x1', '.svg', 'bio'])) {
                        continue;
                    }

                    // Kiểm tra xem ảnh này có giống với ảnh thumbnail (hero image) không
                    if ($imageUrl) {
                        $srcBasename = pathinfo(parse_url($src, PHP_URL_PATH), PATHINFO_FILENAME);
                        $imgUrlBasename = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_FILENAME);
                        
                        // Nếu tên file giống nhau hoặc là chuỗi con của nhau (bỏ qua các tham số resize trên URL)
                        if (!empty($srcBasename) && !empty($imgUrlBasename)) {
                            if (Str::contains($srcBasename, $imgUrlBasename) || Str::contains($imgUrlBasename, $srcBasename)) {
                                continue; // Bỏ qua ảnh này để không bị lặp 2 ảnh giống nhau
                            }
                        }
                    }

                    // Tải ảnh về
                    $slug = Str::slug('content-img-' . time() . '-' . uniqid());
                    $localPath = $this->downloadImage($src, $slug);
                    if ($localPath) {
                        // Kiểm tra kích thước thật của ảnh và tính hợp lệ
                        $fullLocalPath = storage_path('app/public/' . $localPath);
                        $size = @getimagesize($fullLocalPath);
                        if (!$size || $size[0] < 200 || $size[1] < 200) {
                            // Ảnh bị lỗi (không đọc được) hoặc quá nhỏ
                            @unlink($fullLocalPath);
                            continue;
                        }

                        $localUrl = Storage::url($localPath);
                        $imgHtml = "<figure class=\"my-4\"><img src=\"{$localUrl}\" alt=\"Article image\" class=\"w-full h-auto object-cover rounded-lg shadow-sm\"></figure>";
                        $placeholder = "[[IMG_PLACEHOLDER_{$imgCount}]]";
                        
                        $imageMap[$placeholder] = $imgHtml;
                        $content .= "<p>{$placeholder}</p>\n";
                        $imgCount++;
                    }
                }
            }
        }
        return ['text' => $content, 'imageMap' => $imageMap];
    }

    private function extractImageFromHtml($html)
    {
        if (empty($html)) return null;
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);
        
        // Thử tìm thẻ meta og:image trước (ảnh đại diện chuẩn xác nhất)
        $metas = $xpath->query('//meta[@property="og:image"]');
        if ($metas->length > 0) {
            return $metas->item(0)->getAttribute('content');
        }
        
        // Hoặc tìm thẻ meta twitter:image
        $metas = $xpath->query('//meta[@name="twitter:image"]');
        if ($metas->length > 0) {
            return $metas->item(0)->getAttribute('content');
        }

        // Nếu không có, tìm thẻ img lớn nhất hoặc đầu tiên
        $images = $xpath->query('//img');
        if ($images->length > 0) {
            foreach ($images as $img) {
                $src = $img->getAttribute('src');
                if (!empty($src) && str_starts_with($src, 'http')) {
                    return $src;
                }
            }
        }
        return null;
    }

    private function translateHtmlChunks($htmlContent)
    {
        // Tách theo thẻ </p>
        $parts = explode("</p>", $htmlContent);
        $translatedHtml = '';
        $currentChunk = '';
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) continue;
            
            $part .= "</p>";
            
            if (strlen($currentChunk) + strlen($part) > 2000) {
                // Dịch chunk hiện tại
                $translatedHtml .= $this->translateText($currentChunk) . "\n";
                $currentChunk = $part;
            } else {
                $currentChunk .= $part . "\n";
            }
        }
        
        if (!empty($currentChunk)) {
            $translatedHtml .= $this->translateText($currentChunk) . "\n";
        }
        
        // Phục hồi lại các thẻ <p> bị Google dịch làm hỏng
        $translatedHtml = str_ireplace(['< p >', '<p >', '< p>'], '<p>', $translatedHtml);
        $translatedHtml = str_ireplace(['< / p >', '</ p>', '</p >', '< /p>'], '</p>', $translatedHtml);
        
        return $translatedHtml;
    }

    private function translateText($text)
    {
        if (empty(trim(strip_tags($text)))) return '';
        
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=vi&dt=t&q=" . urlencode($text);
        
        try {
            $response = Http::withoutVerifying()->timeout(60)->get($url);
            if ($response->successful()) {
                $json = $response->json();
                $translated = '';
                if (isset($json[0]) && is_array($json[0])) {
                    foreach ($json[0] as $segment) {
                        if (isset($segment[0])) {
                            $translated .= $segment[0];
                        }
                    }
                    return $translated;
                }
            }
        } catch (\Exception $e) {
            $this->error("Lỗi Google Translate API: " . $e->getMessage());
        }
        
        return null;
    }

    private function downloadImage($url, $slug)
    {
        try {
            $imageContent = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ])
                ->get($url)
                ->body();
            if ($imageContent) {
                // Lấy đuôi mở rộng từ URL
                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (!$extension || !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $extension = 'jpg'; // Mặc định
                }

                $filename = 'articles/' . $slug . '-' . time() . '.' . $extension;

                // Lưu vào storage/app/public/articles/...
                Storage::disk('public')->put($filename, $imageContent);
                return $filename;
            }
        } catch (\Exception $e) {
            $this->error("Không thể tải ảnh từ URL: $url");
        }
        return null;
    }
}
