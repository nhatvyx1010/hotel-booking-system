@extends('hotel.hotel_dashboard')
@section('hotel')

<style>
    /* Thêm màu nền và màu chữ cho các dòng quan trọng */
.important-row {
    background-color: #ffeb3b; /* Màu nền vàng nhạt */
    font-weight: bold;
    color: #d32f2f; /* Màu chữ đỏ */
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-5">
                   <div class="col">
					 <div class="card radius-10 border-start border-0 border-3 border-info">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0 text-secondary">Mã đặt phòng</p>
									<h6 class="my-1 text-info">{{ $editData->code }}</h6>
								</div>
								<div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
								</div>
							</div>
						</div>
					 </div>
				   </div>
				   <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-danger">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Ngày đặt phòng</p>
								   <h6 class="my-1 text-danger">{{ \Carbon\Carbon::parse( $editData->created_at )->format('d/m/Y')}}</h6>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-wallet'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-success">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Phương thức thanh toán</p>
								   <h6 class="my-1 text-success">{{ $editData->payment_method }}</h6>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-warning">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Trạng thái thanh toán</p>
								   <h6 class="my-1 text-warning">
                                    @if($editData->payment_status == '1')
                                        <span class="text-success">Hoàn tất</span>
                                    @else
                                        <span class="text-danger">Chờ xử lý</span>
                                    @endif</h6>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div> 

                  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-warning">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Trạng thái đặt phòng</p>
								   <h6 class="my-1 text-warning">@if($editData->status == '1')
                                        <span class="text-success">Đang hoạt động</span>
                                    @else
                                        <span class="text-danger">Chờ xử lý</span>
                                    @endif</h6>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div> 
				</div><!--end row-->

				<div class="row">
                   <div class="col-12 col-lg-8 d-flex">
                      <div class="card radius-10 w-100">
						<div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Loại phòng</th>
                                            <th>Tổng số phòng</th>
                                            <th>Giá</th>
                                            <th>Ngày nhận / Trả phòng</th>
                                            <th>Tổng số đêm</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $editData->room->type->name }}</td>
                                            <td>{{ $editData->number_of_rooms }}</td>
                                            <td>{{ number_format($editData->actual_price, 0, ',', '.') }} VNĐ</td>
                                            <td><span class="badge bg-primary"> {{ $editData->check_in }}</span> / <br><span class="badge bg-warning text-dark"> {{ $editData->check_out }}</span></td>
                                            <td>{{ $editData->total_night }}</td>
                                            <td>{{ number_format($editData->actual_price * $editData->number_of_rooms, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-6" style="float: left">
                                    <style>
                                        .test_table td{text-align: left}
                                    </style>
                                    
                                    <table class="table test_table" style="float: left" border="none">
                                        <tr>
                                            <td>Tạm tính</td>
                                            <td>{{ number_format($editData->subtotal, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td>{{ number_format($editData->discount, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr> <!-- Nhấn mạnh Grand Total -->
                                            <td>Tổng cộng</td>
                                            <td>{{ number_format($editData->total_price, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr class="important-row"> <!-- Nhấn mạnh Prepaid Amount -->
                                            <td>Số tiền đặt cọc</td>
                                            <td>{{ number_format($editData->prepaid_amount, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr class="important-row"> <!-- Nhấn mạnh Remaining Amount -->
                                            <td>Số tiền còn lại</td>
                                            <td>{{ number_format($editData->remaining_amount, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr  class="important-row">
                                            <td>Tổng số tiền</td>
                                            <td>{{ number_format($editData->total_amount, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    </table>
                                </div>


                                <!-- Cancel Reason & Payment Info -->
                                <div class="col-md-6" style="float: right">
                                    <style>
                                        .test_table td {
                                            text-align: right;
                                            padding: 6px 10px;
                                        }
                                        .test_table td:first-child {
                                            text-align: left;
                                        }
                                        .test_table tr.important-row td {
                                            font-weight: bold;
                                        }
                                    </style>

                                    <table class="table test_table" style="float: right" border="none">
                                        <tr class="important-row">
                                            <td>Số tiền đặt cọc</td>
                                            <td><strong>{{ number_format($editData->prepaid_amount, 0, ',', '.') }} VNĐ </strong></td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái</td>
                                            <td>
                                                <strong>
                                                    @if($editData->status == 2)
                                                        <span class="text-warning">Chờ xử lý</span>
                                                    @else
                                                        <span class="text-success">Hoàn thành</span>
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Lý do hủy</td>
                                            <td><strong>{{ $editData->cancel_reason ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại hoàn tiền</td>
                                            <td><strong>{{ $editData->refund_phone ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Mã ngân hàng</td>
                                            <td><strong>{{ $editData->refund_bank_code ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tên ngân hàng</td>
                                            <td><strong>{{ $editData->refund_bank_name ?? 'N/A' }}</strong></td>
                                        </tr>
                                    </table>
                                </div>


                                <div style="clear: both"></div>
                                @php
                                    $assign_rooms = App\Models\BookingRoomList::with('room_number')->where('booking_id', $editData->id)->get();
                                @endphp

                                @if(count($assign_rooms) > 0)
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Số phòng</th>
                                        <th>Trạng thái thanh toán</th>
                                        <th>Trạng thái đặt phòng</th>
                                    </tr>
                                    <tr>
                                        @foreach ($assign_rooms as $assign_room)
                                        <td>{{ $assign_room->room_number->room_no }}</td>
                                        @endforeach
                                        <td>{{ $editData->payment_status == 0?'Chờ xử lý':'Hoàn tất' }}</td>
                                        <td>{{ $editData->status == 0?'Chờ xử lý':'Đang hoạt động' }}</td>

                                    </tr>
                                </table>
                                @else
                                <div class="alert alert-danger text-center">
                                    Không tìm thấy phòng được gán
                                </div>
                                @endif
                            </div>

                            <div class="row" style="margin-top: 40px">
                                <div class="col-md-5">
                                    <label for="">Trạng thái hủy</label>
                                    <p class="form-control-plaintext">
                                        <strong>
                                            {{ $editData->status == 2 ? 'Đang chờ' : ($editData->status == 3 ? 'Hoàn thành' : 'Không xác định') }}
                                        </strong>
                                    </p>
                                </div>
                            </div>

                            </div>
					    </div>
				   </div>
				   <div class="col-12 col-lg-4">
                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Quản lý Phòng và Ngày</h6>
								</div>
							</div>
						</div><div class="card-body">
    <div class="row">
        <div class="col-md-3 mb-2">
            <label>Ngày nhận phòng:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->check_in }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Ngày trả phòng:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->check_out }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Số phòng:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->number_of_rooms }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Tình trạng phòng:</label>
            <p class="form-control-plaintext text-success"><strong>{{ $editData->available_room ?? 'Unknown' }}</strong></p>
        </div>
    </div>
</div>


					   </div>

                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Thông tin khách hàng</h6>
								</div>
							</div>
						</div>
						   <div class="card-body">

                            <ul class="list-group list-group-flush">
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Tên <span class="badge bg-success rounded-pill">{{ $editData['user']['name'] }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Email <span class="badge bg-danger rounded-pill">{{ $editData['user']['email'] }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Điện thoại <span class="badge bg-primary rounded-pill">{{ $editData->phone }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Quốc gia <span class="badge bg-warning text-dark rounded-pill">{{ $editData->country }}</span>
							</li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Tỉnh/Thành phố <span class="badge bg-success rounded-pill">{{ $editData->state }}</span>
							</li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Địa chỉ <span class="badge bg-danger rounded-pill">{{ $editData->address }}</span>
							</li>
						</ul>
                            </div>
                            </div>


				   </div>
				</div><!--end row-->
			</div>

            <div class="modal fade myModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Phòng</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body"></div>
												</div>
											</div>
										</div>

<script>
    $(document).ready(function(){
        getAvaility();

        $(".assign_room").on('click', function(){
            $.ajax({
                url: "{{ route('assign_room', $editData->id) }}",
                success: function(data){
                    $('.myModal .modal-body').html(data);
                    $('.myModal').modal('show');
                }
            });
            return false;
        })
    });
    function getAvaility() {
        var check_in = $('#check_in').val();
        var check_out = $('#check_out').val();
        var room_id = "{{ $editData->rooms_id }}";

        $.ajax({
        url: "{{ route('check_room_availability') }}",
        data: {room_id:room_id, check_in:check_in, check_out:check_out},
        success: function(data){
            $(".availability").text(data['available_room']);
            $("#available_room").val(data['available_room']);
        }
        });
    }

</script>
@endsection
