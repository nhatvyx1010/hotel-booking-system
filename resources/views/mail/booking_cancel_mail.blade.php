<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Đặt Phòng Đã Bị Hủy</title>
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
        <h1>Đặt Phòng Của Bạn Đã Bị Hủy</h1>
        <p>Chúng tôi đã hủy thành công đặt phòng của bạn. Dưới đây là chi tiết về đặt phòng đã bị hủy:</p>

        <h2>Thông Tin Khách Hàng</h2>
        <table>
            <tr>
                <th>Tên</th>
                <td><strong>{{ $booking['name'] }}</strong></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><strong>{{ $booking['email'] }}</strong></td>
            </tr>
            <tr>
                <th>Điện Thoại</th>
                <td><strong>{{ $booking['phone'] }}</strong></td>
            </tr>
            <tr>
                <th>Ngày Nhận Phòng</th>
                <td><strong>{{ $booking['check_in'] }}</strong></td>
            </tr>
            <tr>
                <th>Ngày Trả Phòng</th>
                <td><strong>{{ $booking['check_out'] }}</strong></td>
            </tr>
        </table>

        <h2>Thông Tin Khách Sạn</h2>
        <table>
            <tr>
                <th>Tên Khách Sạn</th>
                <td>{{ $booking['hotel_name'] }}</td>
            </tr>
            <tr>
                <th>Điện Thoại</th>
                <td>{{ $booking['hotel_phone'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking['hotel_email'] }}</td>
            </tr>
            <tr>
                <th>Địa Chỉ</th>
                <td>{{ $booking['hotel_address'] }}</td>
            </tr>
        </table>
        
        <h2>Thông Tin Thanh Toán</h2>
        <table>
            <tr>
                <th>Giảm Giá</th>
                <td>{{ number_format($booking['discount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Số Tiền Đã Thanh Toán Trước</th>
                <td>{{ number_format($booking['prepaid_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Số Tiền Còn Lại</th>
                <td>{{ number_format($booking['remaining_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Tổng Tiền</th>
                <td>{{ number_format($booking['total_amount'], 0, ',', '.') }} VNĐ</td>
            </tr>
        </table>

        <div class="note">
            Nếu việc hủy đặt phòng này là một nhầm lẫn hoặc bạn có thắc mắc về việc hoàn tiền, vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi.
        </div>
    </div>
</body>
</html>
