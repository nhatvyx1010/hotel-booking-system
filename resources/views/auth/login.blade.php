@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="index.html">Trang Chủ</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Đăng Nhập</li>
            </ul>
            <h3>Đăng Nhập</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Sign In Area -->
<div class="sign-in-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-all-form">
                    <div class="contact-form">
                        <div class="section-title text-center">
                            <span class="sp-color">Đăng Nhập</span>
                            <h2>Đăng Nhập Vào Tài Khoản Của Bạn!</h2>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <div class="form-group">
                                        <input type="text" name="login" id="login" class="form-control" required data-error="Please enter your Username or Email" placeholder="Email/Name/Phone">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 form-condition">
                                    <div class="agree-label">
                                        <input type="checkbox" id="chb1">
                                        <label for="chb1">
                                            Ghi nhớ đăng nhập
                                        </label>
                                    </div>
                                </div>
    
                                <div class="col-lg-6 col-sm-6">
                                    <a class="forget" href="{{ route('password.request') }}">Quên Mật Khẩu?</a>
                                </div>

                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                        Đăng Nhập Ngay
                                    </button>
                                </div>

                                <div class="col-12">
                                    <p class="account-desc">
                                        Chưa có tài khoản?
                                        <a href="{{ route('register') }}">Đăng Ký</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="become-host-section mt-5 pt-4 border-top">
                    <h5 class="text-center mb-3">Bạn có khách sạn muốn đăng ký?</h5>
                    <p class="text-center">
                        Trở thành đối tác và tiếp cận hàng ngàn khách hàng.
                        <br>
                        <a href="{{ route('hotel.register') }}" class="btn btn-outline-primary mt-2">Trở thành Host</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sign In Area End -->

@endsection
