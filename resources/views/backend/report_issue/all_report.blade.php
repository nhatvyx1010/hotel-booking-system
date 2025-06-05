@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .large-checkbox {
        transform: scale(1.5);
    }
</style>

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tất cả Báo cáo</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người dùng</th>
                            <th>Khách sạn</th>
                            <th>Lý do</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allReports as $key => $report)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $report->user->name ?? 'N/A' }}</td>
                                <td>{{ $report->hotel->name ?? 'N/A' }}</td>
                                <td>{{ $report->message }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle large-checkbox" type="checkbox"
                                            data-report-id="{{ $report->id }}"
                                            {{ $report->status === 'reviewed' ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr/>

</div>

<script>
    $(document).ready(function () {
        $('.status-toggle').on('change', function () {
            var reportId = $(this).data('report-id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: "{{ route('update.report.status') }}",
                method: "POST",
                data: {
                    report_id: reportId,
                    status: isChecked ? 'reviewed' : 'pending',
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function () {
                    toastr.error("Đã có lỗi xảy ra.");
                }
            });
        });
    });
</script>

@endsection
