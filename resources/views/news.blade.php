@extends('layouts.app')

@section('title', 'Football News & Latest Articles | KeoHub')

@section('is_dashboard', true)

@section('content')
<div class="flex h-full w-full">
    <!-- Left Sidebar: Leagues -->
    <aside class="hidden lg:block w-56 xl:w-64 flex-shrink-0 bg-[#f8f9fa] border-r border-gray-100 overflow-y-auto">
        <div class="p-8">
            <h3 class="text-xl font-bold text-secondary font-outfit mb-1">Leagues</h3>
            <p class="text-[10px] text-gray-400 font-bold tracking-[0.15em] uppercase mb-8">Global Coverage</p>
            
            <ul class="space-y-5 font-sans font-medium text-gray-600 text-[15px]">
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path border="round" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg> 
                        Premier League
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                        La Liga
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg> 
                        Serie A
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg> 
                        Bundesliga
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg> 
                        Ligue 1
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg> 
                        Champions League
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content Area (Scrollable) -->
    <div class="flex-grow overflow-y-auto bg-white p-4 md:p-8 lg:p-12 relative w-full">
        <!-- Optional max-width container inside to keep articles from stretching infinitely -->
        <div class="max-w-[1400px] mx-auto flex flex-col gap-8 md:gap-10">

        <!-- Mobile Leagues Scroller (Hidden on Desktop) -->
        <div class="block lg:hidden w-full overflow-x-auto pb-2 -mt-2 -mb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Hide scrollbar styling for webkit -->
            <style>
                .block.lg\\:hidden::-webkit-scrollbar { display: none; }
            </style>
            <div class="flex items-center gap-2.5 w-max px-1">
                <button class="bg-secondary text-white font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap shadow-sm">Premier League</button>
                <button class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap border border-gray-200 transition-colors">La Liga</button>
                <button class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap border border-gray-200 transition-colors">Serie A</button>
                <button class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap border border-gray-200 transition-colors">Bundesliga</button>
                <button class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap border border-gray-200 transition-colors">Ligue 1</button>
                <button class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-[11px] uppercase tracking-wider px-4 py-2 rounded-full whitespace-nowrap border border-gray-200 transition-colors">Champions League</button>
            </div>
        </div>
        
        <!-- Large Featured Article (Hero-like) -->
        <div class="relative w-full h-[400px] md:h-[500px] lg:h-[550px] rounded-3xl overflow-hidden shadow-2xl group border border-gray-100">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?q=80&w=1200&auto=format&fit=crop" alt="Featured Article" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000">
            
            <!-- Dark Gradient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
            
            <!-- Content Overlaid -->
            <div class="absolute bottom-0 left-0 p-6 md:p-10 lg:p-12 max-w-3xl z-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-primary text-white text-[10px] font-bold uppercase tracking-[0.2em] px-3 py-1 rounded-sm shadow-sm">Feature</span>
                    <span class="text-primary font-bold text-[13px]">Tactics Deep Dive</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white font-outfit leading-tight mb-4 tracking-tight cursor-pointer">
                    The Evolution of the Inverted Full-Back
                </h1>
                <p class="text-gray-300 text-sm md:text-base font-sans mb-8 max-w-2xl leading-relaxed hidden sm:block">
                    How Pep Guardiola's tactical innovation became the standard for modern European dominance and what it means for the next generation of defenders.
                </p>
                <a href="#" class="inline-flex items-center gap-2 bg-[#86efac] hover:bg-[#4ade80] text-secondary font-black py-3 px-6 rounded-lg transition-transform transform hover:-translate-y-1 shadow-lg text-sm md:text-base">
                    Read Analysis 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <!-- Latest News Filter Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mt-4">
            <h2 class="text-2xl md:text-3xl font-black text-secondary font-outfit flex items-center gap-2 tracking-tight">
                Latest News <span class="w-2.5 h-2.5 bg-primary rounded-full mt-1.5"></span>
            </h2>
            <div class="flex flex-wrap items-center gap-2 md:gap-3 text-[10px] sm:text-xs font-bold uppercase tracking-wider font-sans">
                <button class="bg-secondary text-white px-5 py-2.5 rounded-full shadow-sm transition-transform hover:scale-105">All</button>
                <button class="bg-gray-100 text-gray-500 hover:text-secondary hover:bg-gray-200 px-5 py-2.5 rounded-full transition-colors border border-gray-200">Match Reports</button>
                <button class="bg-gray-100 text-gray-500 hover:text-secondary hover:bg-gray-200 px-5 py-2.5 rounded-full transition-colors border border-gray-200">Transfers</button>
            </div>
        </div>

        <!-- Grid of 3 Articles (Top Row) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm">Transfers</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        Summer Window: Top 5 Targets for the Big Six
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        Analyzing the strategic gaps and potential marquee signings as clubs prepare for a chaotic transfer window.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>2 Hours Ago</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>5 Min Read</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm">Match Report</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        Champions League Final: The Tactical Stalemate
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        A granular look at how mid-block defense neutralized the most explosive attack in Europe.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>5 Hours Ago</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>12 Min Read</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544626053-8985dc34ae63?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm">Youth Academy</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        The New Golden Generation: Scouting the U21 Elite
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        Our scouts traveled across Europe to identify the 10 teenagers ready to break into the senior squads.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>Yesterday</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>7 Min Read</span>
                    </div>
                </div>
            </div>
        <!-- Card 4 (Merged from Bottom Row) -->
            <!-- Card 4 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <div class="absolute inset-0 bg-secondary/90 z-10 flex items-center justify-center">
                        <span class="text-white font-black font-outfit text-3xl opacity-20">$$$</span>
                    </div>
                    <img src="https://images.unsplash.com/photo-1628155930542-3c7a64e2c848?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 opacity-50 mix-blend-overlay">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm z-20">Finance</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        The Billion-Dollar Multi-Club Model
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        How structural changes in football ownership are reshaping the competitive balance.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>1 Day Ago</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>10 Min Read</span>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm">Tactics</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        Pressing Triggers: A Modern Masterclass
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        Understanding the subtle cues that signal a coordinated team press and how elite teams execute it.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>2 Days Ago</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>15 Min Read</span>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all group flex flex-col h-full cursor-pointer transform hover:-translate-y-1">
                <div class="relative h-48 sm:h-40 md:h-48 w-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1518605368461-1e1e12739502?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-secondary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-sm shadow-sm">Infrastructure</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-secondary font-outfit mb-3 leading-snug tracking-tight">
                        Sustainable Stadiums: The Future of Sport
                    </h3>
                    <p class="text-gray-500 text-sm mb-5 line-clamp-2 font-sans flex-grow leading-relaxed">
                        How European clubs are racing to achieve net-zero carbon footprints through innovative architecture.
                    </p>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-auto">
                        <span>3 Days Ago</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>5 Min Read</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="flex justify-center mt-6 mb-12">
            <button class="px-16 py-4 border-2 border-gray-100 text-secondary bg-white font-bold uppercase tracking-[0.2em] text-[11px] rounded-full hover:bg-secondary hover:text-white hover:border-secondary transition-all shadow-sm">
                Load More Stories
            </button>
        </div>

        </div> <!-- End max-width inner -->
    </div> <!-- End scrollable pane -->
</div> <!-- End flex container -->
@endsection
