@extends('frontend.main_master')
@section('main')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg7">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li> Thanh toán</li>
                    </ul>
                    <h3> Thanh toán</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Checkout Area -->
		<section class="checkout-area pt-100 pb-70">
			<div class="container">
				<form method="post" role="form" action="{{ url('/create-payment') }}" class="stripe_form require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">
					@csrf
					<div class="row">
                        <div class="col-lg-8">
							<div class="billing-details">
								<h3 class="title">Chi tiết thanh toán</h3>

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label>Quốc gia <span class="required">*</span></label>
											<div class="select-box">
												<select name="country" class="form-control">
													<option value="Viet Nam">Việt Nam</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Họ tên <span class="required">*</span></label>
											<input type="text" name="name" class="form-control" value="{{ \Auth::user()->name }}">
											@error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
										</div>
									</div>

									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Email <span class="required">*</span></label>
											<input type="email" name="email" class="form-control" value="{{ \Auth::user()->email }}">
											@error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
										</div>
									</div>

									<div class="col-lg-4 col-md-12">
										<div class="form-group">
											<label>Số điện thoại <span class="required">*</span></label>
											<input type="text" name="phone" class="form-control" value="{{ \Auth::user()->phone }}">
											@error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
										</div>
									</div>

									<div class="col-lg-4 col-md-6">
										<div class="form-group">
											<label>Địa chỉ <span class="required">*</span></label>
											<input type="text" name="address" class="form-control" value="{{ \Auth::user()->address }}">
											@error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
										</div>
									</div>

									<div class="col-lg-4 col-md-6">
										<div class="form-group">
											<label>Tỉnh / Thành phố <span class="required">*</span></label>
											<input type="text" name="state" class="form-control">
											@error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
										</div>
									</div>

									<!-- <div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>ZipCode <span class="required">*</span></label>
											<input type="text" name="zip_code" class="form-control">
											@if ($errors->has('zip_code'))
												<div class="text-danger">{{ $error->first('zip_code') }}</div>
											@endif
										</div>
									</div> -->

									<!-- <p>Session Value: {{ json_encode(session('book_date')) }}</p> -->

								</div>
							</div>
                            
                            <div class="payment-box">

                                <div class="payment-method">
                                    <p>
                                        <input type="radio" id="cash-on-delivery" name="payment_method" value="COD">
                                        <label for="cash-on-delivery">Thanh toán trực tiếp tại quầy lễ tân</label>
                                    </p>
                                    <p>
                                        <input type="radio" id="vnpay" name="payment_method" value="VNPAY">
                                        <label for="vnpay">Thanh toán với VNPAY</label>
                                    </p>

                                    <!-- Nội dung khi chọn COD -->
                                    <div id="cod_info" class="payment-info d-none">
                                        <p>Bạn đã chọn <strong>Thanh toán trực tiếp tại quầy lễ tân</strong>. Vui lòng chuẩn bị số tiền đúng khi thanh toán.</p>
                                        <p><strong>Bạn phải thanh toán 30% phí.</strong></p>
                                        <table class="table">
                                            <tr>
                                                <td><p>Tạm tính</p></td>
                                                <td style="text-align: right"><p>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <tr>
                                                <td><p>Số tiền phải trả</p></td>
                                                <td style="text-align: right"><p>{{ number_format($subtotal * 30 / 100, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <tr>
                                                <td><p>Giảm giá</p></td>
                                                <td style="text-align: right"><p>{{ number_format($discount, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <tr>
                                                <td><p>Tổng cộng</p></td>
                                                <td style="text-align: right"><p>{{ number_format($subtotal * 30 / 100 - $discount, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <!-- Hidden input để gửi total_price -->
                                            <input type="hidden" name="total_price" value="{{ $subtotal * 30 / 100 - $discount }}">
                                        </table>
                                    </div>

                                    <!-- Nội dung khi chọn VNPAY -->
                                    <div id="vnpay_info" class="payment-info d-none">
                                        <p>Bạn đã chọn <strong>Chuyển khoản ngân hàng (VNPAY)</strong>. Bạn sẽ được chuyển đến trang xử lý thanh toán.</p>
                                        <table class="table">
                                            <tr>
                                                <td><p>Tạm tính</p></td>
                                                <td style="text-align: right"><p>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <tr>
                                                <td><p>Giảm giá</p></td>
                                                <td style="text-align: right"><p>{{ number_format($discount, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <tr>
                                                <td><p>Tổng cộng</p></td>
                                                <td style="text-align: right"><p>{{ number_format($subtotal - $discount, 0, ',', '.') }} VNĐ</p></td>
                                            </tr>
                                            <!-- Hidden input để gửi total_price -->
                                                <input type="hidden" name="total_price" value="{{ $subtotal - $discount }}">
                                        </table>
                                    </div>
                                </div>

                                <button type="submit" class="order-btn" id="myButton">Đặt hàng</button>
                            </div>
						</div>
                        
                        
                        <div class="col-lg-4">
                            <section class="checkout-area pb-70">
                                <div class="card-body">
                                      <div class="billing-details">
                                            <h3 class="title">Tóm tắt đặt phòng</h3>
                                            <hr>
              
                                            <div style="display: flex">
                                                  <img style="height:100px; width:120px;object-fit: cover" src="{{ (!empty($room->image)) ? url($room->image) : url('upload/no_image.jpg') }}" alt="Images" alt="Images">
                                                  <div style="padding-left: 10px;">
                                                        <a href=" " style="font-size: 20px; color: #595959;font-weight: bold">{{ @$room->type->name }}</a>
                                                        <p><b>{{ $room->price }} / Đêm</b></p>
                                                  </div>
              
                                            </div>
              
                                            <br>
              
                                            <table class="table" style="width: 100%">
                                                  <tr>
                                                        <td><p>Tổng số đêm <br><b> ( {{ $book_data['check_in'] }} - {{ $book_data['check_out'] }} )</p></td>
                                                        <td style="text-align: right"></b><p>{{ $nights }} Ngày</p></td>
                                                  </tr>
                                                  <table class="table">
                                                    <tr>
                                                        <th>Ngày</th>
                                                        <th>Giá/phòng</th>
                                                        <th>Số phòng</th>
                                                    </tr>
                                                    @foreach($dates as $d)
                                                        <tr>
                                                            <td>{{ $d['date'] }}</td>
                                                            <td>
                                                                {{ number_format($d['price'], 0, ',', '.') }} VNĐ
                                                                @if($d['is_special'])
                                                                    <span style="color: red;">* Giá lễ/tết</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $book_data['number_of_rooms'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                  <tr>
                                                        <td><p>Tạm tính</p></td>
                                                        <td style="text-align: right"><p>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Giảm giá</p></td>
                                                        <td style="text-align:right"> <p>{{ number_format($discount, 0, ',', '.') }} VNĐ</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Tổng cộng</p></td>
                                                        <td style="text-align:right"> <p>{{ number_format($subtotal - $discount, 0, ',', '.') }} VNĐ</p></td>
                                                  </tr>
                                            </table>
              
                                      </div>
                                </div>
                          </section>

						</div>


						<div class="col-lg-8 col-md-8">
						</div>
					</div>
				</form>
			</div>
		</section>
		<!-- Checkout Area End -->

<style>
	.hide{display:none}
</style>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- Checkout Area End -->

<style>
    .d-none { display: none; }
    .table { width: 100%; }
    .table td { padding: 8px 0; }
</style>

<script>
$(document).ready(function () {
    $('input[name="payment_method"]').on('change', function () {
        var payment_method = $(this).val();
        if (payment_method === 'COD') {
            $('#cod_info').removeClass('d-none');
            $('#vnpay_info').addClass('d-none');
        } else if (payment_method === 'VNPAY') {
            $('#vnpay_info').removeClass('d-none');
            $('#cod_info').addClass('d-none');
        }
    });

    $('#checkout-form').on('submit', function (e) {
        var pay_method = $('input[name="payment_method"]:checked').val();
        if (!pay_method) {
            alert('Vui lòng chọn phương thức thanh toán.');
            e.preventDefault();
        }
    });
});
</script>



<!-- <script type="text/javascript">

      $(document).ready(function () {

            $(".pay_method").on('click', function () {
                  var payment_method = $(this).val();
                  if (payment_method == 'Stripe'){
                        $("#stripe_pay").removeClass('d-none');
                  }else{
                        $("#stripe_pay").addClass('d-none');
                  }
            });

      });

      $(function() {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {

                  var pay_method = $('input[name="payment_method"]:checked').val();
                  if (pay_method == undefined){
                        alert('Please select a payment method');
                        return false;
                  }else if(pay_method == 'COD'){

                  }else{
                        document.getElementById('myButton').disabled = true;

                        var $form         = $(".require-validation"),
                                inputSelector = ['input[type=email]', 'input[type=password]',
                                      'input[type=text]', 'input[type=file]',
                                      'textarea'].join(', '),
                                $inputs       = $form.find('.required').find(inputSelector),
                                $errorMessage = $form.find('div.error'),
                                valid         = true;
                        $errorMessage.addClass('hide');

                        $('.has-error').removeClass('has-error');
                        $inputs.each(function(i, el) {
                              var $input = $(el);
                              if ($input.val() === '') {
                                    $input.parent().addClass('has-error');
                                    $errorMessage.removeClass('hide');
                                    e.preventDefault();
                              }
                        });

                        if (!$form.data('cc-on-file')) {

                              e.preventDefault();
                              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                              Stripe.createToken({
                                    number: $('.card-number').val(),
                                    cvc: $('.card-cvc').val(),
                                    exp_month: $('.card-expiry-month').val(),
                                    exp_year: $('.card-expiry-year').val()
                              }, stripeResponseHandler);
                        }
                  }



            });



            function stripeResponseHandler(status, response) {
                  if (response.error) {

                        document.getElementById('myButton').disabled = false;

                        $('.error')
                                .removeClass('hide')
                                .find('.alert')
                                .text(response.error.message);
                  } else {

                        document.getElementById('myButton').disabled = true;
                        document.getElementById('myButton').value = 'Please Wait...';

                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $form.get(0).submit();
                  }
            }

      });
</script> -->

@endsection
