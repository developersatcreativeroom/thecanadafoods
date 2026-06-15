<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

use Hamcrest\Core\SetTest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helper;
use Session;
use DB;
use Mail;
use Hash;
use Image;


class CkeditorController extends Controller implements HasMiddleware
{
    public $successStatus=200;
    private $prefix = 'admin';
    private $pagerecords;

    public function __construct(){
    	// $this->middleware('admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    public function upload(Request $request)
    {
        

        $image = $request->file('upload');
        if($image->getMimeType()=='image/jpeg'){
            $fName=$image->getClientOriginalName();
            $arr=explode('.',$fName);
            $extVal=end($arr);
            $extension='.'.$extVal;
        }else if($image->getMimeType()=='image/png'){
            $extension='.png';
        }
        else{
            $extension = '.'.$image->getClientOriginalExtension();
        }
        $name=md5(time()+rand(10,1000));
        Storage::disk('public')->put('ckeditor/'.$name.$extension,file::get($image));

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        //$url = asset('storage/uploads/'.$filenametostore); 
        $url = asset('storage/ckeditor/'.$name.$extension);
        $msg = 'Image successfully uploaded'; 
        $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
          
        // Render HTML output 
        @header('Content-type: text/html; charset=utf-8'); 
        echo $re;

        
        
        //return response()->json(['fileName' => $name.$extension, 'uploaded'=> 1, 'url' => asset('storage/ckeditor/').'/'.$name.$extension]);
    }
    
    
}

