<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class HotelRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private $user) {}

    public function envelope()
    {
        return new Envelope(
            subject: 'Yêu cầu trở thành khách sạn không được phê duyệt'
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.hotel_rejected',
            with: [
                'user' => $this->user,
                'supportEmail' => 'bookinghotel@booking.com', // thay bằng email thực
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
