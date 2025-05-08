@extends('frontend.main_master')

@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Testimonials</li>
            </ul>
            <h3 class="text-white">What Our Guests Say</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Testimonials Area -->
<div class="testimonials-area pt-100 pb-70 bg-light">
    <div class="container">
        <div class="section-title text-center mb-60">
            <span class="sp-color">TESTIMONIALS</span>
            <h2>What Our Guests Are Saying</h2>
        </div>

        <div class="row">
            @foreach($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-testimonial rounded-lg shadow-sm overflow-hidden">
                        <div class="testimonial-content p-4 bg-white">
                            <!-- <div class="testimonial-avatar text-center mb-4">
                                <img src="{{ asset('upload/testimonial-avatar.jpg') }}" alt="{{ $testimonial->name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            </div> -->
                            <h5 class="text-center mb-2 font-weight-bold">{{ $testimonial->name }}</h5>
                            <p class="testimonial-city text-center text-muted mb-3">{{ $testimonial->city }}</p>
                            <p class="testimonial-message text-center text-muted">{{ $testimonial->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Testimonials Area End -->

@endsection
