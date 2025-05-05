<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomNumber;
use App\Models\RoomType;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('hotel.dashboard')->with('error', 'Room not found for this hotel');
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

        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 850)->save('upload/roomimg/'.$name_gen);
            $room['image'] = $name_gen;
        }
        $room->save();

        if($request->facility_name == NULL){

            $notification = array(
                'message' => 'Sorry! Not Any Basic Facility Select',
                'alert-type' => 'error'
            );
            return redirect()->back()->with('message', 'Sorry! Not Any Basic Item Select')->with('alert-type', 'error');
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

        if($room->save()){
            $files = $request->multi_img;
            if(!empty($files)){
                $subimage = MultiImage::where('rooms_id', $id)->get()->toArray();
                MultiImage::where('rooms_id', $id)->delete();
            }
            if(!empty($files)){
                foreach($files as $file){
                    $imgName = date('YmdHi').$file->getClientOriginalName();
                    $file->move('upload/roomimg/multi_img/', $imgName);
                    $subimage['multi_img'] = $imgName;

                    $subimage = new MultiImage();
                    $subimage->rooms_id = $room->id;
                    $subimage->multi_img = $imgName;
                    $subimage->save();
                }
            }
        }

        $notification = array(
            'messsage' => 'Room Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Updated Successfully')->with('alert-type', 'success');
    }

    public function HotelUpdateRoom(Request $request, $id){
        $user_id = Auth::id();
    
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
    
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found for this hotel');
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
    
        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 850)->save('upload/roomimg/'.$name_gen);
            $room['image'] = $name_gen;
        }
        $room->save();
    
        if($request->facility_name == NULL){
            return redirect()->back()->with('message', 'Sorry! Not Any Basic Item Select')->with('alert-type', 'error');
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
            $subimage = MultiImage::where('rooms_id', $id)->get()->toArray();
            MultiImage::where('rooms_id', $id)->delete();
    
            foreach($files as $file){
                $imgName = date('YmdHi').$file->getClientOriginalName();
                $file->move('upload/roomimg/multi_img/', $imgName);
    
                $user_id = Auth::id();
                $multiImage = new MultiImage();
                $multiImage->rooms_id = $room->id;
                $multiImage->multi_img = $imgName;
                $multiImage->hotel_id = $user_id;
                $multiImage->save();
            }
        }
    
        $notification = array(
            'message' => 'Room Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Updated Successfully')->with('alert-type', 'success');
    }    

    public function MultiImageDelete($id){
        $deletedata = MultiImage::where('id', $id)->first();

        if($deletedata){
            $imagePath = $deletedata->multi_img;
            if(file_exists($imagePath)){
                unlink($imagePath);
                echo "Image Unlinked Successfully";
            }else{
                echo "Image does not exist";
            }

            MultiImage::where('id', $id)->delete();
        }
        $notification = array(
            'messsage' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Multi Image Deleted Successfully')->with('alert-type', 'success');
    }

    public function HotelMultiImageDelete($id){
        $user_id = Auth::id();
    
        $deletedata = MultiImage::where('id', $id)->whereHas('room', function($query) use ($user_id) {
            $query->where('hotel_id', $user_id);
        })->first();
    
        if ($deletedata) {
            $imagePath = $deletedata->multi_img;
            if(file_exists($imagePath)){
                unlink($imagePath);
                echo "Image Unlinked Successfully";
            } else {
                echo "Image does not exist";
            }
            MultiImage::where('id', $id)->delete();
    
            $notification = array(
                'message' => 'Multi Image Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with('message', 'Multi Image Deleted Successfully')->with('alert-type', 'success');
        } else {
            return redirect()->back()->with('error', 'Image not found for this hotel');
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
            'messsage' => 'Room Number Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Number Added Successfully')->with('alert-type', 'success');
    }

    public function HotelStoreRoomNumber(Request $request, $id){
        $user_id = Auth::id();
    
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found for this hotel');
        }
    
        $data = new RoomNumber();
        $data->hotel_id = $user_id;
        $data->rooms_id = $id;
        $data->room_type_id = $request->room_type_id;
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();
    
        $notification = array(
            'message' => 'Room Number Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Number Added Successfully')->with('alert-type', 'success');
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
            'messsage' => 'Room Number Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with('message', 'Room Number Updated Successfully')->with('alert-type', 'success');
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
            return redirect()->back()->with('error', 'Room Number not found for this hotel');
        }
    
        $roomNumber->room_no = $request->room_no;
        $roomNumber->status = $request->status;
        $roomNumber->save();
    
        return redirect()->route('hotel.room.type.list')
            ->with('message', 'Room Number Updated Successfully')
            ->with('alert-type', 'success');
    }    

    public function DeleteRoomNumber($id){
        RoomNumber::find($id)->delete();

        $notification = array(
            'messsage' => 'Room Number Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with('message', 'Room Number Deleted Successfully')->with('alert-type', 'success');
    }

    public function HotelDeleteRoomNumber($id){
        RoomNumber::find($id)->delete();

        $notification = array(
            'messsage' => 'Room Number Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('hotel.room.type.list')->with('message', 'Room Number Deleted Successfully')->with('alert-type', 'success');
    }

    public function DeleteRoom(Request $request, $id){
        $room = Room::find($id);

        if(file_exists('upload/roomimg/'.$room->image) AND ! empty($room->image)){
            @unlink('upload/roomimg/'.$room->image);
        }

        $subimage = MultiImage::where('rooms_id', $room->id)->get()->toArray();
        if(!empty($subimage)){
            foreach($subimage as $value){
                if(!empty($value)){
                    @unlink('upload/roomimg/multi_img/'.$value['multi_img']);
                }
            }
        }
        RoomType::where('id', $room->roomtype_id)->delete();
        MultiImage::where('rooms_id', $room->id)->delete();
        Facility::where('rooms_id', $room->id)->delete();
        RoomNumber::where('rooms_id', $room->id)->delete();
        $room->delete();

        $notification = array(
            'messsage' => 'Room Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Deleted Successfully')->with('alert-type', 'success');
    }

    public function HotelDeleteRoom(Request $request, $id){
        $user_id = Auth::id();
        $room = Room::where('id', $id)->where('hotel_id', $user_id)->first();
    
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found for this hotel');
        }
    
        if(file_exists('upload/roomimg/'.$room->image) AND ! empty($room->image)){
            @unlink('upload/roomimg/'.$room->image);
        }
    
        $subimage = MultiImage::where('rooms_id', $room->id)->get()->toArray();
        if(!empty($subimage)){
            foreach($subimage as $value){
                if(!empty($value)){
                    @unlink('upload/roomimg/multi_img/'.$value['multi_img']);
                }
            }
        }
    
        RoomType::where('id', $room->roomtype_id)->delete();
        MultiImage::where('rooms_id', $room->id)->delete();
        Facility::where('rooms_id', $room->id)->delete();
        RoomNumber::where('rooms_id', $room->id)->delete();
    
        $room->delete();
    
        $notification = array(
            'message' => 'Room Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Room Deleted Successfully')->with('alert-type', 'success');
    }
}
