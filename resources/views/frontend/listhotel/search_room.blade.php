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
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-4">
                                <img src="{{ asset($hotel->bookarea->image ?? 'upload/default.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="{{ $hotel->name }}">
                            </div>
                            <div class="col-lg-8">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-3">{{ $hotel->bookarea->short_title ?? $hotel->name }}</h4>
                                    <p class="card-text mb-4">{{ $hotel->bookarea->short_desc ?? '' }}</p>
                                    <!-- <a href="{{ $hotel->bookarea->link_url ?? '#' }}" target="_blank" class="btn btn-outline-primary mb-4">Visit Hotel Website</a> -->
                                    
                                    <a href="{{ route('booking.search.hotel', [
                                                    'hotel_id' => $hotel->id,
                                                    'check_in' => old('check_in'),
                                                    'check_out' => old('check_out'),
                                                    'persion' => old('persion')
                                                ]) }}" target="_blank" class="btn btn-outline-primary mb-4">
                                        Visit Hotel Website
                                    </a>

                                    <!-- Room Section -->
                                    @php
                                        $hotelRooms = App\Models\Room::where('hotel_id', $hotel->id)->get();
                                        $empty_array = [];
                                        $foundRoom = null;
                                    @endphp

                                    @foreach($hotelRooms as $item)
                                        @php
                                            $bookings = App\Models\Booking::withCount('assign_rooms')
                                                ->whereIn('id', $check_date_booking_ids)
                                                ->where('rooms_id', $item->id)
                                                ->get()
                                                ->toArray();

                                            $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
                                            $av_room = $hotel->room_numbers_count - $total_book_room;
                                        @endphp

                                        @if($av_room > 0 && old('persion') <= $item->total_adult)
                                            @php $foundRoom = $item; break; @endphp
                                        @else
                                            @php array_push($empty_array, $item->id) @endphp
                                        @endif
                                    @endforeach

                                    @if($foundRoom)
                                        <div class="d-flex align-items-center mt-3">
                                            <div style="width: 120px; height: 80px; overflow: hidden; border-radius: 8px; margin-right: 15px;">
                                                <a href="{{ route('search_room_details', $foundRoom->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                                    <img src="{{ asset('upload/roomimg/'.$foundRoom->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="Room Image">
                                                </a>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('search_room_details', $foundRoom->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}" class="text-dark">
                                                        {{ $foundRoom->type->name }}
                                                    </a>

                                                </h6>
                                                <small class="text-muted">${{ $foundRoom->price }} / night</small>
                                                <div class="rating text-warning mt-1">
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star-half'></i>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($hotelRooms->count() == count($empty_array))
                                        <p class="text-danger mt-3">Sorry, No Available Rooms for {{ $hotel->name }}.</p>
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
