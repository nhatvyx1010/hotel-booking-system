<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');
    }

    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function AdminLogin(){
        return view('admin.admin_login');
    }

    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name =$request->name;
        $data->email =$request->email;
        $data->phone =$request->phone;
        $data->address =$request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'messsage' => 'Cập nhật hồ sơ quản trị viên thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Cập nhật hồ sơ quản trị viên thành công')->with('alert-type', 'success');
    }

    public function AdminChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }

    public function AdminPasswordUpdate(Request $request){
        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if(!Hash::check($request->old_password, auth::user()->password)){
            $notification = array(
                'messsage' => 'Mật khẩu cũ không đúng!',
                'alert-type' => 'error'
            );
            return back()->with('message', 'Mật khẩu cũ không đúng!')->with('alert-type', 'error');
        }

        //Update the password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'messsage' => 'Đổi mật khẩu thành công',
            'alert-type' => 'success'
        );
        return back()->with('message', 'Đổi mật khẩu thành công')->with('alert-type', 'success');
    }

    public function AllAdmin(){
        $alladmin = User::where('role', 'admin')->get();
        return view('backend.pages.admin.all_admin', compact('alladmin'));
    }

    public function AddAdmin(){
        $roles = Role::all();
        return view('backend.pages.admin.add_admin', compact('roles'));
    }
    
    public function StoreAdmin(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if($request->roles){
            $role = Role::find($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        $notification = array(
            'messsage' => 'Tạo người dùng quản trị viên thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with('message', 'Tạo người dùng quản trị viên thành công')->with('alert-type', 'success');
    }

    public function EditAdmin($id){
        $user = User::find($id);
        $roles = Role::all();
        return view('backend.pages.admin.edit_admin', compact('user', 'roles'));
    }

    public function UpdateAdmin(Request $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        $user->roles()->detach();
        if($request->roles){
            $role = Role::find($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        $notification = array(
            'messsage' => 'Cập nhật người dùng quản trị viên thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with('message', 'Cập nhật người dùng quản trị viên thành công')->with('alert-type', 'success');
    }

    public function DeleteAdmin($id){
        $user = User::find($id);
        if(!is_null($user)){
            $user->delete();
        }

        $notification = array(
            'messsage' => 'Xóa người dùng quản trị viên thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa người dùng quản trị viên thành công')->with('alert-type', 'success');
    }
}
