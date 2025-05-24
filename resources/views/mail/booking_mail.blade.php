<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Xác nhận đặt phòng</title>
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
        <h1>Cảm ơn bạn đã đặt phòng!</h1>
        <p class="message">
            Chúng tôi vui mừng xác nhận đặt phòng của bạn. Dưới đây là thông tin chi tiết về đặt phòng:
        </p>

        <h2>Thông tin khách</h2>
        <table>
            <tr>
                <th>Họ và tên</th>
                <td>{{ $booking['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking['email'] }}</td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>{{ $booking['phone'] }}</td>
            </tr>
            <tr>
                <th>Ngày nhận phòng</th>
                <td>{{ $booking['check_in'] }}</td>
            </tr>
            <tr>
                <th>Ngày trả phòng</th>
                <td>{{ $booking['check_out'] }}</td>
            </tr>
        </table>

        <h2>Thông tin khách sạn</h2>
        <table>
            <tr>
                <th>Tên khách sạn</th>
                <td>{{ $booking['hotel_name'] }}</td>
            </tr>
            <tr>
                <th>Điện thoại</th>
                <td>{{ $booking['hotel_phone'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking['hotel_email'] }}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $booking['hotel_address'] }}</td>
            </tr>
        </table>

        <h2>Chi tiết thanh toán</h2>
        <table>
            <tr>
                <th>Giảm giá</th>
                <td>{{ number_format($booking['discount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Số tiền đã thanh toán trước</th>
                <td>{{ number_format($booking['prepaid_amount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Số tiền còn lại</th>
                <td>{{ number_format($booking['remaining_amount'], 0, '.', ',') }} VND</td>
            </tr>
            <tr>
                <th>Tổng số tiền</th>
                <td><strong>{{ number_format($booking['total_amount'], 0, '.', ',') }} VND</strong></td>
            </tr>
        </table>

        <p class="message">
            Nếu bạn có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi. Chúng tôi rất mong được đón tiếp bạn!
        </p>
    </div>
</body>
</html>
