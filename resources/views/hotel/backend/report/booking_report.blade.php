@extends('hotel.hotel_dashboard')
@section('hotel')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Báo cáo đặt phòng</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Báo cáo đặt phòng</li>
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
                            <form class="row g-3" action="{{ route('hotel.search-by-date') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <!-- Report Type -->
                                <div class="col-md-12">
                                    <label class="form-label">Loại báo cáo</label><br>
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

                                <!-- Date Range -->
                                <div class="col-md-6 date-range">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6 date-range">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>

                                <!-- Week -->
                                <div class="col-md-6 week-input d-none">
                                    <label class="form-label">Chọn tuần</label>
                                    <input type="week" name="week" class="form-control">
                                </div>

                                <!-- Month -->
                                <div class="col-md-6 month-input d-none">
                                    <label class="form-label">Chọn tháng</label>
                                    <input type="month" name="month" class="form-control">
                                </div>

                                <!-- Year -->
                                <div class="col-md-6 year-input d-none">
                                    <label class="form-label">Chọn năm</label>
                                    <input type="number" name="year" class="form-control" min="2000" max="2100" placeholder="VD 2025">
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary px-4">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
