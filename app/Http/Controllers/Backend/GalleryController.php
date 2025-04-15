<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class GalleryController extends Controller
{
    public function AllGallery(){
        $gallery = Gallery::latest()->get();
        return view('backend.gallery.all_gallery', compact('gallery'));
    }

    public function AddGallery(){
        return view('backend.gallery.add_gallery');
    }

    public function StoreGallery(Request $request){
        $images = $request->file('photo_name');
        foreach ($images as $img) {
            $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(550, 550)->save('upload/gallery/'.$name_gen);
            $save_url = 'upload/gallery/'.$name_gen;
            
            Gallery::insert([
                'photo_name' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Gallery Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.gallery')->with('message', 'Gallery Inserted Successfully')->with('alert-type', 'success');
    }

    public function EditGallery($id){
        $gallery = Gallery::find($id);
        return view('backend.gallery.edit_gallery', compact('gallery'));
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
        'message' => 'Gallery Updated Successfully',
        'alert-type' => 'success'
    );
    return redirect()->route('all.gallery')->with('message', 'Gallery Updated Successfully')->with('alert-type', 'success');
    }

    public function DeleteGallery($id){
        $item = Gallery::findOrFail($id);
        $img = $item->photo_name;
        unlink($img);

        Gallery::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Gallery Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Gallery Image Deleted Successfully')->with('alert-type', 'success');
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
            'message' => 'Selected Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Selected Image Deleted Successfully')->with('alert-type', 'success');
    }
}
