<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\BlogCategory;

use Carbon\Carbon;
use App\Helper;
use App\Models\Gallery;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Validation\Rule;
use Image;
use Validator;
use Mail;


class BlogController extends Controller implements HasMiddleware
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'blog';

    public function  __construct()
    {
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }


    public function list(Request $request)
    {
        $page = $request->page;
        $rows = Blog::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data = array('rows' => $rows);
        return view($this->prefix . '.' . $this->folder . '.list')->with($data);
    }

    public function add()
    {
        $categories = BlogCategory::where('status', 1)->get();
        $data = array('categories' => $categories);
        return view($this->prefix . '.' . $this->folder . '.form')->with($data);
    }

    public function edit($id)
    {
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Blog::with('galleries')->find($id);
        if ($row == null) {
            return to_route('admin.blogs');
        }
        $categories = BlogCategory::where('status', 1)->get();
        $data = array('row' => $row, 'categories' => $categories);
        // dd($data);
        return view($this->prefix . '.' . $this->folder . '.form')->with($data);
    }

    public function postData(Request $request)
    {

        // dd($request->all());
        $id = trim($request->input('id'));
        $title = trim($request->input('title'));
        $slug = trim($request->input('slug'));
        $readTime = trim($request->input('read_time'));
        $blogCategoryId = trim($request->input('blog_category_id'));
        $shortDescription = trim($request->input('short_description'));
        $image = $request->file('image');
        $description = trim($request->input('description'));
        $seoTitle = trim($request->input('seo_title'));
        $seoDescription = trim($request->input('seo_description'));
        $seoKeywords = trim($request->input('seo_keywords'));
        $status = trim($request->input('status'));
        $images = $request->file('images');
        $imagesAlt = $request->input('images_alt');

        // dd($imagesAlt);

        //if(empty($id)){
        $validationArray = array(
            'title' => 'required',
            'read_time' => 'required|max:20',
            'short_description' => 'required',
            'description' => 'required',
            'blog_category_id' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keywords' => 'required',
            'status' => 'required'
        );

        $validationArray = [
            'image' => ($id ? 'nullable' : 'required') . '|mimes:jpeg,jpg,png,webp',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('blogs', 'slug')
                    ->ignore($id)
                    ->whereNull('deleted_at'),
            ],
        ];

        // if(empty($id)){
        //     $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
        //     //'images'=>'required|array',
        // }else{
        //     $validationArray['image']='mimes:jpeg,jpg,png,webp';
        //     $validationArray['slug'] = 'required|alpha_dash|unique:blogs,slug,'.$id;
        // }

        $request->validate($validationArray);


        DB::beginTransaction();
        //print $price; die;

        if (empty($id)) {
            $insertRow = ['title' => $title, 'blog_category_id' => $blogCategoryId, 'read_time' => $readTime, 'short_description' => $shortDescription, 'description' => $description, 'seo_title' => $seoTitle, 'seo_description' => $seoDescription, 'seo_keywords' => $seoKeywords, 'status' => $status];
            $blog = Blog::create($insertRow);
        } else {
            $blog = Blog::find($id);
            $blog->title = $title;
            $blog->slug = $slug;
            $blog->blog_category_id = $blogCategoryId;
            $blog->short_description = $shortDescription;
            $blog->description = $description;
            $blog->read_time = $readTime;
            $blog->seo_title = $seoTitle;
            $blog->seo_description = $seoDescription;
            $blog->seo_keywords = $seoKeywords;
            $blog->status = $status;
            $blog->save();
        }

        $operation = empty($id) ? 'add' : 'update';
        $altText = isset($imageAlt) && !empty($imageAlt) ? trim($imageAlt) : false;

        // add products images here start
        if (isset($image)) {
            // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
            Helper::uploadImage($image, $blog, 'blogs', true, $operation, 'image', true, true, true, false);
        }
        if (isset($images) && is_array($images) && count($images) > 0) {
            $gallery = new Gallery();
            Helper::uploadImages($images, $blog->galleries(), 'blogs/' . $blog->id . '/gallery/', false, $operation, 'image', false, $imagesAlt, true, false, false);
        }

        if ($blog) {
            DB::commit();
            Helper::flashMessage(true, 'Blog added/updated successfully!');
            return to_route('admin.blogs');
        } else {
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


    public function deleteBlogGallery($blog_id, $id)
    {
        // print $product_id;
        // print ' ';
        // print $id; die;

        $blog = Blog::find($blog_id);
        $image = $blog->galleries()->find($id);
        if ($image) {
            //print 'blogs/'.$image->blogs_id.'/gallery/'.$image->image_name; die;
            Storage::disk('public')->delete('blogs/' . $blog->id . '/gallery/' . $image->image);
            Storage::disk('public')->delete('blogs/' . $blog->id . '/gallery/thumb/' . $image->image);
            $image->delete();
            Helper::flashMessage(true, 'Blog Image deleted successfully!');
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = trim($request->id);
        $row = Blog::find($id);
        //print 'a'; die;
        if (!$row) {
            return to_route('admin.blogs');
        }

        $row->delete();

        if ($row) {
            Helper::flashMessage(true, 'Blog deleted successfully!');
            return to_route('admin.blogs');
        } else {
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }
}
