@php
    $team = App\Models\Team::latest()->get();
@endphp

<div class="team-area-three pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">ĐỘI NGŨ</span>
            <h2>Hãy Gặp Gỡ Các Thành Viên Đặc Biệt Trong Đội Ngũ Của Chúng Tôi</h2>
        </div>
        <div class="team-slider-two owl-carousel owl-theme pt-45">
            @foreach($team as $item)
            <div class="team-item">
                <a href="team.html">
                    <img src="{{asset($item->image)}}" alt="Images">
                </a>
                <div class="content">
                    <h3><a href="team.html">{{($item->name)}}</a></h3>
                    <span>{{($item->position)}}</span>
                    <ul class="social-link">
                        <li>
                            <a href="{{($item->facebook)}}" target="_blank"><i class='bx bxl-facebook'></i></a>
                        </li> 
                        <li>
                            <a href="#" target="_blank"><i class='bx bxl-twitter'></i></a>
                        </li> 
                        <li>
                            <a href="#" target="_blank"><i class='bx bxl-instagram'></i></a>
                        </li> 
                        <li>
                            <a href="#" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                        </li> 
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
