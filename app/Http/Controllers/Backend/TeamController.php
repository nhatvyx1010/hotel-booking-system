<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function HotelAllTeam(){
        $user_id = Auth::id();
    
        $team = Team::where('hotel_id', $user_id)->latest()->get();
    
        return view('hotel.backend.team.all_team', compact('team'));
    }
    

    public function HotelAddTeam(){
        return view('hotel.backend.team.add_team');
    }

    public function HotelStoreTeam(Request $request){
        // Lấy ID người dùng đang đăng nhập
        $user_id = Auth::id();

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550, 670)->save('upload/team/'.$name_gen);
        $save_url = 'upload/team/'.$name_gen;

        Team::insert([
            'hotel_id' => $user_id,
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Team Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('hotel.all.team')->with('message', 'Team Data Inserted Successfully')->with('alert-type', 'success');
    }

    public function HotelEditTeam($id){
        $team = Team::findOrFail($id);
        return view('hotel.backend.team.edit_team', compact('team'));
    }

    public function HotelUpdateTeam(Request $request){
        $team_id = $request->id;

        if($request->file('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 670)->save('upload/team/'.$name_gen);
            $save_url = 'upload/team/'.$name_gen;
    
            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Team Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('hotel.all.team')->with('message', 'Team Updated With Image Successfully')->with('alert-type', 'success');
        } else {
            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Team Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('hotel.all.team')->with('message', 'Team Updated Without Image Successfully')->with('alert-type', 'success');
        }
    }

    public function HotelDeleteTeam($id){
        $item = Team::findOrFail($id);
        $img = $item->image;
        unlink($img);

        Team::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Team Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Team Image Deleted Successfully')->with('alert-type', 'success');
    }

    public function HotelBookArea()
    {
        $user_id = Auth::id();
        $book = BookArea::where('hotel_id', $user_id)->first();

        return view('hotel.backend.bookarea.book_area', compact('book'));
    }

    public function HotelBookAreaUpdate(Request $request)
    {
        $user_id = Auth::id();
        $book = BookArea::where('hotel_id', $user_id)->first();

        $data = [
            'hotel_id' => $user_id,
            'short_title' => $request->short_title,
            'main_title' => $request->main_title,
            'short_desc' => $request->short_desc,
            'link_url' => $request->link_url,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000, 1000)->save('upload/bookarea/' . $name_gen);
            $data['image'] = 'upload/bookarea/' . $name_gen;
        }

        if ($book) {
            $book->update($data);
            $message = $request->hasFile('image') ? 'Book Area Updated With Image Successfully' : 'Book Area Updated Without Image Successfully';
        } else {
            BookArea::create($data);
            $message = $request->hasFile('image') ? 'Book Area Created With Image Successfully' : 'Book Area Created Without Image Successfully';
        }

        return redirect()->back()->with('message', $message)->with('alert-type', 'success');
    }
}
