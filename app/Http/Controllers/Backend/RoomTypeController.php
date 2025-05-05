<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class RoomTypeController extends Controller
{
    public function RoomTypeList(){

        $allData = RoomType::orderBy('id','desc')->get();
        return view('backend.allroom.roomtype.view_roomtype',compact('allData'));

    }

    public function HotelRoomTypeList() {
        $user_id = Auth::id();
        $allData = RoomType::where('hotel_id', $user_id)
                           ->orderBy('id', 'desc')
                           ->get();
        return view('hotel.backend.allroom.roomtype.view_roomtype', compact('allData'));
    }

    public function AddRoomType(){
        return view('backend.allroom.roomtype.add_roomtype');
    }

    public function HotelAddRoomType(){
        return view('hotel.backend.allroom.roomtype.add_roomtype');
    }

    public function RoomTypeStore(Request $request){

        $roomtype_id =  RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        Room::insert([
            'roomtype_id' => $roomtype_id,
        ]);

        $notification = array(
            'message' => 'RoomType Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }

    public function HotelRoomTypeStore(Request $request) {
        $user_id = Auth::id();
        $roomtype_id = RoomType::insertGetId([
            'name' => $request->name,
            'hotel_id' => $user_id,
            'created_at' => Carbon::now(),
        ]);

        Room::insert([
            'roomtype_id' => $roomtype_id,
            'hotel_id' => $user_id,
        ]);

        $notification = [
            'message' => 'RoomType Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('hotel.room.type.list')->with($notification);
    }
}
 