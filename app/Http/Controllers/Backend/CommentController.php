<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function StoreComment(Request $request){
        Comment::insert([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Bình luận đã được thêm, quản trị viên sẽ duyệt',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Bình luận đã được thêm, quản trị viên sẽ duyệt')->with('alert-type', 'success');
    }

    public function AllComment(){
        $allcomment = Comment::with(['user', 'post'])->latest()->get();
        return view('backend.comment.all_comment', compact('allcomment'));
    }

    public function UpdateCommentStatus(Request $request){
        $commentId = $request->input('comment_id');
        $isChecked = $request->input('is_checked', 0);
        $comment = Comment::find($commentId);
        if($comment){
            $comment->status = $isChecked;
            $comment->save();
        }

        return response()->json(['message' => 'Cập nhật trạng thái bình luận thành công']);
    }
}
