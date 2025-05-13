@extends('frontend.main_master')
@section('main')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg10">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Room Details </li>
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

        <!-- Room Details Area End -->
        <div class="room-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="room-details-side">
                            <div class="side-bar-form">
                                <h3>Booking Sheet </h3>
                                <form action="{{ route('user_booking_store', $roomdetails->id) }}" method="post" id="bk_form">
                                    @csrf
                                    
                                    <input hidden name="room_id" id="room_id" value="{{ $roomdetails->id }}">
                                    <input hidden name="hotel_id" id="hotel_id" value="{{ $roomdetails->hotel_id }}">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Check in</label>
                                                <div class="input-group">
                                                    <input autocomplete="off" type="text" required name="check_in" id="check_in" class="form-control dt_picker" value="{{ old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : '' }}">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Check Out</label>
                                                <div class="input-group">
                                                    <input autocomplete="off" type="text" required name="check_out" id="check_out" class="form-control dt_picker" value="{{ old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : '' }}">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Numbers of Persons</label>
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
                                                <label>Numbers of Rooms</label>
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
                                                <td><p>SubTotal</p></td>
                                                <td style="text-align: right"><span class="t_subtotal">0</span></td>
                                                </tr>

                                                <tr>
                                                <td><p>Discount</p></td>
                                                <td style="text-align: right"><span class="t_discount">0</span></td>
                                                </tr>

                                                <tr>
                                                <td><p>Total</p></td>
                                                <td style="text-align: right"><span class="t_g_total">0</span></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
            
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                                Book Now
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
                                       <b> Basic : {{ number_format($roomdetails->price, 0, ',', '.') }} VNĐ/Night/Room</b>
                                    </li> 
                                 
                                </ul>
                            </div>

                            <div class="room-details-content">
                                <p>
                                    {!! $roomdetails->description !!}
                                </p>




   <div class="side-bar-plan">
                                <h3>Basic Plan Facilities</h3>
                                <ul>
                                    @foreach ($facility as $fac)
                                    <li><a href="#">{{ $fac->facility_name }}</a></li>
                                    @endforeach
                                </ul>

                                
                            </div>







<div class="row"> 
 <div class="col-lg-6">



 <div class="services-bar-widget">
                                <h3 class="title">Room Details</h3>
        <div class="side-bar-list">
            <ul>
               <li>
                    <a href="#"> <b>Capacity : </b>{{ $roomdetails->room_capacity }}<i class='bx bxs-cloud-download'></i></a>
                </li>
                <li>
                     <a href="#"> <b>Size : </b>{{ $roomdetails->size }}<i class='bx bxs-cloud-download'></i></a>
                </li>
               
               
            </ul>
        </div>
    </div>




 </div>



 <div class="col-lg-6">
 <div class="services-bar-widget">
    <h3 class="title">Room Details</h3>
    <div class="side-bar-list">
        <ul>
            <li>
                <a href="#"> <b>View : </b>{{ $roomdetails->view }}<i class='bx bxs-cloud-download'></i></a>
            </li>
            <li>
                    <a href="#"> <b>Bed Style : </b>{{ $roomdetails->bed_style }} <i class='bx bxs-cloud-download'></i></a>
            </li>
                
        </ul>
    </div>
</div> 

                    </div> 
                        </div>

 

                            </div>

                            <div class="room-details-review">
                                <h2>Clients Review and Retting's</h2>
                                <div class="review-ratting">
                                    <h3>Your retting: </h3>
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
                                                <textarea name="message" class="form-control"  cols="30" rows="8" required data-error="Write your message" placeholder="Write your review here.... "></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three">
                                                Submit Review
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
                    <h2>Other Rooms</h2>
                </div>

                <div class="row ">

                @foreach ($otherRooms as $item)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ url('room/details/'.$item->id) }}">
                                            <img src="{{asset('upload/roomimg/'.$item->image)}}" alt="Images">
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
                                            <li><i class='bx bx-user'></i>{{ $item->room_capacity }} Person</li>
                                            <li><i class='bx bx-expand'></i>{{ $item->size }}m2</li>
                                        </ul>

                                        <ul>
                                            <li><i class='bx bx-show-alt'></i>{{ $item->view }}</li>
                                            <li><i class='bx bxs-hotel'></i>{{ $item->bed_style }}</li>
                                        </ul>
                                        
                                        <a href="#" class="book-more-btn">
                                            Book Now
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
    $(document).ready(function () {
       var check_in = "{{ old('check_in') }}";
       var check_out = "{{ old('check_out') }}";
       var hotel_id = "{{ $roomdetails->hotel_id }}";
       var room_id = "{{ $room_id }}";

       if (check_in != '' && check_out != ''){
          getAvaility(check_in, check_out, room_id, hotel_id);
       }


       $("#check_out").on('change', function () {
          var check_out = $(this).val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id, hotel_id);
          }
       });

       $(".number_of_rooms").on('change', function () {
          var check_out = $("#check_out").val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id, hotel_id);
          }
       });


    });

    function getAvaility(check_in, check_out, room_id, hotel_id) {
       $.ajax({
          url: "{{ route('check_room_availability_hotel') }}",
          data: {room_id:room_id, check_in:check_in, check_out:check_out, hotel_id:hotel_id},
          success: function(data){
             $(".available_room").html('Availability : <span class="text-success">'+data['available_room']+' Rooms</span>');
             $("#available_room").val(data['available_room']);
             price_calculate(data['total_nights']);
          }
       });
    }

    function price_calculate(total_nights){
       var room_price = $("#room_price").val();
       var discount_p = $("#discount_p").val();
       var select_room = $("#select_room").val();

       var sub_total = room_price * total_nights * parseInt(select_room);

       var discount_price = (parseInt(discount_p)/100)*sub_total;

       $(".t_subtotal").text(sub_total);
       $(".t_discount").text(discount_price);
       $(".t_g_total").text(sub_total-discount_price);

    }

    $("#bk_form").on('submit', function () {
       var av_room = $("#available_room").val();
       var select_room = $("#select_room").val();
       if (parseInt(select_room) >  av_room){
          alert('Sorry, you select maximum number of room');
          return false;
       }
       var number_persion = $("#number_persion").val();
       var total_adult = $("#total_adult").val();
       if(parseInt(number_persion) > parseInt(total_adult)){
          alert('Sorry, you select maximum number of person');
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
