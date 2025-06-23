@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh Sửa Khách Hàng</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Khách Hàng</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <form method="POST" action="{{ route('customer.update', $customer->id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                {{-- Name --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tên khách hàng</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Số điện thoại</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required>
                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Photo --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Ảnh đại diện</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="photo" class="form-control">
                                        @if($customer->photo)
                                            <img src="{{ asset($customer->photo) }}" alt="Ảnh khách hàng" class="mt-2" style="width: 100px; height: 70px;">
                                        @endif
                                        @error('photo') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                                        <a href="{{ route('all.customer') }}" class="btn btn-secondary px-4">Hủy</a>
                                    </div>
                                </div>

                            </div> <!-- End card-body -->
                        </form>
                    </div> <!-- End card -->
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
