@php
    $setting = App\Models\SiteSetting::find(1);
@endphp

<div class="navbar-area">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="/" class="logo" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 28px; color: #333; letter-spacing: 2px; text-decoration: none;">
            Hotel <span style="color: #f39c12;">Booking</span>
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light ">
                <a class="navbar-brand" href="/" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 28px; color: #333; letter-spacing: 2px; text-decoration: none;">
                    Hotel <span style="color: #f39c12;">Booking</span>
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link active">
                                Trang chủ 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about.us') }}" class="nav-link">
                                Giới thiệu
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                Restaurant 
                            </a>
                        </li> -->

                        <!-- <li class="nav-item">
                            <a href="{{ route('show.gallery') }}" class="nav-link">
                                Gallery 
                            </a>
                        </li> -->

                        <li class="nav-item">
                            <a href="{{ route('blog.list') }}" class="nav-link">
                                Blog
                            </a>
                        </li>
    @php
        $room = App\Models\Room::latest()->get();
    @endphp

                        <li class="nav-item">
                            <a href="{{ route('contact.us') }}" class="nav-link">
                                Liên hệ
                            </a>
                        </li>

                        <li class="nav-item-btn">
                            <a href="#" class="default-btn btn-bg-one border-radius-5">Đặt ngay</a>
                        </li>
                    </ul>

                    <div class="nav-btn">
                        <a href="#" class="default-btn btn-bg-one border-radius-5">Đặt ngay</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
