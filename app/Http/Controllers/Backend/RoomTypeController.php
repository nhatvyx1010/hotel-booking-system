<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    public function RoomTypeList(){
        $allData = RoomType::orderBy('id', 'desc')->get();
        return view('backend.allroom.roomtype.view_roomtype', compact('allData'));
    }

    public function AddRoomType(){
        return view('backend.allroom.roomtype.add_roomtype');
    }

    public function RoomTypeStore(Request $request){
        RoomType::insert([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'messsage' => 'RoomType Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with('message', 'RoomType Inserted Successfully')->with('alert-type', 'success');
    }
}
