<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index(){
        $cities = City::whereHas('hotels', function($query) {
            $query->where('status', 'active');
        })->get();
        return view('frontend.index', compact('cities'));
    }

    public function UserProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('profileData'));
    }

    public function UserStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name =$request->name;
        $data->email =$request->email;
        $data->phone =$request->phone;
        $data->address =$request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'messsage' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'User Profile Updated Successfully')->with('alert-type', 'success');
    }

    public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'messsage' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with('message', 'User Logout Successfully')->with('alert-type', 'success');
    }

    public function UserChangePassword(){
        return view('frontend.dashboard.user_change_password');
    }

    public function ChangePasswordStore(Request $request){
        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if(!Hash::check($request->old_password, auth::user()->password)){
            $notification = array(
                'messsage' => 'Old Password Does Not Match!',
                'alert-type' => 'error'
            );
            return back()->with('message', 'Old Password Does Not Match!')->with('alert-type', 'error');
        }

        //Update the password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'messsage' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        return back()->with('message', 'Password Change Successfully')->with('alert-type', 'success');
    }



    #Send Message
    public function SendMessage(Request $request)
    {
        $message = $request->input('message');
        $history = session('message_history', []);
        if (!is_array($history)) {
            $history = [];
        }


        try {
            $response = Http::post('http://192.168.254.1:8001/chat', [
                'message' => $message,
                'history' => $history
            ]);

            if ($response->successful()) {
                $data = $response->json();
                session(['message_history' => $data['history']]);
                return response()->json($data);
            } else {
                \Log::error('API Error: ' . $response->status() . ' - ' . $response->body());
                return response()->json(['error' => 'Không thể gửi tin nhắn'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi gọi API'], 500);
        }
    }

}
