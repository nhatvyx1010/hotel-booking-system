<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use App\Models\City;
use App\Models\Facility;
use Carbon\Carbon;

class FilterController extends Controller
{
    public function FilterHotel(Request $request)
    {
        $keyword = $request->input('keyword');
        $amenities = $request->input('amenities', []);
        $cityId = $request->input('city_id');
        $cityName = $request->input('city_name');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        $views = $request->input('views', []); 
        $bedStyles = $request->input('bed_styles', []); 

        $priceMin = $priceMin !== null ? (int)$priceMin : 0;
        $priceMax = $priceMax !== null ? (int)$priceMax : 20000000; 

        if (!$cityId && $cityName) {
            $city = City::where('name', $cityName)->first();
            if ($city) {
                $cityId = $city->id;
            } else {
                $cityId = null;
            }
        }

        $query = User::where('status', 'active')
            ->where('role', 'hotel');

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        $query->whereHas('rooms', function ($q) use ($amenities, $priceMin, $priceMax, $views, $bedStyles) {
            if (!empty($amenities)) {
                $q->whereHas('facilities', function ($q2) use ($amenities) {
                    $q2->whereIn('facility_name', $amenities);
                });
            }
            $q->whereBetween('price', [$priceMin, $priceMax]);

            if (!empty($views)) {
                $q->whereIn('view', $views);
            }

            if (!empty($bedStyles)) {
                $q->whereIn('bed_style', $bedStyles);
            }
        })
        ->with(['bookarea', 'city'])
        ->with(['rooms' => function ($q) use ($amenities, $priceMin, $priceMax, $views, $bedStyles) {
            if (!empty($amenities)) {
                $q->whereHas('facilities', function ($q2) use ($amenities) {
                    $q2->whereIn('facility_name', $amenities);
                });
            }
            $q->whereBetween('price', [$priceMin, $priceMax]);

            if (!empty($views)) {
                $q->whereIn('view', $views);
            }

            if (!empty($bedStyles)) {
                $q->whereIn('bed_style', $bedStyles);
            }

            $q->with('facilities', 'type');
        }]);

        $hotels = $query->get();

        $facilities = Facility::select('facility_name')->distinct()->get();
        $cities = City::all();

        $uniqueViews = Room::whereNotNull('view')->distinct()->pluck('view');
        $uniqueBedStyles = Room::whereNotNull('bed_style')->distinct()->pluck('bed_style');

        return view('frontend.filterhotel.search_data', compact('hotels', 'facilities', 'cities', 'uniqueViews', 'uniqueBedStyles'));
    }
}
