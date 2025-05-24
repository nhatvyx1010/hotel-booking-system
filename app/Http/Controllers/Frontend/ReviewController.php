<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function ValidateBooking(Request $request)
    {
        $request->validate([
            'booking_code' => 'required',
            'booking_email' => 'required|email',
        ]);

        $booking = Booking::with(['room'])
            ->where('code', $request->booking_code)
            ->where('email', $request->booking_email)
            ->whereDate('check_out', '<=', Carbon::today())
            ->where('status', '1')
            ->first();
        
        if (!$booking || !$booking->room || $booking->room->hotel_id != $request->hotel_id) {
            return back()->with([
                'message' => 'Không tìm thấy thông tin đặt phòng phù hợp, hoặc bạn không thuộc khách sạn này.',
                'alert-type' => 'error',
            ]);
        }

        if (!$booking) {
            return back()->with([
                'message' => 'Không tìm thấy thông tin đặt phòng phù hợp hoặc bạn chưa hoàn tất kỳ nghỉ.',
                'alert-type' => 'error',
            ]);
        }

        $userId = Auth::id();

        // Kiểm tra đã review booking chưa
        $hasReviewed = Review::where('user_id', $userId)
            ->where('booking_id', $booking->id)
            ->exists();

        if ($hasReviewed) {
            return back()->with([
                'message' => 'Bạn đã đánh giá cho booking này rồi, không thể đánh giá thêm.',
                'alert-type' => 'error',
            ]);
        }

        // Nếu chưa review
        session()->put('canReview', true);
        session()->put('booking_id', $booking->id);

        return back()->with([
            'message' => 'Tìm thấy thông tin đặt phòng phù hợp. Bạn có thể viết đánh giá.',
            'alert-type' => 'success',
        ]);
    }


    public function ReviewStore(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        $id = Auth::user()->id;

        Review::create([
            'hotel_id' => $request->hotel_id,
            'user_id' => $id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Hoặc pending tuỳ quyền
        ]);

        session()->forget('canReview');
        session()->forget('booking_id');

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

    public function HotelReply(Request $request, $id)
    {
        $parentReview = Review::findOrFail($id);

        // Chỉ hotel mới có quyền trả lời
        if (auth()->id() !== $parentReview->hotel_id) {
            abort(403);
        }

        Review::create([
            'hotel_id' => $parentReview->hotel_id,
            'user_id' => auth()->id(), // hotel user id
            'booking_id' => $parentReview->booking_id,
            'parent_id' => $parentReview->id,
            'comment' => $request->comment,
            'status' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Phản hồi đã được gửi.');
    }

    public function HotelAllReview()
    {
        $hotelId = Auth::id();

        $allreview = Review::with(['user', 'hotel', 'booking'])
            ->where('hotel_id', $hotelId)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('hotel.backend.review.all_review', compact('allreview'));
    }

}
