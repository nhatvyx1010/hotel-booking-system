<header>
	<style>
		.notification-unread {
			background-color:rgb(212, 212, 212); /* màu sẫm hơn cho chưa đọc */
		}

		.notification-read {
			background-color: #ffffff; /* màu bình thường cho đã đọc */
		}
	</style>
	<div class="topbar d-flex align-items-center">
		<nav class="navbar navbar-expand gap-3">
			<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
			</div>
				<div class="top-menu ms-auto">
				<ul class="navbar-nav align-items-center gap-1">
					<li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
						<a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
						</a>
					</li>
					<li class="nav-item dark-mode d-none d-sm-flex">
						<a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
						</a>
					</li>

					<li class="nav-item dropdown dropdown-large">
						<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
						@php
							$ncount = Auth::user()->unreadNotifications()->count();
							$profileData = App\Models\Hotel::find(Auth::user()->id);

						@endphp	
						<span class="alert-count" id="notification-count">{{ $ncount }}</span>
							<i class='bx bx-bell'></i>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a href="javascript:;">
								<div class="msg-header">
									<p class="msg-header-title">Thông báo</p>
									<p class="msg-header-badge"></p>
								</div>
							</a>
							<div class="header-notifications-list">
								@php
									$user = Auth::user();
								@endphp

								@forelse ($user->notifications as $notification)
									@php
										$isUnread = $notification->read_at === null;
									@endphp
									<a class="dropdown-item {{ $isUnread ? 'notification-unread' : 'notification-read' }}" href="javascript:;" onclick="markNotificationAsRead('{{ $notification->id }}')">

										<div class="d-flex align-items-center">
											<div class="notify bg-light-success text-success"><i class='bx bx-check-square'></i>
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">{{ $notification->data['message'] }}<span class="msg-time float-end">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span></h6>
												<p class="msg-info">Đặt phòng mới</p>
											</div>
										</div>
									</a>
								@empty
								@endforelse
							</div>
							<a href="javascript:;">
								<div class="text-center msg-footer">
									<button class="btn btn-primary w-100">Xem tất cả thông báo</button>
								</div>
							</a>
						</div>
					</li>
					<li class="nav-item dropdown dropdown-large">
						<div class="dropdown-menu dropdown-menu-end">
							<a href="javascript:;">
								<div class="msg-header">
									<p class="msg-header-title">My Cart</p>
									<p class="msg-header-badge">10 Items</p>
								</div>
							</a>
							<div class="header-message-list">
								<a class="dropdown-item" href="javascript:;">
									<div class="d-flex align-items-center gap-3">
										<div class="position-relative">
											<div class="cart-product rounded-circle bg-light">
												<img src="assets/images/products/11.png" class="" alt="product image">
											</div>
										</div>
										<div class="flex-grow-1">
											<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
											<p class="cart-product-price mb-0">1 X $29.00</p>
										</div>
										<div class="">
											<p class="cart-price mb-0">$250</p>
										</div>
										<div class="cart-product-cancel"><i class="bx bx-x"></i>
										</div>
									</div>
								</a>

							</div>
							<a href="javascript:;">
								<div class="text-center msg-footer">
									<div class="d-flex align-items-center justify-content-between mb-3">
										<h5 class="mb-0">Total</h5>
										<h5 class="mb-0 ms-auto">$489.00</h5>
									</div>
									<button class="btn btn-primary w-100">Checkout</button>
								</div>
							</a>
						</div>
					</li>
				</ul>
			</div>

			@php
				$id = Auth::user()->id;
				$profileData = App\Models\User::find($id);
			@endphp

			<div class="user-box dropdown px-3">
				<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="{{ (!empty($profileData->photo)) ? url($profileData->photo) : url('upload/no_image.jpg') }}" class="user-img" alt="user avatar">
					<div class="user-info">
						<p class="user-name mb-0">{{ $profileData->name }}</p>
						<p class="designattion mb-0">{{ $profileData->email }}</p>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<li><a class="dropdown-item d-flex align-items-center" href="{{ route('hotel.profile')}}"><i class="bx bx-user fs-5"></i><span>Hồ sơ</span></a>
					</li>
					<li><a class="dropdown-item d-flex align-items-center" href="{{ route('hotel.change.password')}}"><i class="bx bx-cog fs-5"></i><span>Đổi mật khẩu</span></a>
					</li>
					<li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="bx bx-home-circle fs-5"></i><span>Dashboard</span></a>
					</li>
					<li>
						<div class="dropdown-divider mb-0"></div>
					</li>
					<li><a class="dropdown-item d-flex align-items-center" href="{{ route('hotel.logout')}}"><i class="bx bx-log-out-circle"></i><span>Đăng xuất</span></a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>

<script>
	function markNotificationAsRead(notificationId){
		fetch('/mark-notification-as-read/'+ notificationId, {
			method: 'POST',
			headers: {
				'Content-Type' : 'application/json',
				'X-CSRF-TOKEN' : '{{ csrf_token() }}'
			},
			body: JSON.stringify({})
		})
		.then(response => response.json())
		.then(data => {
			document.getElementById('notification-count').textContent = data.count;
		})
		.catch(error => {
			console.log('Error', error);
		});
	}
</script>
