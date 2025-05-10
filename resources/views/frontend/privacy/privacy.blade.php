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
            <p>We respect your privacy and are committed to protecting your personal data. This Privacy Policy outlines how we collect, use, share, and safeguard information across our hotel booking platform, which connects users with various accommodation providers.</p>

            <h4>2. Information We Collect</h4>
            <ul>
                <li>Personal information: name, email address, phone number, and account credentials</li>
                <li>Booking information: selected property, stay dates, guest preferences</li>
                <li>Payment data: processed securely through third-party payment gateways</li>
                <li>Technical data: IP address, device type, browser info, and usage data via cookies</li>
            </ul>

            <h4>3. How We Use Your Information</h4>
            <ul>
                <li>To process your accommodation bookings and provide customer support</li>
                <li>To communicate booking confirmations, updates, and service messages</li>
                <li>To personalize your experience and improve our platform</li>
                <li>To send relevant offers and promotional messages, with your consent</li>
                <li>To comply with applicable legal obligations and regulations</li>
            </ul>

            <h4>4. Sharing Your Information</h4>
            <p>We share your personal data only with:</p>
            <ul>
                <li>The hotels or accommodations you book through our platform</li>
                <li>Trusted service providers (e.g., payment processors, analytics, and customer support)</li>
                <li>Government authorities when required by law</li>
            </ul>
            <p>We do not sell your personal data to third parties.</p>

            <h4>5. Data Security</h4>
            <p>We implement strong security measures to protect your data from unauthorized access, alteration, disclosure, or destruction.</p>

            <h4>6. Your Rights</h4>
            <ul>
                <li>Access your personal data and request a copy</li>
                <li>Request correction or deletion of your data</li>
                <li>Withdraw consent where processing is based on consent</li>
                <li>Object to or restrict processing under certain circumstances</li>
            </ul>
            <p>You can exercise these rights by contacting us directly.</p>

            <h4>7. Cookies</h4>
            <p>We use cookies and similar technologies to understand user behavior, improve performance, and personalize content. You can manage cookie preferences through your browser settings.</p>

            <h4>8. Policy Updates</h4>
            <p>We may update this Privacy Policy from time to time. The latest version will always be posted on our website with an updated effective date.</p>

            <h4>9. Contact Us</h4>
            <p>If you have any questions or concerns about this Privacy Policy or how we handle your data, please contact us at: <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a></p>
        </div>
    </div>
</div>

@endsection
