<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminHotelController extends Controller
{
    public function AllHotel(){
        $hotels = User::where('role', 'hotel')->with('city')->get();
    
        return view('backend.hotel.all_hotel', compact('hotels'));
    }
    
    public function AddHotel(){
        return view('backend.hotel.add_hotel');
    }

    public function StoreHotel(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $hotel = new User();
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->password = bcrypt($request->password);
        $hotel->phone = $request->phone;
        $hotel->address = $request->address;
        $hotel->role = 'hotel';
        $hotel->status = 'active';
        
        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/admin_images/' . $hotel->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $hotel->photo = $filename;
        }
        
        $hotel->save();

        $notification = array(
            'message' => 'Hotel added successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.hotel')->with('message', 'Hotel added successfully!')->with('alert-type', 'success');
    }

    public function EditHotel($id){
        $hotel = User::findOrFail($id);
        $cities = City::all();

        return view('backend.hotel.edit_hotel', compact('hotel', 'cities'));
    }

    public function UpdateHotel(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'city_id' => 'required|exists:cities,id',
        ]);

        $hotel = User::findOrFail($id);
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->phone = $request->phone;
        $hotel->address = $request->address;
        $hotel->city_id = $request->city_id;
        
        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/admin_images/' . $hotel->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $hotel->photo = $filename;
        }

        $hotel->save();

        $notification = array(
            'message' => 'Hotel updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.hotel')->with('message', 'Hotel updated successfully!')->with('alert-type', 'success');
    }

    public function DeleteHotel($id){
        $hotel = User::findOrFail($id);
        $hotel->delete();

        $notification = array(
            'message' => 'Hotel deleted successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.hotel')->with('message', 'Hotel deleted successfully!')->with('alert-type', 'success');
    }
}
