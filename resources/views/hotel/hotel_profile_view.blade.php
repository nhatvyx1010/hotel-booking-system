@extends('hotel.hotel_dashboard')
@section('hotel')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Hotel Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Hotel Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
            <img src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
            <div class="mt-3">
                <h4>{{ $profileData->name }}</h4>
                <p class="text-secondary mb-1">{{ $profileData->email }}</p>
            </div>
        </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                                    <span class="text-secondary">codervent</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                                    <span class="text-secondary">codervent</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
    <div class="col-lg-8">
        <div class="card">
            <form action="{{ route('hotel.profile.store') }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tên</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name" class="form-control" value="{{ $profileData->name }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="email" name="email" class="form-control" value="{{ $profileData->email }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Số điện thoại</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="phone" class="form-control" value="{{ $profileData->phone }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Địa chỉ</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="address" class="form-control" value="{{ $profileData->address }}" />
                    </div>
                </div>

                @php
                    $existingAudio = !empty($profileData->hotel_audio) ? url('upload/audio/' . $profileData->hotel_audio) : null;
                @endphp

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 for="audio_file" class="form-label">File Audio (mp3, wav)</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input class="form-control" name="audio_file" type="file" id="audio_file" accept=".mp3,.wav,.m4a" />
                        <input type="hidden" name="delete_audio" id="deleteAudioFlag" value="0">
                    </div>
                </div>

                <div class="row mb-3" id="audioPreviewWrapper" style="{{ $existingAudio ? '' : 'display: none;' }}">
                    <div class="col-sm-3">
                        <h6 class="form-label">Preview audio (nếu có)</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <audio id="audioPreview" controls style="width: 100%;">
                            <source src="{{ $existingAudio ? asset($profileData->hotel_audio) : '#' }}" type="audio/mpeg" />
                            Trình duyệt không hỗ trợ thẻ audio.
                        </audio>
                        <button type="button" id="deleteAudioBtn" class="btn btn-sm btn-danger mt-2">
                            Xoá audio
                        </button>
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Ảnh</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input class="form-control" name="photo" type="file" id="image" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <img id="showImage" src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="320">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Lưu thay đổi" />
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Preview ảnh
        $('#image').change(function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#showImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(e.target.files[0]);
        });

        // Preview audio khi chọn file mới
        $('#audio_file').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                $('#audioPreview source').attr('src', url);
                $('#audioPreview')[0].load();
                $('#audioPreviewWrapper').show();
                $('#deleteAudioFlag').val('0'); // không xoá audio cũ nếu chọn file mới
            }
        });

        // Nút xoá audio
        $('#deleteAudioBtn').click(function () {
            $('#audio_file').val('');
            $('#deleteAudioFlag').val('1'); // đặt cờ xoá
            $('#audioPreview source').attr('src', '');
            $('#audioPreview')[0].load();
            $('#audioPreviewWrapper').hide();
        });
    });
</script>

@endsection
