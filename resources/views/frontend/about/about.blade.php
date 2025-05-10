@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>About Us</li>
            </ul>
            <h3>About Us</h3>
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
                    <h2 class="mb-4 text-primary">Welcome to Our Booking Platform</h2>
                    <p class="text-muted">
                        Founded in 2025, our platform connects travelers with thousands of hotels across the country.
                        Whether you're planning a business trip, a family vacation, or a romantic getaway,
                        our system helps you find and book the perfect stay quickly and easily.
                        With an easy-to-use interface, secure payment options, and verified user reviews,
                        we are committed to making hotel booking as seamless as possible.
                    </p>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="about-services text-center">
                    <h3 class="mb-4 text-secondary">What We Offer</h3>
                    <div class="row">
                        @php
                            $services = [
                                'Wide Range of Hotel Options',
                                'Real-Time Availability & Pricing',
                                'Secure Online Booking',
                                'Verified Guest Reviews',
                                'Multilingual Customer Support',
                                'Flexible Payment Methods',
                                'Exclusive Deals & Discounts',
                                'Mobile-Friendly Booking',
                                'Easy Cancellation Policies'
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
                    <h3 class="mb-4 text-secondary">Our Team</h3>
                    <p class="text-muted px-lg-5">
                        Our dedicated team is made up of tech enthusiasts, hospitality experts, and customer service professionals
                        working together to provide you with the best hotel booking experience.
                        We continuously improve our system to meet the changing needs of modern travelers and hospitality partners.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Area End -->

@endsection
