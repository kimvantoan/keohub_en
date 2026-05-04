@extends('layouts.app')

@section('title', 'Chính Sách Bảo Mật | LichDaBong')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
    <!-- Header Section -->
    <div class="bg-secondary text-white px-8 py-16 text-center border-b border-gray-800 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 font-outfit tracking-tight">Chính Sách Bảo Mật</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-sans">
                Bảo vệ quyền riêng tư của bạn là ưu tiên hàng đầu của chúng tôi.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8 md:p-12 lg:p-16 max-w-4xl mx-auto font-sans text-gray-700 leading-relaxed text-lg pb-16">
        <p class="mb-10 text-gray-600 bg-gray-50 border border-gray-100 p-6 rounded-2xl">
            Chính sách này phác thảo cách <strong>APEXNET DIGITAL LLC</strong> (hoạt động dưới tên <strong>KeoHub</strong>) thu thập, sử dụng và bảo vệ thông tin cá nhân của người truy cập.
        </p>
        
        <div class="space-y-12">
            <!-- Section 1 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">1. Thu Thập Thông Tin</h2>
                <p class="mb-4">
                    Chúng tôi chỉ thu thập thông tin nhận dạng cá nhân khi bạn tự nguyện gửi cho chúng tôi qua biểu mẫu liên hệ hoặc đăng ký nhận bản tin. Thông tin này có thể bao gồm Tên và địa chỉ Email của bạn.
                </p>
                <p>
                    Chúng tôi cũng tự động thu thập thông tin không nhận dạng cá nhân như loại trình duyệt, địa chỉ IP và các trang bạn truy cập trên trang web của chúng tôi cho mục đích phân tích lưu lượng truy cập.
                </p>
            </section>

            <!-- Section 2 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">2. Sử Dụng Thông Tin</h2>
                <p class="mb-4">Bất kỳ thông tin nào chúng tôi thu thập đều có thể được sử dụng để:</p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-600">
                    <li>Cá nhân hóa và cải thiện trải nghiệm người dùng của bạn.</li>
                    <li>Tăng cường hỗ trợ khách hàng và bảo mật trang web.</li>
                    <li>Gửi email định kỳ (nếu bạn đã đăng ký).</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">3. Cookie</h2>
                <p>
                    Trang web của chúng tôi sử dụng "cookie" để nâng cao trải nghiệm người dùng. Bạn có thể chọn cấu hình trình duyệt của mình để từ chối cookie; tuy nhiên, xin lưu ý rằng làm như vậy có thể ngăn một số phần của trang web hoạt động bình thường.
                </p>
            </section>

            <!-- Section 4 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">4. Bảo Vệ Thông Tin</h2>
                <p>
                    Chúng tôi thực hiện nhiều biện pháp bảo mật để duy trì sự an toàn cho thông tin cá nhân của bạn. Dữ liệu được mã hóa và sẽ không bao giờ được chia sẻ, bán hoặc cho thuê cho bên thứ ba vì mục đích thương mại.
                </p>
            </section>

            <!-- Section 5 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">5. Sự Đồng Ý Của Bạn</h2>
                <p>
                    Bằng cách sử dụng trang web của chúng tôi, bạn đồng ý với chính sách bảo mật của chúng tôi. Nếu có bất kỳ sửa đổi nào, chúng tôi sẽ cập nhật trực tiếp trên trang này.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
