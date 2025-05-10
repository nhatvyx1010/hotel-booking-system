<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        h1 {
            color: #dc3545; /* red */
            font-size: 22px;
            margin-bottom: 20px;
        }
        h4 {
            margin: 5px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
        .note {
            margin-top: 20px;
            background-color: #ffe3e3;
            padding: 15px;
            border-left: 4px solid #dc3545;
            border-radius: 4px;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Booking Has Been Cancelled</h1>
        <p>We’ve successfully cancelled your reservation. Below are the details of your cancelled booking:</p>

        <h4>Check In: <strong>{{ $booking['check_in'] }}</strong></h4>
        <h4>Check Out: <strong>{{ $booking['check_out'] }}</strong></h4>
        <h4>Username: <strong>{{ $booking['name'] }}</strong></h4>
        <h4>Email: <strong>{{ $booking['email'] }}</strong></h4>
        <h4>Phone: <strong>{{ $booking['phone'] }}</strong></h4>

        <div class="note">
            If this cancellation was a mistake or if you have questions regarding refunds, please contact our support team.
        </div>

        <div class="footer">
            &copy; 2025 Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
