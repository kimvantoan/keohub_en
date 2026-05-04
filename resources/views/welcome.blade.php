@extends('layouts.app')

@section('title', 'Trang Chủ | LichDaBong - Nhận Định & Tin Tức Bóng Đá')

@section('content')

<!-- Dynamic Category Sections -->
@if(isset($categoryBlocks) && $categoryBlocks->count() > 0)
    @foreach($categoryBlocks as $block)
        @if($block->articles->count() > 0)
        <div class="mt-16 mb-10">
            <!-- Section Header -->
            <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-2">
                <h2 class="text-xl md:text-2xl font-black text-secondary font-outfit uppercase tracking-tight">{{ $block->name }}</h2>
                <a href="{{ route('news.index') }}?category={{ $block->slug }}" class="text-primary font-bold hover:text-primary-dark transition-colors text-xs sm:text-sm uppercase tracking-wider">
                    MORE {{ strtoupper($block->name) }}
                </a>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($block->articles as $article)
                <div class="flex flex-col group cursor-pointer" onclick="window.location.href='{{ route('news.show', $article->slug) }}'">
                    <div class="w-full aspect-[4/3] sm:aspect-[16/9] overflow-hidden mb-3 relative bg-gray-100 shadow-sm">
                        <img src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=400&auto=format&fit=crop' }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-secondary font-outfit leading-tight group-hover:text-primary transition-colors line-clamp-3 mb-2">
                        <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>
                    <p class="text-[11px] sm:text-xs text-gray-400 font-sans mt-auto uppercase tracking-wide">
                        LichDaBong | {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('M j, Y') : $article->created_at->format('M j, Y') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
@endif

<!-- Table Standings Section -->
<div id="standings" class="mt-16 mb-20 scroll-mt-24 relative">
    <div class="bg-[#f4f6f8] rounded-2xl md:rounded-3xl p-2 sm:p-6 md:p-10 border border-gray-100 shadow-inner overflow-hidden relative">
        <!-- Header & Tabs -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 md:mb-8 gap-4 md:gap-6 px-2 md:px-0 relative z-20">
            <h2 id="standings-title" class="text-xl md:text-3xl font-black text-secondary font-outfit uppercase tracking-tight">{{ $currentLeagueName ?? 'Ngoại Hạng Anh' }}</h2>
            
            <div class="flex flex-wrap items-center gap-1 sm:gap-2 bg-gray-200/50 p-1 rounded-3xl w-full lg:w-auto justify-center" id="standings-tabs">
                @php
                    $shortNames = [
                        'PL' => 'PL',
                        'PD' => 'La Liga',
                        'SA' => 'Serie A',
                        'BL1' => 'Bundes',
                        'FL1' => 'Ligue 1'
                    ];
                    $leaguesToDisplay = $allowedLeagues ?? $shortNames;
                @endphp
                @foreach($leaguesToDisplay as $code => $name)
                    <a href="?league={{ $code }}" data-league="{{ $code }}" class="league-tab px-2 py-1.5 sm:px-4 sm:py-2 text-[10px] sm:text-sm font-bold rounded-full transition-colors flex-1 md:flex-none text-center whitespace-nowrap {{ (isset($currentLeagueCode) && $currentLeagueCode === $code) ? 'bg-secondary text-white shadow-sm' : 'text-gray-500 hover:text-secondary' }}">
                        {{ $shortNames[$code] ?? $code }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Loader overlay only over the table area -->
        <div id="standings-loader" class="hidden absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center top-[120px] lg:top-[80px]">
            <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
        </div>

        <div id="standings-content">
            @include('partials.standings')
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const standingsContainer = document.getElementById('standings');
        
        if (standingsContainer) {
            standingsContainer.addEventListener('click', function(e) {
                // Find if a league tab was clicked
                const tab = e.target.closest('a.league-tab');
                if (tab) {
                    e.preventDefault();
                    
                    const url = tab.getAttribute('href');
                    const loader = document.getElementById('standings-loader');
                    const content = document.getElementById('standings-content');
                    
                    // Show loader
                    if (loader) loader.classList.remove('hidden');
                    if (content) content.style.opacity = '0.5';
                    
                    // Update URL without reloading
                    window.history.pushState({}, '', url);
                    
                    // Fetch new data
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (content) content.innerHTML = data.html;
                        
                        // Update title
                        const titleEl = document.getElementById('standings-title');
                        if (titleEl) titleEl.innerText = data.leagueName;
                        
                        // Update active tab styles
                        document.querySelectorAll('.league-tab').forEach(t => {
                            if (t.dataset.league === data.leagueCode) {
                                t.className = 'league-tab px-2 py-1.5 sm:px-4 sm:py-2 text-[10px] sm:text-sm font-bold rounded-full transition-colors flex-1 md:flex-none text-center whitespace-nowrap bg-secondary text-white shadow-sm';
                            } else {
                                t.className = 'league-tab px-2 py-1.5 sm:px-4 sm:py-2 text-[10px] sm:text-sm font-bold rounded-full transition-colors flex-1 md:flex-none text-center whitespace-nowrap text-gray-500 hover:text-secondary';
                            }
                        });

                        if (loader) loader.classList.add('hidden');
                        if (content) content.style.opacity = '1';
                    })
                    .catch(error => {
                        console.error('Error fetching standings:', error);
                        if (loader) loader.classList.add('hidden');
                        if (content) content.style.opacity = '1';
                    });
                }
            });
        }
    });
</script>
@endpush
@endsection
