@extends('frontend.main_master')
@section('main')
<style>
    h6.mb-4.fw-bold {
        display: block !important;
        width: 100%;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .form-check {
        margin-bottom: 0.5rem;
    }
    /* Bạn có thể chỉnh thêm CSS cho slider nếu muốn */
    #price-slider {
        margin-top: 10px;
    }
</style>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filter -->
        <aside class="col-lg-3 mb-4">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-bold">Bộ lọc khách sạn</h5>
                <form id="filterForm" method="POST" action="{{ route('filter.hotel') }}">
                    @csrf
                    <!-- Keyword -->
                    <div class="mb-4">
                        <input
                            type="text"
                            name="keyword"
                            id="keyword"
                            class="form-control"
                            placeholder="Tìm khách sạn..."
                            value="{{ request('keyword') }}"
                            autocomplete="off"
                        >
                    </div>

                    <!-- City name + hidden city_id -->
                    @php
                        $selectedCityId = request('city_id');
                        $selectedCityName = null;
                        if ($selectedCityId) {
                            $cityMatch = $cities->firstWhere('id', $selectedCityId);
                            $selectedCityName = $cityMatch ? $cityMatch->name : null;
                        }
                    @endphp
                    <div class="mb-4">
                        <label for="city_name" class="form-label fw-semibold">Chọn thành phố</label>
                        <input
                            list="cities"
                            name="city_name"
                            id="city_name"
                            class="form-control"
                            placeholder="Nhập hoặc chọn thành phố"
                            autocomplete="off"
                            value="{{ old('city_name', $selectedCityName ?? '') }}"
                        >
                        <datalist id="cities">
                            @foreach($cities as $city)
                                <option value="{{ $city->name }}" data-id="{{ $city->id }}"></option>
                            @endforeach
                        </datalist>
                        <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id', $selectedCityId ?? '') }}">
                    </div>

                    <!-- Amenities checkboxes -->
                    <div class="mb-4">
                        <h6 class="mb-3 fw-bold">Tiện nghi</h6>
                        @php
                            $selectedAmenities = request('amenities', []);
                        @endphp
                        @foreach($facilities as $facility)
                            <div class="form-check">
                                <input
                                    class="form-check-input filter-checkbox"
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $facility->facility_name }}"
                                    id="amenity-{{ Str::slug($facility->facility_name) }}"
                                    {{ in_array($facility->facility_name, $selectedAmenities) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="amenity-{{ Str::slug($facility->facility_name) }}">
                                    {{ ucfirst($facility->facility_name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Lọc khách sạn</button>
                </form>
            </div>
        </aside>

        <!-- Hotel List -->
        <main class="col-lg-9">
            <div id="hotel-list">
                @include('frontend.filterhotel.hotel_list', ['hotels' => $hotels])
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('city_name').addEventListener('input', function() {
        const val = this.value;
        const options = document.querySelectorAll('#cities option');
        let cityId = '';
        options.forEach(option => {
            if (option.value === val) {
                cityId = option.dataset.id;
            }
        });
        document.getElementById('city_id').value = cityId;
    });
});
</script>
@endsection
