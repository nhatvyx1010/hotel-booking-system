<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class AdminReviewController extends Controller
{
    public function AllReview()
    {
        $allreview = Review::with(['user', 'hotel', 'booking'])
                    ->whereNull('parent_id')
                    ->latest()
                    ->get();
        return view('backend.review.all_review', compact('allreview'));
    }

    public function UpdateReviewStatus(Request $request)
    {
        $reviewId = $request->input('review_id');
        $status = $request->input('status');

        $review = Review::find($reviewId);

        if ($review && in_array($status, ['pending', 'approved', 'rejected'])) {
            $review->status = $status;
            $review->save();
            return response()->json(['message' => 'Cập nhật trạng thái đánh giá thành công']);
        }

        return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
    }

    public function StoreReview(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'booking_id' => $request->booking_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('message', 'Đánh giá đã gửi và đang chờ phê duyệt');
    }
}
