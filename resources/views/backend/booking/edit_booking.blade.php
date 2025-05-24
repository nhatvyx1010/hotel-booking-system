@extends('admin.admin_dashboard')
@section('admin')

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
                                        <span class="text-success">Hoàn thành</span>
                                    @else
                                        <span class="text-danger">Chưa thanh toán</span>
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
                                        <span class="text-success">Hoàn thành</span>
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
                                            <th>Khách sạn</th>
                                            <th>Loại phòng</th>
                                            <th>Tổng số phòng</th>
                                            <th>Giá</th>
                                            <th>Ngày nhận / trả phòng</th>
                                            <th>Tổng số ngày</th>
                                            <th>Tổng cộng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $hotel->name }}</td>
                                            <td>{{ $editData->room->type->name }}</td>
                                            <td>{{ $editData->number_of_rooms }}</td>
                                            <td>{{ number_format($editData->actual_price, 0, ',', '.') }} VNĐ</td>
                                            <td><span class="badge bg-primary"> {{ $editData->check_in }}</span> / <br><span class="badge bg-warning text-dark"> {{ $editData->check_out }}</span></td>
                                            <td>{{ $editData->total_night }}</td>
                                            <td>{{ number_format($editData->actual_price * $editData->number_of_rooms, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-6" style="float: right">
                                    <style>
                                        .test_table td{text-align: right}
                                    </style>
                                    
                                    <table class="table test_table" style="float: right" border="none">
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
                                            <td>Số tiền đã trả trước</td>
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

                                
                            </div>
                            <div class="row" style="margin-top: 40px">
                                <div class="col-md-5">
                                    <label for="">Trạng thái thanh toán</label>
                                    <p class="form-control">
                                        {{ $editData->payment_status == 0 ? 'Chưa thanh toán' : 'Hoàn thành' }}
                                    </p>
                                </div>

                                <div class="col-md-5">
                                    <label for="">Trạng thái đặt phòng</label>
                                    <p class="form-control">
                                        {{ $editData->status == 0 ? 'Chờ xử lý' : 'Hoàn thành' }}
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
									<h6 class="mb-0">Quản lý phòng và ngày</h6>
								</div>
							</div>
						</div>
						   <div class="card-body">
                            <form action="{{ route('update.booking', $editData->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="">Ngày nhận phòng</label>
                                        <input type="date" required name="check_in" id="check_in" class="form-control" value="{{ $editData->check_in }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="">Ngày trả phòng</label>
                                        <input type="date" required name="check_out" id="check_out" class="form-control" value="{{ $editData->check_out }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="">Số lượng phòng</label>
                                        <input type="number" required name="number_of_rooms" class="form-control" value="{{ $editData->number_of_rooms }}">
                                    </div>

                                    <input type="hidden" name="available_room" id="available_room" class="form-control">
                                </div>
                            </form>
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
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Số điện thoại <span class="badge bg-primary rounded-pill">{{ $editData->phone }}</span>
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
