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
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Reviews</li>
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
                            <th>Serial</th>
                            <th>User</th>
                            <th>Hotel</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allreview as $key => $review)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                <td>{{ $review->hotel->name ?? 'N/A' }}</td>
                                <td>{{ $review->rating }}</td>
                                <td>
                                    {{ Str::limit($review->comment ?? 'N/A', 40) }}
                                    
                                    @if($review->replies->isNotEmpty())
                                        <div class="mt-2 p-2 bg-light border rounded">
                                            <strong>Hotel Reply:</strong> {{ $review->replies->first()->comment }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check-danger form-check form-switch">
                                        <input class="form-check-input status-toggle large-checkbox" type="checkbox"
                                            data-review-id="{{ $review->id }}"
                                            {{ $review->status === 'approved' ? 'checked' : '' }}>
                                        <label class="form-check-label"></label>
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
            var reviewId = $(this).data('review-id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: "{{ route('update.review.status') }}", // bạn cần tạo route này
                method: "POST",
                data: {
                    review_id: reviewId,
                    status: isChecked ? 'approved' : 'pending',
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function () {
                    toastr.error("Something went wrong.");
                }
            });
        });
    });
</script>
@endsection
