<?php

namespace App\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Seo;
use App\Models\Tax;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;

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


class SeoController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting.seo';

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
        $rows = Seo::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
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
        $seoKeywords = trim($request->input('seo_keywords'));
        //print $id; die;

        $validationArray=array(
            //'page'=>'required',
            'seo_title'=>'required',
            'seo_description'=>'required',
            'seo_keywords'=>'required',
        );

        if(empty($id)){
            $validationArray['page'] = 'required|unique:seo,page';
        }else{
            $validationArray['page'] = 'required|unique:seo,page,'.$id;
        }
        
        $request->validate($validationArray);

        DB::beginTransaction();

        
        if(empty($id)){
            $seo = Seo::create(['page'=>$page, 'seo_title'=>$seoTitle, 'seo_description'=>$seoDescription, 'seo_keywords'=>$seoKeywords]);
        }else{
            $seo = Seo::find($id);

            $seo->page = $page;
            $seo->seo_title = $seoTitle;
            $seo->seo_description = $seoDescription;
            $seo->seo_keywords = $seoKeywords;
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
