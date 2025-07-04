@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh sửa lời nhận xét</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa lời nhận xét</li>
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
            <form id="myForm" action="{{ route('testimonial.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $testimonial->id }}">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tên</h6>
                    </div>
                    <div class="form-group col-sm-9 text-secondary">
                        <input type="text" name="name" class="form-control" value="{{ $testimonial->name }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Thành phố</h6>
                    </div>
                    <div class="form-group col-sm-9 text-secondary">
                        <input type="text" name="city" class="form-control" value="{{ $testimonial->city }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Lời nhắn</h6>
                    </div>
                    <div class="form-group col-sm-9 text-secondary">
                    <textarea name="message" class="form-control" id="input11" rows="3"> {{ $testimonial->message }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Ảnh</h6>
                    </div>
                    <div class="form-group col-sm-9 text-secondary">
                        <input class="form-control" name="image" type="file" id="image" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <img id="showImage" src="{{ asset($testimonial->image) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80">
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

        <script type="text/javascript">
            $(document).ready(function (){
                $('#myForm').validate({
                    rules: {
                        name: {
                            required : true,
                        },
                        position: {
                            required : true,
                        }, 
                        facebook: {
                            required : true,
                        },
                    },
                    messages :{
                        name: {
                            required : 'Please Enter Team Name',
                        }, 
                        position: {
                            required : 'Please Enter Team Position',
                        }, 
                        facebook: {
                            required : 'Please Enter Facebook Url',
                        },
                    },
                    errorElement : 'span', 
                    errorPlacement: function (error,element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight : function(element, errorClass, validClass){
                        $(element).addClass('is-invalid');
                    },
                    unhighlight : function(element, errorClass, validClass){
                        $(element).removeClass('is-invalid');
                    },
                });
            });
            
        </script>

@endsection
