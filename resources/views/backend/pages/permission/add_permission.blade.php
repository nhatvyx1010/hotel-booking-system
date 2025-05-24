@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Thêm Quyền</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Quyền</li>
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
                            <form class="row g-3" action="{{ route('store.permission') }}" method="post" enctype="multipart/form-data">
                            @csrf

									<div class="col-md-6">
										<label for="input1" class="form-label">Tên Quyền</label>
										<input type="text" name="name" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Nhóm Quyền</label>
										<select name="group_name" class="form-select mb-3" aria-label="Default select example">
                                            <option selected="">Chọn Nhóm</option>
                                            <option value="Team">Nhóm</option>
                                            <option value="Book Area<">Khu Đặt Phòng</option>
                                            <option value="Manage Room">Quản Lý Phòng</option>
                                            <option value="Booking">Đặt Phòng</option>
                                            <option value="Room List">Danh Sách Phòng</option>
                                            <option value="Setting">Cài Đặt</option>
                                            <option value="Testimonial">Lời Chứng Thực</option>
                                            <option value="Blog">Blog</option>
                                            <option value="Manage Comment">Quản Lý Bình Luận</option>
                                            <option value="Booking Report">Báo Cáo Đặt Phòng</option>
                                            <option value="Hotel Gallery">Thư Viện Khách Sạn</option>
                                            <option value="Contact Message">Tin Nhắn Liên Hệ</option>
                                            <option value="Role and Permission">Vai Trò và Quyền</option>
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
