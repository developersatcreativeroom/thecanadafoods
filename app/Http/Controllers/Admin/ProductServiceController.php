<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\ProductService;
use App\Models\Product;
use App\Models\CartService;

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


class ProductServiceController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'productservice';

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
        $rows = ProductService::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        $products = Product::where('status',1)->get();
        $data=array('products'=>$products);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = ProductService::find($id);
        if($row == null){
            return to_route('admin.product.services');
        }
        $products = Product::where('status',1)->get();
        $data=array('row' => $row, 'products' => $products);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $slug = trim($request->input('slug'));
        $productID = trim($request->input('product_id'));
        $summary = trim($request->input('summary'));
        $image = $request->file('image');
        $description = trim($request->input('description'));
        $price = trim($request->input('price'));
        $oldPrice = trim($request->input('old_price'));
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'name'=>'required',
                'product_id'=>'required',
                'summary'=>'required',
                'description'=>'required',
                'price'=>'required',
                'old_price'=>'required|gt:price',
                'status'=>'required'
            );
            
            if(empty($id)){
                $validationArray['image']='required|mimes:jpeg,jpg,png,webp';
                //'images'=>'required|array',
            }else{
                $validationArray['image']='mimes:jpeg,jpg,png,webp';
                $validationArray['slug'] = 'required|alpha_dash|unique:product_services,slug,'.$id;
            }
            
            $request->validate($validationArray);


            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $productService = ProductService::create(['name'=>$name, 'product_id'=>$productID, 'summary'=>$summary, 'description'=>$description, 'price'=>$price, 'old_price'=>$oldPrice, 'status'=>$status]);
            }else{
                $productService = ProductService::find($id);
                $productService->name = $name;
                $productService->slug = $slug;
                $productService->product_id = $productID;
                $productService->summary = $summary;
                $productService->description = $description;
                $productService->price = $price;
                $productService->old_price = $oldPrice;
                $productService->status = $status;
                $productService->save();
            }

            $operation = empty($id) ? 'add' : 'update';

            // add products images here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $productService, 'product-services', true, $operation, 'image', true, true, true, $productService->id);
            }
           
            if($productService){
                DB::commit();
                Helper::flashMessage(true, 'Product Service added/updated successfully!');
                return to_route('admin.product.services');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = ProductService::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.product.services');
        }

        CartService::where('product_service_id',$id)->delete();
      
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Product Service deleted successfully!');
            return to_route('admin.product.services');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
