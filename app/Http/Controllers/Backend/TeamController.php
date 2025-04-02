<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function AllTeam(){
        $team = Team::latest()->get();
        return view('backend.team.all_team', compact('team'));
    }

    public function AddTeam(){
        return view('backend.team.add_team');
    }

    public function StoreTeam(Request $request){
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550, 670)->save('upload/team/'.$name_gen);
        $save_url = 'upload/team/'.$name_gen;

        Team::insert([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'messsage' => 'Team Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.team')->with('message', 'Team Data Inserted Successfully')->with('alert-type', 'success');
    }

    public function EditTeam($id){
        $team = Team::findOrFail($id);
        return view('backend.team.edit_team', compact('team'));
    }

    public function UpdateTeam(Request $request){
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
                'messsage' => 'Team Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.team')->with('message', 'Team Updated With Image Successfully')->with('alert-type', 'success');
        } else {
            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'messsage' => 'Team Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.team')->with('message', 'Team Updated Without Image Successfully')->with('alert-type', 'success');
        }
    }

    public function DeleteTeam($id){
        $item = Team::findOrFail($id);
        $img = $item->image;
        unlink($img);

        Team::findOrFail($id)->delete();
        $notification = array(
            'messsage' => 'Team Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Team Image Deleted Successfully')->with('alert-type', 'success');
    }
}
