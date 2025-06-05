@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách khách sạn đang hoạt động</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.hotel') }}" class="btn btn-primary px-5"> Thêm khách sạn </a>
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
                            <th>Hình ảnh</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Thành phố</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $key => $hotel)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($hotel->photo)
                                        <img src="{{ asset('upload/admin_images/' . $hotel->photo) }}" alt="" style="width:70px; height:40px">
                                    @else
                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="" style="width:70px; height:40px">
                                    @endif
                                </td>
                                <td>{{ $hotel->name }}</td>
                                <td>{{ $hotel->email }}</td>
                                <td>{{ $hotel->phone }}</td>
                                <td>{{ $hotel->address }}</td>
                                <td>{{ $hotel->city ? $hotel->city->name : 'N/A' }}</td>
                                <td>{{ ucfirst($hotel->status) }}</td>
                                <td>
                                    <a href="{{ route('edit.hotel', $hotel->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('delete.hotel', $hotel->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
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
