@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Trang Chủ</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Phòng</li>
            </ul>
            <h3>Phòng</h3>
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
                            <label>THỜI GIAN NHẬN PHÒNG</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_in" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_in') }}">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>	
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>THỜI GIAN TRẢ PHÒNG</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_out" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_out') }}">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>	
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>SỐ KHÁCH</label>
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
                            <label>THÀNH PHỐ</label>
                            <input list="cities" id="city_name" class="form-control" placeholder="Nhập tên thành phố" value="{{ old('city_name') ?? $cityName ?? '' }}">
                            <datalist id="cities">
                                @foreach($cities as $city)
                                    <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id') ?? $selectedCityId ?? '' }}">

                    <div class="col-lg-2 col-md-2">
                        <button type="submit" class="default-btn btn-bg-one border-radius-5">
                            Kiểm tra
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
            <span class="sp-color">PHÒNG</span>
            <h2>Khách Sạn & Phòng Của Chúng Tôi</h2>
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
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-4"> {{-- Thêm div bọc với Flexbox --}}
                                        <div>
                                            @if($hotel->min_price && $hotel->max_price)
                                                <p class="card-text mb-0"> {{-- Đặt mb-0 để loại bỏ margin dưới cùng --}}
                                                    <strong class="text-success">Giá phòng từ:</strong> 
                                                    {{ number_format($hotel->min_price, 0, ',', '.') }} VNĐ - 
                                                    {{ number_format($hotel->max_price, 0, ',', '.') }} VNĐ
                                                </p>
                                            @elseif($hotel->random_room)
                                                <p class="card-text mb-0"> {{-- Đặt mb-0 để loại bỏ margin dưới cùng --}}
                                                    <strong class="text-success">Giá phòng từ:</strong> 
                                                    {{ number_format($hotel->random_room->price, 0, ',', '.') }} VNĐ
                                                </p>
                                            @else
                                                <p class="card-text mb-0 text-danger">Không có thông tin giá phòng.</p>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('booking.search.hotel', [
                                            'hotel_id' => $hotel->id,
                                            'check_in' => old('check_in'),
                                            'check_out' => old('check_out'),
                                            'persion' => old('persion')
                                        ]) }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4 py-2"> {{-- Xóa mb-4 --}}
                                            Truy Cập Khách Sạn
                                        </a>
                                    </div>
                                    
                                    <ul>
                                        <li>
                                            <b>Views: </b>
                                                @forelse($hotel->room_views as $view)
                                                    <span class="badge bg-primary me-1">{{ $view }}</span>
                                                @empty
                                                    <span class="text-muted">Không có dữ liệu view</span>
                                                @endforelse
                                        </li>
                                    </ul>

                                    @if($hotel->random_room)
                                        <div class="d-flex align-items-center mt-3">
                                            <div style="width: 120px; height: 80px; overflow: hidden; border-radius: 8px; margin-right: 15px;">
                                                <a href="{{ route('search_room_details', $hotel->random_room->id) }}">
                                                    <img src="{{ asset($hotel->random_room->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="Room Image">
                                                </a>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('search_room_details', $hotel->random_room->id) }}" class="text-dark">
                                                        {{ $hotel->random_room->type->name ?? 'Phòng' }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ number_format($hotel->random_room->price, 0, ',', '.') }} VNĐ / đêm</small>
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
                                        <p class="text-danger mt-3">Không có phòng trống cho khách sạn này.</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Check if there is already a city_name in the input field when the page loads
    var cityName = document.getElementById('city_name').value;
    var cities = document.querySelectorAll('#cities option');
    var cityId = '';

    // If there is a city_name, find the corresponding city_id
    cities.forEach(function(option) {
        if (option.value === cityName) {
            cityId = option.getAttribute('data-id');
        }
    });

    // Set the city_id in the hidden input field
    document.getElementById('city_id').value = cityId;

    // Add event listener to update the city_id when the user selects a new city
    document.getElementById('city_name').addEventListener('input', function() {
        var selectedCityName = this.value;
        var selectedCityId = '';

        cities.forEach(function(option) {
            if (option.value === selectedCityName) {
                selectedCityId = option.getAttribute('data-id');
            }
        });

        document.getElementById('city_id').value = selectedCityId;
    });
});

</script>

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
