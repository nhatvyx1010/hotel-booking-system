@extends('frontend.main_master')
@section('main')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Inner Banner -->
<div class="inner-banner inner-bg6">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="index.html">Trang chủ</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Danh sách đặt phòng của người dùng </li>
            </ul>
            <h3>Danh sách đặt phòng của người dùng</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Service Details Area -->
<div class="service-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.dashboard.user_menu')
            </div>


            <div class="col-lg-9">
                <div class="service-article">
                    

    <section class="checkout-area pb-70">
    <div class="container">
    <form action="{{ route('password.change.store') }}" method="post" enctype="multipart/form-data">
    @csrf
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="billing-details">
                        <h3 class="title">Danh sách đặt phòng của người dùng</h3>

                        <table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">Số đặt phòng</th>  
        <th scope="col">Tên khách sạn</th>  
        <th scope="col">Ngày đặt phòng</th>  
        <th scope="col">Khách hàng</th>  
        <th scope="col">Phòng</th>  
        <th scope="col">Ngày nhận / trả phòng</th>  
        <th scope="col">Tổng số phòng</th>  
        <th scope="col">Trạng thái</th>  
    </tr>
  </thead>
  <tbody>
    @foreach ($allData as $item)
    <tr>
      <td><a href="{{ route('user.invoice', $item->id) }}">{{ $item->code }}</a></td>
      <td>{{ $item['room']['hotel']['name'] }}</td>
      <td>{{ $item->created_at->format('d/m/Y') }}</td>
      <td>{{ $item['user']['name'] }}</td>
      <td>
        {{ $item['room'] ? $item['room']['type']['name'] : 'Không có phòng/loại' }}
    </td>

      <td><span class="badge bg-primary">{{ $item->check_in }}</span><span class="badge bg-warning text-dark">{{ $item->check_out }}</span> </td>
      <td>{{ $item->number_of_rooms }}</td>
      <td>
        @if ($item->status == 1)
            <span class="badge bg-success">Hoàn thành</span>
        @else
            <span class="badge bg-info text-dark">Đang chờ</span>
        @endif
        <a href="{{ route('user.booking.cancel.form', $item->id) }}" class="btn btn-sm btn-danger mt-2">Huỷ</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

</div>
</div>
</div>
</form>      
        
    </div>
</section>
                    
                </div>
            </div>

            
        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection
