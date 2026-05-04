@extends('layouts.app')

@section('title', 'Giới Thiệu | LichDaBong')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
    <!-- Header Section -->
    <div class="bg-secondary text-white px-8 py-16 text-center border-b border-gray-800 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 font-outfit tracking-tight">Giới Thiệu LichDaBong</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-sans">
                Phát triển bởi APEXNET DIGITAL LLC, chúng tôi là nền tảng truyền thông thể thao hàng đầu về tin tức bóng đá và dự đoán trận đấu.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8 md:p-12 lg:p-16 max-w-4xl mx-auto font-sans text-gray-600 leading-relaxed space-y-12 text-lg">
        
        <!-- Our Mission -->
        <section>
            <h2 class="text-2xl font-bold text-secondary mb-6 font-outfit border-l-4 border-primary pl-4">Sứ Mệnh Của Chúng Tôi</h2>
            <p class="mb-5">LichDaBong ra đời với mong muốn:</p>
            <ul class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100 text-gray-700">
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Đơn giản hóa số liệu thống kê bóng đá và nghiên cứu tỷ lệ cược thông qua các bài viết chất lượng cao.
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Cung cấp những góc nhìn sâu sắc nhất bằng cách phân tích trận đấu, đội bóng và tối ưu hóa dữ liệu thể thao.
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Áp dụng công nghệ tiên tiến và AI để cá nhân hóa trải nghiệm đọc cho từng người dùng.
                </li>
            </ul>
        </section>

        <!-- What We Offer -->
        <section>
            <h2 class="text-2xl font-bold text-secondary mb-6 font-outfit border-l-4 border-accent pl-4">LichDaBong Cung Cấp Gì?</h2>
            
            <h3 class="text-xl font-bold text-gray-800 mb-3 font-outfit mt-8">Khám Phá & Nghiên Cứu</h3>
            <p class="mb-4">Người dùng có thể nhanh chóng tìm thấy:</p>
            <ul class="list-disc list-inside space-y-2 mb-8 ml-2 text-gray-700">
                <li>Dự đoán trận đấu và phân tích tỷ lệ cược hàng đầu cho các giải đấu khác nhau.</li>
                <li>Phân tích chiến thuật bóng đá và hướng dẫn phù hợp cho mọi người đam mê.</li>
                <li>Các mẹo cá cược tối ưu và đề xuất chân thực nhất.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mb-3 font-outfit">Đề Xuất Thông Minh (AI)</h3>
            <p class="mb-4">Chúng tôi đang liên tục phát triển các tính năng để:</p>
            <ul class="list-disc list-inside space-y-2 ml-2 text-gray-700">
                <li>Gợi ý tài liệu thể thao được cá nhân hóa dựa trên đội bóng yêu thích của bạn.</li>
                <li>Đề xuất thông tin trận đấu phù hợp bằng trí tuệ nhân tạo.</li>
            </ul>
        </section>

        <!-- Our Commitments -->
        <section>
            <h2 class="text-2xl font-bold text-secondary mb-6 font-outfit border-l-4 border-blue-500 pl-4">Cam Kết Của Chúng Tôi</h2>
            <div class="bg-secondary text-gray-300 p-8 rounded-2xl shadow-lg mb-6">
                <ul class="space-y-4 mb-6">
                    <li class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                        Thông tin biên tập rõ ràng và minh bạch
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                        Chỉ hợp tác với các đối tác thể thao uy tín
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                        Luôn đặt trải nghiệm người dùng làm trung tâm
                    </li>
                </ul>
                <p class="text-sm border-t border-gray-700 pt-6">
                    Là một nền tảng truyền thông thể thao đang phát triển, chúng tôi tập trung vào sự phát triển bền vững, nâng cao chất lượng nội dung và sản phẩm mỗi ngày để mang lại giá trị đích thực và lâu dài cho độc giả.
                </p>
            </div>
        </section>

        <!-- Company Information -->
        <section class="border-t border-gray-200 pt-10 mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-bold text-secondary mb-4 font-outfit">Thông Tin Công Ty</h3>
                <p class="mb-2"><strong>Tên Pháp Lý:</strong> APEXNET DIGITAL LLC</p>
                <p><strong>Trụ Sở Chính:</strong> 412 N Main St, Suite 100, Buffalo, Wyoming 82834, United States</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-secondary mb-4 font-outfit">Liên Hệ</h3>
                <p class="mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    +1 (936) 228-9993
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    contact@apexnetdigital.com
                </p>
            </div>
        </section>

    </div>
</div>
@endsection
