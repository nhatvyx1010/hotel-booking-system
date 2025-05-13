@extends('frontend.main_master')
@section('main')
<style>
    .inner-banner.inner-bg3 {
        height: 200px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;    
    }

    .inner-title {
        text-align: center;
        width: 100%;
    }
</style>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg9">
            <div class="container">
                <div class="inner-title">
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
                        <form method="get" action="{{ route('booking.search.hotel') }}">
                            <div class="row align-items-center">
                                <input type="text" required name="hotel_id" value="{{ $hotel->id }}" hidden>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>CHECK IN TIME</label>
                                        <div class="input-group">
                                            <input autocomplete="off" type="text" required name="check_in" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_in') }}">
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-chevron-down'></i>	
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>CHECK OUT TIME</label>
                                        <div class="input-group">
                                            <input autocomplete="off" type="text" required name="check_out" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_out') }}">
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
                    <h2>Our Rooms & Rates</h2>
                </div>
                <div class="row pt-45">
                    <?php $empty_array = []; ?>
                    @foreach($rooms as $item)

                    @php
                        $bookings = App\Models\Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $item->id)->get()->toArray();
                        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
                        $av_room = @$item->room_numbers_count-$total_book_room;
                    @endphp

                    @if($av_room > 0 && old('persion') <= $item->total_adult)


                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('search_room_details', $item->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">
                                <img src="{{asset('upload/roomimg/'.$item->image)}}" alt="Images" style="width: 550px; height:300px">
                            </a>
                            <div class="content">
                                <h6><a href="{{ route('search_room_details', $item->id.'?check_in='.old('check_in').'&check_out='.old('check_out').'&persion='.old('persion')) }}">{{ $item['type']['name'] }}</a></h6>
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
                    <?php array_push($empty_array, $item->id) ?>

                    @endif

                    @endforeach

                    @if (count($rooms) == count($empty_array))
                    <p class="text-center text-danger">Sorry No Data Found</p>
                    @endif

                </div>
            </div>
        </div>
        <!-- Room Area End -->


        
        <!-- Gallery -->
        <div class="inner-banner inner-bg3"  style="height: 150px;">
            <div class="container">
                <div class="inner-title">
                    <h3>Gallery</h3>
                </div>
            </div>
        </div>

        <div class="gallery-area pt-50 pb-30">
            <div class="container">
                <div class="tab gallery-tab">

                    <div class="tab_content current active pt-45">
                        <div class="tabs_item current">
                            <div class="gallery-tab-item">
                                <div class="gallery-view">
                                    <div class="row">

                                        @foreach ($gallery as $item)
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="single-gallery">
                                                <img src="{{ $item->photo_name }}" alt="Images">
                                                <a href="{{ $item->photo_name }}" class="gallery-icon">
                                                    <i class='bx bx-plus'></i>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery Area End -->
        @if ($hotel || $bookArea)
    <div class="hotel-bookarea-section py-5">
        <div class="container">
            <div class="row">

                {{-- Hotel Info --}}
                @if($hotel)
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            @if($hotel->photo)
                                <div class="me-3">
                                    <img src="{{ asset('upload/admin_images/' . $hotel->photo) }}"
                                        alt="{{ $hotel->name }}"
                                        class="img-fluid rounded-circle border"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-2">{{ $hotel->name }}</h4>
                                <p class="mb-1"><i class="fas fa-phone-alt text-muted"></i> {{ $hotel->phone }}</p>
                                <p class="mb-0"><i class="fas fa-map-marker-alt text-muted"></i> {{ $hotel->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Book Area Info --}}
                @if($bookArea)
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        @if($bookArea->image)
                            <img src="{{ asset($bookArea->image) }}"
                                class="card-img-top"
                                alt="{{ $bookArea->short_title }}"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted">{{ $bookArea->short_title }}</h6>
                            <h4 class="card-title">{{ $bookArea->main_title }}</h4>
                            <p class="card-text">{{ $bookArea->short_desc }}</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
@endif

<!-- Hotel Information End -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
    $(document).ready(function () {
        // Khởi tạo datepicker cho cả check_in và check_out
        $(".dt_picker").datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true
        });

        // Lắng nghe sự kiện khi người dùng chọn ngày check_in
        $("input[name='check_in']").on("change", function () {
            var checkInDate = $(this).val(); // Lấy ngày check_in
            if (checkInDate) {
                var checkIn = new Date(checkInDate); // Chuyển check_in thành đối tượng Date
                var checkOutDate = new Date(checkIn); // Sao chép giá trị check_in
                checkOutDate.setDate(checkOutDate.getDate() + 1); // Cộng thêm 1 ngày

                // Định dạng lại ngày check_out
                var day = checkOutDate.getDate();
                var month = checkOutDate.getMonth() + 1; // Lưu ý tháng trong JavaScript bắt đầu từ 0
                var year = checkOutDate.getFullYear();
                // Đảm bảo rằng ngày và tháng có 2 chữ số
                if (day < 10) day = '0' + day;
                if (month < 10) month = '0' + month;
                var formattedDate = year + '-' + month + '-' + day;

                // Đặt giá trị cho check_out
                $("input[name='check_out']").val(formattedDate);
                // Thiết lập ngày bắt đầu chọn cho check_out phải sau check_in
                $("input[name='check_out']").datepicker("setStartDate", formattedDate);

                // Cập nhật vùng chọn ngày của check_out để ẩn các ngày trước check_in
                $("input[name='check_out']").datepicker("option", "beforeShowDay", function(date) {
                    return [date > checkIn, '']; // Nếu ngày check_out bằng check_in hoặc nhỏ hơn, không thể chọn
                });
            }
        });

        // Lắng nghe sự kiện khi người dùng chọn ngày check_out
        $("input[name='check_out']").on("change", function () {
            var checkInDate = $("input[name='check_in']").val(); // Lấy ngày check_in
            var checkOutDate = $(this).val(); // Lấy ngày check_out

            if (checkInDate && checkOutDate) {
                var checkIn = new Date(checkInDate);
                var checkOut = new Date(checkOutDate);

                // Kiểm tra nếu ngày check_out <= check_in
                if (checkOut <= checkIn) {
                    alert("Ngày check-out phải sau ngày check-in ít nhất 1 ngày.");
                    $(this).val(""); // Xóa giá trị check_out nếu không hợp lệ
                }
            }
        });
    });
</script>

@endsection
