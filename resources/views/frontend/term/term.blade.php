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
            <p>By accessing or using our hotel booking platform, you agree to be bound by these terms and conditions. If you do not agree with any part, please do not use our services.</p>

            <h4>2. Nature of Our Platform</h4>
            <p>We operate as an intermediary between users and accommodation providers (hotels, hostels, resorts, etc.). We do not own or manage any properties listed on our platform.</p>

            <h4>3. Booking Policy</h4>
            <p>All bookings made through our platform are subject to confirmation by the hotel. Cancellation, refund, and modification policies vary depending on the individual property and are clearly stated during the booking process.</p>

            <h4>4. User Responsibilities</h4>
            <p>You are responsible for providing accurate, current, and complete information when using our platform. You agree to comply with all applicable laws and hotel-specific rules during your stay.</p>

            <h4>5. Property Responsibilities</h4>
            <p>Each property is solely responsible for the accuracy of its listing, pricing, availability, and the quality of services provided. We are not liable for any deficiencies or disputes arising from your stay.</p>

            <h4>6. Payments & Refunds</h4>
            <p>Payment methods vary and may include prepayment or pay-at-property options. Refunds (if applicable) are subject to each property's cancellation policy. We are not responsible for delays or refusals of refunds initiated by hotels.</p>

            <h4>7. Cancellations & Modifications</h4>
            <p>Requests for cancellation or modification should be made via your account dashboard or by contacting our support. Charges may apply depending on the hotel's policy.</p>

            <h4>8. Limitation of Liability</h4>
            <p>We are not liable for any injury, loss, claim, or damages arising from your interactions or stay with a third-party property booked through our platform.</p>

            <h4>9. Intellectual Property</h4>
            <p>All content on our platform, including logos, text, and graphics, is owned or licensed by us and may not be copied or reproduced without permission.</p>

            <h4>10. Governing Law</h4>
            <p>These terms are governed by and construed in accordance with the laws of [Your Country/Region], without regard to its conflict of law principles.</p>

            <h4>11. Contact Us</h4>
            <p>If you have any questions or concerns regarding these terms, please contact us at <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a>.</p>
        </div>
    </div>
</div>

@endsection
