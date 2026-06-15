<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Rating;
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


class RatingController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'rating';

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
        $query = Rating::latest();
        if ($request->filled('product')) {
            $product = Product::where('slug', $request->product)->first();
            if ($product) {
                $query->where('product_id', $product->id);
            }
        }

        if ($request->filled('star')) {
            $query->where('rating', $request->star);
        }
        $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page); 
        $products = Product::get();
        $data=array('rows'=>$rows, 'products' => $products,);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){   
        $products = Product::get();
        $users = User::get();
        $data=array('products' => $products, 'users' => $users);     
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Rating::find($id);
        if($row == null){
            return to_route('admin.ratings');
        }
        $products = Product::get();
        $users = User::get();
        $data=array('row' => $row, 'products' => $products, 'users' => $users);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $product = trim($request->input('product'));
        $user = trim($request->input('user'));
        $name = trim($request->input('name'));
        $email = trim($request->input('email'));
        $rate = trim($request->input('rate'));
        $review = trim($request->input('review'));
        $isApproved = trim($request->input('is_approved'));
        $status = trim($request->input('status'));
 
        $validationArray=array(
            'product'=>'required',
            'name'=>'required',
            'rate'=>'required',
            'is_approved'=>'required',
            'status'=>'required',
        );
        
        $request->validate($validationArray);

        DB::beginTransaction();
        $user = $user !== '' ? $user : null;
        if(empty($id)){
            $rating = Rating::create([
                'product_id'=>$product, 
                'user_id'=>$user, 
                'name'=>$name, 
                'email'=>$email, 
                'rating'=>$rate, 
                'review'=>$review, 
                'is_approved'=>$isApproved, 
                'status'=>$status
            ]);
        }else{
            $rating = Rating::find($id);
            $rating->product_id = $product;
            $rating->user_id = $user ?? null;
            $rating->name = $name;
            $rating->email = $email;
            $rating->rating = $rate;
            $rating->review = $review;
            $rating->is_approved = $isApproved;
            $rating->status = $status;
            $rating->save();
        } 
        
        if($rating){
            DB::commit();
            Helper::flashMessage(true, 'Review updated successfully!');
            return to_route('admin.ratings');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Rating::find($id); 
        if(!$row){
            return to_route('admin.ratings');
        } 

        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Rating deleted successfully!');
            return to_route('admin.ratings');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
