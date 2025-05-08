@extends('frontend.main_master')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Inner Banner -->
<div class="inner-banner inner-bg6">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="#">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>User Booking List</li>
            </ul>
            <h3>Cancel Booking</h3>
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
                            <h3>Cancel Booking: {{ $booking->code }}</h3>

                            <!-- Booking Information -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5><strong>Booking Information</strong></h5>
                                    <p><strong>Booking Number:</strong> {{ $booking->code }}</p>
                                    <p><strong>Booking Date:</strong> {{ $booking->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Room Type:</strong> 
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
                                    <p><strong>Check In:</strong> {{ $booking->check_in }}</p>
                                    <p><strong>Check Out:</strong> {{ $booking->check_out }}</p>
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
                                    <strong>Lưu ý:</strong> Thời gian nhận phòng còn chưa đến 24h. Bạn sẽ <strong>không được hoàn tiền</strong>.
                                </div>
                            @else
                                <div class="alert alert-success">
                                    Bạn sẽ được <strong>hoàn tiền 100%</strong> sau khi huỷ booking.
                                </div>
                            @endif

                            <!-- Cancel Form -->
                            <form action="{{ route('user.booking.cancel.store', $booking->id) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="cancel_reason">Reason for Cancellation</label>
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

                                <button type="submit" class="btn btn-danger mt-3" {{ $hoursDiff < 24 ? 'disabled' : '' }}>
                                    Submit Cancellation
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
