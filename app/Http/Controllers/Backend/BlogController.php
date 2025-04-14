<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\BlogPost;
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
            'message' => 'Blog Category Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Blog Category Added Successfully')->with('alert-type', 'success');
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
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Blog Category Updated Successfully')->with('alert-type', 'success');
    }

    public function DeleteBlogCategory($id){
        BlogCategory::find($id)->delete();
        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Blog Category Deleted Successfully')->with('alert-type', 'success');
    }

    public function AllBlogPost(){
        $post = BlogPost::latest()->get();
        return view('backend.post.all_post', compact('post'));
    }

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();
        return view('backend.post.add_post', compact('blogcat'));
    }

    public function StoreBlogPost(Request $request){
        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
        $save_url = 'upload/post/'.$name_gen;

        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'messsage' => 'BlogPost Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.post')->with('message', 'BlogPost Data Inserted Successfully')->with('alert-type', 'success');
    }

    public function EditBlogPost($id){
        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);
        return view('backend.post.edit_post', compact('blogcat', 'post'));
    }

    public function UpdateBlogPost(Request $request){
        $post_id = $request->id;

        if($request->file('post_image')){
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550, 370)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;
    
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'messsage' => 'BlogPost Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog.post')->with('message', 'BlogPost Updated With Image Successfully')->with('alert-type', 'success');
        } else {
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'messsage' => 'BlogPost Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog.post')->with('message', 'BlogPost Updated Without Image Successfully')->with('alert-type', 'success');
        }
    }

    public function DeleteBlogPost($id){
        $item = BlogPost::findOrFail($id);
        $img = $item->post_image;
        unlink($img);

        BlogPost::findOrFail($id)->delete();
        $notification = array(
            'messsage' => 'BlogPost Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'BlogPost Image Deleted Successfully')->with('alert-type', 'success');
    }
}
