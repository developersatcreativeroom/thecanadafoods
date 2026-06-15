<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Permission;

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

use App\Mail\SendForgotPasswordRecoveryLinkToAdminUser;

class AdminUserController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'subadminuser';

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
        $rows = Admin::where('level',1)->latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        $permissions = Permission::get();
        $data=array('permissions' =>$permissions);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Admin::where('level',1)->find($id);
        if($row == null){
            return to_route('admin.sub.users');
        }
        $permissions = Permission::get();
        $data=array('row' => $row, 'permissions' => $permissions);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $username = trim($request->input('username'));
        $password = $request->input('password') ? $request->input('password') : null;
        $email = trim($request->input('email'));
        $image = $request->file('image');
        $roleID = trim($request->input('role_id'));
        $status = trim($request->input('status'));

        //if(empty($id)){
            $validationArray=array(
                'name'=>'required',
                'image'=>'mimes:jpeg,jpg,png',
                'role_id'=>'required',
                'status'=>'required'
            );
            
            if(empty($id)){
                $validationArray['username'] = 'required|unique:admins,username,';
                $validationArray['email'] = 'required|email|unique:admins,email,';
                $validationArray['password'] = 'required';
                //'images'=>'required|array',
            }else{
                $validationArray['username'] = 'required|unique:admins,username,'.$id;
                $validationArray['email'] = 'required|email|unique:admins,email,'.$id;
                $validationArray['password'] = '';
            }
            
            $request->validate($validationArray);


            DB::beginTransaction();
            //print $price; die;

            if($password != null){
                $password = Hash::make($password);
            }
            

            if(empty($id)){
                $insertRow = ['name'=>$name, 'username'=>$username, 'email'=>$email, 'password'=>$password,'role_id' => $roleID,'status'=>$status,'level'=>1];
                $adminSubUser = Admin::create($insertRow);
            }else{
                $adminSubUser = Admin::where('level',1)->find($id);
                $adminSubUser->name = $name;
                $adminSubUser->username = $username;
                if($password != null){
                    $adminSubUser->password = $password;
                }
                $adminSubUser->email = $email;
                $adminSubUser->role_id = $roleID;
                $adminSubUser->status = $status;
                $adminSubUser->save();
            }

            $operation = empty($id) ? 'add' : 'update';

            // add products images here start
            if(isset($image)){
                // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                Helper::uploadImage($image, $adminSubUser, 'admin/profile', false, $operation, 'image', true, true, true, false);
            }
           
            if($adminSubUser){
                DB::commit();
                Helper::flashMessage(true, 'Admin Sub User added/updated successfully!');
                return to_route('admin.sub.users');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Admin::where('level',1)->find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.sub.users');
        }
      
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Admin Sub User deleted successfully!');
            return to_route('admin.sub.users');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

    public function filter(Request $request){ 
        $page = $request->page;
        $search = $request->search;
        $clear = $request->clear;

        $query = Admin::latest();
       
        $query->where('level',1);

        if($search){
            $query->where( function ($subQuery) use ($search) {
                $subQuery->where('name','like','%'.$search.'%');
                $subQuery->orWhere('username','like','%'.$search.'%');
                $subQuery->orWhere('email','like','%'.$search.'%');
            });
        }

        if($clear == 'true'){
            $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page);
        }else{
            $rows = $query->get();
        }
        //print '<pre>'; print_r($rows->toArray()); die;
        return array('html' => (String)View::make($this->prefix.'.'.$this->folder.'.rows')->with(compact('rows')));
    }

}
