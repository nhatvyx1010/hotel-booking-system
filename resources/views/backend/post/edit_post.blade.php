@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Chỉnh sửa bài viết Blog</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa bài viết Blog</li>
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
                            <form class="row g-3" action="{{ route('update.blog.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">

                                <div class="col-md-6">
                                    <label for="input7" class="form-label">Danh mục Blog</label>
                                    <select name="blogcat_id" id="input7" class="form-select">
                                        <option selected="">Chọn danh mục</option>
                                        @foreach ($blogcat as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $post->blogcat_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="hotel_id" class="form-label">Khách sạn</label>
                                    <select name="hotel_id" id="hotel_id" class="form-select">
                                        <option value="">Chọn khách sạn</option>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ $hotel->id == $post->hotel_id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Tiêu đề bài viết</label>
                                    <input type="text" name="post_title" class="form-control" id="input1" value="{{ $post->post_title }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="input11" class="form-label">Mô tả ngắn</label>
                                    <textarea name="short_desc" class="form-control" id="input11" rows="3">{{ $post->short_desc }}></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label for="input11" class="form-label">Mô tả chi tiết</label>
                                    <textarea name="long_desc" class="form-control" id="myeditorinstance">{!! $post->long_desc !!}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Ảnh bài viết</label>
                                    <input class="form-control" name="post_image" type="file" id="image" />
                                </div>

                                <div class="col-md-6">
                                    <label for="input1" class="form-label"></label>
                                    <img id="showImage" src="{{ asset($post->post_image) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80">
                                </div>

                                <div class="col-md-6">
                                    <label for="audio_file" class="form-label">File Audio (mp3, wav)</label>
                                    <input class="form-control" name="audio_file" type="file" id="audio_file" accept=".mp3,.wav,.m4a" />
                                </div>

                                <div class="col-md-6">
                                    @if($post->audio_file)
                                        <label class="form-label">Audio hiện tại</label><br>
                                        <audio controls style="width: 100%;">
                                            <source src="{{ asset($post->audio_file) }}" type="audio/mpeg">
                                            Trình duyệt của bạn không hỗ trợ thẻ audio.
                                        </audio>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="remove_audio" value="1" id="remove_audio">
                                            <label class="form-check-label" for="remove_audio">
                                                Xóa audio hiện tại
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Gửi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Preview ảnh bài viết khi chọn file mới
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Preview audio khi chọn file audio mới
        $('#audio_file').change(function(e){
            var file = e.target.files[0];
            if (file) {
                var url = URL.createObjectURL(file);
                // Nếu chưa có thẻ audio preview, bạn có thể tạo hoặc chọn thẻ audio hiện có
                // Ở đây mình tạo thẻ audio mới dưới input audio_file nếu chưa có
                if ($('#audioPreview').length === 0) {
                    $('<audio controls style="width: 100%; margin-top:10px;" id="audioPreview"></audio>').insertAfter('#audio_file');
                }
                $('#audioPreview').attr('src', url).show();
            } else {
                $('#audioPreview').hide();
            }
        });
    });
</script>

@endsection
