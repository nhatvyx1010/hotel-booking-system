<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        h1 {
            color: #2c7be5;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank you for your booking!</h1>
        <p>We're happy to confirm your reservation. Below are your booking details:</p>
        
        <h4>Check In: {{ $booking['check_in'] }}</h4>
        <h4>Check Out: {{ $booking['check_out'] }}</h4>
        <h4>Username: {{ $booking['name'] }}</h4>
        <h4>Email: {{ $booking['email'] }}</h4>
        <h4>Phone: {{ $booking['phone'] }}</h4>
        
        <p>If you have any questions, feel free to contact us. We look forward to seeing you!</p>
        
        <div class="footer">
            &copy; 2025 Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
