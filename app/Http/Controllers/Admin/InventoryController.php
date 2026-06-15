<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\User;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Image;
use Validator;
use Mail;


class InventoryController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'inventory';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function inventory(Request $request){
        $page = $request->page;
        $query = InventoryLog::with(['products' => function($subQuery){
            $subQuery->join('products','products.id','=','inventory_log_products.product_id');
        },
        'products.attribute.details' => function($subQuery){
                $subQuery->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_value')
                ->join('attributes','attributes.id','=', 'product_attribute_details.attribute_id')
                ->join('attribute_options','attribute_options.id','=', 'product_attribute_details.attribute_option_id');
        }])
        //->latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        ;
        $query->latest();
        

        if($request->ajax()){
            $slug = $request->key;
            $attribute = $request->attribute;
            $user = $request->user;
            $stock = $request->stock;
            $event = $request->event;

            //$startDate = new Carbon($request->startDate);
            //$endDate = new Carbon($request->endDate);

            $startDate = $request->filled('startDate') ? new Carbon($request->startDate) : null;
            $endDate = $request->filled('endDate') ? new Carbon($request->endDate) : null;
            if($endDate){
                $endDate = $endDate->endOfDay();
            }
            //print $startDate; die;
            //print $endDate; die;

            if($slug || $attribute){
                $product = Product::with(['attributes.details'=> function($subQuery){
                        $subQuery->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_value')
                        ->join('attributes','attributes.id','=', 'product_attribute_details.attribute_id')
                        ->join('attribute_options','attribute_options.id','=', 'product_attribute_details.attribute_option_id');
                }])->where('slug',$slug)->first();
            }

            $attributes = (isset($product) && $product->attributes) ? $product->attributes->toArray() : [];

            if($slug){
                $productID = $product->id;
                //print $productID; die;
                $query->whereHas('products', function($subQuery) use ($productID) {
                    $subQuery->where('inventory_log_products.product_id', $productID);
                });
            }

            if($attribute){
                //print $productID; die;
                $query->whereHas('products', function($subQuery) use ($attribute) {
                    $subQuery->where('inventory_log_products.product_attribute_id', $attribute);
                });
            }

            if($user){
                $query->where('user_id',$user);
            }
            
            if($stock){
                $query->where('type',$stock);
            }

            if($event){
                $query->where('event',$event);
            }

            if($startDate){
                //print $startDate; die;
                $query->whereDate('created_at', '>=', $startDate);
            }

            if($endDate){
                $query->whereDate('created_at', '<=', $endDate);
            }

            $rows = $query->get();
            //die;
            //print '<pre>'; print_r($rows->toArray()); die;
            
            return array('attributes' => $attributes,'html' => (String)View::make('admin.inventory.inventory-logs')->with(compact('rows')));
            //return view($this->prefix.'.'.$this->folder.'.list')->with($data);
        }

        $rows = $query->get();
        //print '<pre>'; print_r($rows->toArray()); die;

        $products = Product::get();
        $users = User::get();
        $attributes = [];
        $data=array('rows'=>$rows, 'products' => $products, 'attributes' => $attributes, 'users' => $users);
        return view($this->prefix.'.'.$this->folder.'.inventory')->with($data);
    }

    
    public function inventoryAdd(Request $request){ 
        
        if($request->ajax()){
            $slug = $request->key;
            $attribute = $request->attribute;

            //if($slug || $attribute){
                $product = Product::with(['attributes.details'=> function($subQuery){
                        $subQuery->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_value')
                        ->join('attributes','attributes.id','=', 'product_attribute_details.attribute_id')
                        ->join('attribute_options','attribute_options.id','=', 'product_attribute_details.attribute_option_id');
                }])->where('slug',$slug)->first();
            //}

            $attributes = (isset($product) && $product->attributes) ? $product->attributes->toArray() : [];

            if($attribute){
                //print $productID; die;
                $product->whereHas('attributes', function($subQuery) use ($attribute) {
                    $subQuery->where('product_attributes.product_attribute_id', $attribute);
                });
            }

            //$product = $query->get();

            
            return array('product' => $product,'attributes' => $attributes);
            //return view($this->prefix.'.'.$this->folder.'.list')->with($data);
        }

        
        $products = Product::get();
        
        $attributes = [];
        $data=array('attributes' => $attributes, 'products' => $products);
        return view($this->prefix.'.'.$this->folder.'.inventory-add')->with($data);


    }


    public function inventoryAddStock(Request $request){ 
        
        if($request->ajax()){
            $type = $request->type;
            $key = $request->key;
            $attribute = $request->attribute;
            $event = $request->event;
            $stock = $request->stock;
            $note = $request->note;
            $price = $request->price;

            $validationArray=array(
                'type'=>'required|in:product,attribute' ,
                'key'=>'required',
                'attribute'=>'numeric',
                'event'=>'required|in:added,remove',
                'stock'=>'required|numeric',
                'note'=>'',
                
            );
            
            $request->validate($validationArray);

            $query = Product::with('attributes')->where('slug',$key);
            

            //print $attribute; die;

            if($attribute){
                $query->with('attribute', function($subQuery) use ($attribute) {
                    $subQuery->where('id', $attribute);
                });
            }
            
            $product = $query->first();

            //print '<pre>'; print_r($product->attribute); die;

            if($type == 'product' && !$product){
                return array('result' => false, 'message' => 'Product does not exists');
            }

            if($type == 'attribute' && $product && !$product->attribute){
                return array('result' => false, 'message' => 'Product Attribute does not exists');
            }
            
            //print '<pre>'; print_r($product->attribute); die;


            $typeDB = ($event == 'added') ? 1 : 2;
            $remarks = ($event == 'added') ? 'Stock quantity added' : 'Stock quantity reduced';

            if($event == 'remove'){
                if($type == 'product' && ($product->stock < $stock)){
                    return array('result' => false, 'message' => 'Product quantity cannot be reduced beyond zero');
                }
                if($type == 'attribute' && ($product->attribute->stock < $stock)){
                    return array('result' => false, 'message' => 'Product quantity cannot be reduced beyond zero');
                }
            }

            $event = ($event == 'remove') ? 'reduced' : $event;

            $inventoryLog = InventoryLog::create(['event' => $event, 'type' => $typeDB, 'remarks' => $remarks, 'user_level' => 0, 'note' => $note ]);

            if($type == 'product'){
                
                $inventoryLog->products()->create(['product_id' => $product->id, 'quantity' => $stock, 'price' => $price]);
                
                if($event == 'added'){
                    $product->stock = $product->stock + $stock;
                }else{
                    $product->stock = $product->stock - $stock;
                }
                $product->save();

            }else if($type == 'attribute'){
                $inventoryLog->products()->create(['product_id' => $product->id, 'product_attribute_id' => $attribute, 'quantity' => $stock, 'price' => $price]);

                if($event == 'added'){
                    $product->attribute->stock = $product->attribute->stock + $stock;
                }else{
                    $product->attribute->stock = $product->attribute->stock - $stock;
                }
                $product->attribute->save();
            }
            

            // product
            // 'stock' => $stock, 

            if($inventoryLog){
                return array('result' => true, 'message' => 'Inventory updated Successfully');
            }else{
                return array('result' => false, 'message' => 'Something went wrong');
            }
            
        }

        $products = Product::get();
        $attributes = [];
        $data=array('attributes' => $attributes, 'products' => $products);
        return view($this->prefix.'.'.$this->folder.'.inventory-add')->with($data);

    }
    
}
