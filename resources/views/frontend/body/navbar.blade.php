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
                            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                Trang chủ 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about.us') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">
                                Giới thiệu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.list') }}" class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact.us') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">
                                Liên hệ
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="nav-search ms-3">
                                <form action="{{ route('filter.hotel') }}" method="POST" class="search-form position-relative">
                                    @csrf
                                    <span class="search-icon"><i class="fas fa-search"></i></span>
                                    <input type="text" name="keyword" class="form-control search-input ps-5" placeholder="Tìm khách sạn..." />
                                </form>
                            </div>
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
<style>
    .search-form {
        display: inline-block;
        position: relative;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #999;
        font-size: 14px;
    }

    .search-input {
        width: 160px;
        transition: width 0.4s ease;
        border-radius: 20px;
        padding: 6px 12px 6px 35px; /* padding-left for icon */
        border: 1px solid #ccc;
    }

    .search-input:focus {
        width: 220px;
        outline: none;
        box-shadow: 0 0 5px rgba(243, 156, 18, 0.5);
        border-color: #f39c12;
    }
</style>
