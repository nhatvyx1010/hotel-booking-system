<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
		</div>
		<div>
			<h4 class="logo-text">
				<a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-primary">Hotel Booking</a>
			</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
		</div>
		</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
		
		<li>
			<a href="{{ route('admin.dashboard') }}">
				<div class="parent-icon"><i class='bx bx-home'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-building-house'></i>
				</div>
				<div class="menu-title">Quản Lý Khách Sạn</div>
			</a>
			<ul>
				<li><a href="{{ route('all.hotel') }}"><i class='bx bx-list-ul'></i>Khách sạn đang hoạt động</a></li>
				<li><a href="{{ route('all.hotel.inactive') }}"><i class='bx bx-list-ul'></i>Khách sạn bị khóa</a></li>
				<li><a href="{{ route('all.hotel.pending') }}"><i class='bx bx-list-ul'></i>Khách sạn chờ phê duyệt</a></li>
				<li><a href="{{ route('all.hotel.cancelled') }}"><i class='bx bx-list-ul'></i>Khách sạn không được duyệt</a></li>


				<li> <a href="{{ route('add.hotel') }}"><i class='bx bx-plus'></i>Thêm Khách Sạn</a>
				</li>
			</ul>
		</li>

		<li class="menu-label">Quản Lý Đặt Phòng</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-bed'></i>
				</div>
				<div class="menu-title">Đặt Phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('booking.list') }}"><i class='bx bx-list-check'></i>Danh Sách Đặt Phòng</a>
				</li>
				<!-- <li> <a href="{{ route('add.room.list') }}"><i class='bx bx-radio-circle'></i>Add Booking</a>
				</li> -->
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-user'></i></div>
				<div class="menu-title">Tài Khoản Khách Hàng</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.customer') }}"><i class='bx bx-group'></i>Tất Cả Khách Hàng</a></li>
				<li> <a href="{{ route('add.customer') }}"><i class='bx bx-user-plus'></i>Thêm Khách Hàng</a></li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-cog'></i>
				</div>
				<div class="menu-title">Cài Đặt</div>
			</a>
			<ul>
				<li> <a href="{{ route('smtp.setting') }}"><i class='bx bx-envelope'></i>Cài Đặt SMTP</a>
				</li>
				<li> <a href="{{ route('site.setting') }}"><i class='bx bx-wrench'></i>Cài Đặt Website</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-message-square-dots'></i>
				</div>
				<div class="menu-title">Nhận Xét</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.testimonial') }}"><i class='bx bx-comment-detail'></i>Tất Cả Nhận Xét</a>
				</li>

				<li> <a href="{{ route('add.testimonial') }}"><i class='bx bx-message-add'></i>Thêm Nhận Xét</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-news'></i>
				</div>
				<div class="menu-title">Blog</div>
			</a>
			<ul>
				<li> <a href="{{ route('blog.category') }}"><i class='bx bx-category'></i>Danh Mục Blog</a>
				</li>

				<li> <a href="{{ route('all.blog.post') }}"><i class='bx bx-file'></i>Tất Cả Bài Blog</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-comment'></i>
				</div>
				<div class="menu-title">Quản Lý Bình Luận</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.comment') }}"><i class='bx bx-message-rounded-dots'></i>Tất Cả Bình Luận</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-star'></i>
				</div>
				<div class="menu-title">Quản Lý Đánh Giá</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.review') }}"><i class='bx bx-star'></i>Tất Cả Đánh Giá</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-star'></i>
				</div>
				<div class="menu-title">Vấn Đề Từ Khách Hàng</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.report') }}"><i class='bx bx-star'></i>Tất Cả Vấn Đề</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bar-chart-alt-2'></i>
				</div>
				<div class="menu-title">Báo Cáo Đặt Phòng</div>
			</a>
			<ul>
				<li> <a href="{{ route('booking.report') }}"><i class='bx bx-pie-chart-alt'></i>Báo Cáo Đặt Phòng</a>
				</li>
			</ul>
		</li>

		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-map'></i>
				</div>
				<div class="menu-title">Thành Phố</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.city') }}"><i class='bx bx-map-pin'></i>Tất Cả Thành Phố</a>
				</li>

				<li> <a href="{{ route('add.city') }}"><i class='bx bx-plus-circle'></i>Thêm Thành Phố</a>
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

		<!-- <li class="menu-label">Vai Trò & Quyền Hạn</li>
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Vai Trò & Quyền Hạn</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.permission') }}"><i class='bx bx-radio-circle'></i>Tất Cả Quyền Hạn</a>
				</li>

				<li> <a href="{{ route('all.roles') }}"><i class='bx bx-radio-circle'></i>Tất Cả Vai Trò</a>
				</li>

				<li> <a href="{{ route('add.roles.permission') }}"><i class='bx bx-radio-circle'></i>Thêm Quyền Cho Vai Trò</a>
				</li>

				<li> <a href="{{ route('all.roles.permission') }}"><i class='bx bx-radio-circle'></i>Danh Sách Vai Trò & Quyền</a>
				</li>
			</ul>
		</li> -->

		<!-- <li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
				</div>
				<div class="menu-title">Quản Lý Admin</div>
			</a>
			<ul>
				<li> <a href="{{ route('all.admin') }}"><i class='bx bx-radio-circle'></i>Tất Cả Admin</a>
				</li>

				<li> <a href="{{ route('add.admin') }}"><i class='bx bx-radio-circle'></i>Thêm Admin</a>
				</li>
			</ul>
		</li> -->

		<li class="menu-label">Khác</li>
		<li>
			<a href="#" target="_blank">
				<div class="parent-icon"><i class="bx bx-support"></i>
				</div>
				<div class="menu-title">Hỗ Trợ</div>
			</a>
		</li>
	</ul>
	<!--end navigation-->
</div>