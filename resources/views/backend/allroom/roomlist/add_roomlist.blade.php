@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Thêm Đặt Phòng</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Đặt Phòng</li>
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

								<form method="POST" action="{{ route('store.roomlist') }}" class="row g-3">
                                    @csrf
									<div class="col-md-4">
										<label for="roomtype_id" class="form-label">Loại Phòng</label>
                                        <select name="room_id" id="room_id" class="form-select">
											<option selected="">Chọn Loại Phòng</option>
                                            @foreach ($roomtype as $item)
                                            <option value="{{ $item->room->id }}" {{ collect(old('roomtype_id'))->contains($item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
										</select>
									</div>
									<div class="col-md-4">
										<label for="input2" class="form-label">Ngày Nhận Phòng</label>
										<input type="date" name="check_in" class="form-control" id="check_in">
									</div>
                                    <div class="col-md-4">
										<label for="input2" class="form-label">Ngày Trả Phòng</label>
										<input type="date" name="check_out" class="form-control" id="check_out">
									</div>

									<div class="col-md-4">
										<label for="input3" class="form-label">Số Phòng</label>
										<input type="number" name="number_of_rooms" class="form-control">
                                        
                                        <input type="hidden" name="available_room" id="available_room" class="form-control">
                                        <div class="mt-2">
                                            <label for="">Số phòng còn trống: <span class="text-success availability"></span></label>
                                        </div>
									</div>

									<div class="col-md-4">
										<label for="input4" class="form-label">Số Khách</label>
										<input type="text" name="number_of_person" class="form-control" id="number_of_person">
									</div>

                                    <h3 class="mt-3 mb-5 text-center">Thông Tin Khách Hàng</h3>

									<div class="col-md-4">
										<label for="input5" class="form-label">Họ Tên</label>
										<input type="text" name="name" class="form-control" id="input5" value="{{ old('name') }}">
									</div>
                                    <div class="col-md-4">
										<label for="input5" class="form-label">Email</label>
										<input type="email" name="email" class="form-control" value="{{ old('email') }}">
									</div>
                                    <div class="col-md-4">
										<label for="input5" class="form-label">Số Điện Thoại</label>
										<input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
									</div>

                                    <div class="col-md-4">
										<label for="input5" class="form-label">Quốc Gia</label>
										<input type="text" name="country" class="form-control" value="{{ old('country') }}">
									</div>
                                    <div class="col-md-4">
										<label for="input5" class="form-label">Tỉnh / Thành Phố</label>
										<input type="text" name="state" class="form-control" value="{{ old('state') }}">
									</div>

									<div class="col-md-12">
										<label for="input11" class="form-label">Địa Chỉ</label>
										<textarea name="address" class="form-control" id="input11" placeholder="Địa Chỉ ..." rows="3">{{ old('address') }}</textarea>
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

<script>
    $(document).ready(function(){
        $("#room_id").on('change', function(){
            $("#check_in").val('');
            $("#check_out").val('');
            $(".availability").text(0);
            $("#available_room").val(0);
        });

        $("#check_out").on('change', function(){
            getAvaility();
        });
    });
    function getAvaility() {
        var check_in = $('#check_in').val();
        var check_out = $('#check_out').val();
        var room_id = $("#room_id").val();

        var startDate = new Date(check_in);
        var endDate = new Date(check_out);

        if(startDate > endDate){
            alert('Invalid Date');
            $("#check_out").val('');
            return false;
        }

        if(check_in != '' && check_out != '' && room_id != ''){
            $.ajax({
                url: "{{ route('check_room_availability') }}",
                data: {room_id:room_id, check_in:check_in, check_out:check_out},
                success: function(data){
                    $(".availability").text(data['available_room']);
                    $("#available_room").val(data['available_room']);
                }
            });
        }else{
            alert('Các trường không được để trống');
        }
    }

</script>

@endsection
