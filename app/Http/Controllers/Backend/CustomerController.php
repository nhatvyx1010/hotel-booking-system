<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function AllCustomer(){
        $customers = User::where('role', 'user')->latest()->get();
        return view('backend.customer.all_customer', compact('customers'));
    }

    public function AddCustomer(){
        return view('backend.customer.add_customer');
    }

    public function StoreCustomer(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $customer = new User();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->password = Hash::make($request->password);
        $customer->role = 'user';

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $customer->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $customer->photo = $filename;
        }

        $customer->save();

        $notification = array(
            'message' => 'Thêm khách hàng thành công!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.customer')->with('success', 'Thêm khách hàng thành công')->with('alert-type', 'success');
    }

    public function EditCustomer($id){
        $customer = User::findOrFail($id);
        return view('backend.customer.edit_customer', compact('customer'));
    }

    public function UpdateCustomer(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $customer = User::findOrFail($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/' . $customer->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $customer->photo = $filename;
        }

        $customer->save();

        return redirect()->route('all.customer')->with('success', 'Cập nhật khách hàng thành công')->with('alert-type', 'success');
    }

    public function DeleteCustomer($id){
        $customer = User::findOrFail($id);
        if ($customer->photo) {
            @unlink(public_path('upload/admin_images/' . $customer->photo));
        }
        $customer->delete();

        return redirect()->route('all.customer')->with('success', 'Xóa khách hàng thành công')->with('alert-type', 'success');
    }
}
