<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\HotelApprovedMail;
use App\Mail\HotelRejectedMail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminHotelController extends Controller
{
    public function AllHotel(){
        $hotels = User::where('role', 'hotel')->where('status', 'active')->with('city')->get();
    
        return view('backend.hotel.all_hotel', compact('hotels'));
    }

    public function AllHotelInactive(){
        $hotels = User::where('role', 'hotel')->where('status', 'inactive')->with('city')->get();
    
        return view('backend.hotel.all_hotel_inactive', compact('hotels'));
    }

    public function AllHotelPending(){
        $hotels = User::where('role', 'hotel')->where('status', 'pending')->with('city')->get();
    
        return view('backend.hotel.all_hotel_pending', compact('hotels'));
    }

    public function AllHotelCancelled(){
        $hotels = User::where('role', 'hotel')->where('status', 'cancelled')->with('city')->get();
    
        return view('backend.hotel.all_hotel_cancelled', compact('hotels'));
    }
    
    public function AddHotel(){
        $cities = City::latest()->get();
        return view('backend.hotel.add_hotel', compact('cities'));
    }

    public function StoreHotel(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'hotel_audio' => 'nullable|mimes:mp3,wav,m4a',
            'city_id' => ['required', 'exists:cities,id'],
        ]);

        $hotel = new User();
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->password = bcrypt($request->password);
        $hotel->phone = $request->phone;
        $hotel->address = $request->address;
        $hotel->city_id = $request->city_id;
        $hotel->role = 'hotel';
        $hotel->status = 'active';

        // Xử lý ảnh - upload lên Cloudinary
        if ($request->hasFile('photo')) {
            $uploadResult = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'admin_images',
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
                'resource_type' => 'image',
            ]);

            $hotel->photo = $uploadResult->getSecurePath(); // Lưu URL ảnh
        }

        // Xử lý file âm thanh 
        if ($request->hasFile('hotel_audio')) {
            $uploadResult = Cloudinary::upload($request->file('hotel_audio')->getRealPath(), [
                'folder' => 'hotel_audio',
                'resource_type' => 'video' 
            ]);

            $hotel->hotel_audio = $uploadResult->getSecurePath(); 
        }

        $hotel->save();

        return redirect()->route('all.hotel')->with('message', 'Thêm khách sạn thành công!')->with('alert-type', 'success');
    }

    public function EditHotel($id){
        $hotel = User::findOrFail($id);
        $cities = City::all();

        return view('backend.hotel.edit_hotel', compact('hotel', 'cities'));
    }
    
    public function EditHotelPending($id){
        $hotel = User::findOrFail($id);
        $cities = City::all();

        return view('backend.hotel.edit_hotel_pending', compact('hotel', 'cities'));
    }

    public function UpdateHotel(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'hotel_audio' => 'nullable|mimes:mp3,wav,m4a',  // Validate audio
            'city_id' => 'required|exists:cities,id',
        ]);

        $hotel = User::findOrFail($id);
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->phone = $request->phone;
        $hotel->address = $request->address;
        $hotel->city_id = $request->city_id;
        $hotel->status = $request->status;

        // Xử lý ảnh - upload lên Cloudinary
        if ($request->hasFile('photo')) {
            $uploadResult = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'admin_images',
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
                'resource_type' => 'image',
            ]);

            $hotel->photo = $uploadResult->getSecurePath(); // Lưu URL ảnh
        }

        // Xử lý file âm thanh - upload lên Cloudinary
        if ($request->hasFile('hotel_audio')) {
            $uploadResult = Cloudinary::upload($request->file('hotel_audio')->getRealPath(), [
                'folder' => 'hotel_audio',
                'resource_type' => 'video' // Bắt buộc cho file mp3/wav
            ]);

            $hotel->hotel_audio = $uploadResult->getSecurePath(); // Lưu URL file audio
        }

        $hotel->save();

        return redirect()->route('all.hotel')->with('message', 'Cập nhật khách sạn thành công!')->with('alert-type', 'success');
    }
    
    public function UpdateHotelPending(Request $request, $id){
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
        $hotel->status = $request->status;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'admin_images',
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
                'resource_type' => 'image',
            ]);

            $hotel->photo = $uploadResult->getSecurePath(); // Lưu URL ảnh
        }
        
        try {
            if ($hotel->status === 'active') {
                Mail::to('nguyenphamnhatvy1010@gmail.com')->cc($hotel->email)->send(new HotelApprovedMail($hotel));
            } elseif ($hotel->status === 'cancelled') {
                Mail::to('nguyenphamnhatvy1010@gmail.com')->cc($hotel->email)->send(new HotelRejectedMail($hotel));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gửi email thất bại: ' . $e->getMessage());
        }

        $hotel->save();

        $notification = array(
            'message' => 'Cập nhật khách sạn thành công!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.hotel')->with('message', 'Cập nhật khách sạn thành công!')->with('alert-type', 'success');
    }

    public function DeleteHotel($id){
        $hotel = User::findOrFail($id);
        $hotel->delete();

        $notification = array(
            'message' => 'Xóa khách sạn thành công!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.hotel')->with('message', 'Xóa khách sạn thành công!')->with('alert-type', 'success');
    }
}
