<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;

class DashboardController extends Controller{
    public function getBookingChartData(Request $request){
        $type = $request->query('type', 'week');
        $offset = intval($request->query('offset', 0));
        $today = Carbon::now();
        $hotelId = $request->query('hotel');

        $data = [];

        if ($type === 'week') {
            $start = $today->copy()->addWeeks($offset)->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $day = $start->copy()->addDays($i);

                $query = Booking::query();
                if ($hotelId) {
                    $query->whereHas('room', function ($q) use ($hotelId) {
                        $q->where('hotel_id', $hotelId);
                    });
                }
                $total = $query->whereDate('check_in', $day)->sum('total_price');

                $data[] = [
                    'label' => $day->format('D d M'),
                    'value' => $total
                ];
            }
        } elseif ($type === 'month') {
            $start = $today->copy()->addMonths($offset)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            for ($day = $start->copy(); $day->lte($end); $day->addDays(2)) {
                $next = $day->copy()->addDay();

                $query = Booking::query();
                if ($hotelId) {
                    $query->whereHas('room', function ($q) use ($hotelId) {
                        $q->where('hotel_id', $hotelId);
                    });
                }
                $total = $query->whereBetween('check_in', [$day, $next])->sum('total_price');

                $data[] = [
                    'label' => $day->format('d M') . ' - ' . $next->format('d M'),
                    'value' => $total
                ];
            }
        } elseif ($type === 'year') {
            $year = $today->copy()->addYears($offset)->year;

            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create($year, $i, 1);
                $monthEnd = $monthStart->copy()->endOfMonth();

                $query = Booking::query();
                if ($hotelId) {
                    $query->whereHas('room', function ($q) use ($hotelId) {
                        $q->where('hotel_id', $hotelId);
                    });
                }
                $total = $query->whereBetween('check_in', [$monthStart, $monthEnd])->sum('total_price');

                $data[] = [
                    'label' => $monthStart->format('M'),
                    'value' => $total
                ];
            }
        }

        return response()->json($data);
    }

    public function getBookingChartDataHotel(Request $request)
    {
        $hotelId = Auth::user()->id;

        $type = $request->query('type', 'week');
        $offset = intval($request->query('offset', 0));
        $today = Carbon::now();

        $data = [];

        if ($type === 'week') {
            $start = $today->copy()->addWeeks($offset)->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $day = $start->copy()->addDays($i);
                $total = Booking::whereDate('check_in', $day)
                    ->whereHas('room', function ($query) use ($hotelId) {
                        $query->where('hotel_id', $hotelId);
                    })
                    ->sum('total_price');
                $data[] = [
                    'label' => $day->format('D d M'),
                    'value' => $total
                ];
            }
        } elseif ($type === 'month') {
            $start = $today->copy()->addMonths($offset)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            for ($day = $start; $day->lte($end); $day->addDays(2)) {
                $next = $day->copy()->addDay();
                $total = Booking::whereBetween('check_in', [$day, $next])
                    ->whereHas('room', function ($query) use ($hotelId) {
                        $query->where('hotel_id', $hotelId);
                    })
                    ->sum('total_price');
                $data[] = [
                    'label' => $day->format('d M') . ' - ' . $next->format('d M'),
                    'value' => $total
                ];
            }
        } elseif ($type === 'year') {
            $year = $today->copy()->addYears($offset)->year;
            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create($year, $i, 1);
                $monthEnd = $monthStart->copy()->endOfMonth();
                $total = Booking::whereBetween('check_in', [$monthStart, $monthEnd])
                    ->whereHas('room', function ($query) use ($hotelId) {
                        $query->where('hotel_id', $hotelId);
                    })
                    ->sum('total_price');
                $data[] = [
                    'label' => $monthStart->format('M'),
                    'value' => $total
                ];
            }
        }

        return response()->json($data);
    }

}
