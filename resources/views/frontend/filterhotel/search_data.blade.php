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
    .noUi-connect {
        background: #007bff; 
    }
    .noUi-horizontal .noUi-handle {
        background: #fff;
        border: 1px solid #ced4da;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .noUi-target {
        border: 1px solid #ced4da;
        border-radius: 4px;
        background: #f8f9fa;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
    .noUi-tooltip {
        display: none; /* Ẩn tooltip mặc định */
        background: #007bff;
        color: white;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 0.8em;
        transform: translate(-50%, 0);
        white-space: nowrap;
    }
    .noUi-active .noUi-tooltip {
        display: block; /* Hiện tooltip khi kéo */
    }
    .price-range-display {
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        color: #333;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-bold">Bộ lọc khách sạn</h5>
                <form id="filterForm" method="POST" action="{{ route('filter.hotel') }}">
                    @csrf
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

                    {{--- --- THÊM BỘ LỌC VIEW BẰNG CHECKBOX --- ---}}
                    <div class="mb-4">
                        <h6 class="mb-3 fw-bold">Loại View</h6>
                        @php
                            $selectedViews = request('views', []); // Lấy các view đã chọn từ request
                        @endphp
                        @foreach($uniqueViews as $view)
                            <div class="form-check">
                                <input
                                    class="form-check-input filter-checkbox"
                                    type="checkbox"
                                    name="views[]" {{-- Đảm bảo tên là 'views[]' để nhận mảng --}}
                                    value="{{ $view }}"
                                    id="view-{{ Str::slug($view) }}"
                                    {{ in_array($view, $selectedViews) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="view-{{ Str::slug($view) }}">
                                    {{ $view }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{--- --- THÊM BỘ LỌC LOẠI GIƯỜNG BẰNG CHECKBOX --- ---}}
                    <div class="mb-4">
                        <h6 class="mb-3 fw-bold">Loại Giường</h6>
                        @php
                            $selectedBedStyles = request('bed_styles', []); // Lấy các bed_style đã chọn từ request
                        @endphp
                        @foreach($uniqueBedStyles as $bedStyle)
                            <div class="form-check">
                                <input
                                    class="form-check-input filter-checkbox"
                                    type="checkbox"
                                    name="bed_styles[]" {{-- Đảm bảo tên là 'bed_styles[]' để nhận mảng --}}
                                    value="{{ $bedStyle }}"
                                    id="bed_style-{{ Str::slug($bedStyle) }}"
                                    {{ in_array($bedStyle, $selectedBedStyles) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="bed_style-{{ Str::slug($bedStyle) }}">
                                    {{ $bedStyle }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <h6 class="mb-3 fw-bold">Giá tiền (VNĐ)</h6>
                        <div id="price-slider"></div>
                        <div class="price-range-display mt-2">
                            <span id="slider-range-value"></span>
                        </div>
                        <input type="hidden" name="price_min" id="price_min" value="{{ request('price_min', 0) }}">
                        <input type="hidden" name="price_max" id="price_max" value="{{ request('price_max', 10000000) }}">
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Áp dụng bộ lọc</button>
                    </div>
                </form>
            </div>
        </aside>

        <main class="col-lg-9">
            <div id="hotel-list">
                @include('frontend.filterhotel.hotel_list', ['hotels' => $hotels])
            </div>
        </main>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
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

    const priceSlider = document.getElementById('price-slider');
    const priceMinInput = document.getElementById('price_min');
    const priceMaxInput = document.getElementById('price_max');
    const sliderRangeValue = document.getElementById('slider-range-value');

    const initialPriceMin = parseInt(priceMinInput.value) || 0;
    const initialPriceMax = parseInt(priceMaxInput.value) || 10000000; 

    noUiSlider.create(priceSlider, {
        start: [initialPriceMin, initialPriceMax],
        connect: true, 
        range: {
            'min': 0, 
            'max': 10000000
        },
        step: 100000, 
        tooltips: true, 
        format: {
            to: function (value) {
                return Math.round(value).toLocaleString('vi-VN') + ' đ';
            },
            from: function (value) {
                return Number(value.replace(' đ', '').replace(/\./g, '')); 
            }
        }
    });

    priceSlider.noUiSlider.on('update', function (values, handle) {
        priceMinInput.value = values[0].replace(' đ', '').replace(/\./g, '');
        priceMaxInput.value = values[1].replace(' đ', '').replace(/\./g, '');
        sliderRangeValue.innerHTML = values[0] + ' - ' + values[1];
    });

});
</script>
@endsection