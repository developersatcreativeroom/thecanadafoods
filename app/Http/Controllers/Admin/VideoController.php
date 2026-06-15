<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Video;

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


class VideoController extends Controller implements HasMiddleware
{   
    private $videorecords;
    private $prefix = 'admin';
    private $folder = 'video';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->videorecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function list(Request $request){ 
        $video = $request->video;
        $rows = Video::latest()->paginate($this->videorecords, ['*'], 'video', $video);
        //print '<pre>'; print_r($rows); die;
        $data=array('rows'=>$rows);
        return view($this->prefix.'.'.$this->folder.'.list')->with($data);
    }

    public function add(){
        return view($this->prefix.'.'.$this->folder.'.form');
    }

    public function edit($id){
        
        $row = Video::find($id);
        
        $data=array('row' => $row);
        return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    }

    public function postData(Request $request){
        $id = trim($request->input('id'));
        $link = trim($request->input('video'));
        $status = trim($request->input('status'));
        //print $id; die;
        

        $validationArray=array(
            'video'=>'required',
            'status'=>'required',
        );
        
        $request->validate($validationArray);
        //die;

        DB::beginTransaction();


        //$link = "http://www.youtube.com/watch?v=oHg5SJYRHA0&lololo";
        $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
        if (empty($video_id[1]))
            $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

        $video_id = explode("&", $video_id[1]); // Deleting any other params
        $videoID = $video_id[0];
        
        if(empty($id)){
            $video = Video::create(['video'=>$videoID, 'status'=>$status]);
        }else{
            $video = Video::find($id);

            $video->video = $videoID;
            $video->status = $status;
            $video->save();
        }

        if($video){
            DB::commit();
            Helper::flashMessage(true, 'Video added/updated successfully!');
            return to_route('admin.videos');
        }else{
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request){
        $id = trim($request->id);
        $row = Video::find($id);
        if(!$row){
            return to_route('admin.videos');
        }
        $row->delete();
        
        if($row){
            Helper::flashMessage(true, 'Video deleted successfully!');
            return to_route('admin.videos');
        }else{
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }

}
