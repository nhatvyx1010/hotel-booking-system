@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Thêm Khách Hàng</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Khách Hàng</li>
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
                        <form id="myForm" action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Họ và Tên</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" />
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Email</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" />
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Số Điện Thoại</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" />
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Mật Khẩu</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" />
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Nhập Lại Mật Khẩu</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password_confirmation" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Ảnh Đại Diện</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input class="form-control @error('photo') is-invalid @enderror" name="photo" type="file" id="image" />
                                        @error('photo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Preview" class="rounded-circle p-1 bg-primary" width="80">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Lưu" />
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

<!-- Show image preview -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

<!-- Form validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#myForm').validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                phone: { required: true },
                password: { required: true, minlength: 6 },
                password_confirmation: { required: true, equalTo: '[name="password"]' },
                photo: { required: true }
            },
            messages: {
                name: { required: 'Vui lòng nhập tên khách hàng' },
                email: {
                    required: 'Vui lòng nhập email',
                    email: 'Email không hợp lệ'
                },
                phone: { required: 'Vui lòng nhập số điện thoại' },
                password: {
                    required: 'Vui lòng nhập mật khẩu',
                    minlength: 'Mật khẩu tối thiểu 6 ký tự'
                },
                password_confirmation: {
                    required: 'Vui lòng xác nhận mật khẩu',
                    equalTo: 'Mật khẩu không khớp'
                },
                photo: { required: 'Vui lòng chọn ảnh đại diện' }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

@endsection
