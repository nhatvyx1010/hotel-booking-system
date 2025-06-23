<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Contact;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            return redirect()->back()
                ->with('message', 'Vui lòng chọn ít nhất một ảnh để upload')
                ->with('alert-type', 'error');
        }

        foreach ($images as $img) {
            $uploadResult = Cloudinary::upload($img->getRealPath(), [
                'folder' => 'gallery',
                'transformation' => [
                    'width' => 550,
                    'height' => 550,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $save_url = $uploadResult->getSecurePath(); // URL ảnh từ Cloudinary

            Gallery::create([
                'photo_name' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('all.gallery')
            ->with('message', 'Thêm ảnh thư viện thành công')
            ->with('alert-type', 'success');
    }
    
    public function HotelStoreGallery(Request $request)
    {
        $images = $request->file('photo_name');
        $user_id = Auth::id();

        if (!$images || count($images) === 0) {
            return redirect()->back()->with([
                'message' => 'Vui lòng chọn ít nhất một ảnh',
                'alert-type' => 'error'
            ]);
        }

        foreach ($images as $img) {
            $uploadResult = Cloudinary::upload($img->getRealPath(), [
                'folder' => 'gallery',
                'transformation' => [
                    'width' => 550,
                    'height' => 550,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            Gallery::create([
                'photo_name' => $uploadResult->getSecurePath(),
                'hotel_id' => $user_id,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('hotel.all.gallery')->with([
            'message' => 'Thêm ảnh thư viện thành công',
            'alert-type' => 'success'
        ]);
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

    public function UpdateGallery(Request $request)
    {
        $gal_id = $request->id;
        $img = $request->file('photo_name');

        if (!$img) {
            return redirect()->back()->with([
                'message' => 'Vui lòng chọn ảnh để cập nhật',
                'alert-type' => 'error'
            ]);
        }

        $uploadResult = Cloudinary::upload($img->getRealPath(), [
            'folder' => 'gallery',
            'transformation' => [
                'width' => 550,
                'height' => 550,
                'crop' => 'fill',
                'gravity' => 'auto',
            ],
            'resource_type' => 'image',
        ]);

        $save_url = $uploadResult->getSecurePath();

        Gallery::findOrFail($gal_id)->update([
            'photo_name' => $save_url,
        ]);

        return redirect()->route('all.gallery')->with([
            'message' => 'Cập nhật ảnh thư viện thành công',
            'alert-type' => 'success'
        ]);
    }

    public function HotelUpdateGallery(Request $request)
    {
        $gal_id = $request->id;
        $user_id = Auth::id();
        $img = $request->file('photo_name');

        $gallery = Gallery::where('hotel_id', $user_id)->find($gal_id);
        if (!$gallery) {
            return redirect()->route('hotel.all.gallery')->with([
                'message' => 'Không tìm thấy ảnh thư viện',
                'alert-type' => 'error'
            ]);
        }

        if (!$img) {
            return redirect()->back()->with([
                'message' => 'Vui lòng chọn ảnh để cập nhật',
                'alert-type' => 'error'
            ]);
        }

        $uploadResult = Cloudinary::upload($img->getRealPath(), [
            'folder' => 'gallery',
            'transformation' => [
                'width' => 550,
                'height' => 550,
                'crop' => 'fill',
                'gravity' => 'auto',
            ],
            'resource_type' => 'image',
        ]);

        $gallery->update([
            'photo_name' => $uploadResult->getSecurePath(),
        ]);

        return redirect()->route('hotel.all.gallery')->with([
            'message' => 'Cập nhật ảnh thư viện thành công',
            'alert-type' => 'success'
        ]);
    }


    public function DeleteGallery($id){
        $item = Gallery::findOrFail($id);
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
