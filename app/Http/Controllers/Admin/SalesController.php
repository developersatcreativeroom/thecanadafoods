<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;

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


class SalesController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'sale';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }
    
    public function sales(Request $request){
        //print 'a'; die;

        // $page = $request->page;

        $year = date('Y');

        //$graph['January'] = Visit::where('card_id',$card->id)->whereYear('created_at', $year)->whereMonth('created_at', '01')->count();

        $array = [];
        $counter = 0;
        foreach(config('constants.MONTHS') as $monthKey => $month){
            //$array[$month] =  Order::whereYear('created_at', $year)->whereMonth('created_at', $key)->count();
            $orderObj = Order::whereYear('orders.created_at', $year)->whereMonth('orders.created_at', $monthKey)->with(['products', 'payments' => function($subQuery){
                //$subQuery->sum('amount');
                $subQuery->where('status',1);
            }]);
            

            
            $orders = $orderObj->get();
            $ordersCount = $orderObj->count();
            //print '<pre>'; print_r($orders->toArray());
            $array[$counter]['month'] =  $month;
            $array[$counter]['orders'] =  $ordersCount;
            //$array[$counter]['orders_list'] =  $orders;
            
            //$array[$counter]['payments'] =  $orders->payments;

            //$array[$counter]['total'] =  Helper::numberFormat($orders->payments->sum('amount'), 2);
            $amount = 0;
            foreach($orders as $order){
                //$array[$counter]['orders'] =  Payment::where('order')->get();
                $amount =  $order->payments->sum('amount');
            }

            //$array[$counter]['total'] =  Helper::numberFormat($order->payments->sum('amount'), 2);
            $array[$counter]['total1'] =  Helper::numberFormat($amount);

            $counter++;
        }
        //print '<pre>'; print_r($array); die;
        $data=array('array'=>$array);
        return view($this->prefix.'.'.$this->folder.'.sales')->with($data);


        // $rows = Order::select('orders.*')->with(['products'])->get();
        // print '<pre>'; print_r($rows); die;
        // foreach($rows as $key => $row){
        //     if($row->user_id == null){
        //         $order = Order::find($row->id);
        //         $rows[$key]->first_name = $order->first_name; 
        //         $rows[$key]->last_name = $order->last_name; 
        //         $rows[$key]->email = $order->email; 
        //         $rows[$key]->phone = $order->phone; 
        //     }
        // }
        // $data=array('rows'=>$rows);
        // return view($this->prefix.'.'.$this->folder.'.sales')->with($data);
        //return view($this->prefix.'.'.$this->folder.'.sales');
    }

    public function view($id){
        $row = Order::select('orders.*','users.first_name','users.last_name','users.email','users.country_code','users.phone')->leftjoin('users','users.id','=','orders.user_id')->with([
            'products', 'billing','shipping','history','payment' => function($query){
            $query->where('status',1);
        }])->find($id);
        if($row == null){
            return to_route('admin.orders');
        } 
        if($row->user_id == null){
            $order = Order::find($row->id);
            $row->first_name = $order->first_name; 
            $row->last_name = $order->last_name; 
            $row->email = $order->email; 
            $row->country_code = $order->country_code;
            $row->phone = $order->phone; 
        }
        //print '<pre>'; print_R($row); die;
        //print '<pre>'; print_R($row->toArray()); die;
        $data=array('row' => $row);

        return view($this->prefix.'.'.$this->folder.'.view')->with($data);
    }

    public function viewInvoice(Request $request,$id){
        $row = Order::select('orders.*','users.first_name','users.last_name','users.email','users.phone')->leftjoin('users','users.id','=','orders.user_id')->with([
            'products', 'billing','shipping','history','payment' => function($query){
            $query->where('status',1);
        }])->find($id);
        if($row == null){
            return to_route('admin.orders');
        } 
        if($row->user_id == null){
            $order = Order::find($row->id);
            $row->first_name = $order->first_name; 
            $row->last_name = $order->last_name; 
            $row->email = $order->email; 
            $row->phone = $order->phone; 
        }
        //$orderDetails = json_decode(json_encode($orderDetails),true);
        //$title="Invoice";
        //$numberWords =  convert_number_to_words($orderDetails['grand_total']);
        //print '<pre>'; print_R($row); die;
        $data=array('row' => $row);
        return view('admin.order.order-invoice')->with($data);
    }
    


    // public function add(){        
    //     $categories = Helper::getCategories();
    //     $taxes = Tax::get();
    //     $brands = Brand::get();
    //     $colors = Color::get();
    //     $attributes = Attribute::get();
    //     $data=array('categories'=>$categories, 'taxes'=>$taxes, 'brands'=>$brands, 'colors'=>$colors, 'attributes' => $attributes);
    //     return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    // }

    // public function edit($id){
    //     $categories = Helper::getCategories();  
    //     $taxes = Tax::get();
    //     $brands = Brand::get();
    //     $colors = Color::get();
    //     $attributes=Attribute::get();
        
    //     //print '<pre>'; print_r($attributes[0]['values']); die;
    //     //$product = Product::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
    //     $row = Product::with(
    //         //['attributes', 'attributes.details','categories]
    //         ['attributes.details' => function($query){
                
    //             $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_value')
    //             ->join('attributes','attributes.id','=', 'product_attribute_details.attribute_id')
    //             ->join('attribute_options','attribute_options.id','=', 'product_attribute_details.attribute_option_id');

    //         },
    //         'categories']
    //     )->find($id);
    //     if($row == null){
    //         return to_route('admin.products');
    //     } 

    //     //print '<pre>'; print_r($row); die;
    //     $selectedCategories = $row->categories;
    //     //print '<pre>'; print_r($selectedCategories); die;

    //     $categoriesProduct = [];
    //     foreach($selectedCategories as $selectedCategory){
    //         $categoriesProduct[] = $selectedCategory->category_id;
    //     }
    //     //print '<pre>'; print_r($categoriesProduct); die;

    //     $variants = [];
    //     foreach($row->attributes as $attribute){
    //         foreach($attribute->details as $detail){
    //             $variants[] = $detail->attribute_id;
    //         }
    //     }
        
    //     $variants = array_unique($variants);
    //     //print_r($variants); die;
        
    //     $data=array('categories'=>$categories, 'taxes'=>$taxes, 'brands'=>$brands, 'colors'=>$colors, 'attributes' => $attributes, 'row' => $row, 'categoriesProduct' => $categoriesProduct, 'variants' => $variants);
    //     return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    // }

    
}
