@extends('frontend.main_master')
@section('main')
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

        <!-- Room Details Area End -->
        <div class="room-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="room-details-side">
                            <div class="side-bar-form">
                                <h3>Phiếu đặt phòng</h3>
                                <form action="{{ route('user_booking_store', $roomdetails->id) }}" method="post" id="bk_form">
                                    @csrf
                                    
                                    <input type="hidden" name="room_id" value="{{ $roomdetails->id }}">
                                    <div class="row align-items-center">
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


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Số người</label>
                                                <select class="form-control" name="persion" id="number_persion">
                                                    @for($i = 1; $i <= 4; $i++)
                                                        <option {{ old('persion') == $i ? 'selected' : '' }} value="0{{ $i }}">0{{ $i }}</option>
                                                    @endfor
                                                </select>	
                                            </div>
                                        </div>

                                        <input type="hidden" id="total_adult" value="{{ $roomdetails->total_adult }}">
                                        <input type="hidden" id="room_price" value="{{ $roomdetails->price }}">
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
                                        <div class="col-lg-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                <td><p>Tạm tính</p></td>
                                                <td style="text-align: right"><span class="t_subtotal">0</span></td>
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
                                    <img src="{{ asset($image->multi_img) }}" alt="Images">
                                </div>
                                @endforeach 
                            </div>
                            <div class="room-details-title">
                                <h2>{{ $roomdetails->type->name }}</h2>
                                <ul>
                                    
                                    <li>
                                       <b> Cơ bản : {{ number_format($roomdetails->price, 0, ',', '.') }} VNĐ/Đêm/Phòng</b>
                                    </li> 
                                 
                                </ul>
                            </div>

                            <div class="room-details-content">
                                <p>
                                    {!! $roomdetails->description !!}
                                </p>

   <div class="side-bar-plan">
                                <h3>Tiện nghi gói cơ bản</h3>
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
                     <a href="#"> <b>Diện tích : </b>{{ $roomdetails->size }}m2</a>
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
                     <a href="#"> <b>Kiểu giường : </b>{{ $roomdetails->bed_style }}</a>
                </li>
                 
            </ul>
        </div>
    </div> 

                    </div> 
                        </div>

 

                            </div>

                            <div class="room-details-review">
                                <h2>Đánh giá và xếp hạng từ khách hàng</h2>
                                <div class="review-ratting">
                                    <h3>Đánh giá của bạn: </h3>
                                    <i class='bx bx-star'></i>
                                    <i class='bx bx-star'></i>
                                    <i class='bx bx-star'></i>
                                    <i class='bx bx-star'></i>
                                    <i class='bx bx-star'></i>
                                </div>
                                <form >
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control"  cols="30" rows="8" required data-error="Viết đánh giá của bạn" placeholder="Viết đánh giá của bạn tại đây.... "></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three">
                                                Gửi đánh giá
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                    <h2>Phòng khác</h2>
                </div>

                <div class="row ">

                @foreach ($otherRooms as $item)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ url('room/details/'.$item->id) }}">
                                            <img src="{{asset($item->image)}}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="room-card-content">
                                         <h3>
                                             <a href="{{ url('room/details/'.$item->id) }}">{{ $item['type']['name'] }}</a>
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
                                            <li><i class='bx bx-user'></i>{{ $item->room_capacity }} người</li>
                                            <li><i class='bx bx-expand'></i>{{ $item->size }}m2</li>
                                        </ul>

                                        <ul>
                                            <li><i class='bx bx-show-alt'></i>{{ $item->view }}</li>
                                            <li><i class='bx bxs-hotel'></i>{{ $item->bed_style }}</li>
                                        </ul>
                                        
                                        <a href="room-details.html" class="book-more-btn">
                                            Đặt phòng ngay
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

        <script>
            
    function formatCurrency(number) {
        return number.toLocaleString('vi-VN') + ' VNĐ';
    }
    
    $(document).ready(function () {
       var check_in = "{{ old('check_in') }}";
       var check_out = "{{ old('check_out') }}";
       var room_id = "{{ $room_id }}";
       if (check_in != '' && check_out != ''){
          getAvaility(check_in, check_out, room_id);
       }


       $("#check_out").on('change', function () {
          var check_out = $(this).val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });

       $(".number_of_rooms").on('change', function () {
          var check_out = $("#check_out").val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });


    });

    function getAvaility(check_in, check_out, room_id) {
       $.ajax({
          url: "{{ route('check_room_availability') }}",
          data: {room_id:room_id, check_in:check_in, check_out:check_out},
          success: function(data){
             $(".available_room").html('Availability : <span class="text-success">'+data['available_room']+' Phòng</span>');
             $("#available_room").val(data['available_room']);
             price_calculate(data['total_nights']);
          }
       });
    }

    function price_calculate(total_nights) {
        var room_price = parseFloat($("#room_price").val()) || 0;
        var discount_p = parseFloat($("#discount_p").val()) || 0;
        var select_room = parseInt($("#select_room").val()) || 1;

        var sub_total = room_price * total_nights * select_room;
        var discount_price = (discount_p / 100) * sub_total;

        $(".t_subtotal").text(formatCurrency(sub_total));
        $(".t_discount").text(formatCurrency(discount_price));
        $(".t_g_total").text(formatCurrency(sub_total - discount_price));
    }

    $("#bk_form").on('submit', function () {
       var av_room = $("#available_room").val();
       var select_room = $("#select_room").val();
       if (parseInt(select_room) >  av_room){
          alert('Xin lỗi, bạn đã chọn vượt quá số lượng phòng cho phép');
          return false;
       }
       var number_persion = $("#number_persion").val();
       var total_adult = $("#total_adult").val();
       if(parseInt(number_persion) > parseInt(total_adult)){
          alert('Xin lỗi, bạn đã chọn vượt quá số lượng người cho phép');
          return false;
       }

    })
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
