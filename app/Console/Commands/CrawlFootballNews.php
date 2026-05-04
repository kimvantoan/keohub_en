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
    protected $signature = 'crawl:news {--limit=5} {--source=https://www.espn.com/espn/rss/soccer/news}';

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

        $this->info("Bắt đầu lấy dữ liệu từ: $sourceUrl");

        // 1. Tạo hoặc lấy Category "Bóng đá Quốc tế"
        $category = Category::firstOrCreate(
            ['slug' => 'bong-da-quoc-te'],
            [
                'name' => 'Bóng đá Quốc tế'
            ]
        );
        $this->info("Đã dùng chuyên mục: " . $category->name);

        // 2. Fetch RSS
        try {
            $response = Http::withoutVerifying()->get($sourceUrl);
            if (!$response->successful()) {
                $this->error('Không thể truy cập RSS feed.');
                return;
            }

            $xml = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);

            if (!$xml || !isset($xml->channel->item)) {
                $this->error('RSS feed không đúng định dạng.');
                return;
            }
        } catch (\Exception $e) {
            $this->error('Lỗi khi đọc RSS: ' . $e->getMessage());
            return;
        }

        $items = $xml->channel->item;
        $count = 0;

        foreach ($items as $item) {
            if ($count >= $limit) break;

            $title = (string) $item->title;
            $link = (string) $item->link;
            $description = (string) $item->description;
            $pubDate = date('Y-m-d H:i:s', strtotime((string) $item->pubDate));

            $this->info("Đang xử lý: $title");

            // Extract Image
            $imageUrl = null;
            if (isset($item->enclosure)) {
                $imageUrl = (string) $item->enclosure['url'];
            }
            // Check media:content or media:thumbnail
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

            // Cào bài viết gốc
            $htmlContent = $this->scrapeFullArticle($link);

            // Tìm ảnh từ HTML nếu RSS không có
            if (!$imageUrl && strlen($htmlContent) > 50) {
                $imageUrl = $this->extractImageFromHtml($htmlContent);
            }

            // Generate content using Google Free API
            $geminiData = $this->translateWithGoogleFree($title, $description, $link, $htmlContent);
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
                Article::create([
                    'category_id' => $category->id,
                    'title' => $translatedTitle,
                    'slug' => $slug,
                    'content' => $geminiData['content'] ?? '',
                    'thumbnail' => $thumbnailPath,
                    'meta_title' => $geminiData['meta_title'] ?? $translatedTitle,
                    'meta_description' => $geminiData['meta_description'] ?? '',
                    'is_published' => true,
                    'published_at' => $pubDate,
                ]);

                $this->info("Đã lưu thành công: $translatedTitle");
                $count++;
            } catch (\Exception $e) {
                $this->error("Lỗi khi lưu bài viết: " . $e->getMessage());
            }
        }

        $this->info("Hoàn tất! Đã lưu $count bài viết mới.");
    }

    private function translateWithGoogleFree($title, $summary, $link, $htmlContent)
    {
        $translatedTitle = $this->translateText($title);
        $translatedSummary = $this->translateText($summary);

        if (!$translatedTitle || !$translatedSummary) {
            return null;
        }

        $translatedContentHTML = '';
        
        if (strlen($htmlContent) > 50) {
            $extractedData = $this->extractContentFromHtml($htmlContent);
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
            $response = Http::withoutVerifying()->get($url);
            if (!$response->successful()) return '';
            
            $html = $response->body();
            return $html;
        } catch (\Exception $e) {
            return '';
        }
    }

    private function extractContentFromHtml($html)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);
        
        $elements = $xpath->query('//p | //img');
        $content = '';
        $imageMap = [];
        $imgCount = 0;
        
        foreach ($elements as $el) {
            if ($el->nodeName === 'p') {
                $text = trim($el->nodeValue);
                if (strlen($text) > 40) { 
                    $content .= "<p>" . $text . "</p>\n";
                }
            } elseif ($el->nodeName === 'img') {
                $src = $el->getAttribute('data-src');
                if (empty($src)) $src = $el->getAttribute('data-default-src');
                if (empty($src)) $src = $el->getAttribute('src');
                
                $width = (int) $el->getAttribute('width');
                $height = (int) $el->getAttribute('height');
                
                // Bỏ qua ảnh quá nhỏ (như icon) nếu có kích thước
                if (($width > 0 && $width < 150) || ($height > 0 && $height < 150)) {
                    continue;
                }
                
                if (!empty($src) && str_starts_with($src, 'http')) {
                    $lowerSrc = strtolower($src);
                    // Bỏ qua logo, icon, avatar, tracking pixel
                    if (Str::contains($lowerSrc, ['logo', 'icon', 'avatar', 'profile', 'author', 'tracker', '1x1', '.svg'])) {
                        continue;
                    }

                    // Tải ảnh về
                    $slug = Str::slug('content-img-' . time() . '-' . uniqid());
                    $localPath = $this->downloadImage($src, $slug);
                    if ($localPath) {
                        // Kiểm tra kích thước thật của ảnh
                        $fullLocalPath = storage_path('app/public/' . $localPath);
                        $size = @getimagesize($fullLocalPath);
                        if ($size && ($size[0] < 200 || $size[1] < 200)) {
                            // Ảnh quá nhỏ, có thể là icon hoặc logo
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
            $response = Http::withoutVerifying()->get($url);
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
            $imageContent = Http::withoutVerifying()->get($url)->body();
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
