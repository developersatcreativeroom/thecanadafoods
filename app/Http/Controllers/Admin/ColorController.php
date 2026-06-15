<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Color;
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


class ColorController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'color';

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
        $rows = Color::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        $categories = Helper::getCategories();
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Color::find($id);
        if($row == null){
            return to_route('admin.colors');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $code = trim($request->input('code'));

        //if(empty($id)){
            $validationArray=array(
                //'name'=>'required',
                'code'=>'required'
            );

            if(empty($id)){
                $validationArray['name'] = 'required|unique:colors,name,';
            }else{
                $validationArray['name'] = 'required|unique:colors,name,'.$id;
            }
            
            // $this->validate($request, $validationArray);
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'code'=>$code];
                $color = Color::create($insertRow);
            }else{
                $color = Color::find($id);
                $color->name = $name;
                $color->code = $code;
                $color->save();
            }
           
            if($color){
                DB::commit();
                Helper::flashMessage(true, 'Color added/updated successfully!');
                return to_route('admin.colors');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Color::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.colors');
        }

        $productCount = Product::where('color_id',$row->id)->count();
        if($productCount > 0){
            Helper::flashMessage(false, 'Product(s) added to the color, please remove product from the color first');
            return redirect()->back();
        }

        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Color deleted successfully!');
            return to_route('admin.colors');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
