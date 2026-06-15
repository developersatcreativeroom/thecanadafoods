<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Helper;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminFaqController extends Controller
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'faq';

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
        $query = Faq::latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page); 
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){        
        $data=array();
        $categorys = Category::where('status', 1)->get();
        $data['categorys'] = $categorys;
        $blogs = Blog::where('status', 1)->get();
        $data['blogs'] = $blogs;
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function edit($id){
        $row = Faq::find($id);
        if($row == null){
            return to_route('admin.faqs');
        }
        $data=array('row' => $row);
        $categorys = Category::where('status', 1)->get();
        $data['categorys'] = $categorys;
        $blogs = Blog::where('status', 1)->get();
        $data['blogs'] = $blogs;
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $question = trim($request->input('question'));
        $answer = trim($request->input('answer'));
        $type = trim($request->input('type'));
        $type_id = trim($request->input('type_id'));
        $status = trim($request->input('status'));
 
        $validationArray=array(
            'question'=>'required',
            'answer'=>'required',
            'type'=>'required',
            'type_id'=>'required',
            'status'=>'required'
        );      
        $request->validate($validationArray);
        
        DB::beginTransaction();
        if(empty($id)){
            $faq = Faq::create([
                'question'=>$question, 
                'answer'=>$answer, 
                'type'=>$type, 
                'type_id'=>$type_id, 
                'status'=>$status
            ]);
        }else{
            $faq = Faq::find($id);
            $faq->question = $question;
            $faq->answer = $answer;
            $faq->type = $type;
            $faq->type_id = $type_id;
            $faq->status = $status;
            $faq->save();
        }            
        
        if($faq){
            DB::commit();
            Helper::flashMessage(true, 'Faq added/updated successfully!');
            return to_route('admin.faqs');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Faq::find($id);
        //print 'a'; die;
        if(!$row){
            return to_route('admin.faqs');
        }
      
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Faq deleted successfully!');
            return to_route('admin.faqs');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }
}
