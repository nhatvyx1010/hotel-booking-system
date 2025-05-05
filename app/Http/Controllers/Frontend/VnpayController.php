<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Hash;
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

class VnpayController extends Controller
{
    public function create(Request $request)
    {
        // $this->vnpayOrder($request);
        session([
            'checkout_data' => $request->only(['name', 'email', 'country', 'phone', 'address', 'state', 'payment_method'])
        ]);
        
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


        $vnp_TmnCode = "JVR5WEX9";
        $vnp_HashSecret = "0CAXXYEFTWU30KW8RDCIEAFAHI7VKR4O";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('return-vnpay');

        $vnp_TxnRef = date("YmdHis");
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = 'billpayment';
        
        if ($request->input('payment_method') == "COD") {
            $vnp_Amount = $request->input('total_price') * 0.3 * 100; // Multiply by 100 as required by VNPAY
        } else {
            $vnp_Amount = $request->input('total_price') * 100; // Multiply by 100 as required by VNPAY
        }

        $vnp_Locale = 'vn';
        // $vnp_IpAddr = request()->ip();
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function return(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            // Lấy lại dữ liệu từ session
            $checkoutData = session('checkout_data');

            // Merge vào request để truyền vào vnpayOrder
            $mergedRequest = new Request(array_merge($checkoutData, $request->all()));

            $this->vnpayOrder($mergedRequest);

            return redirect('/')->with('message', 'Booking Added Successfully')->with('alert-type', 'success');
            // return redirect('/')->with('success', 'Thanh toán thành công!');
        }
        return redirect('/')->with('error', 'Thanh toán thất bại!');
    }

    public function vnpayOrder(Request $request){

            $book_data = Session::get('book_date');
            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $total_nights = $toDate->diffInDays($fromDate);
            $room = Room::find($book_data['room_id']);
            $subtotal = $room->price * $total_nights * $book_data['number_of_rooms'];
            $discount = ($room->discount/100) * $subtotal;
            $total_price = $subtotal - $discount;
            $code = rand(000000000, 999999999);


            $payment_method_value;

            if($request->payment_method == 'VNPAY'){
                
                $payment_method_value = "thanh toan bang VNPAY";
                $prepaid_amount = $total_price; // 100% của tổng tiền
                $remaining_amount = $total_price - $prepaid_amount; // Số tiền còn lại cần trả
                $payment_status = 1;

            } else{
                $payment_method_value = "thanh toan truc tiep";
                $payment_status = 0;
                $prepaid_amount = $total_price * 0.3; // 30% của tổng tiền
                $remaining_amount = $total_price - $prepaid_amount; // Số tiền còn lại cần trả
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
            $data->payment_method = $payment_method_value;
            $data->transation_id = '';
            $data->payment_status = $payment_status;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->country = $request->country;
            $data->state = $request->state;
            // $data->zip_code = $request->zip_code;
            $data->address = $request->address;
            $data->code = $code;

            $data->prepaid_amount = $prepaid_amount;
            $data->remaining_amount = $remaining_amount;
            $data->total_amount = $total_price;
            
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

        // $user = Auth::get();
        // Notification::send($user, new BookingComplete($request->name));


    }
}
