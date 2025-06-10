<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

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
      <p><strong>Hotel Name:</strong> {{ $hotel->name ?? 'Hotel Name' }}</p>
      <p><strong>Address:</strong> {{ $hotel->address ?? 'Hotel Address' }}</p>
      <p><strong>Phone:</strong> {{ $hotel->phone ?? '+84 123 456 789' }}</p>
      <p><strong>Email:</strong> {{ $hotel->email ?? 'hotel@example.com' }}</p>
  </div>
</td>
          <td align="right">
              <pre class="font" >
                 Booking Office
                 Email: bookinghotel@book.com
                 Phone: +8484848484
                 Vietnam
              </pre>
          </td>
      </tr>
    </table>

    <table width="100%" style="background:white; padding:2px;"></table>

    <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">

      <thead class="table-light">
          <tr>
              <th>Room Type</th>
              <th>Number of Rooms</th>
              <th>Check-in / Check-out</th>
              <th>Total Nights</th>
              <th>Prepaid Amount</th>
              <th>Remaining Amount</th>
              <th>Total Amount</th>
              <th>Payment Method</th> <!-- Thêm cột payment method -->
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{ $editData->room->type->name }}</td>
              <td>{{ $editData->number_of_rooms }}</td>
              <td>
                <span class="badge bg-primary">{{ $editData->check_in }}</span> / <br>
                <span class="badge bg-warning text-dark">{{ $editData->check_out }}</span>
              </td>
              <td>{{ $editData->total_night }}</td>
              <td>{{ number_format($editData->prepaid_amount, 0, ',', '.') }} VND</td> 
              <td>{{ number_format($editData->remaining_amount, 0, ',', '.') }} VND</td> 
              <td>{{ number_format($editData->total_amount, 0, ',', '.') }} VND</td> 
              <td>{{ $editData->payment_method ?? 'N/A' }}</td>
          </tr>
      </tbody>

    </table>
    <br/>

    <br>
    <h3>Booking Price Breakdown</h3>
    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="margin-top: 10px; border-collapse: collapse; font-size: small;">
        <thead style="background-color: #e0e0e0;">
            <tr>
                <th style="text-align: left;">Date</th>
                <th style="text-align: left;">Type</th>
                <th style="text-align: right;">Price / Room</th>
                <th style="text-align: right;">Total (x{{ $editData->number_of_rooms }})</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyPrices as $day)
                <tr>
                    <td>{{ $day['date'] }}</td>
                    <td>{{ $day['is_special'] ? 'Special Price' : 'Regular Price' }}</td>
                    <td style="text-align: right;">{{ number_format($day['price'], 0, ',', '.') }} VND</td>
                    <td style="text-align: right;">{{ number_format($day['total'], 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table test_table" style="float: right" border="none">
      <tr>
          <td>Subtotal</td>
          <td>{{ number_format($editData->subtotal, 0, ',', '.') }} VND</td> 
      </tr>
      <tr>
          <td>Discount</td>
          <td>{{ number_format($editData->discount, 0, ',', '.') }} VND</td>
      </tr>
  <tr>
      <td>Deposit</td>
      <td>{{ number_format($editData->deposit, 0, ',', '.') }} VND</td>
  </tr>
  <tr>
      <td>Prepaid Amount</td>
      <td>{{ number_format($editData->prepaid_amount ?? 0, 0, ',', '.') }} VND</td>
  </tr>
      <tr>
          <td><strong>Total</strong></td>
          <td><strong>{{ number_format($editData->total_price, 0, ',', '.') }} VND</strong></td>
      </tr>
    </table>

    <div class="thanks mt-3">
      <p>Thank you for your booking!</p>
    </div>
    <div class="authority float-right mt-5">
        <p>-----------------------------------</p>
        <h5>Authorized Signature:</h5>
    </div>
  </body>
</html>
