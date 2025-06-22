<style>
    .custom-card-radius {
        border-radius: 50px !important;
    }
    /* Thêm khoảng cách giữa các cột nếu cần */
    .room-item-col {
        padding-left: 10px; /* Điều chỉnh nếu cần */
        padding-right: 10px; /* Điều chỉnh nếu cần */
    }
    /* Đảm bảo nội dung trong cột ảnh được căn chỉnh tốt */
    .hotel-info-left-col {
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Đẩy button xuống dưới cùng nếu có đủ không gian */
        height: 100%; /* Đảm bảo cột có chiều cao của hàng */
    }
    .hotel-main-image-wrapper {
        margin-bottom: 1rem; /* Khoảng cách giữa ảnh và nội dung */
    }
    .hotel-rooms-and-description-col {
        display: flex;
        flex-direction: column;
        height: 100%;
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
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden custom-card-radius">
                        <div class="row g-0 align-items-stretch">
                            {{-- Cột bên trái: Ảnh, Tên khách sạn, Nút truy cập --}}
                            <div class="col-lg-4 p-4 hotel-info-left-col">
                                <div class="hotel-main-image-wrapper">
                                    <img src="{{ asset($hotel->bookarea->image ?? 'upload/default.jpg') }}"
                                        class="img-fluid w-100"
                                        style="object-fit: cover; border-radius: 10px;"
                                        alt="{{ $hotel->name }}">
                                </div>
                                <div class="card-body p-0">
                                    <h4 class="card-title mb-2 text-primary">
                                        {{ $hotel->bookarea->short_title ?? $hotel->name }}
                                    </h4>
                                </div>
                                <a href="{{ route('booking.search.hotel', [
                                    'hotel_id' => $hotel->id,
                                    'check_in' => old('check_in'),
                                    'check_out' => old('check_out'),
                                    'persion' => old('persion')
                                ]) }}"
                                target="_blank"
                                class="btn btn-outline-primary mt-auto rounded-pill px-4 py-2">
                                    Truy cập khách sạn
                                </a>
                            </div>

                            {{-- Cột bên phải: Mô tả, Danh sách phòng, Nút xem thêm phòng --}}
                            <div class="col-lg-8 p-4 hotel-rooms-and-description-col">
                                <div class="card-body p-0"> {{-- Card body riêng cho nội dung bên phải --}}
                                    {{-- Mô tả ngắn --}}
                                    <p class="card-text mb-4 text-muted">
                                        {{ $hotel->bookarea->short_desc ?? 'Chưa có mô tả' }}
                                    </p>

                                    @if($hotel->rooms->isNotEmpty())
                                        <h5 class="mt-2 mb-3 fw-bold">Các phòng phù hợp:</h5>
                                        <div class="row">
                                            @foreach($hotel->rooms->take(4) as $room)
                                                <div class="col-md-6 mb-3 room-item-col">
                                                    <div class="d-flex align-items-center border p-2 rounded">
                                                        <div style="width: 100px; height: 70px; overflow: hidden; border-radius: 8px; margin-right: 15px;">
                                                            <a href="{{ route('search_room_details', $room->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                                                <img src="{{ asset('upload/roomimg/'.$room->image) }}"
                                                                    class="w-100 h-100"
                                                                    style="object-fit: cover;"
                                                                    alt="Room Image">
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <a href="{{ route('search_room_details', $room->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}"
                                                                class="text-dark">
                                                                    {{ $room->type->name }}
                                                                </a>
                                                            </h6>
                                                            <small class="text-muted">
                                                                {{ number_format($room->price, 0, ',', '.') }} VNĐ / đêm
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
                                                </div>
                                            @endforeach
                                            @if($hotel->rooms->count() > 4)
                                                <div class="col-12 text-center mt-3">
                                                    <a href="{{ route('booking.search.hotel', [
                                                        'hotel_id' => $hotel->id,
                                                        'check_in' => old('check_in'),
                                                        'check_out' => old('check_out'),
                                                        'persion' => old('persion')
                                                    ]) }}" class="btn btn-outline-secondary btn-sm">Xem tất cả phòng</a>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-danger mt-3">
                                            Xin lỗi, không tìm thấy phòng nào phù hợp tại khách sạn này.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-danger">Xin lỗi, không tìm thấy khách sạn nào phù hợp.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>