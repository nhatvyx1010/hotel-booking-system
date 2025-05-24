<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
		</div>
		<div>
			<h4 class="logo-text">Hotel Booking</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
		</div>
		</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
		
		<li>
			<a href="{{ route('hotel.dashboard') }}">
				<div class="parent-icon"><i class='bx bx-home-alt'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>
		
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class="bx bx-category"></i>
				</div>
				<div class="menu-title">Quản lý đội ngũ</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.all.team') }}"><i class='bx bx-radio-circle'></i>Tất cả đội ngũ</a>
				</li>
				<li> <a href="{{ route('hotel.add.team') }}"><i class='bx bx-radio-circle'></i>Thêm đội ngũ</a>
				</li>
			</ul>
		</li>

		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class="bx bx-category"></i>
				</div>
				<div class="menu-title">Quản lý Book Area</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.book.area') }}"><i class='bx bx-radio-circle'></i>Cập nhật Book Area</a>
				</li>
			</ul>
		</li>

		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class="bx bx-category"></i>
				</div>
				<div class="menu-title">Quản lý loại phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.room.type.list') }}"><i class='bx bx-radio-circle'></i>Danh sách loại phòng</a>
				</li>
			</ul>
		</li>

		<li class="menu-label">Quản lý đặt phòng</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">Đặt phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.booking.list') }}"><i class='bx bx-radio-circle'></i>Danh sách đặt phòng</a>
				</li>
				<li> <a href="{{ route('hotel.add.room.list') }}"><i class='bx bx-radio-circle'></i>Thêm đặt phòng</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cart'></i></div>
				<div class="menu-title">Hủy đặt phòng</div>
				@php
					$cancelPendingCount = App\Models\Booking::whereHas('room', function($query) {
						$query->where('hotel_id', Auth::id());
					})
					->where('status', 2)
					->count();
				@endphp
				@if($cancelPendingCount > 0)
					<span style="color: red; font-weight: bold;"> ({{ $cancelPendingCount }})</span>
				@endif
			</a>
			<ul>
				<li>
					<a href="{{ route('hotel.booking.cancel_pending.list') }}">
						<i class='bx bx-radio-circle'></i>Đang chờ hủy
						
						@if($cancelPendingCount > 0)
							<span style="font-weight: bold;"> ({{ $cancelPendingCount }})</span>
						@endif
					</a>
				</li>
				<li>
					<a href="{{ route('hotel.booking.cancel_complete.list') }}">
						<i class='bx bx-radio-circle'></i>Hủy hoàn tất
					</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Quản lý danh sách phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.view.room.list') }}"><i class='bx bx-radio-circle'></i>Danh sách phòng</a>
				</li>
			</ul>
		</li>

		<!-- <li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Setting</div>
			</a>
			<ul>
				<li> <a href="{{ route('site.setting') }}"><i class='bx bx-radio-circle'></i>Site Setting</a>
				</li>
			</ul>
		</li> -->
		
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Báo cáo đặt phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.booking.report') }}"><i class='bx bx-radio-circle'></i>Báo cáo đặt phòng</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Đánh giá khách sạn</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.all.review') }}"><i class='bx bx-radio-circle'></i>Tất cả đánh giá</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Thư viện khách sạn</div>
			</a>
			<ul>
				<li> <a href="{{ route('hotel.all.gallery') }}"><i class='bx bx-radio-circle'></i>Tất cả thư viện ảnh</a>
				</li>
			</ul>
		</li>

		<!-- <li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Contact Message</div>
			</a>
			<ul>
				<li> <a href="{{ route('contact.message') }}"><i class='bx bx-radio-circle'></i>Contact Message</a>
				</li>
			</ul>
		</li> -->

		<li class="menu-label">Khác</li>
		<li>
			<a href="#" target="_blank">
				<div class="parent-icon"><i class="bx bx-support"></i>
				</div>
				<div class="menu-title">Hỗ trợ</div>
			</a>
		</li>
	</ul>
	<!--end navigation-->
</div>