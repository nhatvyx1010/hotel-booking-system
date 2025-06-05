@extends('frontend.main_master')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Inner Banner -->
<div class="inner-banner inner-bg6">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="#">Trang chủ</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Danh sách đặt phòng của người dùng</li>
            </ul>
            <h3>Huỷ đặt phòng</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Service Details Area -->
<div class="service-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.dashboard.user_menu')
            </div>

            <div class="col-lg-9">
                <div class="service-article">
                    <section class="checkout-area pb-70">
                        <div class="container">
                            <h3>Huỷ đặt phòng: {{ $booking->code }}</h3>

                            <!-- Booking Information -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5><strong>Thông tin đặt phòng</strong></h5>
                                    <p><strong>Mã đặt phòng:</strong> {{ $booking->code }}</p>
                                    <p><strong>Ngày đặt phòng:</strong> {{ $booking->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Loại phòng:</strong> 
                                        @if($booking->room && $booking->room->type)
                                            {{ $booking->room->type->name }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Hotel:</strong> 
                                        @if($booking->room && $booking->room->hotel)
                                            {{ $booking->room->hotel->name }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Ngày nhận phòng:</strong> {{ $booking->check_in }}</p>
                                    <p><strong>Ngày trả phòng:</strong> {{ $booking->check_out }}</p>
                                </div>
                            </div>

                            <!-- Nếu đã có report -->
                            @if ($booking->report)
                                <div class="alert alert-warning">
                                    <strong>Lưu ý:</strong> Bạn đã gửi báo cáo cho đặt phòng này. Nội dung như sau:
                                    <blockquote class="mt-2 mb-0">
                                        {{ $booking->report->message }}
                                    </blockquote>
                                    <p class="mt-2 mb-0"><strong>Trạng thái:</strong> {{ ucfirst($booking->report->status) }}</p>
                                </div>
                            @else
                                <!-- Cancel Form -->
                                <div class="alert alert-info">
                                    <strong>Thông báo:</strong> Chúng tôi chỉ xử lý các yêu cầu liên quan đến <strong>hủy đặt phòng, hoàn tiền, sự cố từ phía khách sạn trong quá trình quý khách trú lại, và các vấn đề phát sinh trong quá trình đặt phòng</strong>. Vui lòng không gửi các vấn đề ngoài phạm vi này.
                                </div>
                                <form action="{{ route('user.booking.report.store', $booking->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="report_reason">Nội dung báo cáo</label>
                                        <textarea name="report_reason" id="report_reason" class="form-control" rows="4" required>{{ old('report_reason') }}</textarea>
                                        @error('report_reason')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-danger mt-3">
                                        Gửi báo cáo
                                    </button>
                                    <a href="{{ route('user.booking') }}" class="btn btn-secondary mt-3">Quay lại</a>
                                </form>
                            @endif


                        </div>
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection
