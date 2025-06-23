<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TestimonialController extends Controller
{
    public function AllTestimonial(){
        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));
    }

    public function AddTestimonial(){
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonial(Request $request)
    {
        $save_url = null;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'testimonial',
                'transformation' => [
                    'width' => 50,
                    'height' => 50,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $save_url = $uploadResult->getSecurePath();
        }

        Testimonial::create([
            'name' => $request->name,
            'city' => $request->city,
            'message' => $request->message,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('all.testimonial')->with([
            'message' => 'Thêm dữ liệu đánh giá thành công',
            'alert-type' => 'success',
        ]);
    }


    public function EditTestimonial($id){
        $testimonial = Testimonial::find($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    }

    public function UpdateTestimonial(Request $request)
    {
        $test_id = $request->id;
        $testimonial = Testimonial::findOrFail($test_id);

        $data = [
            'name' => $request->name,
            'city' => $request->city,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ];

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'testimonial',
                'transformation' => [
                    'width' => 50,
                    'height' => 50,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $data['image'] = $uploadResult->getSecurePath();

            $message = 'Cập nhật đánh giá thành công với hình ảnh';
        } else {
            $message = 'Cập nhật đánh giá thành công không có hình ảnh';
        }

        $testimonial->update($data);

        return redirect()->route('all.testimonial')->with([
            'message' => $message,
            'alert-type' => 'success',
        ]);
    }


    public function DeleteTestimonial($id){
        $item = Testimonial::findOrFail($id);
        Testimonial::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Xóa đánh giá thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa đánh giá thành công')->with('alert-type', 'success');
    }
}
