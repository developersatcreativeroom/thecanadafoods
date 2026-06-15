<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

use App\Models\Permission;
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


class PermissionController extends Controller implements HasMiddleware
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'permission';

    public function __construct(){
    	// $this->middleware('admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    public function list(Request $request){
        $page = $request->page;
        $rows = Permission::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        $data = array('rows' => $rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        $row = Permission::where('id',$id)->first();
        $row->permission = unserialize($row->permission);
        $data = array('row'=>$row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){


        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $permission = $request->input('permission');
        // print '<pre>'; print_r($permission); die;


        $validationArray=array(
            'permission' => 'required|array',
            'permission.*' => 'required|min:1',
            //'permission.*' => 'required'
        ); 

        if(empty($id)){
            $validationArray['name']='required|unique:permissions,name';
        }else{
            $validationArray['name']='required|unique:permissions,name,'.$id;
        }

        $request->validate($validationArray);

        if(!isset($permission)){
            Helper::flashMessage(false,'Please select atleast one permission!');
            return redirect()->back();
        }
        // (is_array($permission) && count($permission) < 1


        $permission = serialize($permission);

        if(empty($id)){
            $permissionDB=Permission::create(['name'=>$name,'permission'=>$permission]);

        }else{
            $permissionDB=Permission::find($id);
            $permissionDB->name = $name;
            $permissionDB->permission = $permission;
            $permissionDB->save();
        }
    
        if($permissionDB){
            Helper::flashMessage(true,'Permission added/updated successfully!');
            return to_route('admin.permissions');
        }else{
            Helper::flashMessage(false,'Something went wrong');
            return redirect()->back();
        }
    }

    public function deleteRole($id){

        $permissionDB = Permission::find($id);
        if(!$permissionDB){
            return to_route('admin.permissions');
        }

        $permissionDB->delete();
    
        Helper::flashMessage(true,'Permission deleted successfully!');
        return to_route('admin.permissions');

    }

    
}