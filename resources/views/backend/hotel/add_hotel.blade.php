@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Hotel</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Hotel</li>
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
                                    <div class="col-sm-3"><h6 class="mb-0">Name</h6></div>
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
                                    <div class="col-sm-3"><h6 class="mb-0">Phone</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="phone" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Address</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="text" name="address" class="form-control" />
                                    </div>
                                </div>

                                <input type="hidden" name="city_id" id="city_id">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input list="cities" name="city_name" class="form-control" placeholder="Enter city name" required>
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
                                    <div class="col-sm-3"><h6 class="mb-0">Password</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Confirm Password</h6></div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <input type="password" name="password_confirmation" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Photo</h6></div>
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

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Hotel" />
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
                name: { required: 'Please enter name' },
                email: { required: 'Please enter email', email: 'Email format is incorrect' },
                phone: { required: 'Please enter phone number' },
                address: { required: 'Please enter address' },
                password: { required: 'Please enter password', minlength: 'At least 6 characters' },
                photo: { required: 'Please select a photo' },
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
