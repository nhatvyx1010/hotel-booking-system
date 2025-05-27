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
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;
        } else {
            $save_url = 'upload/post/default.jpg';
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
    
        // Kiểm tra xem có file ảnh không
        if($request->file('post_image')){
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;
    
            // Cập nhật bài viết với ảnh mới và hotel_id (nếu có)
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
                'hotel_id' => $request->hotel_id ? $request->hotel_id : null, // Nếu có hotel_id thì lưu, không thì null
            ]);
    
            $notification = array(
                'message' => 'Cập nhật bài viết blog thành công (có ảnh)',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog.post')->with('message', 'Cập nhật bài viết blog thành công (có ảnh)')->with('alert-type', 'success');
        } else {
            // Cập nhật bài viết mà không thay đổi ảnh và hotel_id (nếu có)
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'created_at' => Carbon::now(),
                'hotel_id' => $request->hotel_id ? $request->hotel_id : null, // Nếu có hotel_id thì lưu, không thì null
            ]);
    
            $notification = array(
                'message' => 'Cập nhật bài viết blog thành công (không có ảnh)',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog.post')->with('message', 'Cập nhật bài viết blog thành công (không có ảnh)')->with('alert-type', 'success');
        }
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
