@php
    $hotels = App\Models\User::where('role', 'hotel')->where('status', 'active')->latest()->limit(4)->get();
@endphp
<style>
    .hotel-name {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Giới hạn 2 dòng */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 3em; /* Đảm bảo chiều cao cố định tương đương 2 dòng */
}

</style>
<div class="hotel-area pt-100 pb-70 section-bg" style="background-color:#ffffff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">KHÁCH SẠN</span>
            <h2>Những Khách Sạn Hàng Đầu Của Chúng Tôi</h2>
        </div>
        <div class="row pt-45">
            @foreach ($hotels as $hotel)
            <div class="col-lg-6">
                <div class="room-card-two">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-4 p-0">
                            <div class="room-card-img">
                                <a href="{{ url('hotel_detail/'.$hotel->id) }}">
                                    <img src="{{ asset('upload/admin_images/' . $hotel->photo) }}" alt="{{ $hotel->name }}" style="width:100%; height:200px; object-fit:cover;">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="room-card-content">
                                <h3 class="hotel-name">
                                    <a href="{{ url('hotel_detail/'.$hotel->id) }}">{{ $hotel->name }}</a>
                                </h3>
                                <p><i class='bx bx-phone'></i> {{ $hotel->phone }}</p>
                                <p><i class='bx bx-map'></i> {{ $hotel->address }}</p>

                                <a href="{{ url('hotel_detail/'.$hotel->id) }}" class="book-more-btn mt-2">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
