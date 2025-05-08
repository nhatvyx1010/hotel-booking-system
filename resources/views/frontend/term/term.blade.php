@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Terms & Conditions</li>
            </ul>
            <h3>Terms & Conditions</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Terms Content -->
<div class="terms-area pt-100 pb-70">
    <div class="container">
        <div class="terms-content">
            <h4>1. Acceptance of Terms</h4>
            <p>By accessing or using our hotel booking platform, you agree to be bound by these terms and conditions. If you do not agree, please do not use the site.</p>

            <h4>2. Booking Policy</h4>
            <p>All bookings are subject to availability and confirmation. Each hotel may have its own cancellation and refund policies, which you agree to review before booking.</p>

            <h4>3. User Responsibilities</h4>
            <p>You are responsible for providing accurate personal information and complying with local laws and regulations while using our services.</p>

            <h4>4. Hotel Responsibilities</h4>
            <p>Each hotel is solely responsible for the quality of its services. We act as an intermediary platform and are not liable for any direct services provided by hotels.</p>

            <h4>5. Payment & Refunds</h4>
            <p>Payments are processed securely. Refunds are handled based on the hotel's policies. Please refer to each hotel’s terms before completing a booking.</p>

            <h4>6. Changes & Cancellation</h4>
            <p>Changes or cancellations must be made through your account or by contacting our support team. Charges may apply based on hotel policy.</p>

            <h4>7. Limitation of Liability</h4>
            <p>We are not responsible for losses, damages, or injuries resulting from your stay at any hotel booked through our platform.</p>

            <h4>8. Governing Law</h4>
            <p>These terms are governed by and construed in accordance with the laws of [Your Country/Region].</p>

            <h4>9. Contact Us</h4>
            <p>If you have any questions about these Terms, please contact us at support@yourhotelplatform.com.</p>
        </div>
    </div>
</div>

@endsection
