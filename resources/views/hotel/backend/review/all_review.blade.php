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
                                    <strong>{{ $review->comment }}</strong>
                                    
                                    {{-- Nếu có phản hồi --}}
                                    @if($review->replies->isNotEmpty())
                                        <div class="mt-2 p-2 bg-light border rounded">
                                            <strong>Hotel Reply:</strong> {{ $review->replies->first()->comment }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($review->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($review->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($review->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif

                                    @if ($review->replies->isEmpty())
                                        <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                            @csrf
                                            <textarea name="comment" class="form-control mb-2" rows="2"
                                                placeholder="Reply to this review..." required></textarea>
                                            <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                                        </form>
                                    @endif
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
@endsection
