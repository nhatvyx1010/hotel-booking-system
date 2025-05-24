@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh Sửa Thành Phố</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Thành Phố</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <form action="{{ route('city.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $city->id }}" />
                            <input type="hidden" name="old_image" value="{{ $city->image }}" />

                            <div class="card-body">

                                {{-- Name --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tên Thành Phố</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" value="{{ $city->name }}" required />
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mô Tả</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea name="description" class="form-control" rows="4" required>{{ $city->description }}</textarea>
                                    </div>
                                </div>

                                {{-- Slug --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Slug</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="slug" class="form-control" value="{{ $city->slug }}" required readonly/>
                                    </div>
                                </div>

                                {{-- Image --}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Hình Ảnh Thành Phố</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="image" class="form-control" />
                                        @if($city->image)
                                            <img src="{{ asset($city->image) }}" alt="City Image" class="mt-2" style="width: 120px; height: auto;">
                                        @endif
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Lưu Thay Đổi" />
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>

</div>

@endsection
