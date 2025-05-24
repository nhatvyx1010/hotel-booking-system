<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hóa đơn</title>

    <style type="text/css"> 
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray;
        }
        .font {
          font-size: 15px;
        }
        .authority {
            float: right;
        }
        .authority h5 {
            margin-top: -10px;
            color: green;
            margin-left: 35px;
        }
        .thanks p {
            color: green;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
        .hotel-info {
            font-size: 14px;
            color: #333;
            margin-top: 5px;
        }
        .hotel-info p {
            margin: 2px 0;
        }
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('DejaVuSans.ttf') format('truetype');
        }
        * {
            font-family: 'DejaVu Sans', sans-serif;
        }

    </style>

  </head>
  <body>

    <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
      <tr>
<td valign="top">
  <h2 style="color: green; font-size: 26px;"><strong>Booking Hotel</strong></h2>
  <!-- Hotel information -->
  <div class="hotel-info">
      <p><strong>Tên khách sạn:</strong> {{ $hotel->name ?? 'Hotel Name' }}</p>
      <p><strong>Địa chỉ:</strong> {{ $hotel->address ?? 'Hotel Address' }}</p>
      <p><strong>Điện thoại:</strong> {{ $hotel->phone ?? '+84 123 456 789' }}</p>
      <p><strong>Email:</strong> {{ $hotel->email ?? 'hotel@example.com' }}</p>
  </div>
</td>
          <td align="right">
              <pre class="font" >
                 Booking Hotel
                 Email: bookinghotel@book.com
                 Điện thoại: +8484848484
                 Việt Nam
              </pre>
          </td>
      </tr>
    </table>

    <table width="100%" style="background:white; padding:2px;"></table>

    <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">

      <thead class="table-light">
          <tr>
            <th>Loại phòng</th>
            <th>Số lượng phòng</th>
            <th>Giá</th>
            <th>Ngày nhận / Ngày trả</th>
            <th>Tổng số đêm</th>
            <th>Tổng cộng</th>
            <th>Phương thức thanh toán</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{ $editData->room->type->name }}</td>
              <td>{{ $editData->number_of_rooms }}</td>
              <td>{{ number_format($editData->actual_price, 0, ',', '.') }} VND</td> 
              <td>
                <span class="badge bg-primary">{{ $editData->check_in }}</span> / <br>
                <span class="badge bg-warning text-dark">{{ $editData->check_out }}</span>
              </td>
              <td>{{ $editData->total_night }}</td>
              <td>{{ number_format($editData->actual_price * $editData->number_of_rooms, 0, ',', '.') }} VND</td> 
              <td>{{ $editData->payment_method ?? 'N/A' }}</td>
          </tr>
      </tbody>

    </table>
    <br/>

    <table class="table test_table" style="float: right" border="none">
      <tr>
          <td>Tạm tính</td>
          <td>{{ number_format($editData->subtotal, 0, ',', '.') }} VND</td> 
      </tr>
      <tr>
          <td>Giảm giá</td>
          <td>{{ number_format($editData->discount, 0, ',', '.') }} VND</td>
      </tr>
    <tr>
        <td>Số tiền trả trước</td>
        <td>{{ number_format($editData->prepaid_amount ?? 0, 0, ',', '.') }} VND</td>
    <tr>
      <td><strong>Tổng cộng</strong></td>
      <td>
        <strong>
          {{ number_format($editData->subtotal - $editData->discount - ($editData->prepaid_amount ?? 0), 0, ',', '.') }} VND
        </strong>
      </td>
  </tr>
    </table>

    <div class="thanks mt-3">
      <p>Cảm ơn bạn đã đặt phòng!</p>
    </div>
    <div class="authority float-right mt-5">
        <p>-----------------------------------</p>
        <h5>Chữ ký xác nhận:</h5>
    </div>
  </body>
</html>
