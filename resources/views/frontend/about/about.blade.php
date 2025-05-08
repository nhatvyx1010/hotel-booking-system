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
                    <img src="https://decoxdesign.com/upload/images/mau-khach-san-5-sao-05-decox-design.jpg" alt="Hotel Image" class="img-fluid rounded shadow">
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center">
                <div class="about-content ps-lg-4">
                    <h2 class="mb-4 text-primary">Welcome to Our Hotel</h2>
                    <p class="text-muted">
                        Founded in 2025, Booking Hotel has been a symbol of luxury and comfort. Located in the heart of the city,
                        our hotel offers top-notch amenities, exceptional service, and a welcoming atmosphere for all our guests.
                        With a commitment to providing an unforgettable stay, we have become one of the most trusted names in hospitality.
                    </p>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="about-services text-center">
                    <h3 class="mb-4 text-secondary">Our Services</h3>
                    <div class="row">
                        @php
                            $services = [
                                '24/7 Front Desk Service',
                                'Free Wi-Fi',
                                'Room Service',
                                'Restaurant & Bar',
                                'Event & Conference Facilities',
                                'Airport Shuttle',
                                'Spa & Wellness Center',
                                'Fitness Center',
                                'Daily Housekeeping'
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
                        Our team consists of highly trained professionals who are dedicated to providing the best experience for every guest.
                        From our front desk staff to housekeeping, and from our chefs to our managers,
                        everyone at Booking Hotel shares a passion for hospitality.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- About Area End -->

@endsection
