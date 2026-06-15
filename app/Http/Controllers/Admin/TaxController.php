<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Tax;
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


class TaxController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'tax';

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
        $rows = Tax::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){
        $countrySetting = Helper::getCountry();
        $data=array('countrySetting'=>$countrySetting);
        //print '<pre>'; print_r($data); die;
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        //print '<pre>'; print_r($attributes[0]['values']); die;
        //$product = Coupon::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
        $row = Tax::find($id);
        if($row == null){
            return to_route('admin.taxes');
        }
        $countrySetting = Helper::getCountry();
        $data=array('row' => $row, 'countrySetting'=>$countrySetting);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $name = trim($request->input('name'));

        $stateTaxName = $request->input('state_tax_name') ? trim($request->input('state_tax_name')) : null;
        $stateTax = $request->input('state_tax') ? trim($request->input('state_tax')) : null;
        $centralTaxName = $request->input('central_tax_name') ? trim($request->input('central_tax_name')) : null;
        $centralTax = $request->input('central_tax') ? trim($request->input('central_tax')) : null;
        $integratedTaxName = $request->input('integrated_tax_name') ? trim($request->input('integrated_tax_name')) : null;
        $integratedTax = $request->input('integrated_tax') ? trim($request->input('integrated_tax')) : null;

        $tax = trim($request->input('tax'));
        $description = trim($request->input('description'));
        $status = trim($request->input('status'));


        $countrySetting = Helper::getCountry();

        //if(empty($id)){
            $validationArray=array(
                //'name'=>'required',
                'tax'=>'required',
                'description'=>'',
                'status'=>'required',
            );

            if($countrySetting == 'IN'){
                $validationArray['state_tax_name'] = 'required';
                $validationArray['state_tax'] = 'required';
                $validationArray['central_tax_name'] = 'required';
                $validationArray['central_tax'] = 'required';
                $validationArray['integrated_tax_name'] = 'required';
                $validationArray['integrated_tax'] = 'required';
            }
            // else{
            //     $validationArray['tax'] = 'required';
            // }

            if(empty($id)){
                $validationArray['name'] = 'required|unique:taxes,name,';
            }else{
                $validationArray['name'] = 'required|unique:taxes,name,'.$id;
            }
            
            $request->validate($validationArray);

            DB::beginTransaction();
            //print $price; die;

            if(empty($id)){
                $insertRow = ['name'=>$name, 'tax'=>$tax, 'state_tax_name'=>$stateTaxName, 'state_tax'=>$stateTax, 'central_tax_name'=>$centralTaxName, 'central_tax'=>$centralTax, 'integrated_tax_name'=>$integratedTaxName, 'integrated_tax'=>$integratedTax, 'description'=>$description, 'status'=>$status];
                $taxRow = Tax::create($insertRow);
            }else{
                $taxRow = Tax::find($id);
                $taxRow->name = $name;
                $taxRow->tax = $tax;
                $taxRow->state_tax_name = $stateTaxName;
                $taxRow->state_tax = $stateTax;
                $taxRow->central_tax_name = $centralTaxName;
                $taxRow->central_tax = $centralTax;
                $taxRow->integrated_tax_name = $integratedTaxName;
                $taxRow->integrated_tax = $integratedTax;
                $taxRow->description = $description;
                $taxRow->status = $status;
                $taxRow->save();
            }
           
            if($taxRow){
                DB::commit();
                Helper::flashMessage(true, 'Tax added/updated successfully!');
                return to_route('admin.taxes');
            }else{
                DB::rollBack();
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back();
            }
        
    }


    public function delete(Request $request){
        $id = trim($request->id);
        $row = Tax::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.taxes');
        }

        $productCount = Product::where('tax_id',$row->id)->count();
        if($productCount > 0){
            Helper::flashMessage(false, 'Product(s) added to the tax, please remove product from the tax first');
            return redirect()->back();
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Tax deleted successfully!');
            return to_route('admin.taxes');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
