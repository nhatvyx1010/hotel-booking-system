@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<div class="service-side-bar">
                    <div class="services-bar-widget">
                        <h3 class="title">User Sidebar</h3>
                        <div class="side-bar-categories">
<img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}" class="rounded mx-auto d-block" alt="Image" style="width:100px; height:100px;"> 
<center>
<b>{{ $profileData->name }}</b><br>
<b>{{ $profileData->email }}</b>
</center>
<br>
<ul> 
        
    <li>
        <a href="{{ route('user.profile') }}">Hồ sơ người dùng</a>
    </li>
    <li>
        <a href="{{ route('user.change.password') }}">Đổi mật khẩu</a>
    </li>
    <li>
        <a href="{{ route('user.booking') }}">Chi tiết đặt phòng</a>
    </li>
    <li>
        <a href="{{ route('user.booking_canceled') }}">Đơn đặt phòng đã hủy </a>
    </li>
    <li>
        <a href="{{ route('user.logout') }}">Đăng xuất </a>
    </li>
</ul>
                        </div>
                    </div>

                    
                </div>