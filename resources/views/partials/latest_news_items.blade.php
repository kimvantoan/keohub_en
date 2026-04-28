@foreach($latestNews as $article)
<a href="{{ route('news.show', $article->slug) }}" class="block group">
    <div class="flex flex-col sm:flex-row gap-5 border-b border-gray-200 pb-6">
        <!-- Image Left -->
        <div class="w-full sm:w-1/3 flex-shrink-0 relative">
            
            <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1518605368461-1e1e12739502?auto=format&fit=crop&q=80&w=400' }}" alt="{{ $article->title }}" class="w-full h-auto object-cover aspect-video">
        </div>
        <!-- Text Right -->
        <div class="w-full sm:w-2/3 flex flex-col justify-start">
            <h3 class="text-lg font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors mb-2">
                {{ $article->title }}
            </h3>
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ Str::limit(strip_tags($article->content), 150) }}
            </p>
        </div>
    </div>
</a>
@endforeach
