@extends('hotel.hotel_dashboard')
@section('hotel')
<div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách tất cả phòng</li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="GET" action="{{ route('hotel.view.room.list') }}" class="mb-3 d-flex align-items-center">
        <label for="date" class="me-2 mb-0">Chọn ngày:</label>
        <input type="date" id="date" name="date" class="form-control" 
            value="{{ request('date') ?? date('Y-m-d') }}" style="width: 150px;" />
        <button type="submit" class="btn btn-primary ms-2">Xem</button>
    </form>

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Loại Phòng</th>
                            <th>Số Phòng</th>
                            <th>Trạng Thái Đặt</th>
                            <th>Ngày Nhận / Trả Phòng</th>
                            <th>Mã Đặt Phòng</th>
                            <th>Khách Hàng</th>
                            <th>Trạng Thái</th>
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
                                            <span class="badge bg-warning">Đang chờ</span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Còn trống</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->booking_id != '')
                                        <span class="badge rounded-pill bg-secondary">{{ date('d-m-Y', strtotime($item->check_in)) }}</span>
                                        to
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
                                    <span class="badge bg-success">Đang hoạt động</span>
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
