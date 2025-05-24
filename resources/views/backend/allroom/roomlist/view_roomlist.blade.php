@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

        				<!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Danh sách phòng</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                        <a href="{{ route('add.room.list') }}" class="btn btn-primary px-5"> Thêm đặt phòng </a>
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
                            <th>Loại phòng</th>
                            <th>Số phòng</th>
                            <th>Trạng thái đặt phòng</th>
                            <th>Ngày nhận/trả phòng</th>
                            <th>Mã số đặt phòng</th>
                            <th>Khách hàng</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($room_number_list as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->room_no }}</td>
                                <td>
                                    @if($item->booking_id != '')
                                        @if($item->booking_status == 1)
                                            <span class="badge bg-danger">Đã đặt</span>
                                        @else
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Còn trống</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->booking_id != '')
                                        <span class="badge rounded-pill bg-secondary">{{ date('d-m-Y', strtotime($item->check_in)) }}</span>
                                        đến
                                        <span class="badge rounded-pill bg-info text-dark">{{ date('d-m-Y', strtotime($item->check_out)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->booking_id != '')
                                    {{$item->booking_number}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->booking_id != '')
                                    {{$item->customer_name}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 'Active')
                                    <span class="badge bg-success">Đã xuất bản</span>
                                    @else
                                    <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
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
