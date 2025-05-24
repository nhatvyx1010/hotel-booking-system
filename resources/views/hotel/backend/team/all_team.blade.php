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
								<li class="breadcrumb-item active" aria-current="page">Tất Cả Thành Viên Đội Ngũ</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                        <a href="{{ route('hotel.add.team') }}" class="btn btn-primary px-5"> Thêm Thành Viên </a>
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
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Chức Vụ</th>
                            <th>Facebook</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($team as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><img src="{{ asset($item->image) }}" alt="" style="width:70px; height:40px"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->position }}</td>
                                <td>{{ $item->facebook }}</td>
                                <td>
                                    <a href="{{ route('hotel.edit.team', $item->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('hotel.delete.team', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
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
