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
								<li class="breadcrumb-item active" aria-current="page">Danh sách hủy đặt phòng</li>
							</ol>
						</nav>
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
                            <th>Ngày đặt</th>
                            <th>Khách hàng</th>
                            <th>Loại phòng</th>
                            <th>Ngày nhận/trả phòng</th>
                            <th>Tổng số phòng</th>
                            <th>Khách</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allData as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a href="{{ route('hotel.edit_booking', $item->id) }}"> {{ $item->code }}</a></td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item['user']['name'] }}</td>
                                <td>{{ $item['room']['type']['name'] }}</td>
                                <td><span class="badge bg-primary"> {{ $item->check_in }}</span> / <br><span class="badge bg-warning text-dark"> {{ $item->check_out }}</span></td>
                                <td>{{ $item->number_of_rooms }}</td>
                                <td>{{ $item->persion }}</td>
                                <td>
                                    @if($item->payment_status == '1')
                                        <span class="text-success">Hoàn thành</span>
                                    @else
                                        <span class="text-danger">Chờ xử lý</span>
                                    @endif
                                </td>
                                <td>@if($item->status == '1')
                                        <span class="text-success">Hoạt động</span>
                                    @else
                                        <span class="text-danger">Chờ xử lý</span>
                                    @endif</td>
                                <td>
                                    <a href="{{ route('hotel.booking.cancel_pending.detail', $item->id) }}" class="btn btn-primary px-3 radius-30" >Chi tiết</a>
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
