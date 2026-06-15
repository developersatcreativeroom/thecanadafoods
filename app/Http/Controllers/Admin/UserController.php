<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\User;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUser;

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


class UserController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'user';

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
        $rows = User::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function filter(Request $request){ 
        $page = $request->page;
        $search = $request->search;
        $clear = $request->clear;

        $query = User::latest();
       
        if($search){

            $query->where( function ($subQuery) use ($search) {
                // $subQuery->where('enquiries.full_name','like','%'.$search.'%');
                $subQuery->fullName($search);
                $subQuery->orWhere('first_name','like','%'.$search.'%');
                $subQuery->orWhere('last_name','like','%'.$search.'%');
                $subQuery->orWhere('email','like','%'.$search.'%');
                $subQuery->orWhere('phone','like','%'.$search.'%');
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

    public function export(Request $request){
        return Excel::download(new ExportUser, 'Users.xlsx');
    }

}
