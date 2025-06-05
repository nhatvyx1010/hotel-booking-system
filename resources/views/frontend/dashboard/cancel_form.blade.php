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

                            <!-- Time Check -->
                            @php
                                $checkInTime = \Carbon\Carbon::parse($booking->check_in);
                                $now = \Carbon\Carbon::now();
                                $hoursDiff = $now->diffInHours($checkInTime, false);
                            @endphp
                            @if ($hoursDiff < 24)
                                <div class="alert alert-warning">
                                    <strong>Lưu ý:</strong> Thời gian nhận phòng còn lại chưa đến 24 giờ. Theo chính sách của chúng tôi, bạn sẽ <strong>không thể hủy phòng</strong> và <strong>không được hoàn lại tiền</strong> trong trường hợp này.
                                </div>
                            @else
                                <div class="alert alert-success">
                                    Bạn có thể <strong>hủy đặt phòng</strong> và sẽ được <strong hoàn lại 100% số tiền</strong> đã thanh toán theo chính sách hoàn tiền của chúng tôi.
                                </div>
                            @endif

                            <!-- Cancel Form -->
                            <form action="{{ route('user.booking.cancel.store', $booking->id) }}" method="POST">
                                @csrf
                                @if ($hoursDiff >= 24)
                                    <div class="form-group">
                                        <label for="cancel_reason">Lý do huỷ đặt phòng</label>
                                        <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="3" required>{{ old('cancel_reason') }}</textarea>
                                        @error('cancel_reason')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="phone">Số điện thoại nhận hoàn tiền</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="bank_account">Số tài khoản ngân hàng</label>
                                        <input type="text" name="bank_account" id="bank_account" class="form-control" value="{{ old('bank_account') }}" required>
                                        @error('bank_account')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="bank_name">Tên ngân hàng</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ old('bank_name') }}" required>
                                        @error('bank_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif


                                <button type="submit" class="btn btn-danger mt-3" {{ $hoursDiff < 24 ? 'disabled' : '' }}>
                                    Gửi yêu cầu huỷ
                                </button>
                                <a href="{{ route('user.booking') }}" class="btn btn-secondary mt-3">Back</a>
                            </form>

                        </div>
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection
