<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function BlogCategory(){
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category', compact('category'));
    }

    public function StoreBlogCategory(Request $request){
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Thêm danh mục blog thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Thêm danh mục blog thành công')->with('alert-type', 'success');
    }

    public function EditBlogCategory($id){
        $categories = BlogCategory::find($id);
        return response()->json($categories);
    }

    public function UpdateBlogCategory(Request $request){
        $cat_id = $request->cat_id;
        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Cập nhật danh mục blog thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Cập nhật danh mục blog thành công')->with('alert-type', 'success');
    }

    public function DeleteBlogCategory($id){
        BlogCategory::find($id)->delete();
        $notification = array(
            'message' => 'Xóa danh mục blog thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa danh mục blog thành công')->with('alert-type', 'success');
    }

    public function AllBlogPost(){
        $post = BlogPost::with(['blog', 'hotel'])->latest()->get();
        return view('backend.post.all_post', compact('post'));
    }

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();
        $hotels = User::where('role', 'hotel')->latest()->get();
        
        return view('backend.post.add_post', compact('blogcat', 'hotels'));
    }

    public function StoreBlogPost(Request $request){

        $request->validate([
            'post_title' => 'required',
            'post_slug' => 'required|unique:blog_posts,post_slug',
            'post_image' => 'nullable|image',
            'audio_file' => 'nullable|mimes:mp3,wav,m4a',
        ]);

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;
        } else {
            $save_url = 'upload/post/default.jpg';
        }

        $audio_save_url = null;
        if ($request->hasFile('audio_file')) {
            $audio = $request->file('audio_file');
            $audio_name = hexdec(uniqid()) . '.' . $audio->getClientOriginalExtension();
            $audio->move('upload/blog_audio/', $audio_name);
            $audio_save_url = 'upload/blog_audio/' . $audio_name;
        }

        $blogPostData = [
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ];

        if ($audio_save_url) {
            $blogPostData['audio_file'] = $audio_save_url;
        }    

        if ($request->has('hotel_id')) {
            $blogPostData['hotel_id'] = $request->hotel_id;
        }

        BlogPost::insert($blogPostData);

        $notification = array(
            'message' => 'Thêm bài viết blog thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.post')->with('message', 'Thêm bài viết blog thành công')->with('alert-type', 'success');
    }

    public function EditBlogPost($id){
        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);
        $hotels = User::where('role', 'hotel')->latest()->get();
        return view('backend.post.edit_post', compact('blogcat', 'post', 'hotels'));
    }

    public function UpdateBlogPost(Request $request){
        $post_id = $request->id;

        // Tìm bài viết
        $blogPost = BlogPost::findOrFail($post_id);

        // Xử lý ảnh nếu có upload mới
        if($request->file('post_image')){
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;

            // Xóa ảnh cũ nếu có
            if($blogPost->post_image && file_exists(public_path($blogPost->post_image))){
                unlink(public_path($blogPost->post_image));
            }

            $blogPost->post_image = $save_url;
        }

        // Xử lý audio
        // Nếu có yêu cầu xóa audio (checkbox remove_audio)
        if($request->has('remove_audio') && $request->remove_audio == 1){
            if($blogPost->audio_file && file_exists(public_path($blogPost->audio_file))){
                unlink(public_path($blogPost->audio_file));
            }
            $blogPost->audio_file = null;
        }

        // Nếu upload file audio mới
        if($request->file('audio_file')){
            // Xóa audio cũ nếu có
            if($blogPost->audio_file && file_exists(public_path($blogPost->audio_file))){
                unlink(public_path($blogPost->audio_file));
            }
            $audio = $request->file('audio_file');
            $audio_name = hexdec(uniqid()) . '.' . $audio->getClientOriginalExtension();
            $audio->move('upload/blog_audio/', $audio_name);
            $blogPost->audio_file = 'upload/blog_audio/' . $audio_name;
        }

        // Cập nhật các trường còn lại
        $blogPost->blogcat_id = $request->blogcat_id;
        $blogPost->user_id = Auth::user()->id;
        $blogPost->post_title = $request->post_title;
        $blogPost->post_slug = strtolower(str_replace(' ','-',$request->post_title));
        $blogPost->short_desc = $request->short_desc;
        $blogPost->long_desc = $request->long_desc;
        $blogPost->hotel_id = $request->hotel_id ? $request->hotel_id : null;
        $blogPost->created_at = Carbon::now();

        $blogPost->save();

        $notification = array(
            'message' => 'Cập nhật bài viết blog thành công',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.post')->with($notification);
    }

    public function DeleteBlogPost($id){
        $item = BlogPost::findOrFail($id);
        $img = $item->post_image;
        unlink($img);

        BlogPost::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Xóa bài viết blog thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Xóa bài viết blog thành công')->with('alert-type', 'success');
    }

    public function BlogDetails($slug){
        $blog = BlogPost::where('post_slug', $slug)->first();
        $bcategory = BlogCategory::latest()->get();
        $lpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_details', compact('blog', 'bcategory', 'lpost'));
    }

    public function BlogCatList($id){
        $blog = BlogPost::where('blogcat_id', $id)->get();
        $namecat = BlogCategory::where('id', $id)->first();
        $bcategory = BlogCategory::latest()->get();
        $lpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_cat_list', compact('blog', 'bcategory', 'lpost', 'namecat'));
    }

    public function BlogList(){
        $blog = BlogPost::latest()->paginate(3);
        $bcategory = BlogCategory::latest()->get();
        $lpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_all', compact('blog', 'bcategory', 'lpost'));
    }
}
