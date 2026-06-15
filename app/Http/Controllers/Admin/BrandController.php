<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Product;

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


class BrandController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'brand';

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
        $rows = Brand::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
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
        $row = Brand::find($id);
        if($row == null){
            return to_route('admin.brands');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $slug = trim($request->input('slug'));
        $image = $request->file('image');
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                //'name'=>'required',
                'status'=>'required'
            );

            if(empty($id)){
                $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
                $validationArray['name'] = 'required|unique:brands,name,';
            }else{
                $validationArray['image']='mimes:jpeg,jpg,png,webp';
                $validationArray['name'] = 'required|unique:brands,name,'.$id;
                $validationArray['slug'] = 'required|alpha_dash|unique:brands,slug,'.$id;
            }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'status'=>$status];
                $brand = Brand::create($insertRow);
            }else{
                $brand = Brand::find($id);
                $brand->name = $name;
                $brand->slug = $slug;
                $brand->status = $status;
                $brand->save();
            }

            $operation = empty($id) ? 'add' : 'update';
            
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $brand, 'brands', true, $operation, 'image', true, true, true, false);
            }
           
            if($brand){
                DB::commit();
                Helper::flashMessage(true, 'Brand added/updated successfully!');
                return to_route('admin.brands');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Brand::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.brands');
        }

        $productCount = Product::where('brand_id',$row->id)->count();
        if($productCount > 0){
            Helper::flashMessage(false, 'Product(s) added to the brand, please remove product from the brand first');
            return redirect()->back();
        }
        if(isset($row->image)){
            // model, directory, is_thumb
            Helper::deleteImage($row, 'brands');
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Brand deleted successfully!');
            return to_route('admin.brands');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
