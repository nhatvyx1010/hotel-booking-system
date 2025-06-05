<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo từ chối yêu cầu khách sạn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Xin chào {{ $user->name }},</h2>

    <p>Chúng tôi rất tiếc phải thông báo rằng <strong style="color: red;">yêu cầu trở thành đối tác khách sạn</strong> của bạn <strong>không được phê duyệt</strong> vào thời điểm này.</p>

    <p>Nguyên nhân có thể do thiếu thông tin, tài liệu chưa đầy đủ hoặc không đạt yêu cầu xét duyệt. Tuy nhiên, bạn hoàn toàn có thể liên hệ với chúng tôi để biết thêm chi tiết hoặc gửi phản hồi.</p>

    <p>
        📧 Liên hệ: <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
    </p>

    <p>Chúng tôi rất mong có cơ hội hợp tác cùng bạn trong tương lai.</p>

    <p style="margin-top: 20px;">
        Trân trọng,<br>
        <strong>Đội ngũ hỗ trợ</strong><br>
        <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
    </p>
</body>
</html>
