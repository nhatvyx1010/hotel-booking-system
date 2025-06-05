@php
    $setting = App\Models\SiteSetting::find(1);
@endphp
<header class="top-header top-header-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-2 pr-0">
                <div class="language-list">
                    <select class="language-list-item">
                        <!-- <option>English</option> -->
                        <option>Tiếng Việt</option>
                    </select>	
                </div>
            </div>

            <div class="col-lg-9 col-md-10">
                <div class="header-right">
                    <ul>
                        <li>
                            <i class='bx bx-home-alt'></i>
                            <a href="#">Da Nang, Viet Nam</a>
                        </li>
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <a href="tel:+1-(123)-456-7890">+84 959595959</a>
                        </li>
        @auth
        <li>
            <i class='bx bxs-user-pin'></i>
            <a href="{{ route('user.profile') }}">Hồ sơ cá nhân</a>
        </li>
        <li>
            <i class='bx bxs-user-retangle'></i>
            <a href="{{ route('user.logout') }}">Đăng xuất</a>
        </li>
        @else
        <li>
            <i class='bx bxs-user-pin'></i>
            <a href="{{ route('login') }}">Đăng nhập</a>
        </li>
        <li>
            <i class='bx bxs-user-retangle'></i>
            <a href="{{ route('register') }}">Đăng ký</a>
        </li>
        @endauth

                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
