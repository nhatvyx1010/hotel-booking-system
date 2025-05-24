<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Booking Cancelled</title>
    <style>
        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        h1 {
            color: #dc3545; /* đỏ báo hủy */
            font-size: 24px;
            margin-bottom: 25px;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 8px;
        }
        h2 {
            color: #444;
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }
        th {
            width: 35%;
            color: #666;
            font-weight: normal;
            background-color: #fcebea; /* màu nền đỏ nhạt */
        }
        .note {
            margin-top: 20px;
            background-color: #ffe3e3;
            padding: 15px;
            border-left: 4px solid #dc3545;
            border-radius: 4px;
            color: #721c24;
            font-size: 15px;
            line-height: 1.4;
        }
        .footer {
            margin-top: 40px;
            font-size: 13px;
            color: #888;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Booking Has Been Cancelled</h1>
        <p>We’ve successfully cancelled your reservation. Below are the details of your cancelled booking:</p>

        <h2>Guest Information</h2>
        <table>
            <tr>
                <th>Name</th>
                <td><strong>{{ $booking['name'] }}</strong></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><strong>{{ $booking['email'] }}</strong></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><strong>{{ $booking['phone'] }}</strong></td>
            </tr>
            <tr>
                <th>Check In</th>
                <td><strong>{{ $booking['check_in'] }}</strong></td>
            </tr>
            <tr>
                <th>Check Out</th>
                <td><strong>{{ $booking['check_out'] }}</strong></td>
            </tr>
        </table>

        <h2>Hotel Information</h2>
        <table>
            <tr>
                <th>Hotel Name</th>
                <td>{{ $booking['hotel_name'] }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $booking['hotel_phone'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking['hotel_email'] }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $booking['hotel_address'] }}</td>
            </tr>
        </table>
        
        <h2>Payment Information</h2>
        <table>
            <tr>
                <th>Discount</th>
                <td>{{ number_format($booking['discount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Prepaid Amount</th>
                <td>{{ number_format($booking['prepaid_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Remaining Amount</th>
                <td>{{ number_format($booking['remaining_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>{{ number_format($booking['total_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
        </table>

        <div class="note">
            If this cancellation was a mistake or if you have questions regarding refunds, please contact our support team.
        </div>
    </div>
</body>
</html>
