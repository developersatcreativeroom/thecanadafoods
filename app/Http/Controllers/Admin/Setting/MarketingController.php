<?php

namespace App\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\SocialMarketing;

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


class MarketingController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting.marketing';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }
    
    public function facebook(Request $request){ 

        $facebookPixel = SocialMarketing::where('type','facebook')->first();
        //print_r($facebookPixel); die;
        

        if ($request->isMethod('post')) {

            $status = trim($request->input('status'));
            $pixelScript = trim($request->input('pixel_script'));

            $validationArray=array(
                'status'=>''
            );

            if($status == 'on'){
                $validationArray['pixel_script']='required';
            }

            //print $countryForm; die;
    
            $request->validate($validationArray);

            $statusDB = ($status == 'on') ? 1 : 0;


            if($facebookPixel){
                $facebookPixel->update(['script' => $pixelScript, 'status' => $statusDB]);
            }else{
                $pixelScript = SocialMarketing::create(['type' => 'facebook', 'script' => $pixelScript, 'status' => $statusDB]);
            }
                
            Helper::flashMessage(true, 'Facebook pixel added/updated successfully!');

            return redirect()->back();


        }

        $data = array('facebookPixel' => $facebookPixel);
        return view($this->prefix.'.'.$this->folder.'.marketing')->with($data);
    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        
        $row = Seo::find($id);
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $page = trim($request->input('page'));
        $seoTitle = trim($request->input('seo_title'));
        $seoDescription = trim($request->input('seo_description'));
        //print $id; die;

        $validationArray=array(
            //'page'=>'required',
            'seo_title'=>'required',
            'seo_description'=>'required',
        );

        if(empty($id)){
            $validationArray['page'] = 'required|unique:seo,page';
        }else{
            $validationArray['page'] = 'required|unique:seo,page,'.$id;
        }
        
        $request->validate($validationArray);

        DB::beginTransaction();

        
        if(empty($id)){
            $seo = Seo::create(['page'=>$page, 'seo_title'=>$seoTitle, 'seo_description'=>$seoDescription]);
        }else{
            $seo = Seo::find($id);

            $seo->page = $page;
            $seo->seo_title = $seoTitle;
            $seo->seo_description = $seoDescription;
            $seo->save();
        }

        if($seo){
            DB::commit();
            Helper::flashMessage(true, 'Seo added/updated successfully!');
            return to_route('admin.settings.seo.list');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Seo::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.settings.seo.list');
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Seo deleted successfully!');
            return to_route('admin.settings.seo.list');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


}
