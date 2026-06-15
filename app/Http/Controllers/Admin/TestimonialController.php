<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Testimonial;

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
use View;


class TestimonialController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'testimonial';

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
        $rows = Testimonial::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
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
        $row = Testimonial::find($id);
        if($row == null){
            return to_route('admin.testimonials');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $designation = trim($request->input('designation'));
        $image = $request->file('image');
        $rating = trim($request->input('rating'));
        $description = trim($request->input('description'));
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'name'=>'required',
                'designation'=>'',
                'image'=>'mimes:jpeg,jpg,png,webp',
                'rating'=>'required|numeric|min:1|max:5',
                'description'=>'required',
                'status'=>'required'
            );

            // if(empty($id)){
            //     $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
            // }else{
            //     $validationArray['image']='mimes:jpeg,jpg,png,webp';
            // }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'designation'=>$designation, 'rating'=>$rating, 'description'=>$description, 'status'=>$status];
                $testimonial = Testimonial::create($insertRow);
            }else{
                $testimonial = Testimonial::find($id);
                $testimonial->name = $name;
                $testimonial->designation = $designation;
                $testimonial->rating = $rating;
                $testimonial->description = $description;
                $testimonial->status = $status;
                $testimonial->save();
            }

            $operation = empty($id) ? 'add' : 'update';

            // add testimonial images here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $testimonial, 'testimonials', true, $operation, 'image', true, false, true, false);
            }
           
            if($testimonial){
                DB::commit();
                Helper::flashMessage(true, 'Testimonial added/updated successfully!');
                return to_route('admin.testimonials');
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
        $row = Testimonial::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.testimonials');
        }
        
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Testimonial deleted successfully!');
            return to_route('admin.testimonials');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

    public function filter(Request $request){ 
        $page = $request->page;
        $search = $request->search;
        $clear = $request->clear;

        $query = Testimonial::latest();
       
        if($search){

            $query->where( function ($subQuery) use ($search) {
                $subQuery->where('name','like','%'.$search.'%');
                $subQuery->orWhere('designation','like','%'.$search.'%');
                $subQuery->orWhere('rating','like','%'.$search.'%');
                $subQuery->orWhere('description','like','%'.$search.'%');
            });
        }

        if($clear == 'true'){
            $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page);
        }else{
            $rows = $query->get();
        }
        //print '<pre>'; print_r($rows->toArray()); die;
        return array('html' => (String)View::make($this->prefix.'.'.$this->folder.'.rows')->with(compact('rows')));
    }

}
