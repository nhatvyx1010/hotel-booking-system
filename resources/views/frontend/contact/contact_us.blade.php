@extends('frontend.main_master')
@section('main')

<div class="container mt-5">
    <h2 class="text-center mb-4">Liên hệ với chúng tôi</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h4>Thông tin liên hệ</h4>
            <p><strong>Điện thoại:</strong> +84 959595959</p>
            <p><strong>Địa chỉ:</strong> Đà Nẵng, Việt Nam</p>
            <p><strong>Email:</strong> bookinghotel@booking.com</p>
        </div>

        <div class="col-md-6">
            <h4>Vị trí của chúng tôi</h4>
            <p>Chúng tôi tọa lạc tại Đà Nẵng, Việt Nam. Hãy liên hệ với chúng tôi nếu bạn cần!</p>

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
