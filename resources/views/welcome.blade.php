@extends('layouts.app')

@section('title', 'Football Predictions & Articles | KeoHub')

@section('content')
<!-- Hero Section -->
<div class="relative w-full h-[450px] md:h-[650px] rounded-[2rem] overflow-hidden shadow-2xl mb-12 group border border-gray-100">
    <!-- Background Image (Stadium) -->
    <img src="https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?q=80&w=1600&auto=format&fit=crop" alt="Hero Featured Article" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000">
    
    <!-- Gradient Overlays for readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/60 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-secondary/90 via-secondary/40 to-transparent"></div>

    <!-- Content Overlaid -->
    <div class="absolute bottom-0 left-0 p-6 sm:p-8 md:p-12 lg:p-16 max-w-4xl z-10">
        <!-- Breaking News Badge -->
        <div class="inline-block bg-[#1f8c4b] text-white text-[11px] font-bold uppercase tracking-[0.2em] px-4 py-1.5 rounded-sm mb-6 shadow-sm">
            Breaking News
        </div>
        
        <!-- Big Title -->
        <h1 class="text-3xl md:text-5xl lg:text-[4rem] font-black text-white font-outfit uppercase leading-[1.05] mb-4 md:mb-6">
            The London Derby:<br>
            Tactical<br>
            Masterclass at the<br>
            Bridge
        </h1>
        
        <!-- Excerpt -->
        <p class="text-gray-300 text-sm sm:text-base md:text-lg lg:text-xl font-sans mb-6 md:mb-8 max-w-2xl leading-relaxed">
            Analyzing how the tactical shift in the 64th minute changed the landscape of the Premier League title race. Deep dive into the heatmaps and pressing triggers.
        </p>
        
        <!-- Call to Action Button -->
        <a href="#" class="inline-flex items-center gap-2 bg-[#86efac] hover:bg-[#4ade80] text-secondary font-black py-3 px-6 md:py-4 md:px-8 rounded-xl transition-all shadow-lg transform hover:-translate-y-1 hover:shadow-[#86efac]/20 text-sm md:text-base">
            Read Analysis 
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>
</div>
<!-- Trending Stories Section -->
<div class="mt-20 mb-10">
    <!-- Section Header -->
    <div class="flex justify-between items-end mb-8 border-b-2 border-gray-100 pb-4">
        <div class="relative">
            <h2 class="text-2xl md:text-3xl font-black text-secondary font-outfit uppercase tracking-tight">Trending Stories</h2>
            <div class="absolute -bottom-[18px] left-0 w-20 h-1 bg-primary"></div>
        </div>
        <a href="#" class="text-primary font-bold hover:text-primary-dark transition-colors flex items-center gap-1 group">
            <span class="hidden sm:inline">View All News</span>
            <span class="sm:hidden">All News</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Featured Story (Left, 8 cols) -->
        <div class="lg:col-span-7 xl:col-span-8 relative rounded-2xl overflow-hidden shadow-md group h-[400px] md:h-[500px]">
            <img src="https://images.unsplash.com/photo-1518605368461-1e1e12739502?q=80&w=1200&auto=format&fit=crop" alt="Featured Story" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent"></div>
            
            <!-- Glassmorphism overlay card -->
            <div class="absolute bottom-6 left-6 right-6 md:right-auto md:w-4/5 bg-white/90 backdrop-blur-md p-6 rounded-xl border-l-4 border-primary shadow-xl">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 block">Transfers</span>
                <h3 class="text-xl sm:text-2xl md:text-3xl font-black text-secondary font-outfit uppercase leading-tight">
                    <a href="#" class="hover:text-primary transition-colors">The €100M Gamble: Is the era of hyper-transfers over?</a>
                </h3>
            </div>
        </div>

        <!-- Right Vertical List (Right, 4 cols) -->
        <div class="lg:col-span-5 xl:col-span-4 flex flex-col justify-between gap-6">
            <!-- Story 1 -->
            <div class="flex gap-5 group cursor-pointer">
                <div class="w-1/3 min-w-[120px] max-w-[140px] h-[100px] rounded-xl overflow-hidden flex-shrink-0 shadow-sm relative">
                    <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=400&auto=format&fit=crop" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs font-bold text-primary uppercase tracking-widest mb-1.5">Tactics</span>
                    <h4 class="text-lg font-bold text-secondary font-outfit leading-snug mb-1.5 group-hover:text-primary transition-colors">
                        <a href="#">The Inverted Fullback: Evolution or Extinction?</a>
                    </h4>
                    <p class="text-sm text-gray-500 line-clamp-2">How tactical trends are shifting back to traditional width in the top five leagues.</p>
                </div>
            </div>

            <!-- Story 2 -->
            <div class="flex gap-5 group cursor-pointer">
                <div class="w-1/3 min-w-[120px] max-w-[140px] h-[100px] rounded-xl overflow-hidden flex-shrink-0 shadow-sm relative">
                    <img src="https://images.unsplash.com/photo-1516733968668-cb4eccece47c?q=80&w=400&auto=format&fit=crop" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs font-bold text-primary uppercase tracking-widest mb-1.5">Academy</span>
                    <h4 class="text-lg font-bold text-secondary font-outfit leading-snug mb-1.5 group-hover:text-primary transition-colors">
                        <a href="#">Next Gen: 5 Wonderkids to Watch in 2024</a>
                    </h4>
                    <p class="text-sm text-gray-500 line-clamp-2">Scouting reports on the teenagers ready to break into the world stage this winter.</p>
                </div>
            </div>

            <!-- Story 3 -->
            <div class="flex gap-5 group cursor-pointer">
                <div class="w-1/3 min-w-[120px] max-w-[140px] h-[100px] rounded-xl overflow-hidden flex-shrink-0 shadow-sm relative">
                    <img src="https://images.unsplash.com/photo-1508344928928-7165b67de128?q=80&w=400&auto=format&fit=crop" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs font-bold text-primary uppercase tracking-widest mb-1.5">Fan Culture</span>
                    <h4 class="text-lg font-bold text-secondary font-outfit leading-snug mb-1.5 group-hover:text-primary transition-colors">
                        <a href="#">The Return of the Ultra: Europe's Rising Atmosphere</a>
                    </h4>
                    <p class="text-sm text-gray-500 line-clamp-2">Exploring the resurgence of organized fan groups across the continent.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Standings Section -->
