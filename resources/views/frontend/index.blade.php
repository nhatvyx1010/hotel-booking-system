@extends('frontend.main_master')
@section('main')

<!-- Banner Area -->
<div class="banner-area" style="height: 480px;">
    <div class="container">
        <div class="banner-content">
            <h1>Discover a Hotel to Book a Suitable Room</h1>
        </div>
    </div>
</div>
<!-- Banner Area End -->

<!-- Banner Form Area -->
<div class="banner-form-area">
    <div class="container" >
        <div class="banner-form">
            <!-- <form method="get" action="{{ route('booking.search') }}"> -->
            <form method="get" action="{{ route('booking.list.room.search') }}">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>CHECK IN TIME</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_in" class="form-control dt_picker" placeholder="yyy-mm-dd">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>	
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>CHECK OUT TIME</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_out" class="form-control dt_picker" placeholder="yyy-mm-dd">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>	
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>GUESTS</label>
                            <select name="persion" class="form-control">
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                            </select>	
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>City</label>
                            <input list="cities" name="city_id" class="form-control" placeholder="Enter city name">
                            <datalist id="cities">
                                @foreach($cities as $city)
                                    <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <button type="submit" class="default-btn btn-bg-one border-radius-5">
                            Check Availability
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Banner Form Area End -->

<!-- Room Area -->
@include('frontend.home.room_area')

<!-- Book Area Two-->
@include('frontend.home.room_area_2')

<!-- Services Area Three -->
@include('frontend.home.room_area_3')

<!-- Services Area Three -->
<!-- @include('frontend.home.services') -->

<!-- Team Area Three -->
<!-- @include('frontend.home.team') -->

<!-- Testimonials Area Three -->
@include('frontend.home.testimonials')

<!-- FAQ Area -->
<!-- @include('frontend.home.faq') -->
<!-- FAQ Area End -->

<!-- Blog Area -->
@include('frontend.home.blog')
<!-- Blog Area End -->
@endsection
