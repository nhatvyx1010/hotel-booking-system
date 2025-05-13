@extends('frontend.main_master')

@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<section class="restaurant-detailed-banner">
    <div class="text-center">
        <img class="img-fluid cover" src="">
    </div>
    <div class="restaurant-detailed-header">
        <div class="container">
            <div class="row d-flex align-items-end">
                <div class="col-md-8">
                    <div class="restaurant-detailed-header-left">
                        <img class="img-fluid mr-3 float-left" alt="osahan" src="">
                        <h2 class="text-white">xxx</h2>
                        <p class="text-white mb-1">
                            <i class="icofont-location-pin"></i>xxx 
                            <span class="badge badge-success">OPEN</span>
                        </p>
                        <p class="text-white mb-0">
                            <i class="icofont-food-cart"></i> xxx
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="restaurant-detailed-header-right text-right">
                        <button class="btn btn-success" type="button">
                            <i class="icofont-clock-time"></i> 25–35 min
                        </button>
                        <h6 class="text-white mb-0 restaurant-detailed-ratings">
                            <span class="generator-bg rounded text-white">
                                <i class="icofont-star"></i> xxx
                            </span> 
                            <i class="ml-3 icofont-speech-comments"></i> reviews
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="offer-dedicated-nav bg-white border-top-0 shadow-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span class="restaurant-detailed-action-btn float-right">
                    <button class="btn btn-light btn-sm border-light-btn" type="button">
                        <i class="icofont-cauli-flower text-success"></i> Pure Veg
                    </button>
                    <button class="btn btn-outline-danger btn-sm" type="button">
                        <i class="icofont-sale-discount"></i> OFFERS
                    </button>
                </span>
                <ul class="nav" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill" href="#pills-order-online" role="tab" aria-controls="pills-order-online" aria-selected="true">
                            Order Online
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="false">
                            Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-restaurant-info-tab" data-toggle="pill" href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info" aria-selected="false">
                            Market Info
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="offer-dedicated-body-left">
                    <div class="tab-content" id="pills-tabContent">

                        {{-- Order Online --}}
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">

                            {{-- Inner Banner --}}
                            <div class="inner-banner inner-bg9">
                                <div class="container">
                                    <div class="inner-title">
                                        <ul>
                                            <li><a href="index.html">Home</a></li>
                                            <li><i class='bx bx-chevron-right'></i></li>
                                            <li>Rooms</li>
                                        </ul>
                                        <h3>Rooms</h3>
                                    </div>
                                </div>
                            </div>

                            {{-- Room Area --}}
                            <div class="room-area pt-100 pb-70">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <span class="sp-color">ROOMS</span>
                                        <h2>Our Rooms & Rates</h2>
                                    </div>
                                    <div class="row pt-45">
                                        <?php $empty_array = []; ?>
                                        @foreach($rooms as $item)
                                            @php
                                                $bookings = App\Models\Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $item->id)->get()->toArray();
                                                $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
                                                $av_room = @$item->room_numbers_count - $total_book_room;
                                            @endphp

                                            @if($av_room > 0 && old('persion') <= $item->total_adult)
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="room-card">
                                                        <a href="{{ route('search_room_details', $item->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                                            <img src="{{ asset('upload/roomimg/'.$item->image) }}" alt="Images" style="width: 550px; height:300px">
                                                        </a>
                                                        <div class="content">
                                                            <h6>
                                                                <a href="{{ route('search_room_details', $item->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                                                    {{ $item['type']['name'] }}
                                                                </a>
                                                            </h6>
                                                            <ul>
                                                                <li class="text-color">{{ number_format($item->price, 0, ',', '.') }} VNĐ</li>
                                                                <li class="text-color">Per Night</li>
                                                            </ul>
                                                            <div class="rating text-color">
                                                                <i class='bx bxs-star'></i>
                                                                <i class='bx bxs-star'></i>
                                                                <i class='bx bxs-star'></i>
                                                                <i class='bx bxs-star'></i>
                                                                <i class='bx bxs-star-half'></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <?php array_push($empty_array, $item->id); ?>
                                            @endif
                                        @endforeach

                                        @if(count($rooms) == count($empty_array))
                                            <p class="text-center text-danger">Sorry No Data Found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery Tab --}}
                        <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                            <div id="gallery" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="restaurant-slider-main position-relative homepage-great-deals-carousel">
                                    <div class="owl-carousel owl-theme homepage-ad">
                                        {{-- Carousel items here --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Market Info Tab --}}
                        <div class="tab-pane fade" id="pills-restaurant-info" role="tabpanel" aria-labelledby="pills-restaurant-info-tab">
                            <div id="restaurant-info" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="address-map float-right ml-5">
                                    <div class="mapouter">
                                        <div class="gmap_canvas">
                                            <iframe width="300" height="170" id="gmap_canvas"
                                                    src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=9&ie=UTF8&iwloc=&output=embed"
                                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-4">Market Info</h5>
                                <p class="mb-3">Name</p>
                                <p class="mb-2 text-black">
                                    <i class="icofont-phone-circle text-primary mr-2"></i> phone
                                </p>
                                <p class="mb-2 text-black">
                                    <i class="icofont-email text-primary mr-2"></i> email
                                </p>
                                <p class="mb-2 text-black">
                                    <i class="icofont-clock-time text-primary mr-2"></i>
                                    Today 11am – 5pm, 6pm – 11pm
                                    <span class="badge badge-success">OPEN NOW</span>
                                </p>
                                <hr class="clearfix">
                                <p class="text-black mb-0">
                                    You can also check the 3D view by using our menu map clicking here &nbsp;&nbsp;&nbsp;
                                    <a class="text-info font-weight-bold" href="#">Venue Map</a>
                                </p>
                                <hr class="clearfix">
                            </div>
                        </div>

                    </div> {{-- end tab-content --}}
                </div> {{-- end offer-dedicated-body-left --}}
            </div>
        </div>
    </div>
</section>

@endsection
