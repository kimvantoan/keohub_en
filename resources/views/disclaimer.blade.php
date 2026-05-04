@extends('layouts.app')

@section('title', 'Điều Khoản Sử Dụng | LichDaBong')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
    <!-- Header Section -->
    <div class="bg-secondary text-white px-8 py-16 text-center border-b border-gray-800 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 font-outfit tracking-tight">Điều Khoản Sử Dụng</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto font-sans">
                Thông tin quan trọng liên quan đến việc sử dụng các dự đoán và thống kê bóng đá của chúng tôi.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8 md:p-12 lg:p-16 max-w-4xl mx-auto font-sans text-gray-700 leading-relaxed text-lg pb-16">
        <p class="mb-10 text-gray-600 bg-gray-50 border border-gray-100 p-6 rounded-2xl">
            Chào mừng đến với <strong>KeoHub</strong>, được điều hành bởi <strong>APEXNET DIGITAL LLC</strong>. Tất cả thông tin được cung cấp trên trang web này chỉ dành cho mục đích thông tin chung.
        </p>
        
        <div class="space-y-12">
            <!-- Section 1 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">Tính Chính Xác Của Thông Tin</h2>
                <p class="mb-4">
                    Mặc dù chúng tôi cố gắng giữ cho thông tin luôn cập nhật và chính xác, chúng tôi không đưa ra bất kỳ tuyên bố hay bảo đảm nào, dù rõ ràng hay ngụ ý, về tính đầy đủ, chính xác, độ tin cậy, tính phù hợp hoặc tính khả dụng liên quan đến trang web hoặc thông tin, sản phẩm hoặc dịch vụ liên quan có trên trang web.
                </p>
                <p>
                    Do đó, bất kỳ sự tin cậy nào bạn đặt vào thông tin đó đều hoàn toàn là rủi ro của riêng bạn. Các điều kiện như <strong>tỷ lệ cược trận đấu, tình trạng đội hình và thống kê đội bóng</strong> có thể thay đổi sau khi bài viết hoặc dự đoán được xuất bản.
                </p>
            </section>

            <!-- Section 2 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">Giới Hạn Trách Nhiệm</h2>
                <p>
                    Trong mọi trường hợp, chúng tôi sẽ không chịu trách nhiệm cho bất kỳ tổn thất hoặc thiệt hại nào bao gồm nhưng không giới hạn ở tổn thất hoặc thiệt hại gián tiếp hoặc do hậu quả, hoặc bất kỳ tổn thất hoặc thiệt hại nào phát sinh từ việc mất dữ liệu hoặc lợi nhuận phát sinh từ hoặc liên quan đến việc sử dụng trang web này.
                </p>
            </section>

            <!-- Section 3 -->
            <section>
                <h2 class="text-2xl font-bold text-secondary mb-4 font-outfit">Liên Kết Ngoài</h2>
                <p>
                    Thông qua trang web này, bạn có thể liên kết đến các trang web khác không nằm dưới sự kiểm soát của APEXNET DIGITAL LLC. Chúng tôi không có quyền kiểm soát tính chất, nội dung và tính khả dụng của các trang web đó. Việc bao gồm bất kỳ liên kết nào không nhất thiết ngụ ý đề xuất hoặc xác nhận các quan điểm được thể hiện trong đó.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
