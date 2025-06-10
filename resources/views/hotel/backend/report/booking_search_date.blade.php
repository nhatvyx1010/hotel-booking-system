@extends('hotel.hotel_dashboard')
@section('hotel')
<div class="page-content">

        				<!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Tất cả Đặt phòng</li>
								<li class="breadcrumb-item active" aria-current="page">Tìm kiếm theo Ngày</li>
								<li class="breadcrumb-item active" aria-current="page"><span class="badge bg-success">{{ $startDate }}</span> to <span class="badge bg-danger">{{ $endDate }}</span></li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                            <a href="{{ route('hotel.booking.report') }}" class="btn btn-primary px-5 me-2">Báo cáo Đặt phòng</a>
                            <a href="{{ route('hotel.booking.export.excel', [
                                    'start_date' => \Carbon\Carbon::parse($startDate)->format('Y-m-d'),
                                    'end_date' => \Carbon\Carbon::parse($endDate)->format('Y-m-d')
                                ]) }}" class="btn btn-success px-4">

                                <i class="lni lni-exit"></i> Xuất Excel
                            </a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã đặt phòng</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Phương thức Thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ number_format($item->total_price, 0, ',', '.') }} VNĐ</td>
                                <td>
                                <a href="{{ route('hotel.download.invoice', $item->id) }}" class="btn btn-warning px-3 radius-10"><i class="lni lni-download"></i>Tải Hóa đơn</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr/>

</div>

@endsection
