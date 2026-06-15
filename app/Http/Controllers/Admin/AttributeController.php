<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\ProductAttributeDetail;

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


class AttributeController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'attribute';

    public function  __construct(){
        $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function list(Request $request){ 
        $page = $request->page;
        $rows = Attribute::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Attribute::with('options')->find($id);
        if($row == null){
            return to_route('admin.attributes');
        }
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $options = $request->input('options');
        //$keyword = trim($request->input('keyword'));

        //if(empty($id)){
            $validationArray=array(
                //'name'=>'required',
                //'keyword'=>'required'
                'options'=>'required|array',
                'options.*'=>'required|min:1',
            );

            if(empty($id)){
                $validationArray['name'] = 'required|unique:attributes,name,';
            }else{
                $validationArray['name'] = 'required|unique:attributes,name,'.$id;
            }
            
            $request->validate($validationArray);
            //print 'a'; die;
            
            $keyword = preg_replace('/\s+/', '_', $name);
            $keyword = strtolower($keyword);

            $name = ucfirst($name);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'keyword'=>$keyword];
                $attribute = Attribute::create($insertRow);
            }else{
                $attribute = Attribute::find($id);
                $attribute->name = $name;
                $attribute->keyword = $keyword;
                $attribute->save();
            }

            if(count($options) > 0){
                foreach($options as $option){
                    $optionKeyword = preg_replace('/\s+/', '_', $option);
                    $optionKeyword = strtolower($optionKeyword);
                    $option = ucfirst($option);
                    if($attribute->options()->where('name', $option)->count() == 0){
                        $attribute->options()->create(['name' => $option, 'keyword' => $optionKeyword]);
                    }
                }
                
            }
           
            if($attribute){
                DB::commit();
                Helper::flashMessage(true, 'Attribute added/updated successfully!');
                return to_route('admin.attributes');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Attribute::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.attributes');
        }

        $productCount = ProductAttributeDetail::where('attribute_id',$row->id)->count();
        if($productCount > 0){
            Helper::flashMessage(false, 'Product(s) added to the attribute, please remove product from the attribute first');
            return redirect()->back();
        }

        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Attribute deleted successfully!');
            return to_route('admin.attributes');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

    public function deleteAttributeOption(Request $request){
        $id = trim($request->attr);
        //print $id; die;

        $row = AttributeOption::find($id);
        //print 'a'; die;
        if(!$row){
            return array('result' => false, 'message' => 'Attribute option does not exist');
        }

        $productCount = ProductAttributeDetail::where('attribute_option_id',$row->id)->count();
        if($productCount > 0){
            return array('result' => false, 'message' => 'Product(s) added to the attribute option, please remove product from the attribute option first');
        }
        $row->delete();
        
        if($row){
            return array('result' => true, 'message' => 'Attribute option deleted successfully!');
        }else{
            return array('result' => false, 'message' => 'Something went wrong');
        }
    }

    

}
