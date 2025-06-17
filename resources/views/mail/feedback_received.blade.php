<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúng tôi đã nhận được phản hồi của quý khách</title>
    <!-- CSS nhúng để đảm bảo khả năng tương thích với các trình duyệt email -->
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Sử dụng Inter font */
            margin: 0;
            padding: 0;
            background-color: #f7fafc; /* Màu nền xám nhạt */
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff; /* Màu nền trắng */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng nhẹ */
            border: 1px solid #e2e8f0; /* Viền nhẹ */
        }
        .header {
            background-color: #4299e1; /* Màu xanh dương (blue-500) */
            padding: 24px;
            text-align: center;
            color: #ffffff; /* Chữ trắng */
            font-size: 24px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            padding: 32px;
            color: #4a5568; /* Màu xám đậm (gray-700) */
            line-height: 1.6; /* Chiều cao dòng */
        }
        .footer {
            background-color: #edf2f7; /* Màu xám nhạt hơn (gray-200) */
            padding: 24px;
            text-align: center;
            font-size: 14px;
            color: #718096; /* Màu xám trung bình (gray-600) */
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .button {
            display: inline-block;
            background-color: #4299e1; /* Màu xanh dương */
            color: #ffffff; /* Chữ trắng */
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none; /* Bỏ gạch chân link */
            font-weight: bold;
            margin-top: 20px;
        }
        /* Điều chỉnh responsive cho màn hình nhỏ hơn */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
                box-shadow: none;
            }
            .header {
                font-size: 20px;
                padding: 16px;
            }
            .content {
                padding: 24px;
            }
        }
    </style>
</head>
<body style="background-color: #f7fafc; padding: 16px; margin: 0;">
    <div class="email-container">
        <!-- Tiêu đề Email -->
        <div class="header">
            Phản hồi của quý khách đã được ghi nhận!
        </div>

        <!-- Nội dung chính của Email -->
        <div class="content">
            <p>Xin chào {{ $user->name ?? 'quý khách' }},</p>
            <p style="margin-top: 16px;">Chúng tôi xin thông báo rằng chúng tôi đã nhận được phản hồi từ quý khách. Đội ngũ của chúng tôi sẽ xem xét và thực hiện xử lý vấn đề của quý khách một cách nhanh chóng nhất.</p>
            <p style="margin-top: 16px;">Chúng tôi rất cảm ơn sự đóng góp của quý khách. Phản hồi của quý khách giúp chúng tôi cải thiện chất lượng dịch vụ tốt hơn mỗi ngày.</p>
            <p style="margin-top: 16px;">Nếu quý khách có bất kỳ câu hỏi nào khác, xin vui lòng liên hệ với chúng tôi qua email: <a href="mailto:{{ $supportEmail }}" style="color: #4299e1; text-decoration: none; font-weight: bold;">{{ $supportEmail }}</a></p>
            <p style="margin-top: 16px;">Trân trọng,</p>
            <p>Đội ngũ Booking Hotel</p>

            <!-- Nút ví dụ (tùy chọn) -->
            <div style="text-align: center; margin-top: 24px;">
                <a href="#" class="button">Truy cập Website của chúng tôi</a>
            </div>
        </div>

        <!-- Chân trang Email -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Booking Hotel</p>
            <p>Địa chỉ: Đà Nẵng</p>
        </div>
    </div>
</body>
</html>
