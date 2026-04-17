@extends('layouts.app')

@section('title', 'Privacy Policy | KeoHub')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
    <!-- Header Section -->
    <div class="bg-secondary text-white px-8 py-16 text-center border-b border-gray-800 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 font-outfit tracking-tight">Privacy Policy</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-sans">
                Protecting your privacy is our top priority.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8 md:p-12 lg:p-16 max-w-4xl mx-auto font-sans text-gray-700 leading-relaxed text-lg pb-16">
        <p class="mb-10 text-gray-600 bg-gray-50 border border-gray-100 p-6 rounded-2xl">
            This policy outlines how <strong>APEXNET DIGITAL LLC</strong> (operating as <strong>KeoHub</strong>) collects, uses, and safeguards the personal information of our visitors.
        </p>
        
        <div class="space-y-12">
            <!-- Section 1 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">1. Information Collection</h2>
                <p class="mb-4">
                    We only collect personally identifiable information when you voluntarily submit it to us via contact forms or newsletter subscriptions. This information may include your Name and Email address.
                </p>
                <p>
                    We also automatically collect non-personally identifiable information such as browser type, IP address, and the pages you visit on our website for traffic analysis purposes.
                </p>
            </section>

            <!-- Section 2 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">2. Information Usage</h2>
                <p class="mb-4">Any information we collect may be used to:</p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-600">
                    <li>Personalize and improve your user experience.</li>
                    <li>Enhance our customer support and site security.</li>
                    <li>Send periodic emails (if you opted in).</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">3. Cookies</h2>
                <p>
                    Our website uses "cookies" to enhance user experience. You can choose to configure your browser to refuse cookies; however, please note that doing so may prevent some parts of the site from functioning properly.
                </p>
            </section>

            <!-- Section 4 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">4. Information Protection</h2>
                <p>
                    We implement a variety of security measures to maintain the safety of your personal information. Data is encrypted and will never be shared, sold, or rented to third parties for commercial purposes.
                </p>
            </section>

            <!-- Section 5 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">5. Your Consent</h2>
                <p>
                    By using our site, you consent to our privacy policy. If there are any modifications, we will update them directly on this page.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
