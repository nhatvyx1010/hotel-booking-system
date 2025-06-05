<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Report;
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

        if ($report && in_array($status, ['pending', 'reviewed'])) {
            $report->status = $status;
            $report->save();
            return response()->json(['message' => 'Cập nhật trạng thái báo cáo thành công']);
        }

        return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
    }
}
