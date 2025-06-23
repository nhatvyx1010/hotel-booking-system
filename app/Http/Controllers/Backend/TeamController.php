<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\BookArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TeamController extends Controller
{
    public function HotelAllTeam()
    {
        $user_id = Auth::id();
        $team = Team::where('hotel_id', $user_id)->latest()->get();
        return view('hotel.backend.team.all_team', compact('team'));
    }

    public function HotelAddTeam()
    {
        return view('hotel.backend.team.add_team');
    }

    public function HotelStoreTeam(Request $request)
    {
        $user_id = Auth::id();
        $imageUrl = null;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'team',
                'transformation' => [
                    'width' => 550,
                    'height' => 670,
                    'crop' => 'fit',
                ],
            ]);
            $imageUrl = $uploadResult->getSecurePath();
        }

        Team::create([
            'hotel_id' => $user_id,
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $imageUrl,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('hotel.all.team')
            ->with('message', 'Dữ liệu Team đã được thêm thành công')
            ->with('alert-type', 'success');
    }

    public function HotelEditTeam($id)
    {
        $team = Team::findOrFail($id);
        return view('hotel.backend.team.edit_team', compact('team'));
    }

    public function HotelUpdateTeam(Request $request)
    {
        $team = Team::findOrFail($request->id);
        $imageUrl = $team->image;

        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'team',
                'transformation' => [
                    'width' => 550,
                    'height' => 670,
                    'crop' => 'fit',
                ],
            ]);
            $imageUrl = $uploadResult->getSecurePath();
        }

        $team->update([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $imageUrl,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('hotel.all.team')
            ->with('message', 'Cập nhật Team thành công')
            ->with('alert-type', 'success');
    }

    public function HotelDeleteTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->back()
            ->with('message', 'Xóa Team thành công')
            ->with('alert-type', 'success');
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
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'bookarea',
                'transformation' => [
                    'width' => 1000,
                    'height' => 1000,
                    'crop' => 'fit',
                ],
            ]);
            $data['image'] = $uploadResult->getSecurePath();
        }

        if ($book) {
            $book->update($data);
            $message = $request->hasFile('image') ? 'Book Area cập nhật có ảnh thành công' : 'Book Area cập nhật không ảnh thành công';
        } else {
            BookArea::create($data);
            $message = $request->hasFile('image') ? 'Book Area tạo có ảnh thành công' : 'Book Area tạo không ảnh thành công';
        }

        return redirect()->back()->with('message', $message)->with('alert-type', 'success');
    }
}
