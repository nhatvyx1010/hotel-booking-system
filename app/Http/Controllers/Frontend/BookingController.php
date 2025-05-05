<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Room;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Stripe;
use App\Models\BookingRoomList;
use App\Models\RoomNumber;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookConfirm;
use App\Models\User;
use App\Notifications\BookingComplete;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function Checkout(){
        if(Session::has('book_date')){
            $book_data = Session::get('book_date');
            $room = Room::find($book_data['room_id']);
            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $nights = $toDate->diffInDays($fromDate);

            return view('frontend.checkout.checkout', compact('book_data', 'room', 'nights'));
        }else{
                $notification = array(
                    'messsage' => 'Something want to wrong!',
                    'alert-type' => 'error'
                );
                return redirect('/')->with('message', 'Something want to wrong!')->with('alert-type', 'error');
        }
    }

    public function BookingStore(Request $request){
        $validateData = $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'persion' => 'required',
            'number_of_rooms' => 'required',
        ]);

        if($request->available_room < $request->number_of_rooms){
            $notification = array(
                'messsage' => 'Something want to wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something want to wrong!')->with('alert-type', 'error');
        }

        Session::forget('book_date');
        $data = array();
        $data['number_of_rooms'] = $request->number_of_rooms;
        $data['available_room'] = $request->available_room;
        $data['persion'] = $request->persion;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in));
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out));
        $data['room_id'] = $request->room_id;

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }

    public function CheckoutStore(Request $request){
        $user = User::where('role', 'admin')->get();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            // 'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

            $book_data = Session::get('book_date');
            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $total_nights = $toDate->diffInDays($fromDate);
            $room = Room::find($book_data['room_id']);
            $subtotal = $room->price * $total_nights * $book_data['number_of_rooms'];
            $discount = ($room->discount/100) * $subtotal;
            $total_price = $subtotal - $discount;
            $code = rand(000000000, 999999999);

            if($request->payment_method == 'Stripe'){
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $s_pay = Stripe\Charge::create([
                    "amount" => $total_price * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Payment For Booking. Booking Number ".$code,
                ]);

                if($s_pay['status'] == 'succeeded'){
                    $payment_status = 1;
                    $transation_id = $s_pay->id;
                }else{
                    $notification = array(
                        'messsage' => 'Sorry Payment Fail',
                        'alert-type' => 'error'
                    );
                    return redirect('/')->with('message', 'Sorry Payment Fail')->with('alert-type', 'error');
                }
            } else{
                $payment_status = 0;
                $transation_id = '';
            }

            $data = new Booking();
            $data->rooms_id = $room->id;
            $data->user_id = Auth::user()->id;
            $data->check_in = date('Y-m-d', strtotime($book_data['check_in']));
            $data->check_out = date('Y-m-d', strtotime($book_data['check_out']));
            $data->persion = $book_data['persion'];
            $data->number_of_rooms = $book_data['number_of_rooms'];
            $data->total_night = $total_nights;
            $data->actual_price = $room->price;
            $data->subtotal = $subtotal;
            $data->discount = $discount;
            $data->total_price = $total_price;
            $data->payment_method = $request->payment_method;
            $data->transation_id = '';
            $data->payment_status = 0;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->country = $request->country;
            $data->state = $request->state;
            // $data->zip_code = $request->zip_code;
            $data->address = $request->address;
            $data->code = $code;
            $data->status = 0;
            $data->created_at = Carbon::now();

            $data->save();

        $sdate = date('Y-m-d', strtotime($book_data['check_in']));
        $edate = date('Y-m-d', strtotime($book_data['check_out']));
        $eldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $eldate);
        foreach($d_period as $period){
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $room->id;
            $booked_dates->book_date = date('Y-m-d', strtotime($period));
            $booked_dates->save();
        }

        Session::forget('book_date');

        $notification = array(
            'messsage' => 'Booking Added Successfully',
            'alert-type' => 'success'
        );

        Notification::send($user, new BookingComplete($request->name));

        return redirect('/')->with('message', 'Booking Added Successfully')->with('alert-type', 'success');
    }

    public function BookingList(){
        $allData = Booking::orderBy('id', 'desc')->get();
        return view('backend.booking.booking_list',compact('allData'));
    }

    public function HotelBookingList(){
        $user_id = Auth::id();  // Lấy ID người dùng hiện tại

        $allData = Booking::whereHas('room', function($query) use ($user_id) {
            $query->where('hotel_id', $user_id);
        })
        ->orderBy('id', 'desc')
        ->get();
    
        return view('hotel.backend.booking.booking_list', compact('allData'));
    }

    public function EditBooking($id){
        $editData = Booking::with('room')->find($id);
        return view('backend.booking.edit_booking', compact('editData'));
    }

    public function HotelEditBooking($id) {
        $user_id = Auth::id();  // Lấy ID người dùng hiện tại
    
        // Lọc booking theo hotel_id từ bảng rooms
        $editData = Booking::with('room')
            ->whereHas('room', function($query) use ($user_id) {
                $query->where('hotel_id', $user_id);
            })
            ->find($id);
    
        return view('hotel.backend.booking.edit_booking', compact('editData'));
    }    

    public function UpdateBookingStatus(Request $request, $id){
        $booking = Booking::find($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        $sendmail = Booking::find($id);
        $data = [
            'check_in' => $sendmail->check_in,
            'check_out' => $sendmail->check_out,
            'name' => $sendmail->name,
            'email' => $sendmail->email,
            'phone' => $sendmail->phone,
        ];

        try {
            Mail::to($sendmail->email)->send(new BookConfirm($data));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        

        $notification = array(
            'messsage' => 'Information Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Information Updated Successfully')->with('alert-type', 'success');
    }
    
    public function HotelUpdateBookingStatus(Request $request, $id){
        $booking = Booking::find($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        $sendmail = Booking::find($id);
        $data = [
            'check_in' => $sendmail->check_in,
            'check_out' => $sendmail->check_out,
            'name' => $sendmail->name,
            'email' => $sendmail->email,
            'phone' => $sendmail->phone,
        ];

        try {
            Mail::to($sendmail->email)->send(new BookConfirm($data));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        

        $notification = array(
            'messsage' => 'Information Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Information Updated Successfully')->with('alert-type', 'success');
    }

    public function UpdateBooking(Request $request, $id){
        if($request->available_room < $request->number_of_rooms){
            $notification = array(
                'messsage' => 'Something Want To Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something Want To Wrong!')->with('alert-type', 'error');
        }
        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('Y-m-d', strtotime($request->check_in));
        $data->check_out = date('Y-m-d', strtotime($request->check_out));
        $data->save();

        BookingRoomList::where('booking_id', $id)->delete();
        RoomBookedDate::where('booking_id', $id)->delete();

        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $eldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $eldate);
        foreach($d_period as $period){
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $data->rooms_id;
            $booked_dates->book_date = date('Y-m-d', strtotime($period));
            $booked_dates->save();
        }
        $notification = array(
            'messsage' => 'Booking Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Booking Updated Successfully')->with('alert-type', 'success');
    }
    
    public function HotelUpdateBooking(Request $request, $id){
        if($request->available_room < $request->number_of_rooms){
            $notification = array(
                'messsage' => 'Something Want To Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Something Want To Wrong!')->with('alert-type', 'error');
        }
        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('Y-m-d', strtotime($request->check_in));
        $data->check_out = date('Y-m-d', strtotime($request->check_out));
        $data->save();

        BookingRoomList::where('booking_id', $id)->delete();
        RoomBookedDate::where('booking_id', $id)->delete();

        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $eldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $eldate);
        foreach($d_period as $period){
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $data->rooms_id;
            $booked_dates->book_date = date('Y-m-d', strtotime($period));
            $booked_dates->save();
        }
        $notification = array(
            'messsage' => 'Booking Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Booking Updated Successfully')->with('alert-type', 'success');
    }

    public function AssignRoom($booking_id){
        $booking = Booking::find($booking_id);
        $booking_date_array = RoomBookedDate::where('booking_id', $booking_id)->pluck('book_date')->toArray();
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)->where('room_id', $booking->rooms_id)->distinct()->pluck('booking_id')->toArray();
        $booking_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();
        $assign_room_ids = BookingRoomList::whereIn('booking_id', $booking_ids)->pluck('room_number_id')->toArray();
        $room_numbers = RoomNumber::where('rooms_id', $booking->rooms_id)->whereNotIn('id', $assign_room_ids)->where('status', 'Active')->get();
        return view('backend.booking.assign_room', compact('booking', 'room_numbers'));
    }
    
    public function HotelAssignRoom($booking_id){
        $booking = Booking::find($booking_id);
        $booking_date_array = RoomBookedDate::where('booking_id', $booking_id)->pluck('book_date')->toArray();
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)->where('room_id', $booking->rooms_id)->distinct()->pluck('booking_id')->toArray();
        $booking_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();
        $assign_room_ids = BookingRoomList::whereIn('booking_id', $booking_ids)->pluck('room_number_id')->toArray();
        $room_numbers = RoomNumber::where('rooms_id', $booking->rooms_id)->whereNotIn('id', $assign_room_ids)->where('status', 'Active')->where('hotel_id', Auth::id())->get();
        return view('hotel.backend.booking.assign_room', compact('booking', 'room_numbers'));
    }

    public function AssignRoomStore($booking_id, $room_number_id){
        $booking = Booking::find($booking_id);
        $check_data = BookingRoomList::where('booking_id', $booking_id)->count();

        if($check_data < $booking->number_of_rooms){
            $assign_data = new BookingRoomList();
            $assign_data->booking_id = $booking_id;
            $assign_data->room_id = $booking->rooms_id;
            $assign_data->room_number_id = $room_number_id;
            $assign_data->save();
            
            $notification = array(
                'messsage' => 'Room Assgined Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with('message', 'Room Assgined Successfully')->with('alert-type', 'success');
        }else{
            $notification = array(
                'messsage' => 'Room Arready Assign',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Room Arready Assign')->with('alert-type', 'error');
        }
    }
    
    public function HotelAssignRoomStore($booking_id, $room_number_id){
        $booking = Booking::find($booking_id);
        $check_data = BookingRoomList::where('booking_id', $booking_id)->count();

        if($check_data < $booking->number_of_rooms){
            $assign_data = new BookingRoomList();
            $assign_data->booking_id = $booking_id;
            $assign_data->room_id = $booking->rooms_id;
            $assign_data->room_number_id = $room_number_id;
            $assign_data->save();
            
            $notification = array(
                'messsage' => 'Room Assgined Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with('message', 'Room Assgined Successfully')->with('alert-type', 'success');
        }else{
            $notification = array(
                'messsage' => 'Room Arready Assign',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Room Arready Assign')->with('alert-type', 'error');
        }
    }

    public function AssignRoomDelete($id){
        $assign_room = BookingRoomList::find($id);
        $assign_room->delete();

        $notification = array(
            'messsage' => 'Assign Room Deleted Successfully ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Assign Room Deleted Successfully')->with('alert-type', 'success');
    }

    public function HotelAssignRoomDelete($id){
        $assign_room = BookingRoomList::find($id);
        $assign_room->delete();

        $notification = array(
            'messsage' => 'Assign Room Deleted Successfully ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Assign Room Deleted Successfully')->with('alert-type', 'success');
    }
    
    public function CheckRoomAvailability(Request $request){
        $user_id = Auth::id();

        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);

        $dt_array = [];
        foreach ($d_period as $period) {
            $dt_array[] = $period->format('Y-m-d');
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)
                                    ->distinct()
                                    ->pluck('booking_id')
                                    ->toArray();

        $room = Room::where('hotel_id', $user_id)
                    ->withCount('room_numbers')
                    ->find($request->room_id);

        if (!$room) {
            return response()->json([
                'available_room' => 0,
                'total_nights' => 0,
                'message' => 'Room not found or does not belong to this hotel.'
            ], 404);
        }

        $bookings = Booking::withCount('assign_rooms')
                    ->whereIn('id', $check_date_booking_ids)
                    ->where('rooms_id', $room->id)
                    ->get()
                    ->toArray();

        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
        $av_room = $room->room_numbers_count - $total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json([
            'available_room' => $av_room,
            'total_nights' => $nights
        ]);
    }
    
    public function HotelCheckRoomAvailability(Request $request){
        $user_id = Auth::id();

        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);

        $dt_array = [];
        foreach ($d_period as $period) {
            $dt_array[] = $period->format('Y-m-d');
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)
                                    ->distinct()
                                    ->pluck('booking_id')
                                    ->toArray();

        $room = Room::where('hotel_id', $user_id)
                    ->withCount('room_numbers')
                    ->find($request->room_id);

        if (!$room) {
            return response()->json([
                'available_room' => 0,
                'total_nights' => 0,
                'message' => 'Room not found or does not belong to this hotel.'
            ], 404);
        }

        $bookings = Booking::withCount('assign_rooms')
                    ->whereIn('id', $check_date_booking_ids)
                    ->where('rooms_id', $room->id)
                    ->get()
                    ->toArray();

        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
        $av_room = $room->room_numbers_count - $total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json([
            'available_room' => $av_room,
            'total_nights' => $nights
        ]);
    }

    public function DownloadInvoice($id){
        $editData = Booking::with('room')->find($id);
        $pdf = Pdf::loadView('hotel.backend.booking.booking_invoice', compact('editData'))
        ->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function HotelDownloadInvoice($id) {
        $user_id = Auth::id();  // Lấy ID người dùng hiện tại
    
        // Lọc booking theo hotel_id từ bảng rooms
        $editData = Booking::with('room')
            ->whereHas('room', function($query) use ($user_id) {
                $query->where('hotel_id', $user_id);
            })
            ->find($id);
    
        // Kiểm tra xem booking có tồn tại không
        if (!$editData) {
            abort(404);  // Nếu không có booking phù hợp, trả về lỗi 404
        }
    
        // Tạo và tải hóa đơn PDF
        $pdf = Pdf::loadView('hotel.backend.booking.booking_invoice', compact('editData'))
            ->setPaper('a4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
    
        return $pdf->download('invoice.pdf');
    }
    

    public function UserBooking(){
        $id = Auth::user()->id;
        $allData = Booking::where('user_id', $id)->orderBy('id', 'desc')->get();
        return view('frontend.dashboard.user_booking', compact('allData'));
    }

    public function UserInvoice($id){
        $editData = Booking::with('room')->find($id);
        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('editData'))
        ->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function MarkAsRead(Request $request, $notificationId){
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $notificationId)->first();
        if($notification){
            $notification->MarkAsRead();
        }

        return response()->json(['count' => $user->unreadNotifications()->count()]);
    }
}
