<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function EditRoom($id){
        $basic_facility = Facility::where('rooms_id', $id)->get();
        $multiimgs = MultiImage::where('rooms_id', $id)->get();
        $editData = Room::find($id);
        return view('backend.allroom.rooms.edit_rooms', compact('editData', 'basic_facility', 'multiimgs'));
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

        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 850)->save('upload/roomimg/'.$name_gen);
            $room['image'] = $name_gen;
        }
        $room->save();

        if($request->facility_name == NULL){

            $notification = array(
                'messsage' => 'Sorry! Not Any Basic Facility Select',
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
}
