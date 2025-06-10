@extends('frontend.main_master')
@section('main')
<style>
    .star-rating {
        display: flex;
        gap: 5px;
        cursor: pointer;
    }

    .star {
        font-size: 1.8rem;
        color: #ccc;
        transition: color 0.2s ease-in-out;
    }

    .star.selected,
    .star.hovered {
        color: rgb(181, 105, 82) !important; /* cam đỏ */
    }
    .bxs-star {
        color: rgb(181, 105, 82) !important;
    }

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg10">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Chi tiết phòng</li>
                    </ul>
                    <h3>{{ $roomdetails->type->name }}</h3>
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
                                        <label>KHÁCH</label>
                                        <select name="persion" class="form-control">
                                            <option value="01" {{ old('persion') == '01' ? 'selected' : '' }}>01</option>
                                            <option value="02" {{ old('persion') == '02' ? 'selected' : '' }}>02</option>
                                            <option value="03" {{ old('persion') == '03' ? 'selected' : '' }}>03</option>
                                            <option value="04" {{ old('persion') == '04' ? 'selected' : '' }}>04</option>
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

        <!-- Room Details Area End -->
        <div class="room-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="room-details-side">
                            <div class="side-bar-form">
                                <h3>Phiếu Đặt Phòng </h3>
                                <form action="{{ route('user_booking_store', $roomdetails->id) }}" method="post" id="bk_form">
                                    @csrf
                                    
                                    <input hidden name="room_id" id="room_id" value="{{ $roomdetails->id }}">
                                    <input hidden name="hotel_id" id="hotel_id" value="{{ $roomdetails->hotel_id }}">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Ngày nhận phòng</label>
                                                <div class="input-group">
                                                    <input autocomplete="off" type="text" required name="check_in" id="check_in" class="form-control dt_picker" value="{{ old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : '' }}">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Ngày trả phòng</label>
                                                <div class="input-group">
                                                    <input autocomplete="off" type="text" required name="check_out" id="check_out" class="form-control dt_picker" value="{{ old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : '' }}">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Số lượng khách</label>
                                                <select class="form-control" name="persion" id="number_persion">
                                                    @for($i = 1; $i <= 4; $i++)
                                                        <option {{ old('persion') == $i ? 'selected' : '' }} value="0{{ $i }}">0{{ $i }}</option>
                                                    @endfor
                                                </select>	
                                            </div>
                                        </div>

                                        <input type="hidden" id="total_adult" value="{{ $roomdetails->total_adult }}">
                                        <input type="hidden" id="room_price" value="{{ $roomdetails->priceToShow }}">
                                        <input type="hidden" id="discount_p" value="{{ $roomdetails->discount }}">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Số lượng phòng</label>
                                                <select class="form-control number_of_rooms" name="number_of_rooms" id="select_room">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="0{{ $i }}">0{{ $i }}</option>
                                                @endfor
                                                </select>	
                                            </div>
                                            <input type="hidden" name="available_room" id="available_room">
                                            <p class="available_room"></p>
                                        </div>

                                        <h5>Bảng giá theo từng ngày:</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Ngày</th>
                                                    <th>Giá</th>
                                                </tr>
                                            </thead>
                                            <tbody id="date_price_table_body">
                                                {{-- Dữ liệu sẽ được cập nhật bằng JavaScript --}}
                                            </tbody>
                                        </table>


                                        <div class="col-lg-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><p>Tạm tính</p></td>
                                                    <td style="text-align: right"><span class="t_subtotal">0</span></td>
                                                    @if($roomdetails->isHolidayPrice)
                                                        <small class="text-danger">* Giá lễ tết áp dụng</small>
                                                    @endif
                                                </tr>

                                                <tr>
                                                <td><p>Giảm giá</p></td>
                                                <td style="text-align: right"><span class="t_discount">0</span></td>
                                                </tr>

                                                <tr>
                                                <td><p>Tổng cộng</p></td>
                                                <td style="text-align: right"><span class="t_g_total">0</span></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
            
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                                Đặt ngay
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="room-details-article">
                            <div class="room-details-slider owl-carousel owl-theme">
                                @foreach ($multiImage as $image)
                                <div class="room-details-item">
                                    <img src="{{ asset('upload/roomimg/multi_img/'.$image->multi_img) }}" alt="Images">
                                </div>
                                @endforeach 
                            </div>

                            <div class="room-details-title">
                                <h2>{{ $roomdetails->type->name }}</h2>
                                <ul>
                                    
                                    <li>
                                       <b> Giá cơ bản : {{ number_format($roomdetails->price, 0, ',', '.') }} VNĐ/Đêm/Phòng</b>
                                    </li> 
                                 
                                </ul>
                            </div>

                            <div class="room-details-content">
                                <p>
                                    {!! $roomdetails->description !!}
                                </p>

   <div class="side-bar-plan">
                                <h3>Tiện ích cơ bản</h3>
                                <ul>
                                    @foreach ($facility as $fac)
                                    <li><a href="#">{{ $fac->facility_name }}</a></li>
                                    @endforeach
                                </ul>

                                
                            </div>

