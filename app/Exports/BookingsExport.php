<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Booking::with('room.hotel');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('check_in', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($booking) {
            return [
                $booking->id,
                $booking->code,
                $booking->name,
                $booking->email,
                $booking->payment_method,
                $booking->room->hotel->name ?? 'N/A',
                $booking->total_price,
                $booking->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã đặt phòng',
            'Tên khách',
            'Email',
            'Phương thức thanh toán',
            'Tên khách sạn',
            'Tổng tiền',
            'Ngày tạo',
        ];
    }
}