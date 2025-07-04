@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

        				<!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Tất cả bài viết</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                        <a href="{{ route('add.blog.post') }}" class="btn btn-primary px-5"> Thêm bài viết </a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề bài viết</th>
                            <th>Danh mục Blog</th>
                            <th>Khách sạn</th>
                            <th>Ảnh bài viết</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($post as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->post_title }}</td>
                                <td>{{ $item['blog']['category_name'] }}</td>
                                <td>{{ $item->hotel?->name ?? 'N/A' }}</td>
                                <td><img src="{{ asset($item->post_image) }}" alt="" style="width:70px; height:40px"></td>
                                <td>
                                    <a href="{{ route('edit.blog.post', $item->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('delete.blog.post', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr/>

</div>

@endsection
