<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\ContactRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Banner;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Video;
use App\Models\Page;


use App\Models\Token;
use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Image;
use Validator;
use Mail;

use App\Mail\SendForgotPasswordRecoveryLinkToAdminUser;

class AdminController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';

    public function  __construct(){
        // $this->middleware('auth:admin', ['except' => ['index']]);
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        // return ['admin'];
        return [
            new Middleware('admin', except: ['index'])
        ];
    }

    
    public function index(Request $request)
    { 


        if (Auth::guard('admin')->guest()){
            //print 'not login'; die;
            return view($this->prefix.'.auth.login');
        }else{
            //print 'login'; die;

            $users = User::count();
            $products = Product::count();
            $colors = Color::count();
            $brands = Brand::count();
            $taxes = Tax::count();
            $coupons = Coupon::count();
            $orders = Order::count();
            $enquiries = Enquiry::count();
            $payments = Payment::count();
            $banners = Banner::count();
            $testimonials = Testimonial::count();
            $gallery = Gallery::count();
            $videos = Video::count();
            $pages = Page::count();
            $contacts = ContactRequest::count();


            $config = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $config['is_enquiry_website'];

            $latestOrders = null;
            $latestEnquiries = null;

            $year = date('Y');
            $month = date('m');
            $now = Carbon::now();

            if(!$isEnquiryWebsite){
                $latestOrders = Order::latest()->limit(10)->get();

                $totalAmountObj = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')
                // ->where('orders.is_payment_done', true)
                ->where('orders.status', true);

                $totalAmount = $totalAmountObj->sum('payments.amount');

                
                $currentYearAmount = $totalAmountObj->whereYear('orders.created_at', $year)->sum('payments.amount');

                $currentMonthAmount = $totalAmountObj->whereYear('orders.created_at', $year)->whereMonth('orders.created_at', $month)->sum('payments.amount');

                $currentWeekAmount = $totalAmountObj->whereYear('orders.created_at', $year)->whereMonth('orders.created_at', $month)->whereBetween("orders.created_at", [
                    $now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')
                 ])->sum('payments.amount');
            }else{
                $latestEnquiries = Enquiry::latest()->limit(10)->get();

                $enquiriesObj = Enquiry::with(['products']);
                
                $totalAmount = $enquiriesObj->get();
                //print '<pre>'; print_r($enquiries->toArray()); die;
                $totalAmount = Helper::getEnquiresTotal($totalAmount);
                //print '<pre>'; print_r($enquiries->toArray()); die;

                //print $totalAmount; die;

                $currentYearAmount = $enquiriesObj->whereYear('enquiries.created_at', $year)->get();

                $currentYearAmount = Helper::getEnquiresTotal($currentYearAmount);

                $currentMonthAmount = $enquiriesObj->whereYear('enquiries.created_at', $year)->whereMonth('enquiries.created_at', $month)->get();

                $currentMonthAmount = Helper::getEnquiresTotal($currentMonthAmount);
                
                $currentWeekAmount = $enquiriesObj->whereYear('enquiries.created_at', $year)->whereMonth('enquiries.created_at', $month)->whereBetween("enquiries.created_at", [
                    $now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])->get();

                $currentWeekAmount = Helper::getEnquiresTotal($currentWeekAmount);
            }

            //print '<pre>'; print_r($latestOrders->toArray()); die;

            $recentProducts = Product::latest()->limit(6)->get();
            $currency = Helper::getCurrency();

            // $totalAmount = Order::select('orders.*', 'payments.amount')->join('payments','payments.order_id','=', 'orders.id')->where('orders.is_payment_done', true)->where('orders.status', true)->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $year)->sum('payments.amount');
            

            $data=array('users' => $users, 'products' => $products, 'colors' => $colors, 'brands' => $brands, 'taxes' => $taxes, 'coupons' => $coupons, 'orders' => $orders, 'enquiries' => $enquiries, 'payments' => $payments, 'banners' => $banners, 'testimonials' => $testimonials, 'gallery' => $gallery, 'videos' => $videos, 'pages' => $pages, 'contacts' => $contacts, 'latestOrders' => $latestOrders, 'latestEnquiries' => $latestEnquiries, 'recentProducts' => $recentProducts, 'totalAmount' => $currency['sign'].$totalAmount, 'currentYearAmount' => $currency['sign'].$currentYearAmount, 'currentMonthAmount' => $currency['sign'].$currentMonthAmount, 'currentWeekAmount' => $currency['sign'].$currentWeekAmount, 'isEnquiryWebsite' => $isEnquiryWebsite);

            return view($this->prefix.'.dashboard')->with($data);      
        }


        // $categoriesCount = Category::count();
        // $productCount = Product::count();
        // $productEnqiryCount = ProductEnquiry::count();
        // $newsCategoryCount = NewsCategory::count();
        // $newsCount = News::count();
        // $jobOpeningCount = JobOpening::count();
        // $jobApplicationCount = JobApplication::count();
        // $bannerCount = Banner::count();
        // $contactCount = Contact::count();

        //$data = array('categoriesCount' => $categoriesCount, 'productCount' => $productCount, 'productEnqiryCount' => $productEnqiryCount, 'newsCategoryCount' => $newsCategoryCount, 'newsCount' => $newsCount, 'jobOpeningCount' => $jobOpeningCount, 'jobApplicationCount' => $jobApplicationCount, 'bannerCount' => $bannerCount, 'contactCount' => $contactCount);

        return view('admin.index');
    }
    public function profile(Request $request)
    {       

        $user = Auth::guard('admin')->user();

        if ($request->isMethod('post')) {

            $validator=array(
                'name'=>'required',
                'email'=>'required|email:strict|unique:admins,email,'.$user->id,
                'image'=>'mimes:jpeg,jpg,png,webp',
                //'mobile'=>'required|numeric|digits:10|unique:admins,mobile,'.$user->id,
            );
            $request->validate($validator);

            //$uploadImage = Helper::uploadMedia(['request' => $request, 'dir' => 'admin/profile', 'inputName' => 'image']);
            // if ($uploadImage['file']) {
	        // 	$user->image = $uploadImage['fileName'];
	        // }

            $image = $request->file('image');
            //print '<pre>'; print_r($image); die;
            if(isset($image)){
                $queryFlag=true;
                if($image->getMimeType()=='image/jpeg'){
                    $fName=$image->getClientOriginalName();
                    $arr=explode('.',$fName);
                    $extVal=end($arr);
                    $extension='.'.$extVal;
                }else if($image->getMimeType()=='image/png'){
                    $extension='.png';
                }else{
                    $extension = $image->getClientOriginalExtension();
                }
                $name=md5(time()+rand(10,1000));

                Storage::disk('public')->put('admin/profile/'.$name.$extension,file::get($image));
              
                $user->image = $name.$extension;                
                $user->save();                
            }

	        

            //$user->mobile = $request->mobile;
            $user->name = $request->name;
            $user->email = $request->email;
            $query = $user->save();

            if($query){
                Helper::flashMessage(true,'Details updated successfully!');
            }else{
                Helper::flashMessage(false,'Something went wrong!');
            }
           
            return to_route('admin.profile');
        }

        return view('admin.profile.index',['row'=>$user]);
    }




    public function changePassword(Request $request)
    {   
        if ($request->isMethod('post')) {
            $old = $request->old_password;
            $new = $request->new_password;
            $confirm = $request->confirm_password;
                
            $validator=array(
                'old_password'=>'required',
                'new_password'=>'required',
                'confirm_password'=>'required|same:new_password',
            );
            $request->validate($validator);
            $user = Auth::guard('admin')->user();
    
            if ((Hash::check($old , $user->password)) == false) {
                Helper::flashMessage(false,'Old password mismatch!');
                return to_route('admin.profile.change.password');
    
            } else if ((Hash::check($new, $user->password)) == true) {
                Helper::flashMessage(false,'Please enter a password different from current');
                return to_route('admin.profile.change.password');
            } 
    
            $user->password = Hash::make($new);
            $query = $user->save();
    
            if($query){
                Helper::flashMessage(true,'Password updated successfully!');
            }else{
                Helper::flashMessage(false,'Something went wrong');
            }
            
            return to_route('admin.profile.change.password');
        }

        return view('admin.profile.change-password');
    }

    public function contactEnquiries(Request $request){
        $page = $request->page;
        //print $id; die;
        $enquiries = Contact::latest()->paginate($this->pagerecords, ['*'], 'page', $page);

        $data=array('enquiries'=>$enquiries);
        return view('admin.contact.enquiries')->with($data);

    }

    

    public function deleteEnquiry(Request $request){
        $id = $request->id;
        //print $id; die;
        $query = Contact::where('id',$id)->delete();


        if($query){
            Helper::flashMessage(true,'Enquiry deleted successfully!');
        }else{
            Helper::flashMessage(false,'Somrthing went wrong');
        }
        
        return redirect()->back();

    }


    /**
     * forgot password
     *
    */   
    public function forgotPassword(Request $request){

        if ( $request->method() == "POST" ) {
    		$rules = ['email' => 'required|email:strict'];
    		
	        $validator = Validator::make( $request->all(), $rules );
	    	if ($validator->fails()) {
	    		return back()->withInput()->withErrors($validator);
	        }

	        $token = new Token;
            
            $admin = Admin::where('status',1)->where('email',$request->email)->first();
            if( empty( $admin ) ){
                Helper::flashMessage(false,'Invalid Email!');
                return redirect()->back()->withInput();
            }
            $unique_token = $admin->id.time().rand('111','999');

            $tempData = [
                'subject'=> "Recover your account!",
                'name'=> $admin->name,
                'recovery_url'=> Route('admin.recover.password',['token' => $unique_token]),
            ];

            Mail::to( $admin->email )->send(new SendForgotPasswordRecoveryLinkToAdminUser($tempData));
            

            $token->user_type = 0;
            $token->user_id = $admin->id;
            $token->type = 'forgot password';
            $token->token = $unique_token;
            $token->token_expiery = Carbon::now()->addHours('24');
            $token->status = 0;
            $token->save();
            Helper::flashMessage(true,'Recovery link sent on your email!');
            return to_route('admin.forgot.password');
	    
	    }
        return view('admin.auth.forgot-password');
    } 
    

    public function recoverPassword(Request $request,$token){
    	if (  $request->method() == "POST" ) {

    		$rules = [
	            'password' => 'required|confirmed',
	        ];
	        $validator = Validator::make( $request->all(), $rules );
	    	if ($validator->fails()) {
	    		return back()->withInput()->withErrors($validator);
	        }

	        $token = Token::where('token',$token)->where('status',0)->latest()->first();
	        if( $token ){
	        	
	        	$timeNow = Carbon::now()->format('Y-m-d H:i:s'); 
	        	$tokeExpiryTime = Carbon::parse($token->token_expiery)->addHours('24')->format('Y-m-d H:i:s');
	        	if( $timeNow > $tokeExpiryTime ){
                    Helper::flashMessage(false,'Recovery link expired!');
	        		return redirect()->back()->withInput();
	        	}else{

	        		$admin = Admin::where('id', $token->user_id)->where('status',1)->first();
	        		if( $admin ){
	        			$admin->password = bcrypt($request->get('password'));
	        			$admin->save();

                        $token->status = 1;
                        $token->save();
                        
                        Helper::flashMessage(true,'Password changed successfully!');
	        			return to_route('admin.login');
	        		}
	        	}

	        }
            
            Helper::flashMessage(false,'Invalid Url!');
            return redirect()->back()->withInput();

    	}
    	return view('admin.auth.recover-password',[ 'token' => $token]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return to_route('admin.login');
    }

}
