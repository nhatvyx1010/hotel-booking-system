<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function BookingReport(){
        return view('backend.report.booking_report');
    }

    public function HotelBookingReport() {
        $user_id = Auth::id();
    
        $bookings = Booking::whereHas('room', function($query) use ($user_id) {
            $query->where('hotel_id', $user_id);
        })->get();
    
        return view('hotel.backend.report.booking_report', compact('bookings'));
    }

    public function SearchByDate(Request $request){
        $reportType = $request->input('report_type');
        $bookings = collect();
        $startDate = null;
        $endDate = null;

        switch ($reportType) {
            case 'date':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                $bookings = Booking::where('check_in', '>=', $startDate)
                                ->where('check_out', '<=', $endDate)
                                ->get();
                break;

            case 'week':
                [$year, $week] = explode('-W', $request->input('week'));
                $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();

                $bookings = Booking::where('check_in', '>=', $startDate)
                                ->where('check_out', '<=', $endDate)
                                ->get();
                break;

            case 'month':
                $month = $request->input('month');
                $startDate = Carbon::parse($month)->startOfMonth();
                $endDate = Carbon::parse($month)->endOfMonth();

                $bookings = Booking::where('check_in', '>=', $startDate)
                                ->where('check_out', '<=', $endDate)
                                ->get();
                break;

            case 'year':
                $year = $request->input('year');
                $startDate = Carbon::createFromDate($year)->startOfYear();
                $endDate = Carbon::createFromDate($year)->endOfYear();

                $bookings = Booking::where('check_in', '>=', $startDate)
                                ->where('check_out', '<=', $endDate)
                                ->get();
                break;

            default:
                $bookings = collect();
        }

        // Tính tổng phí dịch vụ
        $totalServiceFee = $bookings->sum('service_fee');

        return view('backend.report.booking_search_date', compact('bookings', 'reportType', 'startDate', 'endDate', 'totalServiceFee'));
    }


    public function HotelSearchByDate(Request $request){
        $user_id = Auth::id();
        $reportType = $request->input('report_type');
        $bookings = collect(); // default empty collection

        $startDate = null;
        $endDate = null;

        if ($reportType === 'date') {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $bookings = Booking::where('check_in', '>=', $startDate)
                ->where('check_out', '<=', $endDate)
                ->whereHas('room', function ($query) use ($user_id) {
                    $query->where('hotel_id', $user_id);
                })
                ->get();
        }

        elseif ($reportType === 'week') {
            $week = $request->input('week'); // format: YYYY-Www
            $dt = Carbon::parse($week . '-1'); // get Monday of that ISO week
            $startDate = $dt->startOfWeek()->toDateString();
            $endDate = $dt->endOfWeek()->toDateString();

            $bookings = Booking::whereBetween('check_in', [$startDate, $endDate])
                ->whereHas('room', function ($query) use ($user_id) {
                    $query->where('hotel_id', $user_id);
                })
                ->get();
        }

        elseif ($reportType === 'month') {
            $month = $request->input('month'); // format: YYYY-MM
            $dt = Carbon::parse($month);
            $startDate = $dt->startOfMonth()->toDateString();
            $endDate = $dt->endOfMonth()->toDateString();

            $bookings = Booking::whereBetween('check_in', [$startDate, $endDate])
                ->whereHas('room', function ($query) use ($user_id) {
                    $query->where('hotel_id', $user_id);
                })
                ->get();
        }

        elseif ($reportType === 'year') {
            $year = $request->input('year'); // format: YYYY
            $startDate = Carbon::createFromDate($year, 1, 1)->toDateString();
            $endDate = Carbon::createFromDate($year, 12, 31)->toDateString();

            $bookings = Booking::whereBetween('check_in', [$startDate, $endDate])
                ->whereHas('room', function ($query) use ($user_id) {
                    $query->where('hotel_id', $user_id);
                })
                ->get();
        }

        return view('hotel.backend.report.booking_search_date', compact('startDate', 'endDate', 'bookings'));
    }    
}