<div class="row"> 
 <div class="col-lg-6">



 <div class="services-bar-widget">
                                <h3 class="title">Chi tiết phòng</h3>
        <div class="side-bar-list">
            <ul>
               <li>
                    <a href="#"> <b>Sức chứa : </b>{{ $roomdetails->room_capacity }}</a>
                </li>
                <li>
                     <a href="#"> <b>Kích thước : </b>{{ $roomdetails->size }}m2</a>
                </li>
               
            </ul>
        </div>
    </div>

 </div>

 <div class="col-lg-6">
 <div class="services-bar-widget">
    <h3 class="title">Chi tiết phòng</h3>
    <div class="side-bar-list">
        <ul>
            <li>
                <a href="#"> <b>View : </b>{{ $roomdetails->view }}</a>
            </li>
            <li>
                    <a href="#"> <b>Kiểu giường : </b>{{ $roomdetails->bed_style }} </a>
            </li>
                
        </ul>
    </div>
</div> 

                    </div> 
                        </div>

                            </div>
                            <div class="room-details-review mt-5">
                                <h2>Đánh giá và Xếp hạng của Khách hàng</h2>
                                {{-- Danh sách đánh giá --}}
                                <div class="review-list mb-5">
                                    @forelse($reviews as $review)
                                        <div class="card mb-3 shadow-sm">
                                            <div class="card-body">
                                                <h5>{{ $review->user->name }}</h5>
                                                <p>
                                                    <strong>Phòng:</strong> {{ $review->booking->room->type->name ?? 'N/A' }} <br>
                                                    <strong>Số đêm:</strong> {{ $review->booking->total_night ?? '?' }} |
                                                    <strong>Tháng:</strong> {{ \Carbon\Carbon::parse($review->created_at)->format('F Y') }} |
                                                    <strong>Số người:</strong> {{ $review->booking->persion ?? '?' }} <br>
                                                    <strong>Ngày đánh giá:</strong> {{ $review->created_at->format('d/m/Y') }}
                                                </p>
                                                <div>
                                                    <strong>Đánh giá:</strong>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bx {{ $i <= $review->rating ? 'bxs-star' : 'bx-star' }}" 
                                                        style="{{ $i <= $review->rating ? 'color: red;' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <p class="mt-2">{{ $review->comment }}</p>
                                            </div>

                                            {{-- Phản hồi từ khách sạn --}}
                                            @if ($review->replies->isNotEmpty())
                                                @foreach($review->replies as $reply)
                                                    <div class="card bg-light ms-4 me-4 mb-2 border-start border-primary border-3">
                                                        <div class="card-body py-2">
                                                            <strong class="text-primary">Phản hồi từ khách sạn:</strong>
                                                            <p class="mb-1">{{ $reply->comment }}</p>
                                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                            {{-- Form trả lời nếu là khách sạn và chưa trả lời --}}
                                            @if (auth()->check() && auth()->id() === $review->hotel_id && $review->replies->isEmpty())
                                                <form action="{{ route('reviews.reply', $review->id) }}" method="POST" class="ms-4 me-4 mb-4">
                                                    @csrf
                                                    <textarea name="comment" class="form-control mb-2" placeholder="Phản hồi đánh giá này..." rows="2" required></textarea>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Send Reply</button>
                                                </form>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-muted">Chưa có đánh giá nào.</p>
                                    @endforelse
                                </div>

                                {{-- Form đánh giá hoặc modal validate --}}
                                @if(session('canReview'))
                                    {{-- Form đánh giá --}}
                                    <form method="POST" action="{{ route('reviews.store') }}" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                        <input type="hidden" name="booking_id" value="{{ session('booking_id') }}">

                                        <div class="form-group mb-3">
                                            <label for="rating">Đánh giá:</label>
                                            <div class="form-group">
                                                <label>Đánh giá</label>
                                                <div id="star-rating" class="star-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="rating" required>
                                            </div>

                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="comment">Nhận xét của bạn:</label>
                                            <textarea name="comment" class="form-control" rows="4" required placeholder="Viết nhận xét của bạn tại đây..."></textarea>
                                        </div>

                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Gửi đánh giá
                                        </button>
                                    </form>
                                @else
                                    {{-- Nút xác thực đặt phòng --}}
                                    <button class="default-btn btn-bg-one border-radius-5" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                        Bạn cần đặt phòng trước khi đánh giá – Xác thực đặt phòng
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Room Details Area End -->

        <!-- Room Details Other -->
        <div class="room-details-other pb-70">
            <div class="container">
                <div class="room-details-text">
                    <h2>Các Phòng Khác</h2>
                </div>

                <div class="row ">

                @foreach ($otherRooms as $item)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ url('search/room/details/'.$item->id) }}?check_in={{ request('check_in') }}&check_out={{ request('check_out') }}&persion={{ request('persion') }}">
                                            <img src="{{asset('upload/roomimg/'.$item->image)}}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="room-card-content">
                                         <h3>
                                             <a href="{{ url('search/room/details/'.$item->id) }}?check_in={{ request('check_in') }}&check_out={{ request('check_out') }}&persion={{ request('persion') }}">
                                                {{ $item['type']['name'] }}
                                            </a>
                                        </h3>
                                        <span>{{ $item->price }}</span>
                                        <div class="rating">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div>
                                        <p>{{ $item->short_desc }}</p>
                                        <ul>
                                            <li><i class='bx bx-user'></i>{{ $item->room_capacity }} Người</li>
                                            <li><i class='bx bx-expand'></i>{{ $item->size }}m2</li>
                                        </ul>

                                        <ul>
                                            <li><i class='bx bx-show-alt'></i>{{ $item->view }}</li>
                                            <li><i class='bx bxs-hotel'></i>{{ $item->bed_style }}</li>
                                        </ul>
                                        
                                        <a href="#" class="book-more-btn">
                                            Đặt Ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <!-- Room Details Other End -->



