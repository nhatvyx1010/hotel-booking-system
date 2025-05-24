@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $bookings = App\Models\Booking::latest()->get();
    $pending = App\Models\Booking::where('status', '0')->get();
    $complete = App\Models\Booking::where('status', '1')->get();
    $cancel = App\Models\Booking::whereIn('status', ['2', '3'])->get();

    $totalBooking = count($bookings);
    $totalPrice = $bookings->sum('total_price');
    $today = Carbon\Carbon::now()->toDateString();
    $todayPrice = App\Models\Booking::whereDate('created_at', $today)->sum('total_price');
    $allData = App\Models\Booking::orderBy('id', 'desc')->limit(10)->get();

    $pendingRate = $totalBooking > 0 ? round(count($pending) / $totalBooking * 100, 1) : 0;
    $completeRate = $totalBooking > 0 ? round(count($complete) / $totalBooking * 100, 1) : 0;
    $cancelRate = $totalBooking > 0 ? round(count($cancel) / $totalBooking * 100, 1) : 0;
@endphp

<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-3">
                   <div class="col">
					 <div class="card radius-10 border-start border-0 border-4 border-info">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0 text-secondary">Tổng số đơn đặt</p>
									<h4 class="my-1 text-info">{{ count($bookings) }}</h4>
									<p class="mb-0 font-13">Tổng tiền hôm nay:  {{ number_format($todayPrice, 0, ',', '.') }} VNĐ</p>
								</div>
								<div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
								</div>
							</div>
						</div>
					 </div>
				   </div>
				   <div class="col">
					<div class="card radius-10 border-start border-0 border-4 border-danger">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Đơn chờ xử lý</p>
								   <h4 class="my-1 text-warning">{{ count($pending) }}</h4>
								   <p class="mb-0 font-13">{{ $pendingRate }}% tổng số đơn</p>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-warning text-white ms-auto"><i class='bx bxs-wallet'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-4 border-success">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Đơn hoàn tất</p>
								   <h4 class="my-1 text-success">{{ count($complete) }}</h4>
								   <p class="mb-0 font-13">{{ $completeRate }}% tổng số đơn</p>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-4 border-danger">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0 text-secondary">Đơn bị hủy</p>
									<h4 class="my-1 text-danger">{{ count($cancel) }}</h4>
									<p class="mb-0 font-13">{{ $cancelRate }}% tổng số đơn</p>
								</div>
								<div class="widgets-icons-2 rounded-circle bg-danger text-white ms-auto">
									<i class='bx bx-x-circle'></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				  <div class="col">
					<div class="card radius-10 border-start border-0 border-4 border-warning">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Tổng tiền</p>
								   <h4 class="my-1 text-warning"> {{ number_format($totalPrice, 0, ',', '.') }} VNĐ</h4>
								   <p class="mb-0 font-13">VNĐ</p>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div> 
				</div><!--end row-->

				<div class="row">
					<div class="d-flex align-items-center mb-3">
						<label for="dateFilter" class="me-2">Xem theo:</label>
						<select id="dateFilter" class="form-select me-2" style="width: 150px;">
							<option value="week">Tuần</option>
							<option value="month">Tháng</option>
							<option value="year">Năm</option>
						</select>
						<button id="prevBtn" class="btn btn-outline-secondary me-1">← Trước</button>
						<button id="nextBtn" class="btn btn-outline-secondary">Sau →</button>
					</div>

                   <div class="col-12 col-lg-12 d-flex">
                      <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Tổng quan doanh thu</h6>
								</div>
							</div>
						</div>
						  <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
							<canvas id="bookingChart"></canvas>
						  </div>
					  </div>
				   </div>
				</div><!--end row-->

				 <div class="card radius-10">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<div>
								<h6 class="mb-0">Đơn đặt gần đây</h6>
							</div>

						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>STT</th>
										<th>Mã đơn</th>
										<th>Ngày đặt</th>
										<th>Khách hàng</th>
										<th>Tên khách sạn</th>
										<th>Phòng</th>
										<th>Nhận/Trả</th>
										<th>Số phòng</th>
										<th>Khách</th>
									</tr>
								</thead>
								<tbody>
									@foreach($allData as $key=> $item)
										<tr>
											<td>{{ $key+1 }}</td>
											<td><a href="{{ route('edit_booking', $item->id) }}"> {{ $item->code }}</a></td>
											<td>{{ $item->created_at->format('d/m/Y') }}</td>
											<td>{{ $item['user']['name'] }}</td>
											<td>{{ $item['room']['hotel']['name'] ?? 'N/A' }}</td>
											<td>{{ $item['room']['type']['name'] }}</td>
											<td><span class="badge bg-primary"> {{ $item->check_in }}</span> / <span class="badge bg-warning text-dark"> {{ $item->check_out }}</span></td>
											<td>{{ $item->number_of_rooms }}</td>
											<td>{{ $item->persion }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

<script>
    var bookingChart;
    const ctx = document.getElementById('bookingChart').getContext('2d');
    let currentType = 'week';
    let offset = 0;

    function loadChart(type = 'week', offsetVal = 0) {
        $.get(`/admin/bookings/chart-data?type=${type}&offset=${offsetVal}`, function(response) {
            const labels = response.map(item => item.label);
            const data = response.map(item => item.value);

            if (bookingChart) bookingChart.destroy();

            bookingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Price',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    }

    // Initial load
    loadChart(currentType, offset);

    $('#dateFilter').on('change', function() {
        currentType = $(this).val();
        offset = 0; // reset offset when changing type
        loadChart(currentType, offset);
    });

    $('#prevBtn').on('click', function() {
        offset--;
        loadChart(currentType, offset);
    });

    $('#nextBtn').on('click', function() {
        offset++;
        loadChart(currentType, offset);
    });
</script>


@endsection
