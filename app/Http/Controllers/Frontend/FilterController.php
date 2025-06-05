<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Models\City;
use App\Models\Facility;
use Carbon\Carbon;

class FilterController extends Controller
{public function FilterHotel(Request $request)
{
    $keyword = $request->input('keyword');
    $amenities = $request->input('amenities', []);
    $cityId = $request->input('city_id');
    $cityName = $request->input('city_name');
    $priceMin = (int) $request->input('price_min', 100000);
    $priceMax = (int) $request->input('price_max', 10000000);

    if (!$cityId && $cityName) {
        $city = City::where('name', $cityName)->first();
        if ($city) {
            $cityId = $city->id;
        } else {
            $cityId = null;
        }
    }

    $query = User::with(['bookarea', 'rooms.facilities', 'city'])
        ->where('status', 'active')
        ->where('role', 'hotel');

    if ($keyword) {
        $query->where('name', 'like', "%{$keyword}%");
    }

    if (!empty($amenities)) {
        $query->whereHas('rooms', function ($q) use ($amenities) {
            $q->whereHas('facilities', function ($q2) use ($amenities) {
                $q2->whereIn('facility_name', $amenities);
            });
        });
    }

    if ($cityId) {
        $query->where('city_id', $cityId);
    }

    // Thêm điều kiện lọc giá phòng theo khoảng min -> max
    if ($priceMin || $priceMax) {
        $query->whereHas('rooms', function ($q) use ($priceMin, $priceMax) {
            $q->whereBetween('price', [$priceMin, $priceMax]);
        });
    }

    $hotels = $query->get();

    $facilities = Facility::select('facility_name')->distinct()->get();
    $cities = City::all();

    return view('frontend.filterhotel.search_data', compact('hotels', 'facilities', 'cities'));
}

}
