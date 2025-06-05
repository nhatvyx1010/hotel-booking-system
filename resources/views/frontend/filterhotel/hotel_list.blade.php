<!-- Room Area -->
<style>
.custom-card-radius {
    border-radius: 50px !important;
}

</style>
<div class="room-area pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">PHÒNG</span>
            <h2>Khách Sạn & Phòng Của Chúng Tôi</h2>
        </div>

        <div class="row pt-45">
            @forelse($hotels as $hotel)
                <div class="col-12 mb-4">
                    <!-- Hotel Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden custom-card-radius"> <!-- tăng border-radius -->
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-4 p-4">
                                <img src="{{ asset($hotel->bookarea->image ?? 'upload/default.jpg') }}"
                                    class="img-fluid w-100 h-100"
                                    style="object-fit: cover; border-radius: 10px;"
                                    alt="{{ $hotel->name }}">
                            </div>
                            <div class="col-lg-8 p-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-3 text-primary">
                                        {{ $hotel->bookarea->short_title ?? $hotel->name }}
                                    </h4>
                                    <p class="card-text mb-4 text-muted">
                                        {{ $hotel->bookarea->short_desc ?? 'Chưa có mô tả' }}
                                    </p>

                                    <a href="{{ route('booking.search.hotel', [
                                        'hotel_id' => $hotel->id,
                                        'check_in' => old('check_in'),
                                        'check_out' => old('check_out'),
                                        'persion' => old('persion')
                                    ]) }}"
                                    target="_blank"
                                    class="btn btn-outline-primary mb-4 rounded-pill px-4 py-2">
                                        Truy cập khách sạn
                                    </a>

                                    <!-- Room Section -->
                                    @php
                                        $hotelRooms = App\Models\Room::where('hotel_id', $hotel->id)->get();
                                        $foundRoom = $hotelRooms->first();
                                    @endphp

                                    @if($foundRoom)
                                        <div class="d-flex align-items-center mt-3">
                                            <div style="width: 120px; height: 80px; overflow: hidden; border-radius: 8px; margin-right: 15px;">
                                                <a href="{{ route('search_room_details', $foundRoom->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                                    <img src="{{ asset('upload/roomimg/'.$foundRoom->image) }}"
                                                        class="w-100 h-100"
                                                        style="object-fit: cover;"
                                                        alt="Room Image">
                                                </a>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('search_room_details', $foundRoom->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}"
                                                    class="text-dark">
                                                        {{ $foundRoom->type->name }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    {{ number_format($foundRoom->price, 0, ',', '.') }} VNĐ / đêm
                                                </small>
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
                                        <p class="text-danger mt-3">
                                            Xin lỗi, không còn phòng trống tại {{ $hotel->name }}.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Hotel Card -->
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-danger">Xin lỗi, không tìm thấy khách sạn nào.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
<!-- Room Area End -->
