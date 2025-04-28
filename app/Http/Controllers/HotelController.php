<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hotel;
use App\Models\City;

class HotelController extends Controller
{
    //
    public function HotelLogin() {
        return view('hotel.hotel_login');
    }
    //End Method

    public function HotelRegister() {
        return view('hotel.hotel_register');
    }
    //End Method

    public function HotelRegisterSubmit(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'unique:hotels'
            ]
        ]);
        Hotel::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'hotel',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Hotel Register Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('hotel.login')->with($notification);
    }
    //End Method
    
    public function HotelLoginSubmit(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('hotel')->attempt($data)) {
            return redirect()->route('hotel.dashboard')->with('success', 'Login Successfully');
        }else{
            return redirect()->route('hotel.login')->with('error', 'Invalid Creadentials');
        }
    }
    //End Method

    public function HotelDashboard() {
        return view('hotel.index');
    }
    //End Method
    
    public function HotelLogout() {
        Auth::guard('hotel')->logout();
        return redirect()->route('hotel.login')->with('success', 'Logout Success');
    }
    //End Method
    
    public function HotelProfile() {
        $city = City::latest()->get();
        $id = Auth::guard('hotel')->id();
        $profileData = Hotel::find($id);
        return view('hotel.hotel_profile', compact('profileData', 'city'));
    }
    //End Method
    
    public function HotelProfileStore(Request $request) {
        $id = Auth::guard('hotel')->id();
        $data = Hotel::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info;
        $data->cover_photo = $request->cover_photo;
        
        $oldPhotoPath = $data->photo;

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time().'.'.$file->getHotelOriginalExtension();
            $file->move(public_path('upload/hotel_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        
        if($request->hasFile('cover_photo')){
            $file1 = $request->file('cover_photo');
            $filename1 = time().'.'.$file1->getHotelOriginalExtension();
            $file1->move(public_path('upload/hotel_images'), $filename1);
            $data->cover_photo = $filename1;
        }

        $data->save();
        $notification = array(
            'message' => 'Profile Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    //End Method
    
    private function deleteOldImage(string $oldPhotoPath) : void {
        $fullPath = public_path('upload/hotel_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
    //End Private Method

    public function HotelChangePassword() {
        $id = Auth::guard('hotel')->id();
        $profileData = Hotel::find($id);


        return view('hotel.hotel_change_password', compact('profileData'));
    }
    //End Method
    
    public function HotelPasswordUpdate(Request $request) {
        $hotel = Auth::guard('hotel')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $hotel->password)) {
            $notification = array(
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        // Update new password
        Hotel::whereId($hotel->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'message' => 'Password Change Successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    //End Method
}
