@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Thêm Khách Sạn</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Khách Sạn</li>
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
                        <form id="hotelForm" action="{{ route('store.hotel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Tên</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Email</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="email" name="email" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Số Điện Thoại</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="phone" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Địa chỉ</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="address" class="form-control" />
                                    </div>
                                </div>

                                <input type="hidden" name="city_id" id="city_id">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Thành phố</h6>
                                    </div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input list="cities" name="city_name" class="form-control" placeholder="Nhập tên thành phố" required>
                                        <datalist id="cities">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                                            @endforeach
                                        </datalist>
                                        @error('city_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Mật khẩu</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Xác nhận mật khẩu</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password_confirmation" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Hình ảnh</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input class="form-control" name="photo" type="file" id="photo" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showPhoto" src="{{ url('upload/no_image.jpg') }}" class="rounded-circle p-1 bg-primary" width="80" alt="Preview">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">File âm thanh</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input class="form-control" name="hotel_audio" type="file" id="audio" accept="audio/*" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <audio id="showAudio" controls style="display:none; width: 100%;">
                                            <source src="" type="audio/mp4">
                                            Trình duyệt của bạn không hỗ trợ thẻ audio.
                                        </audio>
                                    </div>
                                </div>
                                <!-- End phần upload âm thanh -->

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Lưu khách sạn" />
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

<!-- Preview image -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#photo').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showPhoto').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#photo').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showPhoto').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        $('#audio').change(function(e){
            const file = e.target.files[0];
            if (file) {
                const audioURL = URL.createObjectURL(file);
                $('#showAudio').attr('src', audioURL).show();
            } else {
                $('#showAudio').hide();
            }
        });
    });
</script>

<!-- Form Validation -->
<script type="text/javascript">
    $(document).ready(function (){
        $('#hotelForm').validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                phone: { required: true },
                address: { required: true },
                password: { required: true, minlength: 6 },
                photo: { required: true }
            },
            messages :{
                name: { required: 'Vui lòng nhập tên' },
                email: { required: 'Vui lòng nhập email', email: 'Định dạng email không đúng' },
                phone: { required: 'Vui lòng nhập số điện thoại' },
                address: { required: 'Vui lòng nhập địa chỉ' },
                password: { required: 'Vui lòng nhập mật khẩu', minlength: 'Tối thiểu 6 ký tự' },
                photo: { required: 'Vui lòng chọn hình ảnh' },
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cityInput = document.querySelector('input[name="city_name"]');
        const cityIdInput = document.getElementById('city_id');
        const datalist = document.getElementById('cities');

        cityInput.addEventListener('input', function () {
            const value = cityInput.value;
            const option = Array.from(datalist.options).find(opt => opt.value === value);
            if (option) {
                cityIdInput.value = option.getAttribute('data-id');
            } else {
                cityIdInput.value = ''; // clear if not matched
            }
        });
    });
</script>

@endsection
