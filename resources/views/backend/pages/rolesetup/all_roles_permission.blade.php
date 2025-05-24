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
								<li class="breadcrumb-item active" aria-current="page">Tất cả Vai Trò và Quyền</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                        <a href="{{ route('add.roles.permission') }}" class="btn btn-primary px-5"> Thêm Vai Trò vào Quyền </a>
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
                            <th>Tên Vai Trò</th>
                            <th>Quyền</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @foreach ($item->permissions as $perm)
                                        <span class="badge bg-danger">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit.roles', $item->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('admin.delete.roles', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
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
