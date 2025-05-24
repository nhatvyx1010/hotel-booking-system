@extends('hotel.hotel_dashboard')
@section('hotel')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Booking Report</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking Report</li>
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
                                    <label class="form-label">Report Type</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="date" checked>
                                        <label class="form-check-label">By Date Range</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="week">
                                        <label class="form-check-label">By Week</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="month">
                                        <label class="form-check-label">By Month</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input report-option" type="radio" name="report_type" value="year">
                                        <label class="form-check-label">By Year</label>
                                    </div>
                                </div>

                                <!-- Date Range -->
                                <div class="col-md-6 date-range">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6 date-range">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>

                                <!-- Week -->
                                <div class="col-md-6 week-input d-none">
                                    <label class="form-label">Select Week</label>
                                    <input type="week" name="week" class="form-control">
                                </div>

                                <!-- Month -->
                                <div class="col-md-6 month-input d-none">
                                    <label class="form-label">Select Month</label>
                                    <input type="month" name="month" class="form-control">
                                </div>

                                <!-- Year -->
                                <div class="col-md-6 year-input d-none">
                                    <label class="form-label">Select Year</label>
                                    <input type="number" name="year" class="form-control" min="2000" max="2100" placeholder="e.g. 2025">
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary px-4">Search</button>
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
