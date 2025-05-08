@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Rooms</li>
            </ul>
            <h3>Rooms</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

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
                            <select name="city_id" class="form-control">
                                <option value="">Select a City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
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
<div class="room-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">ROOMS</span>
            <h2>Our Hotels & Rooms</h2>
        </div>

        <div class="row pt-45">
            @forelse($hotels as $hotel)
                <div class="col-12 mb-5">
                    <!-- Hotel Card -->
                    <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-4">
                                <img src="{{ asset($hotel->bookarea->image ?? 'upload/no_images.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover; border-radius: 10px;" alt="{{ $hotel->name }}">
                            </div>
                            <div class="col-lg-8">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-3 text-primary">{{ $hotel->bookarea->short_title ?? $hotel->name }}</h4>
                                    <p class="card-text mb-4 text-muted">{{ $hotel->bookarea->short_desc ?? '' }}</p>
                                    
                                    <a href="{{ route('booking.search.hotel', [
                                                    'hotel_id' => $hotel->id,
                                                    'check_in' => old('check_in'),
                                                    'check_out' => old('check_out'),
                                                    'persion' => old('persion')
                                                ]) }}" target="_blank" class="btn btn-outline-primary mb-4 rounded-pill px-4 py-2">
                                        Visit Hotel Website
                                    </a>

                                    @if($hotel->random_room)
                                        <div class="d-flex align-items-center mt-3">
                                            <div style="width: 120px; height: 80px; overflow: hidden; border-radius: 8px; margin-right: 15px;">
                                                <a href="{{ route('search_room_details', $hotel->random_room->id) }}">
                                                    <img src="{{ asset('upload/roomimg/' . $hotel->random_room->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="Room Image">
                                                </a>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('search_room_details', $hotel->random_room->id) }}" class="text-dark">
                                                        {{ $hotel->random_room->type->name ?? 'Room' }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">${{ $hotel->random_room->price }} / night</small>
                                                <div class="rating text-warning mt-1">
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star-half'></i>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-danger mt-3">No rooms available for this hotel.</p>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Hotel Card -->
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-danger">Sorry, No Hotels Found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Room Area End -->

@endsection
