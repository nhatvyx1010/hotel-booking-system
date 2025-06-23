@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tất Cả Khách Hàng</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.customer') }}" class="btn btn-primary px-5"> Thêm Khách Hàng </a>
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
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Hình Ảnh</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '---' }}</td>

                                <td>
                                    @if($customer->photo)
                                        <img src="{{ asset($customer->photo) }}" alt="" style="width:70px; height:40px">
                                    @else
                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="" style="width:70px; height:40px">
                                    @endif
                                </td>
                                </td>
                                <td>{{ optional($customer->created_at)->format('d/m/Y') ?? '---' }}</td>
                                <td>
                                    <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('customer.delete', $customer->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
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
