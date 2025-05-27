<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Contact;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function AllGallery(){
        $gallery = Gallery::latest()->get();
        return view('backend.gallery.all_gallery', compact('gallery'));
    }

    public function HotelAllGallery(){
        $user_id = Auth::id();
    
        $gallery = Gallery::where('hotel_id', $user_id)->latest()->get();
    
        return view('hotel.backend.gallery.all_gallery', compact('gallery'));
    }
    

    public function AddGallery(){
        return view('backend.gallery.add_gallery');
    }

    public function HotelAddGallery(){
        return view('hotel.backend.gallery.add_gallery');
    }

    public function StoreGallery(Request $request)
    {
        $images = $request->file('photo_name');

        if (!$images || count($images) === 0) {
            return redirect()->back()->with('message', 'Vui lòng chọn ít nhất một ảnh để upload')->with('alert-type', 'error');
        }

        foreach ($images as $img) {
            $name_gen = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(550, 550)->save('upload/gallery/' . $name_gen);
            $save_url = 'upload/gallery/' . $name_gen;

            Gallery::insert([
                'photo_name' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('all.gallery')->with('message', 'Thêm ảnh thư viện thành công')->with('alert-type', 'success');
    }

    public function HotelStoreGallery(Request $request){
        $images = $request->file('photo_name');
        $user_id = Auth::id();
    
        foreach ($images as $img) {
            $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(550, 550)->save('upload/gallery/'.$name_gen);
            $save_url = 'upload/gallery/'.$name_gen;
    
            Gallery::insert([
                'photo_name' => $save_url,
                'hotel_id' => $user_id,
                'created_at' => Carbon::now(),
            ]);
        }
    
        $notification = array(
            'message' => 'Thêm ảnh thư viện thành công',
            'alert-type' => 'success'
        );
    
        return redirect()->route('hotel.all.gallery')->with('message', 'Thêm ảnh thư viện thành công')->with('alert-type', 'success');
    }    

    public function EditGallery($id){
        $gallery = Gallery::find($id);
        return view('backend.gallery.edit_gallery', compact('gallery'));
    }

    public function HotelEditGallery($id){
        $user_id = Auth::id();
        $gallery = Gallery::where('hotel_id', $user_id)->find($id);
        if (!$gallery) {
            return redirect()->route('hotel.all.gallery')->with('message', 'Không tìm thấy ảnh thư viện')->with('alert-type', 'error');
        }
    
        return view('hotel.backend.gallery.edit_gallery', compact('gallery'));
    }

    public function UpdateGallery(Request $request){
        $gal_id = $request->id;
        $img = $request->file('photo_name');

        $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(550, 550)->save('upload/gallery/'.$name_gen);
        $save_url = 'upload/gallery/'.$name_gen;
        
        Gallery::find($gal_id)->update([
            'photo_name' => $save_url,
        ]);

        $notification = array(
            'message' => 'Cập nhật ảnh thư viện thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.gallery')->with('message', 'Cập nhật ảnh thư viện thành công')->with('alert-type', 'success');
    }

    public function HotelUpdateGallery(Request $request){
        $gal_id = $request->id;
        $img = $request->file('photo_name');
        $user_id = Auth::id();
    
        $gallery = Gallery::where('hotel_id', $user_id)->find($gal_id);
        if (!$gallery) {
            return redirect()->route('hotel.all.gallery')->with('message', 'Không tìm thấy ảnh thư viện')->with('alert-type', 'error');
        }
    
        $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(550, 550)->save('upload/gallery/'.$name_gen);
        $save_url = 'upload/gallery/'.$name_gen;
    
        $gallery->update([
            'photo_name' => $save_url,
        ]);
    
        $notification = array(
            'message' => 'Cập nhật ảnh thư viện thành công',
            'alert-type' => 'success'
        );
    
        return redirect()->route('hotel.all.gallery')->with('message', 'Cập nhật ảnh thư viện thành công')->with('alert-type', 'success');
    }    

    public function DeleteGallery($id){
        $item = Gallery::findOrFail($id);
        $img = $item->photo_name;
        unlink($img);

        Gallery::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Xóa ảnh thư viện thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa ảnh thư viện thành công')->with('alert-type', 'success');
    }

    public function HotelDeleteGallery($id){
        $user_id = Auth::id();
    
        $item = Gallery::where('hotel_id', $user_id)->findOrFail($id);
        $img = $item->photo_name;
        unlink($img);
    
        $item->delete();
        $notification = array(
            'message' => 'Xóa ảnh thư viện thành công',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with('message', 'Xóa ảnh thư viện thành công')->with('alert-type', 'success');
    }    

    public function DeleteGalleryMultiple(Request $request){
        $selectedItems = $request->input('selectedItem', []);
        foreach($selectedItems as $itemId){
            $item = Gallery::find($itemId);
            $img = $item->photo_name;
            unlink($img);
            $item->delete();
        }

        $notification = array(
            'message' => 'Xóa các ảnh đã chọn thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa các ảnh đã chọn thành công')->with('alert-type', 'success');
    }

    public function HotelDeleteGalleryMultiple(Request $request){
        $user_id = Auth::id();
    
        $selectedItems = $request->input('selectedItem', []);
        foreach($selectedItems as $itemId){
            $item = Gallery::where('hotel_id', $user_id)->find($itemId);
            if ($item) {
                $img = $item->photo_name;
                unlink($img);
                $item->delete();
            }
        }
    
        $notification = array(
            'message' => 'Xóa các ảnh đã chọn thành công',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with('message', 'Xóa các ảnh đã chọn thành công')->with('alert-type', 'success');
    }    

    public function ShowGallery(){
        $gallery = Gallery::latest()->get();
        return view('frontend.gallery.show_gallery', compact('gallery'));
    }

    public function ContactUs(){
        return view('frontend.contact.contact_us');
    }

    public function StoreContact(Request $request){
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Gửi tin nhắn thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Gửi tin nhắn thành công')->with('alert-type', 'success');
    }

    public function ManageContactMessage(){
        $contact = Contact::latest()->get();
        return view('backend.contact.contact_message', compact('contact'));
    }
}
