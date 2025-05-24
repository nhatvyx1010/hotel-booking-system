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
								<li class="breadcrumb-item active" aria-current="page">Tất Cả Ảnh Bộ Sưu Tập</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                        <a href="{{ route('add.gallery') }}" class="btn btn-primary px-5"> Thêm Bộ Sưu Tập</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('delete.gallery.multiple') }}" method="POST">
                    @csrf
                
                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                                <th width="50px">Chọn</th>
                                <th width="50px">STT</th>
                                <th>Ảnh</th>
                                <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gallery as $key=> $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selectedItem[]" value="{{ $item->id }}">
                                </td>
                                <td>{{ $key+1 }}</td>
                                <td><img src="{{ asset($item->photo_name) }}" alt="" style="width:70px; height:40px"></td>
                                <td>
                                    <a href="{{ route('edit.gallery', $item->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                    <a href="{{ route('delete.gallery', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Xóa mục đã chọn</button>
                </form>
            </div>
        </div>
    </div>
    <hr/>

</div>

@endsection
