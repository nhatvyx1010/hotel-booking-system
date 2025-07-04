<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\City;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HotelController extends Controller
{
    //
    public function HotelLogin() {
        return view('hotel.hotel_login');
    }
    //End Method

    public function HotelRegister() {
        $cities = City::latest()->get();
        return view('hotel.hotel_register', compact('cities'));
    }
    //End Method

    public function HotelRegisterSubmit(Request $request) {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:200'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string'],
                'city_id' => ['required', 'exists:cities,id'],
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'role' => 'hotel',
            'status' => 'pending',
        ]);
    
        event(new Registered($user));
    
        // Auth::login($user);
    
        $notification = array(
            'message' => 'Đăng ký khách sạn thành công! Vui lòng chờ phê duyệt trước khi hoạt động tại hệ thống của chúng tôi!',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($notification);
        // return redirect()->route('hotel.dashboard')->with($notification);
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
            return redirect()->route('hotel.dashboard')->with('success', 'Đăng nhập thành công');
        }else{
            return redirect()->route('hotel.login')->with('error', 'Thông tin đăng nhập không hợp lệ');
        }
    }
    //End Method

    public function HotelDashboard() {
        return view('hotel.index');
    }
    //End Method
    
    public function HotelLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    //End Method
    
    public function HotelProfile() {
        // $city = City::latest()->get();
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('hotel.hotel_profile_view', compact('profileData'));
    }
    //End Method
    
    public function HotelProfileStore(Request $request) {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        $oldPhotoPath = $data->photo;
        $oldAudioPath = $data->hotel_audio;

        if ($request->delete_audio == '1') {
            if (!empty($data->hotel_audio)) {
                $data->hotel_audio = null;
            }
        }

        if ($request->hasFile('photo')) {
            $uploadResult = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'hotel_images',
                'transformation' => [
                    'width' => 500,
                    'height' => 500,
                    'crop' => 'fill',
                    'gravity' => 'auto'
                ],
            ]);

            $data->photo = $uploadResult->getSecurePath();
        }

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');

            $uploadResult = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'hotel_audio',
                'resource_type' => 'video' 
            ]);
            $data->hotel_audio = $uploadResult->getSecurePath();
        }

        $data->save();
        $notification = array(
            'message' => 'Cập nhật hồ sơ thành công',
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
        $id = Auth::id();
        $profileData = User::find($id);
// dd($profileData);
        return view('hotel.hotel_change_password', compact('profileData'));
    }
    //End Method
    
    public function HotelPasswordUpdate(Request $request) {
        $hotel = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $hotel->password)) {
            $notification = array(
                'message' => 'Mật khẩu cũ không khớp!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        // Update new password
        User::whereId($hotel->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'message' => 'Đổi mật khẩu thành công!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    //End Method
}
