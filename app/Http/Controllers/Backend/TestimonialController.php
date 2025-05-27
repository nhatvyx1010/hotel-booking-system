<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class TestimonialController extends Controller
{
    public function AllTestimonial(){
        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));
    }

    public function AddTestimonial(){
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonial(Request $request){
        $image = $request->file('image');
        if ($image) {
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(50, 50)->save('upload/testimonial/' . $name_gen);
            $save_url = 'upload/testimonial/' . $name_gen;
        } else {
            $save_url = null;
        }

        Testimonial::insert([
            'name' => $request->name,
            'city' => $request->city,
            'message' => $request->message,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'messsage' => 'Thêm dữ liệu đánh giá thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.testimonial')->with('message', 'Thêm dữ liệu đánh giá thành công')->with('alert-type', 'success');
    }

    public function EditTestimonial($id){
        $testimonial = Testimonial::find($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    }

    public function UpdateTestimonial(Request $request){
        $test_id = $request->id;

        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(50, 50)->save('upload/testimonial/'.$name_gen);
            $save_url = 'upload/testimonial/'.$name_gen;
    
            Testimonial::findOrFail($test_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'messsage' => 'Cập nhật đánh giá thành công với hình ảnh',
                'alert-type' => 'success'
            );
            return redirect()->route('all.testimonial')->with('message', 'Cập nhật đánh giá thành công với hình ảnh')->with('alert-type', 'success');
        } else {
            Testimonial::findOrFail($test_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Cập nhật đánh giá thành công không có hình ảnh',
                'alert-type' => 'success'
            );
            return redirect()->route('all.testimonial')->with('message', 'Cập nhật đánh giá thành công không có hình ảnh')->with('alert-type', 'success');
        }
    }

    public function DeleteTestimonial($id){
        $item = Testimonial::findOrFail($id);
        $img = $item->image;
        unlink($img);

        Testimonial::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Xóa đánh giá thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa đánh giá thành công')->with('alert-type', 'success');
    }
}
