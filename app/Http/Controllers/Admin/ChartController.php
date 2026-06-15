<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Enquiry;
use App\Models\OrderProduct;
use App\Models\EnquiryProduct;

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


class ChartController extends Controller implements HasMiddleware
{   
    private $videorecords;
    private $prefix = 'admin';
    private $folder = 'video';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->videorecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }
    
    public function sales(Request $request){ 
        $year = $request->year ? trim($request->year) : date('Y');
        //print $year; die;

        //$year = 2023;

        $salesArray = [];

        $config = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $config['is_enquiry_website'];

        for($month=1;$month<=12;$month++){
            if(!$isEnquiryWebsite){
                // $count = Order::where('is_payment_done', true)->where('status', true)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
                $count = Order::where('status', true)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            }else{
                $count = Enquiry::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            }
            $salesArray[] = $count;
            //print_r($count);
        }

        //die;
        //print_r($array); die;
        

        //return array('data' => array(28, 48, 40, 19, 86, 27, 90, 60, 88, 25, 5, 90));
        return array('sales' => $salesArray);
        //print 'a'; die;
        //return 'a';
    }
    
    public function salesAmount(Request $request){ 
        //$year = $request->year ? trim($request->year) : date('Y');
        //print $year; die;

        //$year = 2023;

        $config = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $config['is_enquiry_website'];

        $year = date("Y");
        $lastYear = date("Y",strtotime("-1 year"));

        $salesAmountCurrent = [];

        for($month=1;$month<=12;$month++){
            if(!$isEnquiryWebsite){

                $currentAmount = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')
                // ->where('orders.is_payment_done', true)
                ->where('orders.status', true)->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $year)->sum('payments.amount');
                //print '<pre>'; print_r($currentAmount); die;

                $previousAmount = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')
                // ->where('orders.is_payment_done', true)
                ->where('orders.status', true)->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $lastYear)->sum('payments.amount');
                //print '<pre>'; print_r($currentAmount); die;
            }else{
                $currentAmount = Enquiry::with(['products'])->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
                $currentAmount = Helper::getEnquiresTotal($currentAmount);

                $previousAmount = Enquiry::with(['products'])->whereMonth('created_at', $month)->whereYear('created_at', $lastYear)->get();
                $previousAmount = Helper::getEnquiresTotal($previousAmount);
            }
            
            $salesAmountCurrent[] = $currentAmount;
            $salesAmountPrevious[] = $previousAmount;

        }

        // print '<pre>'; print_r($salesAmountCurrent); die;

        //die;
        //print_r($array); die;
        

        //return array('data' => array(28, 48, 40, 19, 86, 27, 90, 60, 88, 25, 5, 90));
        return array('current' => $salesAmountCurrent, 'previous' => $salesAmountPrevious);
        //print 'a'; die;
        //return 'a';
    }
    
    public function highestSaleProduct(Request $request){ 
        //$year = $request->year ? trim($request->year) : date('Y');
        //print $year; die;

        //$year = 2023;

        $config = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $config['is_enquiry_website'];

        if(!$isEnquiryWebsite){
            // $idData = OrderProduct::select('products.name',DB::raw('count("product_id") as sales_count'))->orderBy(\DB::raw('count(product_id)'), 'DESC')->groupBy('order_products.product_id')->join('products','products.id','=', 'order_products.product_id')->limit(6)->get();
            $idData = OrderProduct::select('products.name')
            ->selectRaw('COUNT(product_id) as sales_count')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->groupBy('order_products.product_id', 'products.name')
            ->orderByDesc('sales_count')
            ->limit(6)
            ->get();
            
        }else{
            // $idData = EnquiryProduct::select('products.name',DB::raw('count("product_id") as sales_count'))->orderBy(\DB::raw('count(product_id)'), 'DESC')->groupBy('enquiry_products.product_id')->join('products','products.id','=', 'enquiry_products.product_id')->limit(6)->get();
            $idData = OrderProduct::select('products.name')
            ->selectRaw('COUNT(product_id) as sales_count')
            ->join('products', 'products.id', '=', 'enquiry_products.product_id')
            ->groupBy('enquiry_products.product_id', 'products.name')
            ->orderByDesc('sales_count')
            ->limit(6)
            ->get();
        }
        
        //print '<pre>'; print_R($idData->toArray()); die;

        $labels = array();
        $data = array();
        foreach($idData as $idDataSingle){
            $labels[] = $idDataSingle->name;
            $data[] = $idDataSingle->sales_count;
        }

        return array('labels' => $labels, 'data' => $data);



        // print '<pre>'; print_R($ids); die;

        // foreach($ids as $id){
        //     $count = OrderProduct::where('id',$id);
        //     print '<pre>'; print_R($count->toArray()); die;    
        // }

        // $count = OrderProduct::select(DB::raw('count("product_id") as sales_count'))->get();
        // print '<pre>'; print_R($count->toArray()); die;

        // $year = date("Y");
        // $lastYear = date("Y",strtotime("-1 year"));

        // $salesAmountCurrent = [];

        // for($month=1;$month<=12;$month++){
        //     $currentAmount = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')->where('orders.is_payment_done', true)->where('orders.status', true)->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $year)->sum('payments.amount');
        //     //print '<pre>'; print_r($currentAmount); die;
        //     $salesAmountCurrent[] = $currentAmount;
            
        //     $PreviousAmount = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')->where('orders.is_payment_done', true)->where('orders.status', true)->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $lastYear)->sum('payments.amount');
        //     //print '<pre>'; print_r($currentAmount); die;
        //     $salesAmountPrevious[] = $PreviousAmount;

        // }

        // //print '<pre>'; print_r($salesAmountCurrent); die;

        // //die;
        // //print_r($array); die;
        

        // //return array('data' => array(28, 48, 40, 19, 86, 27, 90, 60, 88, 25, 5, 90));
        // return array('current' => $salesAmountCurrent, 'previous' => $salesAmountPrevious);
        // //print 'a'; die;
        //return 'a';
    }
    public function highestSaleAmountProduct(Request $request){ 
        //$year = $request->year ? trim($request->year) : date('Y');
        //print $year; die;

        //$year = 2023;

        $config = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $config['is_enquiry_website'];

        if(!$isEnquiryWebsite){
            // $idData = OrderProduct::select('products.name',DB::raw('SUM(final_price) as price_total'))->orderBy(\DB::raw('SUM(final_price)'), 'DESC')->groupBy('order_products.product_id')->join('products','products.id','=', 'order_products.product_id')->limit(6)->get();
            $idData = OrderProduct::select('products.name')
            ->selectRaw('SUM(final_price) as price_total')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->groupBy('order_products.product_id', 'products.name')
            ->orderByDesc('price_total')
            ->limit(6)
            ->get();
            
        }else{
            // $idData = EnquiryProduct::select('products.name',DB::raw('SUM(final_price) as price_total'))->orderBy(\DB::raw('SUM(final_price)'), 'DESC')->groupBy('enquiry_products.product_id')->join('products','products.id','=', 'enquiry_products.product_id')->limit(6)->get();
            $idData = EnquiryProduct::select('products.name')
            ->selectRaw('SUM(final_price) as price_total')
            ->join('products', 'products.id', '=', 'enquiry_products.product_id')
            ->groupBy('enquiry_products.product_id', 'products.name')
            ->orderByDesc('price_total')
            ->limit(6)
            ->get();
        }
        //print '<pre>'; print_R($idData->toArray()); die;

        // $currency = Helper::getCurrency();
        
        $labels = array();
        $data = array();
        foreach($idData as $idDataSingle){
            $labels[] = $idDataSingle->name;
            $data[] = $idDataSingle->price_total;
        }

        return array('labels' => $labels, 'data' => $data);

    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        
        $row = Video::find($id);
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $link = trim($request->input('video'));
        $status = trim($request->input('status'));
        //print $id; die;
        

        $validationArray=array(
            'video'=>'required',
            'status'=>'required',
        );
        
        $request->validate($validationArray);
        //die;

        DB::beginTransaction();


        //$link = "http://www.youtube.com/watch?v=oHg5SJYRHA0&lololo";
        $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
        if (empty($video_id[1]))
            $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

        $video_id = explode("&", $video_id[1]); // Deleting any other params
        $videoID = $video_id[0];
        
        if(empty($id)){
            $video = Video::create(['video'=>$videoID, 'status'=>$status]);
        }else{
            $video = Video::find($id);

            $video->video = $videoID;
            $video->status = $status;
            $video->save();
        }

        if($video){
            DB::commit();
            Helper::flashMessage(true, 'Video added/updated successfully!');
            return to_route('admin.videos');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Video::find($id);
        if(!$row){
            return to_route('admin.videos');
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Video deleted successfully!');
            return to_route('admin.videos');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
