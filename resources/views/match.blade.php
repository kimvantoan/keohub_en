@extends('layouts.app')

@section('title', 'Match Centre | KeoHub')

@section('content')
<div class="pt-6 pb-16 font-sans">

    <!-- Top Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-[#111827] mb-2 font-outfit tracking-tight">Match Centre</h1>
        <p class="text-gray-500 text-sm">Stay updated with live scores and upcoming clashes across the globe.</p>
    </div>

    <!-- Date selector -->
    <div class="flex items-center justify-center gap-2 sm:gap-3 mb-6 max-w-full">
        <!-- Calendar Picker -->
        <div class="relative flex-shrink-0">
            <input type="date" value="{{ $selectedDate->format('Y-m-d') }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="window.location.href='?date=' + this.value + '{{ $selectedComp !== 'all' ? '&comp='.$selectedComp : '' }}'">
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 shadow-sm transition-colors pointer-events-none">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <a href="?date={{ $selectedDate->copy()->subDays(4)->format('Y-m-d') }}{{ $selectedComp !== 'all' ? '&comp='.$selectedComp : '' }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 shadow-sm transition-colors flex-shrink-0">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex overflow-x-auto gap-1 sm:gap-2 py-3 px-1 [&::-webkit-scrollbar]:hidden" style="scrollbar-width: none;">
            @foreach($datesSlider as $ds)
            <a href="?date={{ $ds['date'] }}{{ $selectedComp !== 'all' ? '&comp='.$selectedComp : '' }}"
                class="flex flex-col items-center justify-center min-w-[50px] sm:min-w-[60px] h-[55px] sm:h-[65px] rounded-xl transition-all {{ $ds['isSelected'] ? 'bg-[#0f172a] text-white shadow-md transform -translate-y-1 relative' : 'bg-transparent text-gray-500 hover:bg-white hover:shadow-sm' }}">
                <span class="text-[8px] sm:text-[9px] font-bold tracking-wider uppercase mb-0 sm:mb-0.5 {{ $ds['isSelected'] ? 'text-gray-300' : 'text-gray-400' }}">
                    {{ $ds['isToday'] ? 'Today' : $ds['day'] }}
                </span>
                <span class="text-base sm:text-lg font-bold font-outfit {{ $ds['isSelected'] ? 'text-white' : 'text-gray-800' }}">{{ $ds['dayNumber'] }}</span>
            </a>
            @endforeach
        </div>

        <a href="?date={{ $selectedDate->copy()->addDays(4)->format('Y-m-d') }}{{ $selectedComp !== 'all' ? '&comp='.$selectedComp : '' }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 shadow-sm transition-colors flex-shrink-0">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Matches List -->
        <div class="lg:w-3/4 flex flex-col gap-6 sm:gap-8">
            @forelse($groupedMatches as $compName => $group)
            <div class="mb-2">
                <!-- Competition Header -->
                <div class="flex items-center justify-between mb-4 px-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 font-outfit">{{ $compName }}</h2>
                    </div>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Match Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                    @php $currentDateKey = null; @endphp
                    @foreach($group['matches'] as $match)
                    @php
                    $status = $match['status']['type']['state'] ?? 'pre'; // 'pre', 'in', 'post'
                    $homeTeamNode = collect($match['competitions'][0]['competitors'] ?? [])->firstWhere('homeAway', 'home');
                    $awayTeamNode = collect($match['competitions'][0]['competitors'] ?? [])->firstWhere('homeAway', 'away');

                    $homeTeam = $homeTeamNode['team']['shortDisplayName'] ?? $homeTeamNode['team']['name'] ?? 'TBD';
                    $awayTeam = $awayTeamNode['team']['shortDisplayName'] ?? $awayTeamNode['team']['name'] ?? 'TBD';

                    $homeLogo = $homeTeamNode['team']['logo'] ?? null;
                    $awayLogo = $awayTeamNode['team']['logo'] ?? null;

                    $isLive = ($status === 'in');
                    $isFinished = ($status === 'post');

                    $homeScore = $homeTeamNode['score'] ?? '-';
                    $awayScore = $awayTeamNode['score'] ?? '-';
                    $matchDateObj = \Carbon\Carbon::parse($match['date'])->timezone('Asia/Ho_Chi_Minh');
                    $matchTime = $matchDateObj->format('H:i');
                    $matchDateLabel = $matchDateObj->isToday() ? 'Today' : $matchDateObj->format('d M');
                    $matchDateKey = $matchDateObj->format('Y-m-d');
                    @endphp

                    @if($currentDateKey !== $matchDateKey)
                    @php
                    $currentDateKey = $matchDateKey;
                    $dateDividerText = $matchDateObj->format('l, F j, Y');
                    @endphp
                    <div class="col-span-1 lg:col-span-2 bg-[#f1f5f9] w-full text-center py-2.5 rounded-lg text-[#64748b] text-[13px] font-medium my-1 shadow-[inset_0_1px_3px_rgba(0,0,0,0.03)] border border-[#e2e8f0]">
                        {{ $dateDividerText }}
                    </div>
                    @endif

                    <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-3 shadow-sm border border-gray-100 flex flex-row items-center justify-between gap-2 sm:gap-3 {{ $isLive ? 'border-l-4 border-l-green-500' : '' }} hover:shadow-md transition-shadow">
                        <!-- Home Team -->
                        <div class="flex items-center justify-end flex-1 gap-2 sm:gap-3">
                            <span class="font-bold text-gray-800 text-xs sm:text-sm text-right leading-tight line-clamp-2">{{ $homeTeam }}</span>
                            @if($homeLogo)
                            <img src="{{ $homeLogo }}" class="w-6 h-6 sm:w-8 sm:h-8 object-contain shadow-sm rounded-full bg-white border border-gray-50 flex-shrink-0" alt="">
                            @else
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-100 rounded-full flex-shrink-0"></div>
                            @endif
                        </div>

                        <!-- Center Score / Time -->
                        <div class="flex flex-col items-center justify-center min-w-[60px] sm:min-w-[80px] px-1 sm:px-2 flex-shrink-0">
                            @if($isFinished || $isLive)
                            <div class="{{ $isFinished ? 'bg-gray-100 text-gray-700' : 'bg-[#0f172a] text-white' }} font-black font-outfit text-sm sm:text-lg tracking-widest px-2.5 sm:px-3 py-1 rounded flex items-center justify-between w-full shadow-inner">
                                <span>{{ $homeScore }}</span>
                                <span class="opacity-50 text-[10px] sm:text-xs mx-0.5 sm:mx-1">-</span>
                                <span>{{ $awayScore }}</span>
                            </div>
                            <div class="mt-1 text-[8px] sm:text-[10px] font-bold flex items-center gap-1 {{ $isLive ? 'text-green-500' : 'text-gray-400' }}">
                                @if($isLive)
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                LIVE
                                @else
                                FT
                                @endif
                            </div>
                            @else
                            <div class="font-bold text-gray-800 text-xs sm:text-sm bg-gray-50 px-2 sm:px-2.5 py-1 rounded">{{ $matchTime }}</div>
                            <div class="mt-1 text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-wider">
                                {{ $matchDateLabel }}
                            </div>
                            @endif
                        </div>

                        <!-- Away Team -->
                        <div class="flex items-center justify-start flex-1 gap-2 sm:gap-3">
                            @if($awayLogo)
                            <img src="{{ $awayLogo }}" class="w-6 h-6 sm:w-8 sm:h-8 object-contain shadow-sm rounded-full bg-white border border-gray-50 flex-shrink-0" alt="">
                            @else
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-100 rounded-full flex-shrink-0"></div>
                            @endif
                            <span class="font-bold text-gray-800 text-xs sm:text-sm leading-tight line-clamp-2">{{ $awayTeam }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="bg-gray-50/50 rounded-3xl p-10 text-center border border-gray-100 flex flex-col items-center justify-center md:min-h-[300px]">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-800 mb-2 font-outfit tracking-tight">No matches available</h3>
                <p class="text-gray-500 max-w-sm mx-auto">There are currently no football matches available for this date matching your selected filters.</p>
            </div>
            @endforelse
        </div>

        <!-- Sidebar Competitions Filter -->
        <div class="lg:w-1/4">
            <div class="bg-[#f8fafc] rounded-3xl p-5 border border-gray-100 sticky top-24 shadow-[inset_0_2px_10px_rgba(0,0,0,0.02)]">
                <h3 class="text-base font-extrabold text-[#111827] font-outfit mb-5">Competitions</h3>
                <div class="flex flex-col gap-1.5">
                    <!-- Default Today matches (All relevant competitions) -->
                    <a href="?date={{ $selectedDate->format('Y-m-d') }}&comp=all" class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition-colors {{ $selectedComp === 'all' ? 'bg-[#f1f5f9] shadow-[inset_2px_0_0_#e11d48] font-bold text-gray-900 border border-gray-200/50' : 'text-gray-500 hover:bg-white hover:shadow-sm' }}">
                        <svg class="w-4 h-4 {{ $selectedComp === 'all' ? 'text-gray-800' : 'opacity-60 text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-[13px]">Today's Matches</span>
                    </a>

                    @foreach($availableCompetitions as $code => $comp)
                    <a href="?date={{ $selectedDate->format('Y-m-d') }}&comp={{ $code }}" class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition-colors {{ $selectedComp === $code ? 'bg-[#f1f5f9] shadow-[inset_2px_0_0_#e11d48] font-bold text-gray-900 border border-gray-200/50' : 'text-gray-500 hover:bg-white hover:shadow-sm' }}">
                        <strong class="{{ $selectedComp === $code ? 'text-gray-800' : 'text-gray-400 opacity-60' }} font-black text-[10px] w-4 text-center">{{ $comp['short'] }}</strong>
                        <span class="text-[13px] truncate">{{ $comp['name'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Internal CSS for hiding scrollbars strictly locally -->
<style>
    .scroolbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scroolbar-hide {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
@endsection