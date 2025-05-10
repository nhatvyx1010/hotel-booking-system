@php
    $cities = App\Models\City::whereHas('hotels', function($query) {
        $query->where('status', 'active');
    })->limit(4)->get();
@endphp

<div class="city-area pt-100 pb-70 section-bg" style="background-color:#ffffff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">CITIES</span>
            <h2>Our Top Cities</h2>
        </div>
        <div class="row pt-45">
            @foreach ($cities as $city)
            <div class="col-lg-6">
                <div class="room-card-two">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-4 p-0">
                            <div class="room-card-img">
                                <a href="{{ url('hotelsearchcity/'.$city->id) }}">
                                    <img src="{{ asset($city->image) }}" alt="{{ $city->name }}" style="width:100%; height:200px; object-fit:cover;">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="room-card-content">
                                <h3>
                                    <a href="{{ url('hotelsearchcity/'.$city->id) }}">{{ $city->name }}</a>
                                </h3>
                                <p><i class='bx bx-map'></i> {{ $city->name }}</p>
                                <p><i class='bx bx-info-circle'></i> {{ $city->description }}</p>
                                <p><i class='bx bx-hotel'></i> {{ $city->hotels->count() }} Active Hotels</p>

                                <a href="{{ url('city/details/'.$city->id) }}" class="book-more-btn mt-2">
                                    View Details
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
