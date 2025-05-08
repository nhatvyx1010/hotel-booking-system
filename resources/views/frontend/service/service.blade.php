@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Services</li>
            </ul>
            <h3>Our Services</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Services Area -->
<div class="services-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            @foreach ($facilities as $facility)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="p-4 border rounded bg-light shadow-sm h-100 text-center">
                        <i class='bx bx-check-circle text-success mb-2' style="font-size: 24px;"></i>
                        <h5 class="mb-0">{{ $facility->facility_name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Services Area End -->

@endsection
