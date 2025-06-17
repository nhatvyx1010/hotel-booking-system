@extends('hotel.hotel_dashboard')
@section('hotel')
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

								<form method="POST" action="{{ route('hotel.store.roomlist') }}" class="row g-3">
                                    @csrf
									<div class="col-md-4">
										<label for="roomtype_id" class="form-label">Loại Phòng</label>
                                        <select name="room_id" id="room_id" class="form-select">
											<option selected="">Chọn loại phòng</option>
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
                                            <label for="">Tình trạng phòng trống: <span class="text-success availability"></span></label>
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
										<label for="input5" class="form-label">Tỉnh/Thành</label>
										<input type="text" name="state" class="form-control" value="{{ old('state') }}">
									</div>

									<div class="col-md-12">
										<label for="input11" class="form-label">Địa Chỉ</label>
										<textarea name="address" class="form-control" id="input11" placeholder="Địa Chỉ ..." rows="3">{{ old('address') }}</textarea>
									</div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Tổng Tiền</label>
                                            <input type="number" class="form-control" name="total_amount" id="total_amount" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Tiền Trả Trước</label>
                                            <input type="number" class="form-control" name="prepaid_amount" id="prepaid_amount" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Số Tiền Còn Lại</label>
                                            <input type="number" class="form-control" name="remaining_amount" id="remaining_amount" readonly>
                                        </div>
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
document.addEventListener('DOMContentLoaded', function () {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');

    // Thiết lập ngày hiện tại là giá trị mặc định và min cho check-in
    const today = new Date().toISOString().split('T')[0];
    checkInInput.setAttribute('min', today);
    checkInInput.value = today;

    checkInInput.addEventListener('change', function () {
        const checkInDate = new Date(checkInInput.value);
        const checkOutDate = new Date(checkOutInput.value);

        // Tự động cập nhật min cho ngày check-out
        checkOutInput.setAttribute('min', checkInInput.value);

        if (checkOutInput.value && checkOutDate < checkInDate) {
            alert("Ngày trả phòng không được trước ngày nhận phòng.");
            checkOutInput.value = checkInInput.value;
        }
    });

    checkOutInput.addEventListener('change', function () {
        const checkInDate = new Date(checkInInput.value);
        const checkOutDate = new Date(checkOutInput.value);

        if (checkOutDate < checkInDate) {
            alert("Ngày trả phòng không được trước ngày nhận phòng.");
            checkOutInput.value = checkInInput.value;
        }
    });
});
</script>

<script>
    $(document).ready(function () {
        // Reset fields khi thay đổi room
        $("#room_id").on('change', function () {
            $("#check_in").val('');
            $("#check_out").val('');
            $(".availability").text(0);
            $("#available_room").val(0);
        });

        // Gọi kiểm tra khi chọn check-in nếu đã có check-out
        $("#check_in").on('change', function () {
            if ($("#check_out").val() !== '') {
                getAvaility();
            }
        });

        // Gọi kiểm tra khi chọn check-out
        $("#check_out").on('change', function () {
            getAvaility();
        });

        // Gọi tính lại tổng khi thay đổi số phòng
        $('input[name="number_of_rooms"]').on('input', function () {
            calculateTotalAmount();
        });
    });

    function getAvaility() {
        var check_in = $('#check_in').val();
        var check_out = $('#check_out').val();
        var room_id = $("#room_id").val();

        if (!check_in || !check_out || !room_id) {
            alert('Vui lòng chọn Loại Phòng, Ngày Nhận và Trả Phòng.');
            return;
        }

        var startDate = new Date(check_in);
        var endDate = new Date(check_out);

        if (startDate > endDate) {
            alert('Ngày không hợp lệ: Ngày Trả phải sau Ngày Nhận.');
            $("#check_out").val('');
            $(".availability").text(0);
            $("#available_room").val(0);
            return;
        }

        // AJAX kiểm tra
        $.ajax({
            url: "{{ route('check_room_availability') }}",
            method: 'GET',
            data: {
                room_id: room_id,
                check_in: check_in,
                check_out: check_out
            },
            success: function (res) {
                if (res && typeof res.available_room !== 'undefined') {
                    $(".availability").text(res.available_room);
                    $("#available_room").val(res.available_room);
                } else {
                    $(".availability").text('0');
                    $("#available_room").val('0');
                    alert('Không thể lấy dữ liệu khả dụng.');
                }

                let nights = res.total_nights;
                let price = res.room_price;

                // Lưu lại vào data attribute để dùng lại khi số phòng thay đổi
                $('#check_out').data('nights', nights);
                $('#check_out').data('room-price', price);

                // Tính tổng tiền ban đầu
                calculateTotalAmount();
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert('Lỗi khi Kiểm tra.');
            }
        });
    }

    function calculateTotalAmount() {
        let nights = parseInt($('#check_out').data('nights')) || 1;
        let price = parseFloat($('#check_out').data('room-price')) || 0;
        let rooms = parseInt($('input[name="number_of_rooms"]').val()) || 1;

        let total = nights * price * rooms;
        $('#total_amount').val(total);
        $('.t_subtotal').text(total);

        // Tính Prepaid = 30% Total Amount
        let prepaid = total * 0.3;
        $('#prepaid_amount').val(prepaid);

        // Tính Remaining = Total - Prepaid
        let remaining = total - prepaid;
        $('#remaining_amount').val(remaining);

        // Nếu có phần discount thì vẫn giữ lại (nếu bạn dùng sau này)
        let discount = parseFloat($('#discount_p').val()) || 0;
        let discount_amount = total * discount / 100;

        $('.t_discount').text(discount_amount.toFixed(2));
        $('.t_g_total').text((total - discount_amount).toFixed(2));
    }
</script>

@endsection
