@extends('frontend.main_master')
@section('main')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .pagination {
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
    }

    .page-item.active .page-link {
        background-color:rgb(227, 190, 103);
        border-color: rgb(227, 190, 103);
        color: white;
    }

    .page-link {
        color: rgb(227, 190, 103);
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: rgb(227, 190, 103);
    }

    .btn-danger-custom {
        background-color: #d9534f; /* đỏ đậm bootstrap */
        border-color: #d43f3a;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        padding: 6px 14px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-danger-custom:hover {
        background-color: #c9302c;
        box-shadow: 0 4px 10px rgba(217, 83, 79, 0.5);
        color: white;
        text-decoration: none;
    }

    .btn-cancel-custom {
        background-color: #f0ad4e; /* màu cam bootstrap */
        border-color: #eea236;
        color: #fff;
        font-weight: 600;
        border-radius: 6px;
        padding: 6px 14px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-cancel-custom:hover {
        background-color: #ec971f;
        box-shadow: 0 4px 10px rgba(240, 173, 78, 0.5);
        color: white;
        text-decoration: none;
    }
    /* Cố định chiều rộng cột trạng thái */
    .table td:nth-child(8),
    .table th:nth-child(8) {
        width: 170px; /* chỉnh tăng giảm */
        vertical-align: middle;
    }

    /* Cho trạng thái và nút nằm ngang */
    .status-cell {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px; /* khoảng cách giữa trạng thái và nút */
    }
</style>

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
            <div class="status-cell">
            @if ($item->status == 1)
                <span class="badge bg-success">Hoàn thành</span>
                <a href="{{ route('user.booking.report.form', $item->id) }}" class="btn btn-sm btn-danger-custom mt-1">Báo cáo vấn đề</a>
            @else
                <span class="badge bg-info text-dark">Đang chờ</span>
                <a href="{{ route('user.booking.cancel.form', $item->id) }}" class="btn btn-sm btn-cancel-custom mt-1">Huỷ</a>
            @endif
            </div>
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $allData->links('pagination::bootstrap-5') }}
</div>
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
