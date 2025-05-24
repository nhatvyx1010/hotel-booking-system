@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Báo cáo Đặt phòng</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Báo cáo Đặt phòng
                        @if(!empty($startDate) && !empty($endDate))
                            <span class="ms-2 badge bg-success">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</span>
                            đến
                            <span class="badge bg-danger">{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</span>
                        @endif
                    </li>

                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <form class="row g-3" action="{{ route('search-by-date') }}" method="POST">
                                @csrf

                                {{-- Report Type --}}
                                <div class="col-md-12">
                                    <label class="form-label">Tùy chọn báo cáo</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="date" checked>
                                        <label class="form-check-label">Theo khoảng ngày</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="week">
                                        <label class="form-check-label">Theo tuần</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="month">
                                        <label class="form-check-label">Theo tháng</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="year">
                                        <label class="form-check-label">Theo năm</label>
                                    </div>
                                </div>

                                {{-- Date Range --}}
                                <div class="col-md-6 date-range">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6 date-range">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>

                                {{-- Week --}}
                                <div class="col-md-6 week-input d-none">
                                    <label class="form-label">Chọn tuần</label>
                                    <input type="week" name="week" class="form-control">
                                </div>

                                {{-- Month --}}
                                <div class="col-md-6 month-input d-none">
                                    <label class="form-label">Chọn tháng</label>
                                    <input type="month" name="month" class="form-control">
                                </div>

                                {{-- Year --}}
                                <div class="col-md-6 year-input d-none">
                                    <label class="form-label">Chọn năm</label>
                                    <input type="number" name="year" class="form-control" min="2000" max="2100" placeholder="Ví dụ: 2025">
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary px-4">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Table hiển thị kết quả nếu có --}}
                    @isset($bookings)
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="mb-3">Kết quả tìm kiếm</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã đặt phòng</th>
                                            <th>Tên khách</th>
                                            <th>Email</th>
                                            <th>Tên khách sạn</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->room->type->name ?? 'N/A' }}</td>
                                                <td>{{ $item->payment_method }}</td>
                                                <td>{{ number_format($item->total_price, 0, ',', '.') }} VNĐ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.report-option').change(function () {
            const type = $(this).val();
            $('.date-range, .week-input, .month-input, .year-input').addClass('d-none');

            if (type === 'date') {
                $('.date-range').removeClass('d-none');
            } else if (type === 'week') {
                $('.week-input').removeClass('d-none');
            } else if (type === 'month') {
                $('.month-input').removeClass('d-none');
            } else if (type === 'year') {
                $('.year-input').removeClass('d-none');
            }
        });
    });
</script>
@endsection