<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">Nhập chi tiết đặt phòng của bạn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <form id="bookingValidationForm" method="POST" action="{{ route('validate.booking.for.review') }}">
        @csrf
        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
        <div class="modal-body">
          <p>Vui lòng kiểm tra email xác nhận đặt phòng để tìm mã số đặt phòng và email đặt phòng:</p>

          <div class="mb-3">
            <label for="booking_code" class="form-label">Mã số đặt phòng</label>
            <input type="text" name="booking_code" id="booking_code" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="booking_email" class="form-label">Email đặt phòng</label>
            <input type="email" name="booking_email" id="booking_email" class="form-control" required>
          </div>

          <p class="text-muted mt-2">
            <small>
              Chỉ khách đặt qua website và nghỉ tại chỗ nghỉ trên mới có thể viết đánh giá. Điều này giúp chúng tôi thu thập các đánh giá từ khách thực, như bạn vậy.
            </small>
          </p>
        </div>

        <div class="modal-footer">
          <button type="submit" class="default-btn btn-bg-one border-radius-5">Đánh giá kỳ nghỉ của bạn</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    $('#btn-show-review').on('click', function () {
        $('#review-form').removeClass('d-none');
        $(this).hide();
    });
</script>


<script>
    $(document).ready(function () {
        var check_in = "{{ old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : '' }}";
        var check_out = "{{ old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : '' }}";
        var hotel_id = "{{ $roomdetails->hotel_id }}";
        var room_id = "{{ $roomdetails->id }}";

        if (check_in !== '' && check_out !== '') {
            getAvaility(check_in, check_out, room_id, hotel_id);
        }

        $("#check_out, #check_in").on('change', function () {
            var check_out = $("#check_out").val();
            var check_in = $("#check_in").val();
            if (check_in !== '' && check_out !== '') {
                getAvaility(check_in, check_out, room_id, hotel_id);
            }
        });

        $(".number_of_rooms").on('change', function () {
            var check_out = $("#check_out").val();
            var check_in = $("#check_in").val();
            if (check_in !== '' && check_out !== '') {
                getAvaility(check_in, check_out, room_id, hotel_id);
            }
        });

        $("#bk_form").on('submit', function () {
            var av_room = $("#available_room").val();
            var select_room = $("#select_room").val();
            if (parseInt(select_room) > av_room) {
                alert('Xin lỗi, bạn đã chọn vượt quá số lượng phòng tối đa');
                return false;
            }

            var number_persion = $("#number_persion").val();
            var total_adult = $("#total_adult").val();
            if (parseInt(number_persion) > parseInt(total_adult)) {
                alert('Xin lỗi, bạn đã chọn vượt quá số lượng người tối đa');
                return false;
            }
        });
    });

    function getAvaility(check_in, check_out, room_id, hotel_id) {
        let number_of_rooms = parseInt($("#select_room").val()) || 1;
        $.ajax({
            url: "{{ route('check_room_availability_hotel') }}",
            data: {
                room_id: room_id,
                check_in: check_in,
                check_out: check_out,
                hotel_id: hotel_id,
                number_of_rooms: number_of_rooms
            },
            success: function (data) {
                $(".available_room").html('Tình trạng phòng : <span class="text-success">' + data['available_room'] + ' Phòng</span>');
                $("#available_room").val(data['available_room']);
                $(".t_subtotal").text(data['total_price'].toLocaleString('vi-VN') + " VNĐ");
                $(".t_discount").text(data['discount_price'].toLocaleString('vi-VN') + " VNĐ");
                $(".t_g_total").text(data['final_price'].toLocaleString('vi-VN') + " VNĐ");

                // Cập nhật bảng giá theo từng ngày
                let tableBody = $("#date_price_table_body");
                tableBody.empty();

                data.date_prices.forEach(item => {
                    let isSpecial = item.is_special ? `<span style="color: red;">* Giá lễ tết áp dụng</span>` : '';
                    let row = `
                        <tr>
                            <td>${item.date}</td>
                            <td>
                                ${item.price.toLocaleString('vi-VN')} VNĐ 
                                (${item.price_per_room?.toLocaleString('vi-VN')} x ${item.room_qty} phòng)
                                ${isSpecial}
                            </td>
                        </tr>`;
                    tableBody.append(row);
                });
            }
        });
    }
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

<script>
    $(document).ready(function () {
        const stars = $('#star-rating .star');

        stars.on('mouseenter', function () {
            const val = $(this).data('value');
            highlightStars(val);
        });

        stars.on('mouseleave', function () {
            const selectedVal = $('#rating').val();
            highlightStars(selectedVal);
        });

        stars.on('click', function () {
            const val = $(this).data('value');
            $('#rating').val(val);
            highlightStars(val);
        });

        function highlightStars(value) {
            stars.each(function () {
                const starVal = $(this).data('value');
                $(this).toggleClass('selected', starVal <= value);
            });
        }
    });
</script>


@endsection
