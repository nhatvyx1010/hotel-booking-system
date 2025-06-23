<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CityController extends Controller
{
    // Danh sách tất cả thành phố
    public function CityAll()
    {
        $cities = City::latest()->get();
        return view('backend.city.all_city', compact('cities'));
    }

    // Form thêm mới
    public function CityAdd()
    {
        return view('backend.city.add_city');
    }

    // Lưu thành phố mới
    public function CityStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $city = new City();
        $city->name = $request->name;
        $city->slug = Str::slug($request->name);
        $city->description = $request->description;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'city',
                'transformation' => [
                    'width' => 600,
                    'height' => 400,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $city->image = $uploadResult->getSecurePath(); // Lưu URL ảnh vào DB
        }

        $city->save();

        return redirect()->route('all.city')->with('success', 'Thêm thành phố thành công');
    }

    // Form chỉnh sửa
    public function CityEdit($id)
    {
        $city = City::findOrFail($id);
        return view('backend.city.edit_city', compact('city'));
    }

    // Cập nhật thành phố
    public function CityUpdate(Request $request)
    {
        $city = City::findOrFail($request->id);

        $request->validate([
            'name' => 'required|unique:cities,name,' . $city->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $city->name = $request->name;
        $city->slug = Str::slug($request->name);
        $city->description = $request->description;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'city',
                'transformation' => [
                    'width' => 600,
                    'height' => 400,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $city->image = $uploadResult->getSecurePath(); // Lưu URL ảnh vào DB
        }

        $city->save();

        return redirect()->route('all.city')->with('success', 'Cập nhật thành phố thành công');
    }

    // Xoá thành phố
    public function CityDestroy($id)
    {
        $city = City::findOrFail($id);
        if ($city->image && File::exists(public_path($city->image))) {
            File::delete(public_path($city->image));
        }
        $city->delete();

        return redirect()->route('all.city')->with('success', 'Xóa thành phố thành công');
    }
}
