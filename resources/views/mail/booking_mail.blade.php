<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Booking Confirmation</title>
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
            color: #2c7be5;
            font-size: 24px;
            margin-bottom: 25px;
            border-bottom: 2px solid #2c7be5;
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
            background-color: #f0f4ff;
        }
        p.message {
            font-size: 16px;
            margin-top: 25px;
            line-height: 1.5;
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
        <h1>Thank you for your booking!</h1>
        <p class="message">
            We're happy to confirm your reservation. Below are your booking details:
        </p>

        <h2>Guest Information</h2>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $booking['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking['email'] }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $booking['phone'] }}</td>
            </tr>
            <tr>
                <th>Check In</th>
                <td>{{ $booking['check_in'] }}</td>
            </tr>
            <tr>
                <th>Check Out</th>
                <td>{{ $booking['check_out'] }}</td>
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

        <h2>Payment Details</h2>
        <table>
            <tr>
                <th>Discount</th>
                <td>{{ number_format($booking['discount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Prepaid Amount</th>
                <td>{{ number_format($booking['prepaid_amount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Remaining Amount</th>
                <td>{{ number_format($booking['remaining_amount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td><strong>{{ number_format($booking['total_amount'], 0, '.', ',') }} VND</strong></td>
            </tr>
        </table>

        <p class="message">
            If you have any questions, feel free to contact us. We look forward to welcoming you!
        </p>
    </div>
</body>
</html>
