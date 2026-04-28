@extends('layouts.app')

@section('title', 'Latest News | KeoHub')

@section('content')
<div class="bg-white min-h-screen py-8">
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
                            <h3 class="text-[15px] font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors">
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
                            <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                {{ $featured->title }}
                            </h2>
                            <p class="text-gray-600 mt-3 text-sm leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($featured->content), 200) }}
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
                            <h3 class="text-[15px] font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $article->title }}
                            </h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Body Section (Main Content & Sidebar) -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Main Column (LATEST NEWS) -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-xl font-black text-gray-900 uppercase border-b-2 border-gray-900 pb-2 mb-6 inline-block">
                    LATEST NEWS
                </h2>
                
                <div class="flex flex-col gap-6" id="latest-news-container">
                    @include('partials.latest_news_items')
                </div>

                @if($latestNews->hasMorePages())
                    <div class="text-center mt-8">
                        <button id="load-more-btn" data-url="{{ $latestNews->nextPageUrl() }}" class="bg-gray-900 text-white font-bold uppercase tracking-widest px-8 py-3 hover:bg-green-600 transition-colors inline-block rounded-sm shadow-sm cursor-pointer">
                            Load More
                        </button>
                    </div>
                @endif
                
                @if($latestNews->isEmpty() && $topArticles->isEmpty())
                    <p class="text-gray-500 italic">No news articles found.</p>
                @endif
            </div>

            <!-- Right Sidebar Column -->
            <div class="w-full lg:w-1/3">
                <!-- Ad Banner Placeholder -->
                <div class="bg-gray-100 border border-gray-200 p-4 text-center mb-8 h-[250px] flex items-center justify-center">
                    <span class="text-gray-400 text-sm font-bold tracking-widest uppercase">Advertisement</span>
                </div>

                <!-- Sidebar Category News -->
                @if($sidebarCategory)
                <div>
                    <h2 class="text-xl font-black text-green-700 uppercase border-b-2 border-green-700 pb-2 mb-6 inline-block">
                        {{ strtoupper($sidebarCategory->name) }}
                    </h2>
                    
                    <div class="flex flex-col gap-4">
                        @foreach($sidebarCategory->articles as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="block group">
                            <div class="flex gap-4 border-b border-gray-100 pb-4">
                                <div class="w-24 h-16 flex-shrink-0">
                                    <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1544626053-8985dc34ae63?auto=format&fit=crop&q=80&w=200' }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-3">
                                        {{ $article->title }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');
        const container = document.getElementById('latest-news-container');

        if (loadMoreBtn && container) {
            loadMoreBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                if (!url) return;

                // Change button state
                const originalText = this.innerHTML;
                this.innerHTML = 'Loading...';
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
        }
    });
</script>
@endsection