<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackReceived;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportIssueController extends Controller
{
    public function AllReport()
    {
        $allReports = Report::with(['user', 'hotel', 'booking'])
                        ->latest()
                        ->get();
        return view('backend.report_issue.all_report', compact('allReports'));
    }

    public function UpdateReportStatus(Request $request)
    {
        $reportId = $request->input('report_id');
        $status = $request->input('status');

        $report = Report::find($reportId);

        if (!$report) {
            return response()->json(['message' => 'Không tìm thấy báo cáo'], 404);
        }

        if (!in_array($status, ['pending', 'reviewed'])) {
            return response()->json(['message' => 'Trạng thái yêu cầu không hợp lệ'], 400);
        }

        if ($report->status === 'pending' && $status === 'reviewed') {
            $report->status = $status;
            $report->save();

            $user = User::find($report->user_id);

            if ($user) {
                try {
                    Mail::to('nguyenphamnhatvy10101@gmail.com')->cc($user->email)->send(new FeedbackReceived($user));
                    return response()->json(['message' => 'Cập nhật trạng thái báo cáo thành công và đã gửi email xác nhận'], 200);
                } catch (\Exception $e) {
                    Log::error('Lỗi gửi email xác nhận phản hồi cho báo cáo #' . $reportId . ': ' . $e->getMessage());
                    return response()->json(['message' => 'Cập nhật trạng thái báo cáo thành công nhưng không thể gửi email xác nhận'], 200);
                }
            } else {
                return response()->json(['message' => 'Cập nhật trạng thái báo cáo thành công nhưng không tìm thấy người dùng để gửi email'], 200);
            }
        } elseif ($report->status === 'reviewed' && $status === 'reviewed') {
            return response()->json(['message' => 'Báo cáo đã ở trạng thái đã xem xét. Không cần cập nhật thêm.'], 200);
        } else {
            return response()->json(['message' => 'Cập nhật trạng thái không được phép hoặc không cần thiết.'], 400);
        }
    }
}
