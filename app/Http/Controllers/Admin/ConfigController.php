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


class ConfigController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'config';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }


    public function config(Request $request){

        $minCartAmount = Setting::where('key','min_cart_amount')->first();
        $minCartAmountDB = $minCartAmount ? $minCartAmount->value : null;


        if ($request->isMethod('post')) {

            $minCartAmountForm = trim($request->input('min_cart_amount'));

            $validationArray=array(
                'min_cart_amount'=>'nullable|numeric',
            );

            //print $countryForm; die;
    
            $request->validate($validationArray);
    
            if($minCartAmountDB != $minCartAmountForm){
                if($minCartAmount){
                    $minCartAmount->update(['value' => $minCartAmountForm]);
                }else{
                    Setting::create(['key' => 'min_cart_amount', 'value' => $minCartAmountForm]);
                }
            }
            
            Helper::flashMessage(true, 'Configuration updated successfully!');

            return redirect()->back();
        }


        $data=array('minCartAmountDB' => $minCartAmountDB);
        return view($this->prefix.'.'.$this->folder.'.config')->with($data);
    }


    // public function country(){
        
    //     $row = Setting::where('key','country')->first();
    //     $data=array('row' => $row);
    //     return view($this->prefix.'.'.$this->folder.'.country')->with($data);
    // }


}
