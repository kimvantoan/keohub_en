@extends('layouts.app')

@section('title', 'Disclaimer | KeoHub')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
    <!-- Header Section -->
    <div class="bg-secondary text-white px-8 py-16 text-center border-b border-gray-800 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 font-outfit tracking-tight">Disclaimer</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-sans">
                Important information regarding the use of our football predictions and statistics.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8 md:p-12 lg:p-16 max-w-4xl mx-auto font-sans text-gray-700 leading-relaxed text-lg pb-16">
        <p class="mb-10 text-gray-600 bg-gray-50 border border-gray-100 p-6 rounded-2xl">
            Welcome to <strong>KeoHub</strong>, operated by <strong>APEXNET DIGITAL LLC</strong>. All information provided on this website is for general informational purposes only.
        </p>
        
        <div class="space-y-12">
            <!-- Section 1 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">Accuracy of Information</h2>
                <p class="mb-4">
                    While we strive to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability, or availability with respect to the website or the information, products, or related services contained on the website.
                </p>
                <p>
                    Any reliance you place on such information is therefore strictly at your own risk. Conditions like <strong>match odds, squad availability, and team statistics</strong> may change after an article or prediction has been published.
                </p>
            </section>

            <!-- Section 2 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">Limitation of Liability</h2>
                <p>
                    In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.
                </p>
            </section>

            <!-- Section 3 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">External Links</h2>
                <p>
                    Through this website, you are able to link to other websites which are not under the control of APEXNET DIGITAL LLC. We have no control over the nature, content, and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
