@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh Sửa Quyền</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Quyền</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
    <div class="col-lg-12">
        <div class="card">
							<div class="card-body p-4">
                            <form class="row g-3" action="{{ route('update.permission') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $permission->id }}">

									<div class="col-md-6">
										<label for="input1" class="form-label">Tên Quyền</label>
										<input type="text" name="name" class="form-control" value="{{ $permission->name }}">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Nhóm Quyền</label>
										<select name="group_name" class="form-select mb-3" aria-label="Default select example">
                                            <option selected="">Chọn Nhóm</option>
                                            <option value="Team" {{ $permission->group_name == 'Team' ? 'selected' : '' }}>Nhóm</option>
                                            <option value="Book Area" {{ $permission->group_name == 'Book Area' ? 'selected' : '' }}>Khu Đặt Phòng</option>
                                            <option value="Manage Room" {{ $permission->group_name == 'Manage Room' ? 'selected' : '' }}>Quản Lý Phòng</option>
                                            <option value="Booking" {{ $permission->group_name == 'Booking' ? 'selected' : '' }}>Đặt Phòng</option>
                                            <option value="Room List" {{ $permission->group_name == 'Room List' ? 'selected' : '' }}>Danh Sách Phòng</option>
                                            <option value="Setting" {{ $permission->group_name == 'Setting' ? 'selected' : '' }}>Cài Đặt</option>
                                            <option value="Testimonial" {{ $permission->group_name == 'Testimonial' ? 'selected' : '' }}>Lời Chứng Thực</option>
                                            <option value="Blog" {{ $permission->group_name == 'Blog' ? 'selected' : '' }}>Blog</option>
                                            <option value="Manage Comment" {{ $permission->group_name == 'Manage Comment' ? 'selected' : '' }}>Quản Lý Bình Luận</option>
                                            <option value="Booking Report" {{ $permission->group_name == 'Booking Report' ? 'selected' : '' }}>Báo Cáo Đặt Phòng</option>
                                            <option value="Hotel Gallery" {{ $permission->group_name == 'Hotel Gallery' ? 'selected' : '' }}>Thư Viện Khách Sạn</option>
                                            <option value="Contact Message" {{ $permission->group_name == 'Contact Message' ? 'selected' : '' }}>Tin Nhắn Liên Hệ</option>
                                            <option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>Vai Trò và Quyền</option>
                                        </select>
									</div>

									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Lưu Thay Đổi</button>
										</div>
									</div>
								</form>
							</div>
						</div>
    </div>
            </div>
        </div>
    </div>

@endsection
