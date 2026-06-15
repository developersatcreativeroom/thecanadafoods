<?php

namespace App\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Setting;

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


class SocialController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting.social';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function social(Request $request){ 

        $facebookSocial = Setting::where('key','facebook_social')->first();
        $facebookSocialDB = $facebookSocial ? $facebookSocial->value : null;
        
        $instagramSocial = Setting::where('key','instagram_social')->first();
        $instagramSocialDB = $instagramSocial ? $instagramSocial->value : null;

        $twitterSocial = Setting::where('key','twitter_social')->first();
        $twitterSocialDB = $twitterSocial ? $twitterSocial->value : null;
        
        $pinterestSocial = Setting::where('key','pinterest_social')->first();
        $pinterestSocialDB = $pinterestSocial ? $pinterestSocial->value : null;

        $youtubeSocial = Setting::where('key','youtube_social')->first();
        $youtubeSocialDB = $youtubeSocial ? $youtubeSocial->value : null;
        


        if ($request->isMethod('post')) {

            $facebookSocialForm = trim($request->input('facebook_social'));
            $instagramSocialForm = trim($request->input('instagram_social'));
            $twitterSocialForm = trim($request->input('twitter_social'));
            $pinterestSocialForm = trim($request->input('pinterest_social'));
            $youtubeSocialForm = trim($request->input('youtube_social'));

            $validationArray=array(
                'facebook_social'=>'',
            );

            $request->validate($validationArray);
    
            if($facebookSocialDB != $facebookSocialForm){
                if($facebookSocial){
                    $facebookSocial->update(['value' => $facebookSocialForm]);
                }else{
                    Setting::create(['key' => 'facebook_social', 'value' => $facebookSocialForm]);
                }
            }

            if($instagramSocialDB != $instagramSocialForm){
                if($instagramSocial){
                    $instagramSocial->update(['value' => $instagramSocialForm]);
                }else{
                    Setting::create(['key' => 'instagram_social', 'value' => $instagramSocialForm]);
                }
            }

            if($twitterSocialDB != $twitterSocialForm){
                if($twitterSocial){
                    $twitterSocial->update(['value' => $twitterSocialForm]);
                }else{
                    Setting::create(['key' => 'twitter_social', 'value' => $twitterSocialForm]);
                }
            }

            if($pinterestSocialDB != $pinterestSocialForm){
                if($pinterestSocial){
                    $pinterestSocial->update(['value' => $pinterestSocialForm]);
                }else{
                    Setting::create(['key' => 'pinterest_social', 'value' => $pinterestSocialForm]);
                }
            }

            if($youtubeSocialDB != $youtubeSocialForm){
                if($youtubeSocial){
                    $youtubeSocial->update(['value' => $youtubeSocialForm]);
                }else{
                    Setting::create(['key' => 'youtube_social', 'value' => $youtubeSocialForm]);
                }
            }

            Helper::flashMessage(true, 'Social settings added/updated successfully!');
            return redirect()->back();

        }

        $data = array('facebookSocialDB' => $facebookSocialDB, 'instagramSocialDB' => $instagramSocialDB, 'twitterSocialDB' => $twitterSocialDB, 'pinterestSocialDB' => $pinterestSocialDB, 'youtubeSocialDB' => $youtubeSocialDB);
        return view($this->prefix.'.'.$this->folder.'.social')->with($data);
    }



}
