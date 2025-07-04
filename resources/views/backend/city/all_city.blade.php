@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tất Cả Thành Phố</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.city') }}" class="btn btn-primary px-5"> Thêm Thành Phố </a>
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
                            <th>Tên</th>
                            <th>Mô Tả</th>
                            <th>Hình Ảnh</th>
                            <th>Slug</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $key => $city)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $city->name }}</td>
                                <td>{{ $city->description }}</td>
                                <td>
                                    @if($city->image)
                                        <img src="{{ asset($city->image) }}" alt="City Image" style="width:70px; height:50px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $city->slug }}</td>
                                <td>
                                    <a href="{{ route('edit.city', $city->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('delete.city', $city->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
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
