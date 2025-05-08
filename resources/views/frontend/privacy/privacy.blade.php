@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Privacy Policy</li>
            </ul>
            <h3>Privacy Policy</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Privacy Content -->
<div class="privacy-area pt-100 pb-70">
    <div class="container">
        <div class="privacy-content">
            <h4>1. Introduction</h4>
            <p>We value your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, and protect your information when you use our hotel booking platform.</p>

            <h4>2. Information We Collect</h4>
            <ul>
                <li>Personal details such as name, email, and phone number</li>
                <li>Booking details (hotel, dates, preferences)</li>
                <li>Payment information (processed securely)</li>
                <li>IP address, browser data, and cookies</li>
            </ul>

            <h4>3. How We Use Your Information</h4>
            <ul>
                <li>To process and manage your bookings</li>
                <li>To improve our services and website experience</li>
                <li>To communicate promotions or service updates</li>
                <li>To comply with legal obligations</li>
            </ul>

            <h4>4. Sharing Your Information</h4>
            <p>We share your data only with the hotels you book and with trusted third parties necessary to provide our services. We never sell your data.</p>

            <h4>5. Data Protection</h4>
            <p>We implement appropriate technical and organizational measures to safeguard your data.</p>

            <h4>6. Your Rights</h4>
            <ul>
                <li>Access your personal data</li>
                <li>Request corrections or deletion</li>
                <li>Object to or restrict certain processing</li>
            </ul>

            <h4>7. Cookies</h4>
            <p>We use cookies to enhance your experience. You may disable cookies in your browser settings.</p>

            <h4>8. Changes to this Policy</h4>
            <p>We may update this policy periodically. The latest version will always be available on our website.</p>

            <h4>9. Contact</h4>
            <p>If you have questions, contact us at: <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a></p>
        </div>
    </div>
</div>

@endsection
