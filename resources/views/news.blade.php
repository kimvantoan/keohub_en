@extends('layouts.app')

@section('title', 'Tin Tức Bóng Đá Mới Nhất | LichDaBong')

@section('content')
<div class="bg-white min-h-screen md:py-8 py-0">
    <!-- Centered Container with empty padding on sides -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Section (Featured 3-Column Grid) -->
        @if($topArticles->count() >= 5)
        <div class="mb-12 border-b-2 border-gray-200 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Left Column (2 small articles) -->
                <div class="flex flex-col gap-6">
                    @foreach($topArticles->slice(1, 2) as $article)
                    <a href="{{ route('news.show', $article->slug) }}" class="block group">
                        <div class="w-full">
                            <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?auto=format&fit=crop&q=80&w=400' }}" alt="{{ $article->title }}" class="w-full h-auto object-cover mb-3">
                            <h3 class="text-[15px] font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors">
                                {{ $article->title }}
                            </h3>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Middle Column (1 large featured article) -->
                @php $featured = $topArticles->first(); @endphp
                <div class="md:col-span-2 border-x border-gray-200 px-4 md:px-6">
                    <a href="{{ route('news.show', $featured->slug) }}" class="block group">
                        <div class="w-full relative">

                            <img src="{{ $featured->thumbnail ? Storage::url($featured->thumbnail) : 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $featured->title }}" class="w-full h-auto object-cover mb-4">
                            <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight group-hover:text-primary transition-colors">
                                {{ $featured->title }}
                            </h2>
                            <p class="text-gray-600 mt-3 text-sm leading-relaxed line-clamp-3">
                                {{ $featured->meta_description ?: Str::limit(html_entity_decode(strip_tags($featured->content), ENT_QUOTES, 'UTF-8'), 200) }}
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Right Column (2 small articles) -->
                <div class="flex flex-col gap-6">
                    @foreach($topArticles->slice(3, 2) as $article)
                    <a href="{{ route('news.show', $article->slug) }}" class="block group">
                        <div class="w-full">
                            <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&q=80&w=400' }}" alt="{{ $article->title }}" class="w-full h-auto object-cover mb-3">
                            <h3 class="text-[15px] font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors">
                                {{ $article->title }}
                            </h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Body Section (Main Content) -->
        <div class="max-w-4xl mx-auto mt-4 md:mt-8">
            <!-- LATEST NEWS -->
            <div class="mb-12">
                <h2 class="text-xl font-black text-gray-900 uppercase border-b-2 border-gray-900 pb-2 mb-6 inline-block">
                    TIN TỨC MỚI NHẤT
                </h2>

                <div class="flex flex-col gap-6" id="latest-news-container">
                    @include('partials.latest_news_items')
                </div>

                @if($latestNews->hasMorePages())
                <div class="text-center mt-8">
                    <button data-url="{{ $latestNews->nextPageUrl() }}" data-container="latest-news-container" class="load-more-btn bg-gray-900 text-white font-bold uppercase tracking-widest px-8 py-3 hover:bg-primary transition-colors inline-block shadow-sm cursor-pointer">
                        Xem Thêm
                    </button>
                </div>
                @endif

                @if($latestNews->isEmpty() && $topArticles->isEmpty())
                <p class="text-gray-500 italic">Không tìm thấy bài viết nào.</p>
                @endif
            </div>

            <!-- Category Blocks Section -->
            @if(isset($categoryBlocks) && $categoryBlocks->count() > 0)
            <div class="flex flex-col gap-12 mb-16">
                @foreach($categoryBlocks as $category)
                @if($category->articles->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-6 border-b-2 border-gray-900 pb-2">
                        <h2 class="text-xl font-black text-gray-900 uppercase m-0">
                            {{ $category->name }}
                        </h2>
                    </div>

                    <div class="flex flex-col gap-6" id="cat-container-{{ $category->id }}">
                        @foreach($category->articles as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="block group">
                            <div class="flex flex-col sm:flex-row gap-5 border-b border-gray-100 pb-6">
                                <!-- Image Left -->
                                <div class="w-full sm:w-1/3 flex-shrink-0 relative">
                                    <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1518605368461-1e1e12739502?auto=format&fit=crop&q=80&w=400' }}" alt="{{ $article->title }}" class="w-full h-auto object-cover aspect-video shadow-sm group-hover:opacity-90 transition-opacity">
                                </div>
                                <!-- Text Right -->
                                <div class="w-full sm:w-2/3 flex flex-col justify-start pt-1">
                                    <h3 class="text-lg font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors mb-2">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed mb-3">
                                        {{ $article->meta_description ?: Str::limit(html_entity_decode(strip_tags($article->content), ENT_QUOTES, 'UTF-8'), 150) }}
                                    </p>
                                    <div class="text-xs text-gray-400 font-medium mt-auto">
                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    @if($category->articles_count > 10)
                    <div class="text-center mt-8">
                        <button data-url="{{ route('news.category.load_more', ['id' => $category->id, 'page' => 2]) }}" data-container="cat-container-{{ $category->id }}" class="load-more-btn bg-gray-900 text-white font-bold uppercase tracking-widest px-8 py-3 hover:bg-primary transition-colors inline-block shadow-sm cursor-pointer">
                            Xem Thêm
                        </button>
                    </div>
                    @endif
                </section>
                @endif
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtns = document.querySelectorAll('.load-more-btn');

        loadMoreBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                const containerId = this.getAttribute('data-container');
                const container = document.getElementById(containerId);

                if (!url || !container) return;

                // Change button state
                const originalText = this.innerHTML;
                this.innerHTML = 'Đang tải...';
                this.disabled = true;
                this.classList.add('opacity-50', 'cursor-not-allowed');

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Append new items
                        if (data.html) {
                            container.insertAdjacentHTML('beforeend', data.html);
                        }

                        // Update or hide button
                        if (data.next_url) {
                            this.setAttribute('data-url', data.next_url);
                            this.innerHTML = originalText;
                            this.disabled = false;
                            this.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            this.remove(); // Remove button if no more pages
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching more news:', error);
                        this.innerHTML = originalText;
                        this.disabled = false;
                        this.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
            });
        });
    });
</script>
@endsection