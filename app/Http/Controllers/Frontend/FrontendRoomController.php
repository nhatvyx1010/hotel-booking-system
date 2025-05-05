<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Room;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\User;

class FrontendRoomController extends Controller
{
    public function AllFrontendRoom(){
        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms', compact('rooms'));
    }

    public function RoomDetailsPage($id){
        $roomdetails = Room::find($id);
        $multiImage = MultiImage::where('rooms_id', $id)->get();
        $facility = Facility::where('rooms_id', $id)->get();
        $otherRooms = Room::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        return view('frontend.room.room_details', compact('roomdetails', 'multiImage', 'facility', 'otherRooms'));
    }

    public function BookingSearch(Request $request){
        $request->flash();

        if($request->check_in == $request->check_out){

            $notification = array(
                'messsage' => 'Something want to wrong',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something want to wrong')->with('alert-type', 'error');
        }
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('room_numbers')->where('status', '1')->get();

        return view('frontend.room.search_room', compact('rooms', 'check_date_booking_ids'));
    }

    public function SearchRoomDetails(Request $request, $id){
        $request->flash();
        $roomdetails = Room::find($id);
        $multiImage = MultiImage::where('rooms_id', $id)->get();
        $facility = Facility::where('rooms_id', $id)->get();
        $otherRooms = Room::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        $room_id = $id;
        return view('frontend.room.search_room_details', compact('roomdetails', 'multiImage', 'facility', 'otherRooms', 'room_id'));
    }

    public function CheckRoomAvailability(Request $request){
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

    
        $hotel_id = 7;
    
        $room = Room::where('hotel_id', $hotel_id)
            ->withCount('room_numbers')
            ->find($request->room_id);
        
        $bookings = Booking::withCount('assign_rooms')
            ->whereIn('id', $check_date_booking_ids)
            ->whereHas('room', function ($query) use ($hotel_id) {
                $query->where('hotel_id', $hotel_id);
            })
            ->where('rooms_id', $room->id)
            ->get()
            ->toArray();

        // $room = Room::where('hotel_id', $hotel_id)->withCount('room_numbers')->find($request->room_id);
        // $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $room->id)->get()->toArray();
        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
        $av_room = @$room->room_numbers_count-$total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json(['available_room'=>$av_room, 'total_nights'=>$nights]);
    }

    
    public function BookingListRoomSearch(Request $request){
        $request->flash();

        if($request->check_in == $request->check_out){

            $notification = array(
                'messsage' => 'Something want to wrong',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something want to wrong')->with('alert-type', 'error');
        }
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('room_numbers')->where('status', '1')->get();

        // Lấy hotel_id từ rooms
        $hotel_ids = $rooms->pluck('hotel_id')->unique();

        // Tìm danh sách hotels
        $hotels = User::with('bookarea')
                        ->withCount('room_numbers')
                        ->whereIn('id', $hotel_ids)
                        ->get();
        return view('frontend.listhotel.search_room', compact('hotels', 'check_date_booking_ids'));
    }
    
    public function BookingSearchHotel(Request $request){
        $request->flash();

        if($request->check_in == $request->check_out){

            $notification = array(
                'messsage' => 'Something want to wrong',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something want to wrong')->with('alert-type', 'error');
        }
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('room_numbers')
                    ->where('status', '1')
                    ->where('hotel_id', $request->hotel_id) // Thêm điều kiện lọc theo hotel_id
                    ->get();

        return view('frontend.room.search_room', compact('rooms', 'check_date_booking_ids'));
    }


    public function CheckRoomAvailabilityHotel(Request $request){
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $room = Room::where('hotel_id', $request->hotel_id)
            ->withCount('room_numbers')
            ->find($request->room_id);
        
        $bookings = Booking::withCount('assign_rooms')
            ->whereIn('id', $check_date_booking_ids)
            ->whereHas('room', function ($query) use ($hotel_id) {
                $query->where('hotel_id', $hotel_id);
            })
            ->where('rooms_id', $room->id)
            ->get()
            ->toArray();

        // $room = Room::where('hotel_id', $hotel_id)->withCount('room_numbers')->find($request->room_id);
        // $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $room->id)->get()->toArray();
        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
        $av_room = @$room->room_numbers_count-$total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json(['available_room'=>$av_room, 'total_nights'=>$nights]);
    }



    // public function CheckRoomAvailability(Request $request){
    //     $sdate = date('Y-m-d', strtotime($request->check_in));
    //     $edate = date('Y-m-d', strtotime($request->check_out));
    //     $alldate = Carbon::create($edate)->subDay();
    //     $d_period = CarbonPeriod::create($sdate, $alldate);
    //     $dt_array = [];
    //     foreach ($d_period as $period) {
    //         array_push($dt_array, date('Y-m-d', strtotime($period)));
    //     }
    
    //     // Lấy tất cả các room ID thuộc hotel
    //     $hotel_id = 7;
    //     $roomIds = Room::where('hotel_id', $hotel_id)->pluck('id')->toArray();
    
    //     // Các booking đã đặt trong khoảng ngày
    //     $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)
    //                                 ->distinct()
    //                                 ->pluck('booking_id')
    //                                 ->toArray();
    
    //     // Lấy các bookings của những phòng thuộc khách sạn đó
    //     $bookings = Booking::withCount('assign_rooms')
    //                 ->whereIn('id', $check_date_booking_ids)
    //                 ->whereIn('rooms_id', $roomIds)
    //                 ->get()
    //                 ->toArray();
    
    //     // Tổng số phòng đã đặt
    //     $total_booked_rooms = array_sum(array_column($bookings, 'assign_rooms_count'));
    
    //     // Tổng số room_numbers của khách sạn
    //     $total_rooms = Room::whereIn('id', $roomIds)->withCount('room_numbers')->get()->sum('room_numbers_count');
    
    //     // Phòng còn trống
    //     $available_rooms = $total_rooms - $total_booked_rooms;
    
    //     // Tổng số đêm
    //     $toDate = Carbon::parse($request->check_in);
    //     $fromDate = Carbon::parse($request->check_out);
    //     $nights = $toDate->diffInDays($fromDate);
    
    //     return response()->json([
    //         'available_room' => $available_rooms,
    //         'total_nights' => $nights
    //     ]);
    // }
    
}
