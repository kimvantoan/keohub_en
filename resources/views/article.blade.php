@extends('layouts.app')

@section('title', $article->title . ' | LichDaBong')
@section('meta_description', $article->meta_description ?? Str::limit(html_entity_decode(strip_tags($article->content), ENT_QUOTES, 'UTF-8'), 160))
@section('og_type', 'article')
@section('meta_image', $article->thumbnail ? url(Storage::url($article->thumbnail)) : url('/default-seo-image.jpg'))

@section('content')
<div class="min-h-screen">
    <style>
        /* Ép hình ảnh trong bài viết tràn viền, phẳng, không bo góc */
        .prose img {
            width: 100%;
            border-radius: 0 !important;
            margin-top: 1.5em;
            margin-bottom: 1.5em;
            box-shadow: none !important;
        }
    </style>
    <!-- Article Header -->
    <div class="pt-12 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-black text-secondary font-outfit mb-6 leading-tight tracking-tight">
                {{ $article->title }}
            </h1>

            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($article->categories as $category)
                <a href="#" class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm hover:bg-green-600 transition-colors">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>

            <!-- Description -->
            @if($article->meta_description)
            <p class="text-xl text-gray-600 font-medium mb-3 leading-relaxed">
                {{ $article->meta_description }}
            </p>
            @endif
        </div>
    </div>

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($article->thumbnail)
        <div class="mb-8">
            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-auto object-cover">
        </div>
        @endif

        <div class="prose max-w-none font-sans text-gray-800 text-[17px] leading-relaxed">
            {!! $article->content !!}
        </div>
    </div>

    <!-- Related Articles -->
    @if($relatedArticles->count() > 0)
    <div class="bg-gray-50 border-t border-gray-200 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-black text-secondary font-outfit uppercase tracking-tight mb-8 border-l-4 border-primary pl-3">
                Bài Viết Liên Quan
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedArticles as $related)
                <a href="{{ route('news.show', $related->slug) }}" class="block group">
                    <div class="h-full flex flex-col">
                        <div class="relative h-40 w-full overflow-hidden mb-3">
                            <img src="{{ $related->thumbnail ? Storage::url($related->thumbnail) : 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?auto=format&fit=crop&q=80&w=400' }}" alt="{{ $related->title }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="flex-grow flex flex-col pt-1">
                            <h3 class="text-[15px] font-bold text-secondary font-outfit leading-snug group-hover:text-primary transition-colors line-clamp-3">
                                {{ $related->title }}
                            </h3>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection