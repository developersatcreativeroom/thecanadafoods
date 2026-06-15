<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Gallery;

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


class GalleryController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'gallery';

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
        $rows = Gallery::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Gallery::find($id);
        if($row == null){
            return to_route('admin.gallery');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $image = $request->file('image');
        $isFeatured = trim($request->input('is_featured'));
        $title = trim($request->input('title'));
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'is_featured'=>'',
                'title'=>'',
                'status'=>'required'
            );

            if(empty($id)){
                $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
            }else{
                $validationArray['image']='mimes:jpeg,jpg,png,webp';
            }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            $isFeaturedDB = ($isFeatured == 'on') ? 1 : 0;

            if(empty($id)){
                $insertRow = ['is_featured'=>$isFeaturedDB, 'title'=>$title, 'status'=>$status];
                $gallery = Gallery::create($insertRow);
            }else{
                $gallery = Gallery::find($id);
                $gallery->is_featured = $isFeaturedDB;
                $gallery->title = $title;
                $gallery->status = $status;
                $gallery->save();
            }

            $operation = empty($id) ? 'add' : 'update';

            // add gallery images here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $gallery, 'gallery', true, $operation, 'image', true, true, true, false);
            }
           
            if($gallery){
                DB::commit();
                Helper::flashMessage(true, 'Gallery Image added/updated successfully!');
                return to_route('admin.gallery');
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
        $row = Gallery::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.gallery');
        }
        
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Gallery Image deleted successfully!');
            return to_route('admin.gallery');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
