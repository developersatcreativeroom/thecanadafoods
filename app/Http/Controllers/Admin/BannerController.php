<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Banner;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Image;
use Validator;
use Mail;


class BannerController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'banner';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function list(Request $request){ 
        $page = $request->page;
        $rows = Banner::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        $categories = Helper::getCategories();
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Banner::find($id);
        if($row == null){
            return to_route('admin.banners');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $topTitle = $request->filled('top_title') ? trim($request->input('top_title')) : null;
        $title = $request->filled('title') ? trim($request->input('title')) : null;
        $subTitle = $request->filled('sub_title') ? trim($request->input('sub_title')) : null;
        $image = $request->file('image');
        $description = $request->filled('description') ? trim($request->input('description')) : null;
        $buttonName = $request->filled('button_name') ? trim($request->input('button_name')) : null;
        $buttonLink = $request->filled('button_link') ? trim($request->input('button_link')) : null;
        $serial = $request->filled('serial') ? trim($request->input('serial')) : null;
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'top_title'=>'required',
                'title'=>'required',
                'sub_title'=>'required',
                'description'=>'required',
                'button_name'=>'',
                'button_link'=>'',
                'serial'=>'',
                'status'=>'required'
            );

            if(empty($id)){
                $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
                //'images'=>'required|array',
            }else{
                $validationArray['image']='mimes:jpeg,jpg,png,webp';
            }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['top_title'=>$topTitle, 'title'=>$title, 'sub_title'=>$subTitle, 'description'=>$description, 'button_name'=>$buttonName, 'button_link'=>$buttonLink, 'serial'=>$serial, 'status'=>$status];
                $banner = Banner::create($insertRow);
            }else{
                $banner = Banner::find($id);
                $banner->top_title = $topTitle;
                $banner->title = $title;
                $banner->sub_title = $subTitle;
                $banner->description = $description;
                $banner->button_name = $buttonName;
                $banner->button_link = $buttonLink;
                $banner->serial = $serial;
                $banner->status = $status;
                $banner->save();
            }

            $operation = empty($id) ? 'add' : 'update';

            // add banner images here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $banner, 'banners', true, $operation, 'image', true, false, true, false);
            }
           
            if($banner){
                DB::commit();
                Helper::flashMessage(true, 'Banner added/updated successfully!');
                return to_route('admin.banners');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        // $validationArray=array(
        //     'id'=>'required'
        // );
        // $request->validate($validationArray);
        $row = Banner::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.banners');
        }
        
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Banner deleted successfully!');
            return to_route('admin.banners');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
