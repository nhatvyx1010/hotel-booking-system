<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('backend/assets/images/favicon-32x32.png')}}" type="image/png" />
	<!--plugins-->
	<link href="{{asset('backend/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('backend/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('backend/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('backend/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('backend/assets/css/icons.css')}}" rel="stylesheet">
	<title>Hotel Register Page</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">

					<div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">

                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
							<div class="card-body">
                                 <img src="{{asset('backend/assets/images/login-images/login-cover.svg')}}" class="img-fluid auth-img-cover-login')}}" width="650" alt=""/>
							</div>
						</div>
						
					</div>

					<div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
						<div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
							<div class="card-body p-sm-5">
								<div class="">
									<div class="mb-3 text-center">
										<img src="{{asset('backend/assets/images/logo-icon.png')}}" width="60" alt="">
									</div>
									<div class="text-center mb-4">
										<h5 class="">Hotel Booking - Hotel Manage</h5>
										<p class="mb-0">Register New Account</p>
									</div>
									<div class="form-body">
            <form class="row g-3" method="POST" action="{{ route('hotel.register_submit') }}">
                @csrf
            
				<div class="mb-3">
                      <label class="form-label">Store Name</label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
					  
						@error('name')
							<small class="text-danger">{{ $message }}</small>
						@enderror
					  
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Phone">
					  
						@error('phone')
							<small class="text-danger">{{ $message }}</small>
						@enderror
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Address</label>
                      <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
					  
						@error('address')
							<small class="text-danger">{{ $message }}</small>
						@enderror
                  </div>

				  <input type="hidden" name="city_id" id="city_id">
					<div class="mb-3">
						<label class="form-label">City</label>
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

                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
					  @error('email')
						<small class="text-danger">{{ $message }}</small>
						@enderror
                  </div>
				  <div class="mb-3">
                      <div class="d-flex align-items-start">
                          <div class="flex-grow-1">
                              <label class="form-label">Password</label>
                          </div>
                      </div>
                      
                      <div class="input-group auth-pass-inputgroup">
                          <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                          <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                      </div>
					  @error('password')
						<small class="text-danger">{{ $message }}</small>
						@enderror
                  </div>
				  <div class="mb-3">
						<div class="d-flex align-items-start">
							<div class="flex-grow-1">
								<label class="form-label">Confirm Password</label>
							</div>
						</div>
						
						<div class="input-group auth-pass-inputgroup">
							<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" aria-label="Password" aria-describedby="password-addon">
							<button class="btn btn-light shadow-none ms-0" type="button" id="password-confirm-addon"><i class="mdi mdi-eye-outline"></i></button>
						</div>
						@error('password_confirmation')
							<small class="text-danger">{{ $message }}</small>
						@enderror
					</div>


            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
            <div class="col-12">
                <div class="text-center ">
                    <p class="mb-0">Don't have an account yet? <a href="{{ route('hotel.login') }}">Sign in here</a>
                    </p>
                </div>
            </div>
        </form>
									</div>
									<div class="login-separater text-center mb-5"> <span>OR SIGN IN WITH</span>
										<hr>
									</div>
									<div class="list-inline contacts-social text-center">
										<a href="javascript:;" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i class="bx bxl-facebook"></i></a>
										<a href="javascript:;" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i class="bx bxl-twitter"></i></a>
										<a href="javascript:;" class="list-inline-item bg-google text-white border-0 rounded-3"><i class="bx bxl-google"></i></a>
										<a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i class="bx bxl-linkedin"></i></a>
									</div>

								</div>
							</div>
						</div>
					</div>

				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
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

	<!--app JS-->
	<script src="{{asset('backend/assets/js/app.js')}}"></script>
</body>

</html>