@php
    $setting = App\Models\SiteSetting::find(1);
@endphp

<footer class="footer-area footer-bg">
    <div class="container">
        <div class="footer-top pt-100 pb-70">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <div class="footer-logo" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 24px; color: #fff; letter-spacing: 2px;">
                            <a href="/" style="text-decoration: none; color: inherit;">
                                Hotel <span style="color: #f39c12;">Booking</span>
                            </a>
                        </div>
                        <p>
                        Ở nơi tận cùng thung lũng, gần kề lối thoát, những chiếc lá đâm chồi từ gốc, điểm xuyết màu sắc và dáng hình riêng biệt.
                        </p>
                        <ul class="footer-list-contact">
                            <li>
                                <i class='bx bx-home-alt'></i>
                                <a href="#">Da Nang, Viet Nam</a>
                            </li>
                            <li>
                                <i class='bx bx-phone-call'></i>
                                <a href="tel:+1-(123)-456-7890">+84 959595959</a>
                            </li>
                            <li>
                                <i class='bx bx-envelope'></i>
                                <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget pl-5">
                        <h3>Liên kết</h3>
                        <ul class="footer-list">
                            <li>
                                <a href="{{ route('about.us') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Về chúng tôi
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('services.us') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Dịch vụ
                                </a>
                            </li> 
                            </li> 
                            <li>
                                <a href="{{ route('terms.us') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Điều khoản & Điều kiện
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('privacy.us') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Chính sách bảo mật
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3>Liên kết hữu ích</h3>
                        <ul class="footer-list">
                            <li>
                                <a href="{{ url('/') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Trang chủ
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('blog.list') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Blog
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('testimonials.list') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Nhận xét
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('contact.us') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Liên hệ
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3>Liên hệ</h3>
                        <div class="footer-form">
                            <form class="newsletter-form" data-toggle="validator" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Your Email*" name="EMAIL" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-one">
                                            Liên hệ
                                        </button>
                                        <div id="validator-newsletter" class="form-result"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copy-right-area">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="copy-right-text text-align1">
                        <p>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="social-icon text-align2">
                        <ul class="social-link">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li> 
                            <li>
                                <a href="https://www.twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li> 
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-instagram'></i></a>
                            </li> 
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li> 
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-youtube'></i></a>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
