<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Setting;
use App\Models\Country;

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


class SettingController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    // public function list(Request $request){ 
    //     $page = $request->page;
    //     $rows = Setting::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
    //     //print '<pre>'; print_r($rows); die;
    //     $data=array('rows'=>$rows);
    //     return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    // }

    // public function add(){
    //     return view($this->prefix.'.'.$this->folder.'.form');
    // }

    // public function edit($id){
        
    //     $row = Page::find($id);
        
    //     $data=array('row' => $row);
    //     return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    // }

    // public function postData(Request $request){
    //     $id = trim($request->input('id'));
    //     $title = trim($request->input('title'));
    //     $slug = trim($request->input('slug'));
    //     $description = trim($request->input('description'));
    //     $status = trim($request->input('status'));
    //     //print $id; die;

    //     $validationArray=array(
    //         'title'=>'required',
    //         'description'=>'required',
    //         'status'=>'required',
            
    //     );

    //     if(empty($id)){
    //         $validationArray['slug'] = 'required|unique:pages,slug';
    //     }else{
    //         $validationArray['slug'] = 'required|unique:pages,slug,'.$id;
    //     }
        
    //     $request->validate($validationArray);

    //     DB::beginTransaction();

    //     $slug = preg_replace('/\s+/', '-', $slug);
        
    //     if(empty($id)){
    //         $page = Page::create(['title'=>$title, 'slug'=>$slug, 'description'=>$description, 'status'=>$status]);
    //     }else{
    //         $page = Page::find($id);

    //         $page->title = $title;
    //         $page->slug = $slug;
    //         $page->description = $description;
    //         $page->status = $status;
    //         $page->save();
    //     }

    //     if($page){
    //         DB::commit();
    //         Helper::flashMessage(true, 'Page added/updated successfully!');
    //         return to_route('admin.pages');
    //     }else{
    //         DB::rollBack();
    //         Helper::flashMessage(false, 'Something went wrong');
    //         return redirect()->back();
    //     }
        
    // }


    public function settings(Request $request){

        $country = Setting::where('key','country')->first();
        $countryDB = $country ? $country->value : null;
        $shipping = Setting::where('key','shipping')->first();
        $shippingDB = $shipping ? $shipping->value : null;
        $reviews = Setting::where('key','reviews')->first();
        $reviewsDB = $reviews ? $reviews->value : null;
        $coupon = Setting::where('key','coupon')->first();
        $couponDB = $coupon ? $coupon->value : null;
        $address = Setting::where('key','address')->first();
        $addressDB = $address ? $address->value : null;
        $countryCode = Setting::where('key','country_code')->first();
        $countryCodeDB = $countryCode ? $countryCode->value : null;
        $phone = Setting::where('key','phone')->first();
        $phoneDB = $phone ? $phone->value : null;
        $whatsapp = Setting::where('key','whatsapp')->first();
        $whatsappDB = $whatsapp ? $whatsapp->value : null;
        $hoursWeek = Setting::where('key','hours_week')->first();
        $hoursWeekDB = $hoursWeek ? $hoursWeek->value : null;
        $hoursWeekEnd = Setting::where('key','hours_week_end')->first();
        $hoursWeekEndDB = $hoursWeekEnd ? $hoursWeekEnd->value : null;
        $email = Setting::where('key','email')->first();
        $emailDB = $email ? $email->value : null;
        $map = Setting::where('key','map')->first();
        $mapDB = $map ? $map->value : null;
        $currencySign = Setting::where('key','currency_sign')->first();
        $currencySignDB = $currencySign ? $currencySign->value : null;
        $currencyIsoCode = Setting::where('key','currency_iso_code')->first();
        $currencyIsoCodeDB = $currencyIsoCode ? $currencyIsoCode->value : null;
        $lightLogo = Setting::where('key','light_logo')->first();
        $lightLogoDB = $lightLogo ? $lightLogo->value : null;
        $darkLogo = Setting::where('key','dark_logo')->first();
        $darkLogoDB = $darkLogo ? $darkLogo->value : null;
        $favicon = Setting::where('key','favicon')->first();
        $faviconDB = $favicon ? $favicon->value : null;
        $seoTitle = Setting::where('key','seo_title')->first();
        $seoTitleDB = $seoTitle ? $seoTitle->value : null;
        $seoDescription = Setting::where('key','seo_description')->first();
        $seoDescriptionDB = $seoDescription ? $seoDescription->value : null;
        $seoKeywords = Setting::where('key','seo_keywords')->first();
        $seoKeywordsDB = $seoKeywords ? $seoKeywords->value : null;
        $productServices = Setting::where('key','product_services')->first();
        $productServicesDB = $productServices ? $productServices->value : null;
        $productAddon = Setting::where('key','product_addon')->first();
        $productAddonDB = $productAddon ? $productAddon->value : null;
        $localPickup = Setting::where('key','local_pickup')->first();
        $localPickupDB = $localPickup ? $localPickup->value : null;
        $isEnquiryWebsite = Setting::where('key','is_enquiry_website')->first();
        $isEnquiryWebsiteDB = $isEnquiryWebsite ? $isEnquiryWebsite->value : null;
        $isEmailVerify = Setting::where('key','is_email_verify')->first();
        $isEmailVerifyDB = $isEmailVerify ? $isEmailVerify->value : null;

        $countries = Country::get();

        if ($request->isMethod('post')) {

            $countryForm = trim($request->input('country'));
            $shippingForm = trim($request->input('shipping'));
            $reviewsForm = trim($request->input('reviews'));
            $couponForm = trim($request->input('coupon'));
            $addressForm = trim($request->input('address'));
            $countryCodeForm = trim($request->input('country_code'));
            $phoneForm = trim($request->input('phone'));
            $whatsappForm = trim($request->input('whatsapp'));
            $hoursWeekForm = trim($request->input('hours_week'));
            $hoursWeekEndForm = trim($request->input('hours_week_end'));
            $emailForm = trim($request->input('email'));
            $mapForm = trim($request->input('map'));
            $currencySignForm = trim($request->input('currency_sign'));
            $currencyIsoCodeForm = trim($request->input('currency_iso_code'));
            
            $lightLogoForm = $request->file('light_logo');
            $darkLogoForm = $request->file('dark_logo');
            $faviconForm = $request->file('favicon');

            $seoTitleForm = $request->input('seo_title');
            $seoDescriptionForm = $request->input('seo_description');
            $seoKeywordsForm = $request->input('seo_keywords');
            $productServicesForm = $request->input('product_services');
            $productAddonForm = $request->input('product_addon');
            $localPickupForm = $request->input('local_pickup');
            $isEnquiryWebsiteForm = $request->input('is_enquiry_website');
            $isEmailVerifyForm = $request->input('is_email_verify');

            $validationArray=array(
                'country'=>'',
                'shipping'=>'nullable|numeric',
                'reviews'=>'',
                'coupon'=>'',
                'address'=>'',
                'phone'=>'',
                'hours_week'=>'',
                'hours_week_end'=>'',
                'email'=>'',
                'map'=>'',
                'currency_sign'=>'',
                'light_logo'=>'image|mimes:jpeg,jpg,png,webp,gif',
                'dark_logo'=>'image|mimes:jpeg,jpg,png,webp,gif',
                //'favicon'=>'image|mimes:jpeg,jpg,png,svg,ico',
                'favicon'=>'mimes:jpeg,jpg,png,svg,ico',
                'seo_title'=>'',
                'seo_description'=>'',
                'seo_keywords'=>'',
            );

            //print $countryForm; die;
    
            $request->validate($validationArray);
    
            if($countryDB != $countryForm){
                if($country){
                    $country->update(['value' => $countryForm]);
                }else{
                    Setting::create(['key' => 'country', 'value' => $countryForm]);
                }
            }
            
            if($shippingDB != $shippingForm){
                if($shipping){
                    $shipping->update(['value' => $shippingForm]);
                }else{
                    Setting::create(['key' => 'shipping', 'value' => $shippingForm]);
                }
            }

            if($reviewsDB != $reviewsForm){
                if($reviews){
                    $reviews->update(['value' => $reviewsForm]);
                }else{
                    Setting::create(['key' => 'reviews', 'value' => $reviewsForm]);
                }
            }

            if($couponDB != $couponForm){
                if($coupon){
                    $coupon->update(['value' => $couponForm]);
                }else{
                    Setting::create(['key' => 'coupon', 'value' => $couponForm]);
                }
            }

            if($addressDB != $addressForm){
                if($address){
                    $address->update(['value' => $addressForm]);
                }else{
                    Setting::create(['key' => 'address', 'value' => $addressForm]);
                }
            }

            if($countryCodeDB != $countryCodeForm){
                if($countryCode){
                    $countryCode->update(['value' => $countryCodeForm]);
                }else{
                    Setting::create(['key' => 'country_code', 'value' => $countryCodeForm]);
                }
            }

            if($phoneDB != $phoneForm){
                if($phone){
                    $phone->update(['value' => $phoneForm]);
                }else{
                    Setting::create(['key' => 'phone', 'value' => $phoneForm]);
                }
            }

            if($whatsappDB != $whatsappForm){
                if($whatsapp){
                    $whatsapp->update(['value' => $whatsappForm]);
                }else{
                    Setting::create(['key' => 'whatsapp', 'value' => $whatsappForm]);
                }
            }

            if($hoursWeekDB != $hoursWeekForm){
                if($hoursWeek){
                    $hoursWeek->update(['value' => $hoursWeekForm]);
                }else{
                    Setting::create(['key' => 'hours_week', 'value' => $hoursWeekForm]);
                }
            }
            if($hoursWeekEndDB != $hoursWeekEndForm){
                if($hoursWeekEnd){
                    $hoursWeekEnd->update(['value' => $hoursWeekEndForm]);
                }else{
                    Setting::create(['key' => 'hours_week_end', 'value' => $hoursWeekEndForm]);
                }
            }

            if($emailDB != $emailForm){
                if($email){
                    $email->update(['value' => $emailForm]);
                }else{
                    Setting::create(['key' => 'email', 'value' => $emailForm]);
                }
            }

            if($mapDB != $mapForm){
                if($map){
                    $map->update(['value' => $mapForm]);
                }else{
                    Setting::create(['key' => 'map', 'value' => $mapForm]);
                }
            }

            if($currencySignDB != $currencySignForm){
                if($currencySign){
                    $currencySign->update(['value' => $currencySignForm]);
                }else{
                    Setting::create(['key' => 'currency_sign', 'value' => $currencySignForm]);
                }
            }

            if($currencyIsoCodeDB != $currencyIsoCodeForm){
                if($currencyIsoCode){
                    $currencyIsoCode->update(['value' => $currencyIsoCodeForm]);
                }else{
                    Setting::create(['key' => 'currency_iso_code', 'value' => $currencyIsoCodeForm]);
                }
            }

            if(isset($lightLogoForm)){
                if($lightLogo){
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($lightLogoForm, $lightLogo, 'logo', false, 'update', 'value', true, false, true, false);
                }else{
                    $lightLogo = Setting::create(['key' => 'light_logo']);
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($lightLogoForm, $lightLogo, 'logo', false, 'add', 'value', true, false, false, false);
                }
            }

            if(isset($darkLogoForm)){
                if($darkLogo){
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($darkLogoForm, $darkLogo, 'logo', false, 'update', 'value', true, false, true, false);
                }else{
                    $darkLogo = Setting::create(['key' => 'dark_logo']);
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($darkLogoForm, $darkLogo, 'logo', false, 'add', 'value', true, false, false, false);
                }
            }

            if(isset($faviconForm)){
                if($favicon){
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($faviconForm, $favicon, 'favicon', false, 'update', 'value', true, false, true, false);
                }else{
                    $favicon = Setting::create(['key' => 'favicon']);
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($faviconForm, $favicon, 'favicon', false, 'add', 'value', true, false, false, false);
                }
            }

            if($seoTitleDB != $seoTitleForm){
                if($seoTitle){
                    $seoTitle->update(['value' => $seoTitleForm]);
                }else{
                    Setting::create(['key' => 'seo_title', 'value' => $seoTitleForm]);
                }
            }

            if($seoDescriptionDB != $seoDescriptionForm){
                if($seoDescription){
                    $seoDescription->update(['value' => $seoDescriptionForm]);
                }else{
                    Setting::create(['key' => 'seo_description', 'value' => $seoDescriptionForm]);
                }
            }

            if($seoKeywordsDB != $seoKeywordsForm){
                if($seoKeywords){
                    $seoKeywords->update(['value' => $seoKeywordsForm]);
                }else{
                    Setting::create(['key' => 'seo_keywords', 'value' => $seoKeywordsForm]);
                }
            }

            if($productServicesDB != $productServicesForm){
                if($productServices){
                    $productServices->update(['value' => $productServicesForm]);
                }else{
                    Setting::create(['key' => 'product_services', 'value' => $productServicesForm]);
                }
            }

            if($productAddonDB != $productAddonForm){
                if($productAddon){
                    $productAddon->update(['value' => $productAddonForm]);
                }else{
                    Setting::create(['key' => 'product_addon', 'value' => $productAddonForm]);
                }
            }

            if($localPickupDB != $localPickupForm){
                if($localPickup){
                    $localPickup->update(['value' => $localPickupForm]);
                }else{
                    Setting::create(['key' => 'local_pickup', 'value' => $localPickupForm]);
                }
            }

            if($isEnquiryWebsiteDB != $isEnquiryWebsiteForm){
                if($isEnquiryWebsite){
                    $isEnquiryWebsite->update(['value' => $isEnquiryWebsiteForm]);
                }else{
                    Setting::create(['key' => 'is_enquiry_website', 'value' => $isEnquiryWebsiteForm]);
                }
            }

            if($isEmailVerifyDB != $isEmailVerifyForm){
                if($isEmailVerify){
                    $isEmailVerify->update(['value' => $isEmailVerifyForm]);
                }else{
                    Setting::create(['key' => 'is_email_verify', 'value' => $isEmailVerifyForm]);
                }
            }
            

            Helper::flashMessage(true, 'Settings updated successfully!');

            return redirect()->back();
        }


        $data=array('countries' => $countries, 'countryDB' => $countryDB, 'shippingDB' => $shippingDB, 'reviewsDB' => $reviewsDB, 'couponDB' => $couponDB, 'addressDB' => $addressDB, 'countryCodeDB' => $countryCodeDB, 'phoneDB' => $phoneDB, 'whatsappDB' => $whatsappDB, 'hoursWeekDB' => $hoursWeekDB, 'hoursWeekEndDB' => $hoursWeekEndDB, 'emailDB' => $emailDB, 'mapDB' => $mapDB, 'currencySignDB' => $currencySignDB, 'currencyIsoCodeDB' => $currencyIsoCodeDB, 'lightLogoDB' => $lightLogoDB, 'darkLogoDB' => $darkLogoDB, 'faviconDB' => $faviconDB, 'seoTitleDB' => $seoTitleDB, 'seoDescriptionDB' => $seoDescriptionDB, 'seoKeywordsDB' => $seoKeywordsDB, 'productServicesDB' => $productServicesDB, 'productAddonDB' => $productAddonDB, 'localPickupDB' => $localPickupDB, 'isEnquiryWebsiteDB' => $isEnquiryWebsiteDB, 'isEmailVerifyDB' => $isEmailVerifyDB);
        return view($this->prefix.'.'.$this->folder.'.settings')->with($data);
    }


    // public function country(){
        
    //     $row = Setting::where('key','country')->first();
    //     $data=array('row' => $row);
    //     return view($this->prefix.'.'.$this->folder.'.country')->with($data);
    // }


}
