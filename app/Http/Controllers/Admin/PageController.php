<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Page;
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


class PageController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'page';

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
        $rows = Page::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        
        $row = Page::find($id);
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $title = trim($request->input('title'));
        $slug = trim($request->input('slug'));
        $description = trim($request->input('description'));
        $status = trim($request->input('status'));
        //print $id; die;

        $validationArray=array(
            'title'=>'required',
            'description'=>'required',
            'status'=>'required',
            
        );

        if(empty($id)){
            $validationArray['slug'] = 'required|unique:pages,slug';
        }else{
            $validationArray['slug'] = 'required|unique:pages,slug,'.$id;
        }
        
        $request->validate($validationArray);

        DB::beginTransaction();

        $slug = preg_replace('/\s+/', '-', $slug);
        
        if(empty($id)){
            $page = Page::create(['title'=>$title, 'slug'=>$slug, 'description'=>$description, 'status'=>$status]);
        }else{
            $page = Page::find($id);

            $page->title = $title;
            $page->slug = $slug;
            $page->description = $description;
            $page->status = $status;
            $page->save();
        }

        if($page){
            DB::commit();
            Helper::flashMessage(true, 'Page added/updated successfully!');
            return to_route('admin.pages');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Page::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.pages');
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Page deleted successfully!');
            return to_route('admin.pages');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


}
