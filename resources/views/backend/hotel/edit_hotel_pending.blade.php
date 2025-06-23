@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh sửa khách sạn</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa khách sạn</li>
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
                        <form action="{{ route('update.hotel.pending', $hotel->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $hotel->id }}" />
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tên khách sạn</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" value="{{ $hotel->name }}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email khách sạn</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email" class="form-control" value="{{ $hotel->email }}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Số điện thoại</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="phone" class="form-control" value="{{ $hotel->phone }}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Địa chỉ</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="address" class="form-control" value="{{ $hotel->address }}" readonly/>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Thành phố</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-control" disabled>
                                            <option value="" disabled>Chọn thành phố</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $hotel->city_id == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="city_id" value="{{ $hotel->city_id }}">

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Ảnh khách sạn</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" 
                                            src="{{ (!empty($hotel->photo)) ? url($hotel->photo) : url('upload/no_image.jpg') }}" 
                                            alt="Hotel Image" class="rounded-circle p-1 bg-primary" width="200">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Trạng thái</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="status" class="form-control">
                                            <option value="active" {{ $hotel->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ $hotel->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                            <option value="pending" {{ $hotel->status == 'pending' ? 'selected' : '' }}>Đang chờ phê duyệt</option>
                                            <option value="cancelled" {{ $hotel->status == 'cancelled' ? 'selected' : '' }}>Phê duyệt không thành công</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Lưu thay đổi" />
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>

@endsection
