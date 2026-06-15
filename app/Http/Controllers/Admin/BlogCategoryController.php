<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\BlogCategory;

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


class BlogCategoryController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'blogcategory';

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
        $rows = BlogCategory::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
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
        $row = BlogCategory::find($id);
        if($row == null){
            return to_route('admin.blog.categories');
        }
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $slug = trim($request->input('slug'));
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'name'=>'required',
                'status'=>'required'
            );

            if(empty($id)){
                
            }else{
                $validationArray['slug'] = 'required|alpha_dash|unique:blog_categories,slug,'.$id;
            }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'status'=>$status];
                $category = BlogCategory::create($insertRow);
            }else{
                $category = BlogCategory::find($id);
                $category->name = $name;
                $category->slug = $slug;
                $category->status = $status;
                $category->save();
            }

            $operation = empty($id) ? 'add' : 'update';
           
            if($category){
                DB::commit();
                Helper::flashMessage(true, 'Blog category added/updated successfully!');
                return to_route('admin.blog.categories');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = BlogCategory::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.blog.categories');
        }
      
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Blog Category deleted successfully!');
            return to_route('admin.blog.categories');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
