@extends('frontend.main_master')
@section('main')

<!-- Banner Area -->
<div class="banner-area" style="height: 480px;">
    <div class="container">
        <div class="banner-content">
            <h1>Tìm Khách Sạn Để Đặt Phòng Phù Hợp</h1>
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
                            <label>THỜI GIAN CHECK IN</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_in" class="form-control dt_picker" placeholder="yyyy-mm-dd" id="check_in">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>  
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>THỜI GIAN CHECK OUT</label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" required name="check_out" class="form-control dt_picker" placeholder="yyyy-mm-dd" id="check_out">
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
                            <input list="cities" id="city_name" class="form-control" placeholder="Enter city name" value="{{ old('city_name') ?? $cityName ?? '' }}">
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
                            Kiểm Tra
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Banner Form Area End -->

<script>
    document.getElementById('city_name').addEventListener('input', function() {
        var cityName = this.value;
        var cities = document.querySelectorAll('#cities option');
        var cityId = '';

        // Find matching city by name
        cities.forEach(function(option) {
            if (option.value === cityName) {
                cityId = option.getAttribute('data-id');
            }
        });

        // Set the city_id in the hidden input field
        document.getElementById('city_id').value = cityId;
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
