<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận phê duyệt khách sạn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>🎉 Chúc mừng {{ $user->name }}!</h2>

    <p>Yêu cầu đăng ký trở thành đối tác khách sạn của bạn đã <strong style="color: green;">được phê duyệt thành công</strong>.</p>

    <p>Từ bây giờ, bạn có thể đăng nhập vào hệ thống của chúng tôi để quản lý khách sạn, phòng và đơn đặt của khách hàng một cách dễ dàng và hiệu quả.</p>

    <p>
        👉 <a href="{{ url('/login') }}" style="color: #0d6efd;">Nhấn vào đây để đăng nhập</a>
    </p>

    <hr>

    <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua địa chỉ email hỗ trợ bên dưới.</p>

    <p style="margin-top: 20px;">
        Trân trọng,<br>
        <strong>Đội ngũ hỗ trợ</strong><br>
        <a href="mailto:bookinghotel@booking.com">bookinghotel@booking.com</a>
    </p>
</body>
</html>
