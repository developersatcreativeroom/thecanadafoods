<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Tax;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;

use Carbon\Carbon;
use App\Helper;
use App\Models\User;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Image;
use Validator;
use Mail;


class CouponController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'coupon';

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
        $rows = Coupon::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $currency = Helper::getCurrency();
        $data=array('rows'=>$rows, 'currency' => $currency);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        
        $products = Product::where('status',1)->get();
        $users = User::all();
        $data=array('products'=>$products, 'users'=>$users);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        
        $row = Coupon::find($id);
        $products = Product::where('status',1)->get();        
        $users = User::all();
        $data=array('row' => $row, 'products' => $products, 'users'=>$users);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $code = trim($request->input('code'));
        $type = trim($request->input('type'));
        $noOfTimes = trim($request->input('no_of_times'));
        $amountType = trim($request->input('amount_type'));
        $amountValue = trim($request->input('amount_value'));
        $products = $request->input('products');
        $minProductQuantity = $request->filled('min_product_quantity') ? trim($request->input('min_product_quantity')) : null;
        $minPrice = $request->filled('min_price') ? trim($request->input('min_price')) : null;
        $validFrom = $request->filled('valid_from') ? trim($request->input('valid_from')) : null;
        $validTo = $request->filled('valid_to') ? trim($request->input('valid_to')) : null;
        $image = $request->file('image');
        $status = trim($request->input('status'));
        //print $id; die;

        //print '<pre>'; print_r($products); die;

        //if(empty($id)){
            $validationArray=array(
                'code'=>'required',
                'type'=>'required|in:single,multiple',
                'no_of_times' => 'required_if:type,multiple',
                'amount_type'=>'required|in:percentage,numeric',
                'amount_value'=>'required',
                'products'=>'array',
                'min_product_quantity'=>'',
                'min_price'=>'',
                'valid_from'=>'',
                'valid_to'=>'',
                'status'=>'required',
                
            );

            if(empty($id)){
                $validationArray['code'] = 'required|unique:coupons,code';
            }else{
                $validationArray['code'] = 'required|unique:coupons,code,'.$id;
            }
            
            
            $request->validate($validationArray);


            DB::beginTransaction();

            //print $price; die;

            $productsDB = is_array($products) ? json_encode($products) : null;
            
            $noOfTimesDB = $noOfTimes ? $noOfTimes : null;

            // if($noOfTimesDB == null){
            //     print 'a';
            // }else{
            //     print 'b';
            // }
            // die;
            //print $noOfTimes; die;


            if(empty($id)){
                $insertRow = ['code'=>$code, 'type'=>$type, 'no_of_times'=>$noOfTimesDB, 'amount_type'=>$amountType, 'amount_value'=>$amountValue, 'applicable_on_products'=>$productsDB, 'min_product_quantity'=>$minProductQuantity, 'min_price'=>$minPrice, 'valid_from'=>$validFrom, 'valid_to'=>$validTo, 'status'=>$status];
                $coupon = Coupon::create($insertRow);
            }else{
                $coupon = Coupon::find($id);

                $coupon->code = $code;
                $coupon->type = $type;
                $coupon->no_of_times = $noOfTimesDB;
                $coupon->amount_type = $amountType;
                $coupon->amount_value = $amountValue;
                $coupon->applicable_on_products = $productsDB;
                $coupon->min_product_quantity = $minProductQuantity;
                $coupon->min_price = $minPrice;
                $coupon->valid_from = $validFrom;
                $coupon->valid_to = $validTo;
                $coupon->status = $status;
                $coupon->save();
            }
            
            $operation = empty($id) ? 'add' : 'update';
            // add image here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $coupon, 'coupons', true, $operation, 'image', true, true, true, false);
            }
            // add image here ends

            if($coupon){
                if ($request->has('users')) {
                    $coupon->ForUsers()->sync($request->input('users'));
                }
                DB::commit();
                Helper::flashMessage(true, 'Coupon added/updated successfully!');
                return to_route('admin.coupons');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Coupon::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.coupons');
        }
        // if(isset($row->image)){
        //     // model, directory, is_thumb
        //     Helper::deleteImage($row, 'coupons');
        // }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Coupon deleted successfully!');
            return to_route('admin.coupons');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


}
