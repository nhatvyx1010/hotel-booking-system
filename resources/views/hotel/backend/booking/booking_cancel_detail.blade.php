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
									<p class="mb-0 text-secondary">Booking Number</p>
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
								   <p class="mb-0 text-secondary">Booking Date</p>
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
								   <p class="mb-0 text-secondary">Payment Method</p>
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
								   <p class="mb-0 text-secondary">Payment Status</p>
								   <h6 class="my-1 text-warning">
                                    @if($editData->payment_status == '1')
                                        <span class="text-success">Complete</span>
                                    @else
                                        <span class="text-danger">Pending</span>
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
								   <p class="mb-0 text-secondary">Booking Status</p>
								   <h6 class="my-1 text-warning">@if($editData->status == '1')
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Pending</span>
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
                                            <th>Room Type</th>
                                            <th>Total Room</th>
                                            <th>Price</th>
                                            <th>Check In / Out Date</th>
                                            <th>Total Days</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $editData->room->type->name }}</td>
                                            <td>{{ $editData->number_of_rooms }}</td>
                                            <td>${{ $editData->actual_price }}</td>
                                            <td><span class="badge bg-primary"> {{ $editData->check_in }}</span> / <br><span class="badge bg-warning text-dark"> {{ $editData->check_out }}</span></td>
                                            <td>{{ $editData->total_night }}</td>
                                            <td>${{ $editData->actual_price * $editData->number_of_rooms }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-6" style="float: left">
                                    <style>
                                        .test_table td{text-align: left}
                                    </style>
                                    
                                    <table class="table test_table" style="float: left" border="none">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>${{ $editData->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td>${{ $editData->discount }}</td>
                                        </tr>
                                        <tr> <!-- Nhấn mạnh Grand Total -->
                                            <td>Grand Total</td>
                                            <td>${{ $editData->total_price }}</td>
                                        </tr>
                                        <tr class="important-row"> <!-- Nhấn mạnh Prepaid Amount -->
                                            <td>Prepaid Amount</td>
                                            <td>${{ $editData->prepaid_amount }}</td>
                                        </tr>
                                        <tr class="important-row"> <!-- Nhấn mạnh Remaining Amount -->
                                            <td>Remaining Amount</td>
                                            <td>{{ number_format($editData->remaining_amount, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr  class="important-row">
                                            <td>Total Amount</td>
                                            <td>${{ $editData->total_amount }}</td>
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
                                            <td>Prepaid Amount</td>
                                            <td><strong>{{ number_format($editData->prepaid_amount, 0, ',', '.') }} VNĐ </strong></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                <strong>
                                                    @if($editData->status == 2)
                                                        <span class="text-warning">Pending</span>
                                                    @else
                                                        <span class="text-success">Completed</span> {{-- hoặc tuỳ chỉnh --}}
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Cancel Reason</td>
                                            <td><strong>{{ $editData->cancel_reason ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Refund Phone</td>
                                            <td><strong>{{ $editData->refund_phone ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Bank Code</td>
                                            <td><strong>{{ $editData->refund_bank_code ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Bank Name</td>
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
                                        <th>Room Number</th>
                                        <th>Payment Status</th>
                                        <th>Booking Status</th>
                                    </tr>
                                    <tr>
                                        @foreach ($assign_rooms as $assign_room)
                                        <td>{{ $assign_room->room_number->room_no }}</td>
                                        @endforeach
                                        <td>{{ $editData->payment_status == 0?'Pending':'Complete' }}</td>
                                        <td>{{ $editData->status == 0?'Pending':'Complete' }}</td>

                                    </tr>
                                </table>
                                @else
                                <div class="alert alert-danger text-center">
                                    Not Found Assign Room
                                </div>
                                @endif
                            </div>

                            
                            <form action="{{ route('hotel.update.booking.cancel.status', $editData->id) }}" method="POST">
                                @csrf
                                <div class="row" style="margin-top: 40px">
                                    <div clas="col-md-5">
                                        <label for="">Cancel Status</label>
                                        <select name="status" id="input7" class="form-select">
                                            <option selected="">Selected Status...</option>
                                            <option value="2" {{$editData->status == 2?'selected':''}}>Pending</option>
                                            <option value="3" {{$editData->status == 3?'selected':''}}>Complete</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12" style="margin-top:20px">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>

                            </div>
					    </div>
				   </div>
				   <div class="col-12 col-lg-4">
                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Manage Room and Date</h6>
								</div>
							</div>
						</div><div class="card-body">
    <div class="row">
        <div class="col-md-3 mb-2">
            <label>Check In:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->check_in }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Check Out:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->check_out }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Room:</label>
            <p class="form-control-plaintext"><strong>{{ $editData->number_of_rooms }}</strong></p>
        </div>
        <div class="col-md-3 mb-2">
            <label>Availability:</label>
            <p class="form-control-plaintext text-success"><strong>{{ $editData->available_room ?? 'Unknown' }}</strong></p>
        </div>
    </div>
</div>


					   </div>

                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Customer Information</h6>
								</div>
							</div>
						</div>
						   <div class="card-body">

                            <ul class="list-group list-group-flush">
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Name <span class="badge bg-success rounded-pill">{{ $editData['user']['name'] }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Email <span class="badge bg-danger rounded-pill">{{ $editData['user']['email'] }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Phone <span class="badge bg-primary rounded-pill">{{ $editData->phone }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Country <span class="badge bg-warning text-dark rounded-pill">{{ $editData->country }}</span>
							</li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">State <span class="badge bg-success rounded-pill">{{ $editData->state }}</span>
							</li>
							<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Zip Code <span class="badge bg-danger rounded-pill">{{ $editData->zip_code }}</span>
							</li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Address <span class="badge bg-danger rounded-pill">{{ $editData->address }}</span>
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
														<h5 class="modal-title" id="exampleModalLabel">Rooms</h5>
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
