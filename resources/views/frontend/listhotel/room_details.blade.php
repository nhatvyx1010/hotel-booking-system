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
                                <h3>Phiếu Đặt Phòng</h3>
                                <form>
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Ngày Nhận Phòng</label>
                                                <div class="input-group">
                                                    <input id="datetimepicker" type="text" class="form-control" placeholder="01/06/2025">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Ngày Trả Phòng</label>
                                                <div class="input-group">
                                                    <input id="datetimepicker-check" type="text" class="form-control" placeholder="05/06/2025">
                                                    <span class="input-group-addon"></span>
                                                </div>
                                                <i class='bx bxs-calendar'></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Số Người</label>
                                                <select class="form-control">
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
                                                <select class="form-control">
                                                    <option>01</option>
                                                    <option>02</option>
                                                    <option>03</option>
                                                    <option>04</option>
                                                    <option>05</option>
                                                </select>	
                                            </div>
                                        </div>
            
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                               Đặt Ngay
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
                                       <b> Cơ bản : {{ number_format($roomdetails->price, 0, ',', '.') }} VNĐ/Night/Room</b>
                                    </li> 
                                 
                                </ul>
                            </div>

                            <div class="room-details-content">
                                <p>
                                    {!! $roomdetails->description !!}
                                </p>




   <div class="side-bar-plan">
                                <h3>Tiện Nghi Cơ Bản</h3>
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
                    <a href="#"> <b>Sức Chứa : </b>{{ $roomdetails->room_capacity }}</a>
                </li>
                <li>
                     <a href="#"> <b>Kích Thước : </b>{{ $roomdetails->size }}m2</a>
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
                     <a href="#"> <b>Kiểu Giường : </b>{{ $roomdetails->bed_style }}</a>
                </li>
                 
            </ul>
        </div>
    </div> 

                    </div> 
                        </div>

 

                            </div>

                            <div class="room-details-review">
                                <h2>Đánh Giá Và Nhận Xét Của Khách Hàng</h2>
                                <div class="review-ratting">
                                    <h3>Đánh Giá Của Bạn: </h3>
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
                                                <textarea name="message" class="form-control"  cols="30" rows="8" required data-error="Viết nhận xét của bạn" placeholder="Viết nhận xét của bạn ở đây.... "></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn btn-bg-three">
                                                Gửi Nhận Xét
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
                    <h2>Phòng Khác</h2>
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
                                            <li><i class='bx bx-user'></i>{{ $item->room_capacity }} Người</li>
                                            <li><i class='bx bx-expand'></i>{{ $item->size }}m2</li>
                                        </ul>

                                        <ul>
                                            <li><i class='bx bx-show-alt'></i>{{ $item->view }}</li>
                                            <li><i class='bx bxs-hotel'></i>{{ $item->bed_style }}</li>
                                        </ul>
                                        
                                        <a href="room-details.html" class="book-more-btn">
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

@endsection
