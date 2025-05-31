@extends('frontend.main_master')
@section('main')

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg10">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Trang Chủ</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Chi Tiết Phòng</li>
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
                                <h3>Phiếu Đặt Phòng </h3>
                                <form id="bk_form">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Ngày Check in</label>
                <div class="input-group">
                    <input autocomplete="off" type="text" required name="check_in" id="check_in" class="form-control dt_picker" value="{{ old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : '' }}">
                    <span class="input-group-addon"></span>
                </div>
                <i class='bx bxs-calendar'></i>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Ngày Check out</label>
                <div class="input-group">
                    <input autocomplete="off" type="text" required name="check_out" id="check_out" class="form-control dt_picker" value="{{ old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : '' }}">
                    <span class="input-group-addon"></span>
                </div>
                <i class='bx bxs-calendar'></i>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Số Người</label>
                <select class="form-control" id="number_persion" name="number_persion">
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                </select>	
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Số Phòng</label>
                <select class="form-control number_of_rooms" id="select_room" name="select_room">
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                </select>	
            </div>
        </div>

        <input type="hidden" name="available_room" id="available_room">
        <p class="available_room"></p>

        <input type="hidden" id="room_price" value="{{ $roomdetails->price }}">
        <input type="hidden" id="discount_p" value="{{ $roomdetails->discount ?? 0 }}">
        <input type="hidden" id="total_adult" value="{{ $roomdetails->room_capacity }}">
        
        <div class="col-lg-12 col-md-12">
            <button type="submit" class="default-btn btn-bg-three border-radius-5">Đặt Ngay</button>
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
                                <h3>Tiện Nghi Kế Hoạch Cơ Bản</h3>
                                <ul>
                                    @foreach ($facility as $fac)
                                    <li><a href="#">{{ $fac->facility_name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

<div class="row"> 
 <div class="col-lg-6">
 <div class="services-bar-widget">
                                <h3 class="title">Chi Tiết Phòng</h3>
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
        <h3 class="title">Chi Tiết Phòng</h3>
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

                            <div class="room-details-review">
                                <h2>Đánh giá và Xếp hạng của Khách Hàng</h2>
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
                                                <textarea name="message" class="form-control"  cols="30" rows="8" required data-error="Viết nhận xét của bạn" placeholder="Viết nhận xét của bạn tại đây.... "></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three">
                                                Gửi nhận xét
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
                    <h2>Các phòng khác</h2>
                </div>

                <div class="row ">

                @foreach ($otherRooms as $item)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ url('search/room/details/'.$item->id) }}">
                                            <img src="{{asset('upload/roomimg/'.$item->image)}}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="room-card-content">
                                         <h3>
                                             <a href="{{ url('search/room/details/'.$item->id) }}">{{ $item['type']['name'] }}</a>
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
$(document).ready(function () {
    var check_in = "{{ old('check_in') }}";
    var check_out = "{{ old('check_out') }}";
    var hotel_id = "{{ $roomdetails->hotel_id }}";
    var room_id = "{{ $room_id }}";

    if (check_in != '' && check_out != '') {
        getAvaility(check_in, check_out, room_id, hotel_id);
    }

    $("#check_in, #check_out").on('change', function () {
        let check_in = $("#check_in").val();
        let check_out = $("#check_out").val();
        if (check_in !== '' && check_out !== '') {
            getAvaility(check_in, check_out, room_id, hotel_id);
        }
    });

    $(".number_of_rooms").on('change', function () {
        let check_in = $("#check_in").val();
        let check_out = $("#check_out").val();
        if (check_in !== '' && check_out !== '') {
            getAvaility(check_in, check_out, room_id, hotel_id);
        }
    });
});

function getAvaility(check_in, check_out, room_id, hotel_id) {
    $.ajax({
        url: "{{ route('check_room_availability_hotel') }}",
        data: {
            room_id: room_id,
            check_in: check_in,
            check_out: check_out,
            hotel_id: hotel_id
        },
        success: function (data) {
            $(".available_room").html('Tình trạng phòng : <span class="text-success">' + data['available_room'] + ' Phòng</span>');
            $("#available_room").val(data['available_room']);
            price_calculate(data['total_nights']);
        }
    });
}

function price_calculate(total_nights) {
    var room_price = $("#room_price").val();
    var discount_p = $("#discount_p").val();
    var select_room = $("#select_room").val();

    var sub_total = room_price * total_nights * parseInt(select_room);
    var discount_price = (parseInt(discount_p) / 100) * sub_total;

    $(".t_subtotal").text(sub_total.toLocaleString());
    $(".t_discount").text(discount_price.toLocaleString());
    $(".t_g_total").text((sub_total - discount_price).toLocaleString());
}

$("#bk_form").on('submit', function () {
    var av_room = parseInt($("#available_room").val());
    var select_room = parseInt($("#select_room").val());

    if (select_room > av_room) {
        alert('Xin lỗi, bạn đã chọn số phòng nhiều hơn số phòng hiện có.');
        return false;
    }

    var number_persion = parseInt($("#number_persion").val());
    var total_adult = parseInt($("#total_adult").val());

    if (number_persion > total_adult) {
        alert('Xin lỗi, số người vượt quá sức chứa của phòng.');
        return false;
    }
});
</script>


@endsection
