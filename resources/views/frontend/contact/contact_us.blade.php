@extends('frontend.main_master')
@section('main')

<div class="container mt-5">
    <h2 class="text-center mb-4">Contact Us</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h4>Contact Information</h4>
            <p><strong>Phone:</strong> +84 959595959</p>
            <p><strong>Address:</strong> Da Nang, Viet Nam</p>
            <p><strong>Email:</strong> contact@example.com</p>
        </div>

        <div class="col-md-6">
            <h4>Our Location</h4>
            <p>We are located in Da Nang, Viet Nam. Feel free to reach out to us!</p>

            <!-- Thêm Google Map (nếu cần) -->
            <!-- <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" 
                    src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q=Da+Nang,Viet+Nam" 
                    allowfullscreen>
                </iframe>
            </div> -->
        </div>
    </div>
</div>
@endsection