<div class="mt-16 mb-20">
    <div class="bg-[#f4f6f8] rounded-3xl p-4 sm:p-6 md:p-10 border border-gray-100 shadow-inner">
        <!-- Header & Tabs -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 gap-4 md:gap-6">
            <h2 class="text-xl md:text-3xl font-black text-secondary font-outfit uppercase tracking-tight">Premier League Standings</h2>
            
            <div class="flex items-center gap-1 sm:gap-2 bg-gray-200/50 p-1 rounded-full w-full justify-center md:w-auto">
                <button class="px-4 py-1.5 sm:px-5 sm:py-2 bg-secondary text-white text-xs sm:text-sm font-bold rounded-full shadow-sm flex-1 md:flex-none">PL</button>
                <button class="px-3 py-1.5 sm:px-5 sm:py-2 text-gray-500 hover:text-secondary text-xs sm:text-sm font-bold rounded-full transition-colors flex-1 md:flex-none">La Liga</button>
                <button class="px-3 py-1.5 sm:px-5 sm:py-2 text-gray-500 hover:text-secondary text-xs sm:text-sm font-bold rounded-full transition-colors flex-1 md:flex-none">UCL</button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-2xl shadow-sm overflow-x-auto border border-gray-50">
            <table class="w-full text-left font-sans min-w-[700px]">
                <thead>
                    <tr class="text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-5 px-6 w-16 text-center">Pos</th>
                        <th class="py-5 px-4">Club</th>
                        <th class="py-5 px-4 text-center">Pl</th>
                        <th class="py-5 px-4 text-center">Gd</th>
                        <th class="py-5 px-4 text-center">Pts</th>
                        <th class="py-5 px-6 text-center">Form</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-secondary">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 text-center text-xl font-black font-outfit relative">
                            <!-- Left Green Border -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary rounded-l-2xl"></div>
                            1
                        </td>
                        <td class="py-5 px-4">
                            <div class="flex items-center gap-4">
                                <span class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 border border-gray-200 shadow-sm">MC</span>
                                <span class="font-bold text-lg">Manchester City</span>
                            </div>
                        </td>
                        <td class="py-5 px-4 text-center font-medium text-gray-500">12</td>
                        <td class="py-5 px-4 text-center font-bold text-primary">+18</td>
                        <td class="py-5 px-4 text-center text-2xl font-black font-outfit">30</td>
                        <td class="py-5 px-6">
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 transition-colors relative">
                        <td class="py-5 px-6 text-center text-xl font-black font-outfit">2</td>
                        <td class="py-5 px-4">
                            <div class="flex items-center gap-4">
                                <span class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 border border-gray-200 shadow-sm">ARS</span>
                                <span class="font-bold text-lg">Arsenal</span>
                            </div>
                        </td>
                        <td class="py-5 px-4 text-center font-medium text-gray-500">12</td>
                        <td class="py-5 px-4 text-center font-bold text-primary">+15</td>
                        <td class="py-5 px-4 text-center text-2xl font-black font-outfit">28</td>
                        <td class="py-5 px-6">
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 transition-colors relative">
                        <td class="py-5 px-6 text-center text-xl font-black font-outfit">3</td>
                        <td class="py-5 px-4">
                            <div class="flex items-center gap-4">
                                <span class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 border border-gray-200 shadow-sm">LFC</span>
                                <span class="font-bold text-lg">Liverpool</span>
                            </div>
                        </td>
                        <td class="py-5 px-4 text-center font-medium text-gray-500">12</td>
                        <td class="py-5 px-4 text-center font-bold text-primary">+12</td>
                        <td class="py-5 px-4 text-center text-2xl font-black font-outfit">27</td>
                        <td class="py-5 px-6">
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
