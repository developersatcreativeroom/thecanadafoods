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
use PDF;


class OrderController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'order';

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
        $rows = Order::select('orders.*','users.first_name','users.last_name')->leftjoin('users','users.id','=','orders.user_id')->latest('orders.id')->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        foreach($rows as $key => $row){
            if($row->user_id == null){
                $order = Order::find($row->id);
                $rows[$key]->first_name = $order->first_name; 
                $rows[$key]->last_name = $order->last_name; 
                $rows[$key]->email = $order->email; 
                $rows[$key]->phone = $order->phone; 
            }
        }
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
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

    
    public function downloadInvoice(Request $request,$id){
        // print 'a'; die;
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



        PDF::SetCreator('Ecommerce');
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        //PDF::SetFont('montserratmedium', '', 13, '', true);
        //PDF::SetFont('courier', '', 14, '', true);
        PDF::SetAutoPageBreak(true);
        //PDF::SetMargins(1, 1, 1);
        PDF::SetMargins(10, 10, 10, true);
        PDF::setFontSpacing(0.10);

        //PDF::setCellPaddings( $left = '10px', $top = '', $right = '', $bottom = '');

        // PDF::AddPage();
        //PDF::AddPage('P', 'FOLIO');
        //PDF::AddPage('mm',array(80,200));
        PDF::AddPage();
        
        $data=array('row' => $row, 'logo' => public_path('frontend/img/theme/logo.png'));
        $view=\View::make('admin.order.invoiceHtmlToPDF')->with($data);
        $html=$view->render();
        // print_r($html); die;

        // Print text using writeHTMLCell()
        // PDF::writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        PDF::writeHTML($html, true, false, false, false, '');
        //$file=PDF::Output('example_006.pdf', 'I');

        //$file=PDF::Output('example_006.pdf', 'D');
        //$file=PDF::Output('Order-'.ucfirst($order->first_name).' '.$order->last_name.' ('.$order->order_no.').pdf', 'D');
        // $file=PDF::Output('Invoice-'.$row->id.'.pdf', 'D');
        $file=PDF::Output('Invoice-'.$row->id.'.pdf', 'I');


        // $data=array('row' => $row);
        // return view('admin.order.order-invoice')->with($data);
        // print '<pre>'; print_R($row->toArray()); die;
    }


    
    public function updateStatus(Request $request){ 
        $status = $request->status;
        $note = $request->note;
        $id = $request->id;
        //print $status; die;

        $order = Order::find($id);

        if(!$order){
            return array('result'=>false, 'message' => 'Something went wrong');
        }

        // 'productsHtml' => (String)View::make('front.cart.products-section')->with(compact('cart'))

        $history = $order->history()->create(['status' => $status, 'type' => strtolower($status), 'note' => $note]);
        $order->order_status = $status;
        $order->save();

        if($order->user_id == null){
            $name = $order->first_name.' '.$order->last_name;
            $email = $order->email;
        }else{
            $user = User::find($order->user_id);
            $name = $user->first_name.' '.$user->last_name;
            $email = $user->email;

        }
        $logo = Helper::getLightLogo();
        $emailData = array('logo' => $logo, 'name' => $name, 'status' => $status, 'order_no' => $order->order_no, 'order' => $order, 'note' => $note, 'to' => $email);

        dispatch(new \App\Jobs\OrderStatusQueue($emailData));

        if($history){
            return array('result'=>true, 'message' => 'Order history updated!', 'historyHtml' => (String)View::make('admin.order.view-history')->with(['row' => $order]));
        }else{
            return array('result'=>false, 'message' => 'Something went wrong');
        }

        return array('count'=>$count,'result'=>false, 'message' => 'Something went wrong');
    }
    
    
    public function filter(Request $request){ 
        $page = $request->page;
        $startDate = $request->filled('startDate') ? new Carbon($request->startDate) : null;
        $endDate = $request->filled('endDate') ? new Carbon($request->endDate) : null;
        $status = $request->status;
        $payment = $request->payment;
        $search = $request->search;
        $clear = $request->clear;

        if($endDate){
            $endDate = $endDate->endOfDay();
        }
        // print $startDate; die;
        // print $endDate; die;

        $query = Order::select('orders.*','users.first_name','users.last_name')->leftjoin('users','users.id','=','orders.user_id')->latest('orders.id');
        //print '<pre>'; print_r($rows); die;

        if($startDate){
            $query->whereDate('orders.created_at', '>=', $startDate);
        }

        if($endDate){
            $query->whereDate('orders.created_at', '<=', $endDate);
        }

        if($status){
            $query->where('order_status', $status);
        }

        if($payment){
            $query->where('payment_method', $payment);
        }

        if($search){

            $query->where( function ($subQuery) use ($search) {
                // $subQuery->where('orders.full_name','like','%'.$search.'%');
                $subQuery->fullName($search, 'users');
                $subQuery->orWhere('orders.first_name','like','%'.$search.'%');
                $subQuery->orWhere('orders.last_name','like','%'.$search.'%');
                $subQuery->orWhere('orders.email','like','%'.$search.'%');
                $subQuery->orWhere('orders.phone','like','%'.$search.'%');

                $subQuery->orWhere('users.first_name','like','%'.$search.'%');
                $subQuery->orWhere('users.last_name','like','%'.$search.'%');
                $subQuery->orWhere('users.email','like','%'.$search.'%');
                $subQuery->orWhere('users.phone','like','%'.$search.'%');
                
                $subQuery->orWhere('order_no','like','%'.$search.'%');
            });

            // $query->where('orders.first_name','like','%'.$search.'%');
            // $query->orWhere('orders.last_name','like','%'.$search.'%');
            // $query->orWhere('orders.email','like','%'.$search.'%');
            // $query->orWhere('orders.phone','like','%'.$search.'%');

            // $query->orWhere('users.first_name','like','%'.$search.'%');
            // $query->orWhere('users.last_name','like','%'.$search.'%');
            // $query->orWhere('users.email','like','%'.$search.'%');
            // $query->orWhere('users.phone','like','%'.$search.'%');
            
            // $query->orWhere('order_no','like','%'.$search.'%');
        }


        // if($slug){
        //     $productID = $product->id;
        //     //print $productID; die;
        //     $query->whereHas('products', function($subQuery) use ($productID) {
        //         $subQuery->where('inventory_log_products.product_id', $productID);
        //     });
        // }

        // if($user){
        //     $query->where('user_id',$user);
        // }
        
        // if($stock){
        //     $query->where('type',$stock);
        // }

        // if($event){
        //     $query->where('event',$event);
        // }

       

        if($clear == 'true'){
            $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page);
        }else{
            $rows = $query->get();
        }
        // 
        

        // print '<pre>'; print_r($rows->toArray()); die;

        foreach($rows as $key => $row){
            if($row->user_id == null){
                $order = Order::find($row->id);
                $rows[$key]->first_name = $order->first_name; 
                $rows[$key]->last_name = $order->last_name; 
                $rows[$key]->email = $order->email; 
                $rows[$key]->phone = $order->phone; 
            }
        }
        //die;
        //print '<pre>'; print_r($rows->toArray()); die;
        
        return array('html' => (String)View::make($this->prefix.'.'.$this->folder.'.rows')->with(compact('rows')));
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
