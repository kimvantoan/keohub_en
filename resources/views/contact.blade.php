@extends('layouts.app')

@section('title', 'Contact Us | KeoHub')

@section('content')
<div class="flex items-center justify-center py-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 max-w-5xl w-full p-8 md:p-12">
        <h1 class="text-3xl md:text-4xl font-extrabold text-secondary text-center mb-10 font-outfit">Get In Touch</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16">
            <!-- Left Column: Contact Info -->
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-secondary font-outfit">Contact Information</h2>
                <p class="text-gray-600 font-sans leading-relaxed">
                    We are always happy to hear your feedback, suggestions, or partnership proposals. Do not hesitate to drop us a message!
                </p>
                
                <div class="space-y-6 pt-4 font-sans text-gray-700">
                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="text-primary mt-0.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="font-medium">contact@apexnetdigital.com</span>
                    </div>
                    
                    <!-- Address -->
                    <div class="flex items-start gap-4">
                        <div class="text-primary mt-0.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="font-medium leading-relaxed">
                            412 N Main St, Suite 100, Buffalo,<br>
                            Wyoming 82834, United States
                        </span>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex items-start gap-4">
                        <div class="text-primary mt-0.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <span class="font-medium">+1 (936) 228-9993</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Form -->
            <div>
                @if (session('success'))
                    <div class="bg-primary/10 border-l-4 border-primary text-primary-dark p-4 rounded-r-lg mb-6 shadow-sm">
                        <p class="font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Success!
                        </p>
                        <p class="text-sm mt-1">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="/contact" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-1">Your Name</label>
                        <input type="text" id="name" name="name" required placeholder="John Doe" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-gray-800 placeholder-gray-400">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required placeholder="email@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-gray-800 placeholder-gray-400">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-400 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" required placeholder="How can we help you?" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-gray-800 placeholder-gray-400 resize-none"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-lg transition-colors shadow-md transform hover:-translate-y-0.5">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
