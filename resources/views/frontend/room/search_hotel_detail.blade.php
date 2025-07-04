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
                        <form method="get" action="{{ route('booking.search.hotel') }}">
                            <div class="row align-items-center">
                                <input type="text" required name="hotel_id" value="{{ $hotel->id }}" hidden>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Thời gian nhận phòng</label>
                                        <div class="input-group">
                                            <input autocomplete="off" type="text" required name="check_in" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_in') }}">
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-chevron-down'></i>	
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label>Thời gian trả phòng</label>
                                        <div class="input-group">
                                            <input autocomplete="off" type="text" required name="check_out" class="form-control dt_picker" placeholder="yyy-mm-dd" value="{{ old('check_out') }}">
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-chevron-down'></i>	
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2">
                                    <div class="form-group">
                                        <label>Khách</label>
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
                    <h2>Phòng & Giá cả của chúng tôi</h2>
                </div>
                <div class="row pt-45">
                    <?php $empty_array = []; ?>
                        @foreach($rooms as $item)
                            <div class="col-lg-4 col-md-6">
                                <div class="room-card">
                                    <a href="{{ route('search_room_details', $item->id) }}">
                                        <img src="{{asset($item->image)}}" alt="Images" style="width: 550px; height:300px">
                                    </a>
                                    <div class="content">
                                        <h6><a href="{{ route('search_room_details', $item->id) }}">{{ $item['type']['name'] }}</a></h6>
                                        <ul>
                                            <li class="text-color">{{ number_format($item->price, 0, ',', '.') }} VNĐ</li>
                                            <li class="text-color">Mỗi đêm</li>
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
                        @endforeach


                    @if (count($rooms) == count($empty_array))
                    <p class="text-center text-danger">Xin lỗi, không tìm thấy dữ liệu</p>
                    @endif

                </div>
            </div>
        </div>
        <!-- Room Area End -->


        
        <!-- Gallery -->
        <div class="inner-banner inner-bg3"  style="height: 150px;">
            <div class="container">
                <div class="inner-title">
                    <h3>Thư viện ảnh</h3>
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
                                                <img src="{{ asset($item->photo_name) }}" alt="Images">

                                                <a href="#" class="gallery-icon">
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
                                            <img src="{{ asset($hotel->photo) }}"
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
                                @if ($audioPath)
                                <div class="px-4 pb-4">
                                    <h6 class="mb-2"><i class="fas fa-music text-primary me-2"></i>Giới thiệu khách sạn</h6>
                                    <audio controls style="width: 100%; border-radius: 5px;">
                                        <source src="{{ asset($audioPath) }}" type="audio/mpeg">
                                        Trình duyệt của bạn không hỗ trợ thẻ audio.
                                    </audio>
                                </div>
                                @endif
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


        <!-- Team Information -->
        @php
            $team = App\Models\Team::where('hotel_id', $hotel->id)->latest()->get();
        @endphp

        @if ($team->count() > 0)
            <div class="team-area-three pt-100 pb-50" style="background-color: #f5f5f5;">
                <div class="container">
                    <div class="section-title text-center">
                        <span class="sp-color">ĐỘI NGŨ</span>
                        <h2>Hãy Gặp Gỡ Các Thành Viên Đặc Biệt Trong Đội Ngũ Của Chúng Tôi</h2>
                    </div>
                    <div class="row justify-content-center pt-30">
                        @foreach($team as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="team-item text-center">
                                <a href="team.html">
                                    <img src="{{ asset($item->image) }}" alt="Images" style="width: 100%; height: auto; max-width: 400px; margin: 0 auto; display: block;">
                                </a>
                                <div class="content mt-3">
                                    <h5><a href="team.html">{{ $item->name }}</a></h5>
                                    <span>{{ $item->position }}</span>
                                    <ul class="social-link list-inline mt-2">
                                        @if($item->facebook)
                                        <li class="list-inline-item">
                                            <a href="{{ $item->facebook }}" target="_blank"><i class='bx bxl-facebook'></i></a>
                                        </li>
                                        @endif
                                        <!-- Thêm các link khác nếu có -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <!-- Team Information End -->


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
