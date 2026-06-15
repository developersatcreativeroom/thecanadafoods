<?php

namespace App\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Setting;

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


class AccountingController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting.accounting';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function accounting(Request $request){ 

        $isXero = Setting::where('key','is_xero')->first();
        $isXeroDB = $isXero ? $isXero->value : null;

        if ($request->isMethod('post')) {

            $isXeroForm = $request->input('is_xero');

            $validationArray=array(
                'is_xero'=>'',
            );

            $request->validate($validationArray);

            $isXeroFormDB = ($isXeroForm == 'on') ? true : false;
            
    
            if($isXeroDB != $isXeroFormDB){
                if($isXero){
                    $isXero->update(['value' => $isXeroFormDB]);
                }else{
                    Setting::create(['key' => 'is_xero', 'value' => $isXeroFormDB]);
                }
            }
            
            Helper::flashMessage(true, 'Account settings added/updated successfully!');
            return redirect()->back();

        }

        $data = array('isXeroDB' => $isXeroDB);
        return view($this->prefix.'.'.$this->folder.'.accounting')->with($data);
    }



}
