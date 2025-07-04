<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomNumber;
use App\Models\RoomSpecialPrice;
use App\Models\RoomType;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RoomController extends Controller
{
    public function EditRoom($id){
        $basic_facility = Facility::where('rooms_id', $id)->get();
        $multiimgs = MultiImage::where('rooms_id', $id)->get();
        $editData = Room::find($id);
        $allroomNo = RoomNumber::where('rooms_id', $id)->get();
        return view('backend.allroom.rooms.edit_rooms', compact('editData', 'basic_facility', 'multiimgs', 'allroomNo'));
    }

    public function HotelEditRoom($id){
        $user_id = Auth::id();
    
        $basic_facility = Facility::where('rooms_id', $id)->where('hotel_id', $user_id)->get();
        $multiimgs = MultiImage::where('rooms_id', $id)->where('hotel_id', $user_id)->get();
        $editData = Room::where('id', $id)->where('hotel_id', $user_id)->first();
        $allroomNo = RoomNumber::where('rooms_id', $id)->where('hotel_id', $user_id)->get();
    
        if (!$editData) {
            return redirect()->route('hotel.dashboard')->with('error', 'Không tìm thấy phòng thuộc khách sạn này');
        }
    
        return view('hotel.backend.allroom.rooms.edit_rooms', compact('editData', 'basic_facility', 'multiimgs', 'allroomNo'));
    }

    public function UpdateRoom(Request $request, $id){
        $room = Room::find($id);
        $room->roomtype_id = $room->roomtype_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_desc = $request->short_desc;
        $room->description = $request->description;
        $room->status = 1;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'room_images',
                'transformation' => [
                    'width' => 550,
                    'height' => 850,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $room['image'] = $uploadResult->getSecurePath(); // Lưu URL ảnh vào DB
        }

        $room->save();

        if($request->facility_name == NULL){

            $notification = array(
                'message' => 'Xin lỗi! Bạn chưa chọn tiện ích cơ bản nào',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Xin lỗi! Bạn chưa chọn tiện ích cơ bản nào')->with('alert-type', 'error');
        } else{
            Facility::where('rooms_id', $id)->delete();
            $facilities = Count($request->facility_name);
            for($i = 0; $i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->rooms_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }

        if ($room->save()) {
            $files = $request->multi_img;

            if (!empty($files)) {
                MultiImage::where('rooms_id', $id)->delete();

                foreach ($files as $file) {
                    try {
                        $upload = Cloudinary::upload($file->getRealPath(), [
                            'folder' => 'roomimg/multi'
                        ]);

                        $imageUrl = $upload->getSecurePath();

                        // Lưu đường dẫn cloud vào DB
                        $subimage = new MultiImage();
                        $subimage->rooms_id = $room->id;
                        $subimage->multi_img = $imageUrl;
                        $subimage->save();

                        echo "✅ Uploaded: $imageUrl\n";
                    } catch (Exception $e) {
                        echo "❌ Lỗi upload ảnh phụ: " . $e->getMessage() . "\n";
                    }
                }
            }
        }

        $notification = array(
            'messsage' => 'Cập nhật phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Cập nhật phòng thành công')->with('alert-type', 'success');
    }

    public function HotelUpdateRoom(Request $request, $id){
        $user_id = Auth::id();
    
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
    
        $roomtype_id = $room->roomtype_id;
        $room_type = RoomType::find($roomtype_id);

        if ($room_type) {
            $room_type->name = $request->roomtype_name;
            $room_type->save(); 
        }

        if (!$room) {
            return redirect()->back()->with('error', 'Không tìm thấy phòng thuộc khách sạn này');
        }
    
        $room->roomtype_id = $room->roomtype_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_desc = $request->short_desc;
        $room->description = $request->description;
        $room->status = 1;
    
        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'room_images', // Thư mục lưu trong Cloudinary
                'transformation' => [
                    'width' => 550,
                    'height' => 850,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ],
                'resource_type' => 'image',
            ]);

            $room['image'] = $uploadResult->getSecurePath(); // Lưu đường dẫn ảnh trên Cloudinary
        }

        $room->save();
    
        if($request->facility_name == NULL){
            return redirect()->back()->with('message', 'Xin lỗi! Bạn chưa chọn tiện ích cơ bản nào')->with('alert-type', 'error');
        } else {
            Facility::where('rooms_id', $id)->delete();
            $facilities = count($request->facility_name);
            for($i = 0; $i < $facilities; $i++){
                $user_id = Auth::id();
                $facility = new Facility();
                $facility->rooms_id = $room->id;
                $facility->facility_name = $request->facility_name[$i];
                $facility->hotel_id = $user_id;
                $facility->save();
            }
        }
        
        if ($request->multi_img) {
            $files = $request->multi_img;

            // Xóa ảnh cũ trong DB (nếu có)
            MultiImage::where('rooms_id', $id)->delete();

            foreach ($files as $file) {
                try {
                    // Upload file lên Cloudinary, lưu trong folder roomimg/multi
                    $upload = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'roomimg/multi'
                    ]);

                    $imageUrl = $upload->getSecurePath(); // Đường dẫn ảnh trên Cloudinary

                    $multiImage = new MultiImage();
                    $multiImage->rooms_id = $room->id;
                    $multiImage->hotel_id = Auth::id();
                    $multiImage->multi_img = $imageUrl;
                    $multiImage->save();

                    echo "✅ Uploaded multi_img: $imageUrl\n";
                } catch (Exception $e) {
                    echo "❌ Lỗi upload multi_img: " . $e->getMessage() . "\n";
                }
            }
        }
    
        // Xoá các giá đặc biệt cũ trước khi thêm mới
        RoomSpecialPrice::where('room_id', $room->id)->delete();

        if ($request->has('special_prices')) {
            foreach ($request->special_prices as $price) {
                if (!empty($price['start_date']) && !empty($price['end_date']) && !empty($price['special_price'])) {
                    RoomSpecialPrice::create([
                        'room_id' => $room->id,
                        'start_date' => $price['start_date'],
                        'end_date' => $price['end_date'],
                        'special_price' => $price['special_price'],
                        'description' => $price['description'] ?? null,
                    ]);
                }
            }
        }

        $notification = array(
            'message' => 'Cập nhật phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Cập nhật phòng thành công')->with('alert-type', 'success');
    }    

    public function MultiImageDelete($id){
        $deletedata = MultiImage::where('id', $id)->first();

        if($deletedata){
            MultiImage::where('id', $id)->delete();
        }
        $notification = array(
            'messsage' => 'Xóa đa ảnh hình thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa đa ảnh hình thành công')->with('alert-type', 'success');
    }

    public function HotelMultiImageDelete($id){
        $user_id = Auth::id();
    
        $deletedata = MultiImage::where('id', $id)->whereHas('room', function($query) use ($user_id) {
            $query->where('hotel_id', $user_id);
        })->first();
    
        if ($deletedata) {
            MultiImage::where('id', $id)->delete();
    
            $notification = array(
                'message' => 'Xóa đa ảnh hình thành công',
                'alert-type' => 'success'
            );
            return redirect()->back()->with('message', 'Xóa đa ảnh hình thành công')->with('alert-type', 'success');
        } else {
            return redirect()->back()->with('error', 'Ảnh không tồn tại');
        }
    }
    
    public function StoreRoomNumber(Request $request, $id){
        $data = new RoomNumber();
        $data->rooms_id = $id;
        $data->room_type_id = $request->room_type_id;
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();

        $notification = array(
            'messsage' => 'Thêm số phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Thêm số phòng thành công')->with('alert-type', 'success');
    }

    public function HotelStoreRoomNumber(Request $request, $id){
        $user_id = Auth::id();
    
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Không tìm thấy phòng thuộc khách sạn này');
        }
        $isDuplicate = RoomNumber::where('hotel_id', $user_id)
                        ->where('room_no', $request->room_no)
                        ->exists();

        if ($isDuplicate) {
            return redirect()->back()
                ->with('message', 'Số phòng đã tồn tại trong khách sạn này.')
                ->with('alert-type', 'error');
        }
    
        $data = new RoomNumber();
        $data->hotel_id = $user_id;
        $data->rooms_id = $id;
        $data->room_type_id = $request->room_type_id;
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();
    
        $notification = array(
            'message' => 'Thêm số phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Thêm số phòng thành công')->with('alert-type', 'success');
    }
    

    public function EditRoomNumber($id){
        $editroomno = RoomNumber::find($id);
        return view('backend.allroom.rooms.edit_room_number', compact('editroomno'));
    }

    public function HotelEditRoomNumber($id){
        $editroomno = RoomNumber::find($id);
        return view('hotel.backend.allroom.rooms.edit_room_number', compact('editroomno'));
    }

    public function UpdateRoomNumber(Request $request, $id){
        $data = RoomNumber::find($id);
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();

        $notification = array(
            'messsage' => 'Cập nhật số phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with('message', 'Cập nhật số phòng thành công')->with('alert-type', 'success');
    }

    public function HotelUpdateRoomNumber(Request $request, $id)
    {
        $user_id = Auth::id();
    
        $roomNumber = RoomNumber::where('id', $id)
            ->whereHas('room_type', function($query) use ($user_id) {
                $query->where('hotel_id', $user_id);
            })
            ->first();
    
        if (!$roomNumber) {
            return redirect()->back()->with('error', 'Không tìm thấy số phòng thuộc khách sạn này');
        }
    
        $roomNumber->room_no = $request->room_no;
        $roomNumber->status = $request->status;
        $roomNumber->save();
    
        return redirect()->route('hotel.room.type.list')
            ->with('message', 'Cập nhật số phòng thành công')
            ->with('alert-type', 'success');
    }    

    public function DeleteRoomNumber($id){
        RoomNumber::find($id)->delete();

        $notification = array(
            'message' => 'Xóa số phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with('message', 'Xóa số phòng thành công')->with('alert-type', 'success');
    }

    public function HotelDeleteRoomNumber($id){
        RoomNumber::find($id)->delete();

        $notification = array(
            'message' => 'Xóa số phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('hotel.room.type.list')->with('message', 'Xóa số phòng thành công')->with('alert-type', 'success');
    }

    public function DeleteRoom(Request $request, $id){
        $room = Room::find($id);

        RoomType::where('id', $room->roomtype_id)->delete();
        MultiImage::where('rooms_id', $room->id)->delete();
        Facility::where('rooms_id', $room->id)->delete();
        RoomNumber::where('rooms_id', $room->id)->delete();
        $room->delete();

        $notification = array(
            'messsage' => 'Xóa phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa phòng thành công')->with('alert-type', 'success');
    }

    public function HotelDeleteRoom(Request $request, $id){
        $user_id = Auth::id();
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
    
        if (!$room) {
            return redirect()->back()->with('error', 'Không tìm thấy phòng thuộc khách sạn này');
        }
    
        RoomType::where('id', $room->roomtype_id)->delete();
        MultiImage::where('rooms_id', $room->id)->delete();
        Facility::where('rooms_id', $room->id)->delete();
        RoomNumber::where('rooms_id', $room->id)->delete();
    
        $room->delete();
    
        $notification = array(
            'message' => 'Xóa phòng thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa phòng thành công')->with('alert-type', 'success');
    }
}
