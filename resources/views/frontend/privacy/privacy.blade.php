@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Trang chủ</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Chính sách quyền riêng tư</li>
            </ul>
            <h3>Chính sách quyền riêng tư</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Privacy Content -->
<div class="privacy-area pt-100 pb-70">
    <div class="container">
        <div class="privacy-content">
            <h4>1. Giới thiệu</h4>
            <p>Chúng tôi tôn trọng quyền riêng tư của bạn và cam kết bảo vệ dữ liệu cá nhân của bạn. Chính sách quyền riêng tư này mô tả cách chúng tôi thu thập, sử dụng, chia sẻ và bảo vệ thông tin trên nền tảng đặt phòng khách sạn của mình, kết nối người dùng với các đơn vị cung cấp chỗ ở khác nhau.</p>

            <h4>2. Thông tin chúng tôi thu thập</h4>
            <ul>
                <li>Thông tin cá nhân: tên, địa chỉ email, số điện thoại và thông tin đăng nhập</li>
                <li>Thông tin đặt phòng: chỗ ở đã chọn, ngày lưu trú, sở thích của khách</li>
                <li>Dữ liệu thanh toán: được xử lý an toàn qua cổng thanh toán bên thứ ba</li>
                <li>Dữ liệu kỹ thuật: địa chỉ IP, loại thiết bị, trình duyệt và dữ liệu sử dụng qua cookie</li>
            </ul>

            <h4>3. Cách chúng tôi sử dụng thông tin của bạn</h4>
            <ul>
                <li>Để xử lý đặt phòng và cung cấp hỗ trợ khách hàng</li>
                <li>Để gửi xác nhận đặt phòng, cập nhật và thông báo dịch vụ</li>
                <li>Để cá nhân hóa trải nghiệm của bạn và cải thiện nền tảng</li>
                <li>Để gửi ưu đãi và thông điệp quảng cáo liên quan, khi bạn đồng ý</li>
                <li>Để tuân thủ các nghĩa vụ pháp lý hiện hành</li>
            </ul>

            <h4>4. Chia sẻ thông tin của bạn</h4>
            <p>Chúng tôi chỉ chia sẻ dữ liệu cá nhân của bạn với:</p>
            <ul>
                <li>Khách sạn hoặc chỗ ở bạn đặt qua nền tảng của chúng tôi</li>
                <li>Các đối tác dịch vụ đáng tin cậy (ví dụ: bộ xử lý thanh toán, phân tích, hỗ trợ khách hàng)</li>
                <li>Cơ quan chính phủ khi có yêu cầu theo luật định</li>
            </ul>
            <p>Chúng tôi không bán dữ liệu cá nhân của bạn cho bên thứ ba.</p>

            <h4>5. Bảo mật dữ liệu</h4>
            <p>Chúng tôi áp dụng các biện pháp bảo mật nghiêm ngặt để bảo vệ dữ liệu của bạn khỏi truy cập trái phép, thay đổi, tiết lộ hoặc phá hủy.</p>

            <h4>6. Quyền của bạn</h4>
            <ul>
                <li>Truy cập và yêu cầu bản sao dữ liệu cá nhân của bạn</li>
                <li>Yêu cầu chỉnh sửa hoặc xóa dữ liệu</li>
                <li>Rút lại sự đồng ý nếu việc xử lý dựa trên sự đồng ý</li>
                <li>Phản đối hoặc hạn chế xử lý trong một số trường hợp nhất định</li>
            </ul>
            <p>Bạn có thể thực hiện các quyền này bằng cách liên hệ trực tiếp với chúng tôi.</p>

            <h4>7. Cookie</h4>
            <p>Chúng tôi sử dụng cookie và các công nghệ tương tự để hiểu hành vi người dùng, cải thiện hiệu suất và cá nhân hóa nội dung. Bạn có thể quản lý tùy chọn cookie trong cài đặt trình duyệt.</p>

            <h4>8. Cập nhật chính sách</h4>
            <p>Chúng tôi có thể cập nhật Chính sách quyền riêng tư này theo thời gian. Phiên bản mới nhất sẽ luôn được đăng trên trang web của chúng tôi cùng với ngày hiệu lực được cập nhật.</p>

            <h4>9. Liên hệ với chúng tôi</h4>
            <p>Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào về Chính sách quyền riêng tư này hoặc cách chúng tôi xử lý dữ liệu của bạn, vui lòng liên hệ qua: <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a></p>
        </div>
    </div>
</div>

@endsection
