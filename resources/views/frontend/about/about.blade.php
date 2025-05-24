@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ url('/') }}">Trang chủ</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Về chúng tôi</li>
            </ul>
            <h3>Về chúng tôi</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- About Area -->
<div class="about-area pt-100 pb-70">
    <div class="container">
        <!-- Welcome Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-img text-center">
                    <img src="https://decoxdesign.com/upload/images/mau-khach-san-5-sao-05-decox-design.jpg" alt="Hotel Booking System" class="img-fluid rounded shadow">
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center">
                <div class="about-content ps-lg-4">
                    <h2 class="mb-4 text-primary">Chào mừng bạn đến với nền tảng đặt phòng của chúng tôi</h2>
                    <p class="text-muted">
                    Được thành lập vào năm 2025, nền tảng của chúng tôi kết nối khách du lịch với hàng nghìn khách sạn trên toàn quốc.
                    Dù bạn đang lên kế hoạch cho chuyến công tác, kỳ nghỉ gia đình hay một chuyến đi lãng mạn,
                    hệ thống của chúng tôi giúp bạn tìm và đặt chỗ ở hoàn hảo một cách nhanh chóng và dễ dàng.
                    Với giao diện dễ sử dụng, tùy chọn thanh toán an toàn và đánh giá người dùng đã được xác minh,
                    chúng tôi cam kết giúp việc đặt phòng khách sạn trở nên dễ dàng nhất có thể.
                    </p>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="about-services text-center">
                    <h3 class="mb-4 text-secondary">Chúng tôi cung cấp những gì?</h3>
                    <div class="row">
                        @php
                            $services = [
                            'Nhiều lựa chọn khách sạn đa dạng',
                            'Cập nhật giá cả & tình trạng phòng theo thời gian thực',
                            'Đặt phòng trực tuyến an toàn',
                            'Đánh giá khách đã xác minh',
                            'Hỗ trợ khách hàng đa ngôn ngữ',
                            'Nhiều phương thức thanh toán linh hoạt',
                            'Ưu đãi & giảm giá độc quyền',
                            'Đặt phòng thân thiện trên thiết bị di động',
                            'Chính sách hủy phòng linh hoạt'
                            ];
                        @endphp
                        @foreach ($services as $service)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <i class='bx bx-check-circle me-2 text-success'></i>{{ $service }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="about-team text-center">
                    <h3 class="mb-4 text-secondary">Đội ngũ của chúng tôi</h3>
                    <p class="text-muted px-lg-5">
                    Đội ngũ của chúng tôi gồm những người đam mê công nghệ, chuyên gia ngành khách sạn và các nhân viên chăm sóc khách hàng,
                    cùng nhau làm việc để mang đến cho bạn trải nghiệm đặt phòng tốt nhất.
                    Chúng tôi liên tục cải tiến hệ thống để đáp ứng nhu cầu thay đổi của khách du lịch hiện đại và các đối tác khách sạn.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Area End -->

@endsection
