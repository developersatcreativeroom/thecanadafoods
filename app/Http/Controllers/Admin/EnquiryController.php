<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Enquiry;
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


class EnquiryController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'enquiry';

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
        $rows = Enquiry::select('enquiries.*','users.first_name','users.last_name')->leftjoin('users','users.id','=','enquiries.user_id')->latest('enquiries.id')->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        foreach($rows as $key => $row){
            if($row->user_id == null){
                $enquiry = Enquiry::find($row->id);
                $rows[$key]->first_name = $enquiry->first_name; 
                $rows[$key]->last_name = $enquiry->last_name; 
                $rows[$key]->email = $enquiry->email; 
                $rows[$key]->phone = $enquiry->phone; 
            }
        }
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function view($id){
        $row = Enquiry::select('enquiries.*','users.first_name','users.last_name','users.email','users.country_code','users.phone')->leftjoin('users','users.id','=','enquiries.user_id')->with([
            'products', 'billing','shipping','history'])->find($id);
        if($row == null){
            return to_route('admin.enquiries');
        } 
        if($row->user_id == null){
            $enquiry = Enquiry::find($row->id);
            $row->first_name = $enquiry->first_name; 
            $row->last_name = $enquiry->last_name; 
            $row->email = $enquiry->email; 
            $row->country_code = $enquiry->country_code;
            $row->phone = $enquiry->phone; 
        }
        //print '<pre>'; print_R($row); die;
        //print '<pre>'; print_R($row->toArray()); die;
        $data=array('row' => $row);

        return view($this->prefix.'.'.$this->folder.'.view')->with($data);
    }
    
    public function updateStatus(Request $request){ 
        $status = $request->status;
        $note = $request->note;
        $id = $request->id;
        //print $status; die;

        $enquiry = Enquiry::find($id);

        if(!$enquiry){
            return array('result'=>false, 'message' => 'Something went wrong');
        }

        // 'productsHtml' => (String)View::make('front.cart.products-section')->with(compact('cart'))

        $history = $enquiry->history()->create(['status' => $status, 'type' => strtolower($status), 'note' => $note]);
        $enquiry->enquiry_status = $status;
        $enquiry->save();

        if($enquiry->user_id == null){
            $name = $enquiry->first_name.' '.$enquiry->last_name;
            $email = $enquiry->email;
        }else{
            $user = User::find($enquiry->user_id);
            $name = $user->first_name.' '.$user->last_name;
            $email = $user->email;

        }
        $logo = Helper::getLightLogo();
        $emailData = array('logo' => $logo, 'name' => $name, 'status' => $status, 'enquiry_no' => $enquiry->enquiry_no, 'to' => $email);

        // dispatch(new \App\Jobs\EnquiryStatusQueue($emailData));

        if($history){
            return array('result'=>true, 'message' => 'Enquiry history updated!', 'historyHtml' => (String)View::make('admin.enquiry.view-history')->with(['row' => $enquiry]));
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
        $search = $request->search;
        $clear = $request->clear;

        if($endDate){
            $endDate = $endDate->endOfDay();
        }
        // print $startDate; die;
        // print $endDate; die;

        $query = Enquiry::select('enquiries.*','users.first_name','users.last_name')->leftjoin('users','users.id','=','enquiries.user_id')->latest('enquiries.id');
        

        if($startDate){
            $query->whereDate('enquiries.created_at', '>=', $startDate);
        }

        if($endDate){
            $query->whereDate('enquiries.created_at', '<=', $endDate);
        }

        if($status){
            $query->where('enquiry_status', $status);
        }

        if($search){

            $query->where( function ($subQuery) use ($search) {
                // $subQuery->where('enquiries.full_name','like','%'.$search.'%');
                $subQuery->fullName($search, 'users');
                $subQuery->orWhere('enquiries.first_name','like','%'.$search.'%');
                $subQuery->orWhere('enquiries.last_name','like','%'.$search.'%');
                $subQuery->orWhere('enquiries.email','like','%'.$search.'%');
                $subQuery->orWhere('enquiries.phone','like','%'.$search.'%');

                $subQuery->orWhere('users.first_name','like','%'.$search.'%');
                $subQuery->orWhere('users.last_name','like','%'.$search.'%');
                $subQuery->orWhere('users.email','like','%'.$search.'%');
                $subQuery->orWhere('users.phone','like','%'.$search.'%');
                
                $subQuery->orWhere('enquiry_no','like','%'.$search.'%');
            });
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
        
        //die;
        //print '<pre>'; print_r($rows->toArray()); die;
        
        return array('html' => (String)View::make($this->prefix.'.'.$this->folder.'.rows')->with(compact('rows')));
    }
    
}
