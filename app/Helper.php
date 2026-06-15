<?php
namespace App;

use App\Models\User;
use App\Models\Category;
use App\Models\Seo;
use App\Models\Country;
use App\Models\State;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeDetail;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\OrderProduct;
use App\Models\UserCoupon;
use App\Models\Tax;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Page;
use App\Models\InventoryLog;
use App\Models\Setting;
use App\Models\SocialMarketing;
use App\Models\ShippingPrice;
use App\Models\Coupon;
use App\Models\Order;

use Gregwar\Image\Image;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeCheckoutSession;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\ValidateImportProduct;


use Twilio\Rest\Client;
use Carbon\Carbon;
use Auth;
use Session;
use DB;
use Arr;
use Route;
use Storage;
use Str;

use Illuminate\Support\Facades\File;

use Mail;
use App\Mail\CustomerOrder;
use App\Mail\AdminOrder;
use Illuminate\Support\Facades\URL;

class Helper
{


    public static function abc(){
        print 'a'; die;
    }
    public static function universalDateTimeFormat(){
        return 'd-m-Y, H:i';
    }
    public static function universalDateFormat(){
        return 'd M, Y';
    }

    public static function formatStringDate($date, $time = false) {
        if ($date) {
            $dateTime = new \DateTime($date);
            if(!$time){
                return $dateTime->format(self::universalDateFormat());
            }else{
                return $dateTime->format(self::universalDateTimeFormat());
            }
        }
        return '';
    }
    public static function getCategories(){
        $categories = Category::where('level',0)->where('status',1)->get()->toArray();
        foreach($categories as $key => $category){
            $categories[$key]['children'] = Category::where('level',1)->where('status',1)->where('parent_category_id',$category['id'])->get()->toArray();

            foreach($categories[$key]['children'] as $k => $subCategory){
                $categories[$key]['children'][$k]['children'] = Category::where('level',2)->where('status',1)->where('parent_category_id',$subCategory['id'])->get()->toArray();
            }
            //$categories[$key]['children'] = $array;
        }

        return $categories;
    }

    public static function getCategoriesList($limit = null){
        // $categories = Category::where('status',1)->get();
        $categoryObj = Category::where('status',1);
        if($limit){
            $categoryObj->limit($limit);
        }
        $categories = $categoryObj->get();
        return $categories;
    }

    public static function getCategoriesNav($nav=false) {
        $rows = Category::where('status', 1)->orderBy('priority', 'asc');
        if($nav){
            $rows = $rows->where('is_main_nav', 1);
        } else{
            $rows = $rows->where('is_main_nav', '!=',  1);
        }        
        $rows = $rows->get(); 
        return $rows;
    } 


    public static function getCountries($limit = null){
        return Country::where('status', true)->get();
    }
    

    
    public static function isPreviousProductImageDelete($productID){
        if(OrderProduct::where('product_id',$productID)->count() > 0){
            return false;
        }else{
            return true;
        }
    }

    public static function uploadImage($image, $model, $directory, $isDirectoryID, $operation, $columnName ,$isColumn = false, $isThumb = false, $deletePrevImage = true, $subFolderID = false){
        
        if($image->getMimeType()=='image/jpeg'){
            $fName=$image->getClientOriginalName();
            $arr=explode('.',$fName);
            $extVal=end($arr);
            $extension='.'.$extVal;
        }else if($image->getMimeType()=='image/png'){
            $extension='.png';
        }else{
            $extension = '.'.$image->getClientOriginalExtension(); 
        }

        $name=md5(time()+rand(10,1000));
        $saveName=$name.$extension;

        // if(extension_loaded("exif")){
        //     $exif = exif_read_data($files[$key]['image']);
        //     //print '<pre>'; print_r($exif); die;
        //     if(!empty($exif['Orientation'])) {
        //         switch($exif['Orientation']) {
        //             case 8:
        //                 $files[$key]['image'] = imagerotate($files[$key]['image'],90,0);
        //                 break;
        //             case 3:
        //                 $files[$key]['image'] = imagerotate($files[$key]['image'],180,0);
        //                 break;
        //             case 6:
        //                 $files[$key]['image'] = imagerotate($files[$key]['image'],-90,0);
        //                 break;
        //         }
        //     }
        // }

        $finalDirectory = $directory;

        if($isDirectoryID){
            $rowIDFolder = $subFolderID ? $subFolderID : $model->id;
            $finalDirectory = $directory.'/'.$rowIDFolder;
        }
        //print $finalDirectory; die;
                
        // $imageOld = $model->image;
        // Storage::disk('public')->delete('products/'.$rowIDFolder.'/'.$imageOld);
        // Storage::disk('public')->delete('products/'.$rowIDFolder.'/thumb/'.$imageOld);

        if($operation == 'update' && $deletePrevImage){
            
            if(isset($model->{$columnName})){
                $imageOld = $model->{$columnName};
                //print $finalDirectory.'/'.$imageOld; die;
                Storage::disk('public')->delete($finalDirectory.'/'.$imageOld);
                if($isThumb){
                    Storage::disk('public')->delete($finalDirectory.'/thumb/'.$imageOld);
                }
            }
        }

        Storage::disk('public')->put($finalDirectory.'/'.$saveName,file::get($image));
        
        if($isThumb){
            $thumb = Image::open($image->getRealPath())
                    ->resize(320, 320)
                    ->get(); // Get image as binary data

            Storage::disk('public')->put($finalDirectory.'/thumb/'.$saveName,  (string) $thumb);
        }

        if($isColumn){
            $model->{$columnName} = $saveName;
            $model->save();
        }else{
            $model->create([$columnName=>$saveName]);
        }

        return $saveName;
         
    }

    public static function uploadImages($images, $model, $directory,  $isDirectoryID, $operation, $columnName, $isColumn, $isThumb, $deletePrevImage, $subFolderID){
        
        foreach($images as $image){
            // image, model, directory, is_directory_id, add_or_update, is_column_update, is_thumb, delete_prev_image, sub_folder_id
            Self::uploadImage($image, $model, $directory,  $isDirectoryID, $operation, $columnName, $isColumn, $isThumb, $deletePrevImage, $subFolderID);
        }
        
    }

    public static function deleteImage($model, $directory, $isThumb = false){
        //print '<pre>'; print_r($model); die;
        $storageDirectory = $directory.'/'.$model->id;
        Storage::disk('public')->delete($storageDirectory.'/'.$model->image);
        if($isThumb){
            Storage::disk('public')->delete($storageDirectory.'/'.'/thumb/'.$model->image);
        }
        
        $files = Storage::disk('public')->files($storageDirectory);
        //print '<pre>'; print_r($files); die;
        if(count($files) <= 0){
            Storage::disk('public')->deleteDirectory($storageDirectory);
        }
    }

    public static function createSlug($model,$column)
    {
        $slug = Str::slug($column);
        $count = $model::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public static function combinations($arrays, $level, $i = 0) {
        //
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = self::combinations($arrays, $level, $i + 1);
        $result = array();
        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $kk => $v) {
            foreach ($tmp as $t) {
                // if(is_array($t)){
                //     print 'Level:'.$level.' ';
                //     if($i == $level){
                //         $result[] = array_merge(array($v), array($t));
                //     }else{
                //         $result[] = array_merge(array($v), $t);
                //     }
                // }

                //$result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
                $result[] = is_array($t) ? ($i == $level ? array_merge(array($v), array($t)) : array_merge(array($v), $t))  : array($v, $t);
                
            }
        }
    
        return $result;
    }


    public static function getLevel($arrays, $i = 0, $level = null) {
        
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }
        $level = $i;
        $levelReturn = self::getLevel($arrays, $i + 1, $level);

        if(!is_array($levelReturn) && ($levelReturn > $level)){
            $level = $levelReturn;
        }
        //print 'Level:'.$level.' ' ;
        return $level;
    }

    public static function getProductHtml($product) {


        $html = '
                <div class="vertical-product-card rounded-2 position-relative">';

                    if($product->getPercentageDiscount()){
                        $html .= '<span class="offer-badge text-white fw-bold fs-xxs bg-danger position-absolute start-0 top-0">-'.$product->getPercentageDiscount().'</span>';
                    }

                    $html .= '<div class="position-absolute end-0 top-0 z-1">';
                            if($product->is_sale){
                                $html .= '<span class="badge bg-success ms-1">Sale</span>';
                            }
                            if($product->is_new){
                                $html .= '<span class="badge bg-info ms-1">New</span>';
                            }
                            if($product->is_hot){
                                $html .= '<span class="badge bg-warning ms-1">Hot</span>';
                            }
                            if($product->is_best_sell){
                                $html .= '<span class="badge bg-danger ms-1">Best Sell</span>';
                            }

                    $html .= '</div>';
                    
                    $html .= '<div class="thumbnail position-relative text-center m-sm-4">
                        <a href="'.route('product',$product->slug).'"><img src="'. URL::asset('frontend/img/image-loading.gif') .'" data-src="'. asset('storage/products/').'/'.$product->id.'/thumb/'.$product->image.'" alt="' . ($product->image_alt ? $product->image_alt : $product->name) . '"  class="img-fluid lazyload"></a>

                        <div class="product-btns position-absolute d-flex gap-2 flex-column">';
                        
                        $alreadyWishlist = Self::alreadyInWishlist($product);

                        if(!$product->is_variant){
                            if($alreadyWishlist){

                                $html .= '<a href="#" class="rounded-btn active add-wishlist" data-key="'.$product->slug.'"><i class="fa-regular fa-heart"></i></a>';

                            }else{
                                $html .= '<a href="#" class="rounded-btn add-wishlist" data-key="'.$product->slug.'"><i class="fa-regular fa-heart"></i></a>';
                            }
                        }else{
                            // $html .= '<a aria-label="View Product" class="action-btn hover-up" href="'.route('product',$product->slug).'" ><i class="fi-rs-eye"></i></a>';
                        }

                        

                        $html .= '
                            <a href="'.route('product',$product->slug).'" class="rounded-btn"><i class="fa-regular fa-eye"></i></a>
                            
                        </div>
                    </div>
                    <div class="card-content p-mv-2">';
                    
                    
                        $html .= '<a href="'.route('product',$product->slug).'" class="mb-2 d-inline-block text-secondary fw-semibold fs-xxs">';
                        foreach($product->categories as $key => $category){
                            $html .= $category->name; 
                                if($key < (count($product->categories) - 1)){
                                    $html .= '|';
                                }
                            }
                        $html .= '</a>';
                        
                        if(Self::getReviewShowStatus()){
                            if($product->average_rating_percentage > 0){
                                $html .= '<div class="rating-result" >
                                    <div class="d-flex align-items-center flex-nowrap star-rating fs-xxs mb-2">
                                        <span class="badge text-bg-secondary text-white verified-badge"> <a href="#reviews_section" class="text-white"><i class="fas fa-star"></i> '.$product->average_rating.'</a></span> &nbsp;
                                    </div>
                                </div>';

                                // <div class="d-flex align-items-center flex-nowrap star-rating fs-xxs mb-2">
                                //     <ul class="d-flex align-items-center me-2">
                                //         <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                //         <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                //         <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                //         <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                //         <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                //     </ul>
                                //     <span class="flex-shrink-0">(5.2k Reviews)</span>
                                // </div>

                            }else{
                                $html .= '<div class="">
                                    <small class="text-muted">No reviews</small>
                                </div>';
                            }
                        }
                        
                        
                        $html .= '<a href="'.route('product',$product->slug).'" class="card-title fw-bold d-block text-limit-2 mb-2">'.$product->name.'</a>';

                        

                        $html .='<div class="d-flex">';
                        if($product->getOldPrice()){
                            $html .= '<h6 class="deleted me-1">'.$product->getOldPrice().'</h6>';
                        }

                        $html .='<h6 class="price text-secondary mb-3">'.$product->getPrice().'';
                        if($product->is_tax_included){
                                $html .= '<small class="font-xxs"> (Inc. tax)</small>';
                            }
                            
                            
                        $html .= '</h6>
                        
                        </div>';
                        if(!$product->is_variant){
                        $already = Self::alreadyInCart($product);

                        // if($already){
                        //     $html .= '<a class="btn btn-secondary d-block btn-md rounded-1 delete-cart" data-key="'.$product->slug.'" data-page="list">Remove from Cart</a>';
                        // }else{
                            $html .= '<button aria-label="Add To Cart" class="btn btn-secondary btn-sm d-block btn-md rounded-1 add-cart mb-3 w-100" data-key="'.$product->slug.'" data-page="list">Add to Cart</button>';
                        // }
                            
                    }else{
                        $html .= '<button href="'.route('product',$product->slug).'" class="btn btn-sm btn-secondary d-block btn-md rounded-1 mb-3 w-100">View Details</button>';
                    }
                        
                        
                     $html .= ' </div>
                     
                    
                </div>
            ';

        return $html;

         $html = '<div class="product-cart-wrap mb-30">
                    <div class="product-img-action-wrap">
                        <div class="product-img product-img-zoom">
                            <a href="'.route('product',$product->slug).'">
                                <img class="default-img lazyload" src="'. URL::asset('frontend/img/image-loading.gif') .'" data-src="'. asset('storage/products/').'/'.$product->id.'/thumb/'.$product->image.'" alt="Product">';

                                if(!empty($product) && ($product->hover_image != null || $product->hover_image != '' )){
                                $html .= '<img class="hover-img lazyload" src="'. URL::asset('frontend/img/image-loading.gif') .'" data-src="'.asset('storage/products/').'/'.$product->id.'/thumb/'.$product->hover_image.'" />';
                                }
                                
                                
                    $html .= '</a>
                        </div>
                        <div class="product-action-1">';
                        
                        //$html .= '<a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>';

                        $alreadyWishlist = Self::alreadyInWishlist($product);

                        if(!$product->is_variant){
                            if($alreadyWishlist){
                                $html .= '<a aria-label="Remove from Wishlist" class="action-btn hover-up active add-wishlist" data-key="'.$product->slug.'" ><i class="fi-rs-heart"></i></a>';
                            }else{
                                $html .= '<a aria-label="Add To Wishlist" class="action-btn hover-up add-wishlist" data-key="'.$product->slug.'" ><i class="fi-rs-heart"></i></a>';
                            }
                        }else{
                            $html .= '<a aria-label="View Product" class="action-btn hover-up" href="'.route('product',$product->slug).'" ><i class="fi-rs-eye"></i></a>';
                        }

                        //$html .= '<a aria-label="Compare" class="action-btn hover-up" href="#"><i class="fi-rs-shuffle"></i></a>';

                        $html .= '</div>
                        <div class="product-badges product-badges-position product-badges-mrg">';
                            if($product->is_sale){
                                $html .= '<span class="sale mx-1">Sale</span>';
                            }
                            if($product->is_new){
                                $html .= '<span class="new mx-1">New</span>';
                            }
                            if($product->is_hot){
                                $html .= '<span class="hot mx-1">Hot</span>';
                            }
                            if($product->is_best_sell){
                                $html .= '<span class="best mx-1">Best Sell</span>';
                            }

                    $html .= '</div>
                    </div>
                    <div class="product-content-wrap">
                        <div class="product-category">
                            <a>';
                                foreach($product->categories as $key => $category){
                                $html .= $category->name; 
                                    if($key < (count($product->categories) - 1)){
                                        $html .= '|';
                                    }
                                }
                    $html .= '</a>
                        </div>
                        <h2><a href="'.route('product',$product->slug).'">'.$product->name.'</a></h2>';
                        if(Self::getReviewShowStatus()){
                            if($product->average_rating_percentage > 0){
                                $html .= '<div class="rating-result" title="'.$product->average_rating_percentage.'%">
                                    <span>
                                        <span>'.$product->average_rating_percentage.'%</span>
                                    </span>
                                </div>';
                            }else{
                                $html .= '<div class="">
                                    <small class="text-muted">No reviews</small>
                                </div>';
                            }
                        }
                        
                        $html .= '<div class="product-price">
                            <span>'.$product->getPrice().'</span>';
                            
                            if($product->is_tax_included){
                                $html .= '<small class="font-xxs"> (Inc. tax)</small>';
                            }

                            if($product->getOldPrice()){
                                $html .= '<span class="old-price">'.$product->getOldPrice().'</span>';
                            }
                            

                $html .= '</div>
                        <div class="product-action-1 show">';
                            if(!$product->is_variant){
                                $already = Self::alreadyInCart($product);

                                // if($already){
                                //     $html .= '<a aria-label="Remove From Cart" class="action-btn hover-up delete-cart" data-key="'.$product->slug.'" data-page="list"><i class="fi-rs-trash"></i></a>';
                                // }else{
                                    $html .= '<button aria-label="Add To Cart" class="action-btn hover-up add-cart w-100" data-key="'.$product->slug.'" data-page="list"><i class="fi-rs-shopping-bag-add"></i></button>';
                                // }
                                    
                            }else{
                                $html .= '<button aria-label="View Product" class="action-btn hover-up w-100" href="'.route('product',$product->slug).'" ><i class="fi-rs-eye"></i></button>';
                            }
                            
                    $html .= '</div>
                        </div>
                    </div>';

                return $html;
    }

    


    public static function xeroConnect($url, $type, $data = null)
    {
        $settingToken = Setting::where('key', 'xero_access_token')->first();
        $token = $settingToken->value;
        //print $token; die;
        $headers = [
            'xero-tenant-id: '.config('services.xero.tenant'),
            'Authorization: '.$token,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($type == 'POST'){
            curl_setopt($ch, CURLOPT_POST, true);
            if($data){
                //$postData = http_build_query($data);
                $postData = json_encode($data);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        curl_close($ch);

        //print '<pre>'; print_r($result); die;

        $res = json_decode($result,true);
        // print '<pre>'; print_r($res); die;

        if(isset($res['Status']) && $res['Status'] == 401 && isset($res['Title']) && $res['Title'] == 'Unauthorized'){
            //print 'Here'; die;

            $refreshToken = Self::xeroRefreshTokenDB();

            if($refreshToken){
                // print '<pre>';
                // print $url;
                // print $type;
                // print_r($data);
                // print '</pre>';
                return Self::xeroConnect($url, $type, $data);
            }else{
                return array('result' => false);
            }

        }else if(isset($res['ErrorNumber'])){
            
            return array('result' => false, 'message' => $res['Message'], 'type' => $res['Type'], 'message_details' => isset($res['Elements'][0]['ValidationErrors']) ? $res['Elements'][0]['ValidationErrors'] : "");
        }else if(isset($res['Status']) && $res['Status'] == 'OK'){
            // can be used later, status is noted
        }
        else{
            //return array('result' => false);
        }

        return array('result' => true, 'message' => '', 'data' => $res);
        //print '<pre>'; print_r($res); die;
        
    }

    public static function xeroRefreshToken()
    {
        //print 'a'; die;
        $url = "https://identity.xero.com/connect/token";
        $headers = [
            'Authorization: Basic '. base64_encode(config('services.xero.client_id'). ":" .config('services.xero.client_secret'))
        ];
        
        $settingRefreshToken = Setting::where('key', 'xero_refresh_token')->first();
        $refreshToken = $settingRefreshToken->value;

        $data = [
            'grant_type'=>'refresh_token',
            //'refresh_token'=>'anR0hmI19hu-kh0EYZS36gx4HzEVHlVYbwXIzu0oENg',
            'refresh_token'=> $refreshToken,
        ];

        $postData = http_build_query($data);
        //print $postData; die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        //print '<pre>'; print_r($result); die;
        $res = json_decode($result,true);
        //print '<pre>'; print_r($res); die;
        return $res;
    }

    public static function xeroRefreshTokenDB(){

        $tokenData = Self::xeroRefreshToken();
        //print_r($tokenData); die;

        $countToken = Setting::where('key','xero_access_token')->count();
        if($countToken > 0){
            $settingToken = Setting::where('key','xero_access_token')->first();
            $settingToken->value = $tokenData['token_type'].' '.$tokenData['access_token'];
            $settingToken->save();
        }
            
        $countRefreshToken = Setting::where('key','xero_refresh_token')->count();
        if($countRefreshToken > 0){
            $settingRefreshToken = Setting::where('key','xero_refresh_token')->first();
            $settingRefreshToken->value = $tokenData['refresh_token'];
            $settingRefreshToken->save();
        }

        if($settingToken && $settingRefreshToken){
            return true;
        }else{
            return false;
        }
    }

    public static function xeroItemAddUpdate($product, $oldProduct = null){

        $url = "https://api.xero.com/api.xro/2.0/Items";
        $type = 'POST';
        
        $data = Self::makeProductXeroPostData($product, $oldProduct);
        // print '<pre>'; print_r($data); die;
        if($data['result'] && (isset($data['postData']) && is_array($data['postData']) && count($data['postData'])) > 0){
            //print '<pre>'; print_r($postData); die;
            $result = Self::xeroConnect($url, $type, $data['postData']);
            // print '<pre>'; print_r($result); die;
            Self::updateProductXeroStatus($product, $result, $data['accountingDetails']);
            return true;
        }else{
            return false;
        }
        
    }

    public static function makeProductXeroPostData($product, $oldProduct) {

        if($product->is_variant){
            
            $items = Self::makeVariantProductXeroArray($product);
            if($oldProduct){
                $oldItems = Self::makeVariantProductXeroArray($oldProduct);
            }else{
                $oldItems = [];
            }
            // print '<pre>'; print_r($items); die;
            $array = array();
            foreach($items as $key => $item){
                // print '<pre>'; print_r($item); die;
                $searchKey = 'Code';
                $searchValue = $item[$searchKey];
                
                $searchedOldItem = Self::searchArray($searchKey, $searchValue, $oldItems);
                // print '<pre>'; print_r($item);
                // print '<pre>'; print_r($searchedOldItem); die;

                if(
                    is_array($searchedOldItem) 
                    && ($item['Code'] == $searchedOldItem['Code'])
                    && ($item['Name'] == $searchedOldItem['Name'])
                    && ($item['Description'] == $searchedOldItem['Description'])
                    && ($item['SalesDetails']['UnitPrice'] == $searchedOldItem['SalesDetails']['UnitPrice'])
                ){
                    continue;
                }else{
                    $array[$key] = $item;
                }
                
            }
            
            // print '<pre>'; print_r($array); die;
            $array = array_values($array);
            
            // print '<pre>'; print_r($array); die;
            // print 'Variant'; die;
        }else{

            if(
                $oldProduct != null 
                && ($oldProduct->name == $product->name) 
                && ($oldProduct->short_description == $product->short_description)
                && ($oldProduct->price == $product->price)
            ){
                //print 'a'; die;
                return array('result' => false, 'postData' => []);
            }
            //print 'b'; die;

            // print 'Not variant'; die;
            $array = [
                [
                    "Code" => $product->slug,	// required
                    "Name" => $product->name,
                    "Description" => $product->short_description,
                    "SalesDetails" => [
                        "UnitPrice" => $product->price,
                        "AccountCode" => config('services.xero.account_code'),
                        // "TaxType" => config('services.xero.tax_type')
                    ],
                    'accounting_details' => array("attribute_id" => null, "product_code" => $product->slug)
                ]
            ];
        }

        $accountingDetails = [];
        foreach($array as $key => $arraySingle){
            $accountingDetails[] = $arraySingle['accounting_details'];
            unset($array[$key]['accounting_details']);
        }
        
        if(count($array) > 1){
            $postData['Items'] = $array;
        }else if(count($array) < 1){
            $postData = [];    
        }else{
            $postData = $array;
            if(count($postData) === 1) {
                $postData = $postData[0];
            }
        }

        return array('result' => true, 'postData' => $postData, 'accountingDetails' => $accountingDetails);
    }


    public static function makeVariantProductXeroArray($product) {

        $product = Self::getProductAttributeNames($product);
        // print '<pre>'; print_r($product->toArray()); die;

        $items = [];

        foreach($product->attributes as $key => $attribute){
            $slug = $product->slug;
            $name = $product->name;
            $price = $attribute->price;

            foreach($attribute->details as $k => $detail){
                // $slug .= '_'.$detail->attribute_keyword.'_'.$detail->attribute_option_keyword;
                // $name .= ' '.$detail->attribute_name.' '.$detail->attribute_option_name;
                $slug .= '_'.$detail->attribute_option_keyword;
                $name .= ' '.$detail->attribute_option_name;
            }

            $items[$key] = [
                "Code" => $slug,	// required
                "Name" => $name,
                "Description" => $product->short_description,
                "SalesDetails" => [
                    "UnitPrice" => $price,
                    "AccountCode" => config('services.xero.account_code'),
                    // "TaxType" => config('services.xero.tax_type')
                ],

                'accounting_details' => array("attribute_id" => $attribute->id, "product_code" => $slug)
            ];

        }

        return $items;
    }

    public static function updateProductXeroStatus($product, $result, $accountingDetails) {
        // print '<pre>'; print_r($accountingDetails); die;
        if($product->is_variant){
            // print '<pre>'; print_r($product->toArray()); die;
            // print '<pre>'; print_r($accountingDetails); die;
            // foreach($product->attributes as $key => $attribute){
            foreach($accountingDetails as $accountingDetail){
                // print $product->id; 
                // print '<br>';
                // print $accountingDetail;
                // die;
                $product->accounting()
                // ->where('product_attribute_id', $accountingDetail)
                ->updateOrCreate(['product_attribute_id' => $accountingDetail['attribute_id'], 'accounting_software' => 'xero'], ['product_code' => $accountingDetail['product_code'], 'is_synchronized' => $result['result'], 'message' => $result['message'] ]);
            }
        }else{
            // print '<pre>'; print_r($accountingDetails[0]['product_code']); die;
            $product->accounting()->updateOrCreate(['accounting_software' => 'xero'],['product_code' => $accountingDetails[0]['product_code'], 'is_synchronized' => $result['result'], 'message' => $result['message'] ]);
        }
    }


    public static function createXeroInvoice($order)
    {

        
        // if($order->is_xero_invoice_created){
        //     return redirect()->back()->with('flash_message_error','Invoice already created');    
        // }
        

        $invoiceReference = "";
        // if($order->payment->type == "Stripe"){
        //     $invoiceReference = $order->payment->stripe_charge_id;
        // }elseif($order->payment->type == "Paypal"){
        //     $invoiceReference = $order->payment->paypal_charge_id;
        // }
        
        // print '<pre>'; print_r($order->toArray()); die;
        // print '<pre>'; print_r($order->payment->toArray()); die;
        $orderItems = [];
        $keyRecord = 0;
        $productAcountingNotSync = false;
        // print '<pre>'; print_r($order->toArray()); die;
        foreach($order->products as $key => $product){
            // print '<pre>'; print_r($product->toArray()); die;
            if($product->is_variant){
                $productAccounting = $product->accounting()->where('product_attribute_id', $product->product_attribute_id)->first();
            }else{
                $productAccounting = $product->accounting()->first();
            }
            
            // print '<pre>'; print_r($productAccounting); die;
            if($productAccounting){
                $orderItems[$key]['ItemCode'] = $productAccounting->product_code;
                $orderItems[$key]['Quantity'] = $product->quantity;
                $orderItems[$key]['UnitAmount'] = $product->price;
                $orderItems[$key]['AccountCode'] = config('services.xero.account_code');
                // $orderItems[$key]['TaxType'] = config('services.xero.tax_type'); // uncomment here
                $keyRecord = $key;
            }else{
                $productAcountingNotSync = true;
                break;
            }
        }
        // print '<pre>'; print_r($orderItems); die;

        $orderAccounting = $order->accounting();

        if($productAcountingNotSync){
            $orderAccounting->updateOrCreate(['accounting_software' => 'xero'],['is_synchronized' => false, 'message' => 'One or more order products are not synchronized with xero']);
            return false;
        }

        // shipping starts
        if($order->payment->shipping > 0 && count($orderItems) > 0){
            // $keyRecord = $keyRecord + 1;

            // $orderItems[$keyRecord]['ItemCode'] = 'FD';
            // //$orderItems[$keyRecord]['Quantity'] = 1;
            // $orderItems[$keyRecord]['UnitAmount'] = $order->payment->shipping;
            // // $orderItems[$keyRecord]['AccountCode'] = "204";
            // // $orderItems[$keyRecord]['TaxType'] = "TAX003";
            // $orderItems[$keyRecord]['AccountCode'] = config('services.xero.shipping_account_code');
            // // // $orderItems[$keyRecord]['TaxType'] = config('services.xero.shipping_tax_type'); // uncomment here

            // from Chat Gpt start
            // $orderItems[$keyRecord]["Description"] = "Shipping";
            // $orderItems[$keyRecord]["Quantity"] = 1;
            // $orderItems[$keyRecord]["UnitAmount"] = $order->payment->shipping;
            // $orderItems[$keyRecord]["AccountCode"] = config('services.xero.shipping_account_code');
            // $orderItems[$keyRecord]["TaxType"] = config('services.xero.shipping_tax_type');
            // from Chat Gpt end
        }
        // print '<pre>'; print_r($orderItems); die;
        // shipping ends
        

        if(count($orderItems) <= 0){
            $orderAccounting->updateOrCreate(['accounting_software' => 'xero'],['is_synchronized' => false, 'message' => 'None of the order products are not synchronized with xero']);
            return false;
        }

        if(count($orderItems) <= 0){
            $orderAccounting->updateOrCreate(['accounting_software' => 'xero'],['is_synchronized' => false, 'message' => 'One or more order products are not synchronized with xero']);
            return false;
        }

        $user = Auth::user();
        if($user){
            $order->first_name = $user->first_name;
            $order->last_name = $user->last_name;
            $order->email = $user->email;
            $order->country_code = $user->country_code;
            $order->phone = $user->phone;
        }

        $url = "https://api.xero.com/api.xro/2.0/Invoices";
        $type = 'POST';
        $postData = [
            "Type" => "ACCREC",	// required
            "Contact" => [  // required
                //"ContactID" => "d569987b-ed52-44df-b3c4-eddb3b5cfe35"
                "Name" => $order->first_name.' '.$order->last_name,
                "FirstName" => $order->first_name,
                "LastName" => $order->last_name,
                "EmailAddress" => $order->email,
                "IsCustomer" => true,
                "IsSupplier" => false,
                "DefaultCurrency" => $order->currency_iso_code,
                "Phones" => [
                    [
                      "PhoneType" => "DEFAULT",
                      "PhoneNumber" => $order->phone,
                      "PhoneCountryCode" => $order->country_code
                    ],
                    // [
                    //   "PhoneType": "FAX"
                    // ],[
                    //   "PhoneType": "MOBILE"
                    // ],[
                    //   "PhoneType": "DDI"
                    // ]
                  ],
                  "Addresses" => [
                    [
                        "AddressType" => "POBOX",
                        "AddressLine1" => $order->billing->address_line_1.' '.$order->billing->address_line_2.' '.$order->billing->street,
                        // "AddressLine2" => $order->billing->suburb,
                        "City" => $order->billing->city,
                        "Region" => $order->billing->state,
                        "PostalCode" => $order->billing->postal,
                        "Country" => $order->billing->country,
                    ],
                    // [
                    //     "AddressType" => "STREET"
                    // ]
                    ],
                ],	
                "CurrencyCode" => $order->currency_iso_code,
                "LineAmountTypes" => "Inclusive",
                "LineItems" => $orderItems,  // required
                "Reference" => $invoiceReference

        ];

        //print '<pre>'; print_r($postData); die;
        $result = Self::xeroConnect($url, $type, $postData);
        // print '<pre>'; print_r($result); die;
        //print '<pre>'; print_r($result['message_details'][0]['Message']); die;
        

        if(!$result['result']){
            $message = $result['message'];
            if(isset($result['message_details']) && isset($result['message_details'][0]['Message']))
            {
                $message = $message.': '.$result['message_details'][0]['Message'];
            }
            $orderAccounting->updateOrCreate(['accounting_software' => 'xero'],['is_synchronized' => false, 'message' => $message]);
            return false;
        }


        if($result['result']){
            if($result['data']['Status'] == 'OK'){
                $invoice = $result['data']['Invoices'][0];

                $orderAccounting->updateOrCreate(['accounting_software' => 'xero',],['invoice_id' => $invoice['InvoiceID'], 'invoice_number' => $invoice['InvoiceNumber'], 'contact_id' => $invoice['Contact']['ContactID'], 'is_synchronized' => true, 'message' => '']);
                return true;
                // 'Order successfully added to Xero with invoice number: '.$invoice['InvoiceNumber'];
                
            }else{
                return false;
                // 'Something went wrong, please contact developer';
            }
            
        }

        return false;

        // 'Something went wrong, please contact developer';

    }


    public static function getProductAttributeNames($product) {
        foreach($product->attributes as $key => $attribute){
            foreach($attribute->details as $k => $detail){
                $attributeDetails = Self::getAttributeDetails($detail->attribute_id);
                $attributeOptionDetails = Self::getAttributeOptionDetails($detail->attribute_option_id);

                $product->attributes[$key]->details[$k]->attribute_keyword = $attributeDetails->keyword;
                $product->attributes[$key]->details[$k]->attribute_name = $attributeDetails->name;
                $product->attributes[$key]->details[$k]->attribute_option_keyword = $attributeOptionDetails->keyword;
                $product->attributes[$key]->details[$k]->attribute_option_name = $attributeOptionDetails->name;
            }
        }
        return $product;
    }

    public static function flashMessage($result = true, $message = "") {
        Session::flash('result', $result);
        Session::flash('message', $message);
        return;
    }

    public static function setUserUUID(){
        //$minutes = 30 * 24 * 60; // one month
        $minutes = time()+86400*30; // one month
        $uuid = Str::uuid();
        $cookie = setcookie('user', $uuid, $minutes);
        return $uuid;
     }

    public static function getUserUUID(){
        if(!isset($_COOKIE['user'])){
            return Self::setUserUUID();
        }
        //print '<pre>';print_R($_COOKIE); die;
        return $_COOKIE['user'];
     }

     
    // public static function getAttributes($attributeID){
        
    //     //$attributeID

    //     return array('sign' => '$');
    // }

    public static function getCurrency(){
        $currencySignDB = Setting::where('key','currency_sign')->first();
        $currencySign = ($currencySignDB && $currencySignDB->value) ? $currencySignDB->value : config('constants.CONFIG.currency_sign');

        $currencyIsoCodeDB = Setting::where('key','currency_iso_code')->first();
        $currencyIsoCode = ($currencyIsoCodeDB && $currencyIsoCodeDB->value) ? $currencyIsoCodeDB->value : config('constants.CONFIG.currency_iso_code');

        return array('sign' => $currencySign, 'currency_iso_code' => $currencyIsoCode);

    }

    public static function getTax($cart){
        //print '<pre>'; print_r($cart); die;
        $tax = 0;
        foreach($cart as $cartSingle){
            if(!$cartSingle->is_tax_included){
                $tax = $tax + (Self::getProductTaxAmount($cartSingle->product_id, $cartSingle->product_attribute_id) * $cartSingle->quantity);
            }
        }
        return $tax;
        //return 10;
    }

    public static function getOrderTax($order){
        //print '<pre>'; print_r($cart); die;
        $tax = 0;

        // $countrySetting = Self::getCountry();

        // if($countrySetting == 'IN'){
        //     $abc = Self::taxDetailsForIN($order);
        // }


        foreach($order->products as $product){
            if(!$product->is_tax_included){

                // $taxDetails = Tax::find($product->tax_id);
                // if($countrySetting == 'IN'){

                // }else{
                //     $tax = $tax + ($product->price * ($taxDetails->tax / 100)) * $product->quantity;
                // }

                $tax = $tax + ($product->price * ($product->tax / 100)) * $product->quantity;

            }
            
        }
        return $tax;
        //return 10;
    }

    public static function getProductTaxAmount($productID, $attributeID = null){
        //print $productID; die;
        $row = Product::with(['attribute' => function($subQuery) use($attributeID){
            $subQuery->where('id',$attributeID);
        }])->select('taxes.*','taxes.id as tax_id', 'products.id','products.is_tax_included', 'products.price')
        ->join('taxes','taxes.id','=','products.tax_id')
        ->find($productID);
        //print '<pre>'; print_r($row);
        if($row && !$row->is_tax_included){
            //print 'a'; die;
            if($attributeID){
                return $row->attribute->price * ($row->tax / 100);
            }else{
                return $row->price * ($row->tax / 100);
            }
        }else{
            return 0;
        }
    }

    public static function getProductTax($ID){
        $row = Tax::find($ID);
        if($row){
            //return $row->name.' ('.$row->tax.'%)';
            //return $row->tax;
            return $row;
        }else{
            return null;
        }
    }

    public static function getBrandName($ID){
        $row = Brand::find($ID);
        if($row){
            return $row->name;
        }else{
            return null;
        }
    }

    public static function getColorName($ID){
        $row = Color::find($ID);
        if($row){
            return $row->name;
        }else{
            return null;
        }
    }

    public static function getShipping($user, $cart, $state = null){
        if($user){
            // $shipping = $user->addressShipping()->where('is_default',1)->first();
            $address = Self::getDefaultShippingAddress($user);
            // print '<pre>'; print_r($address->toArray()); die;
            if($address){
                $stateTo = State::where('code', $address['state'])->first();
                if(!$stateTo){
                    return array('result' => false, 'message' => 'State not found');
                }
            }else{
                return ['result' => false];    
            }
            
        }elseif(!$user && $state != null){
            $stateTo = $state;
        }else{
            return ['result' => false];
        }
        
        $shippingPrice = Self::getStateShippingAmount($stateTo);
        // print '<pre>'; print_r($array); die;

        // $shippingPrice = Self::getWeightBasedShippingPrice($user);

        if($shippingPrice['result']){
            $array = array(array());
            // print '<pre>'; print_r($array); die;
            return array('result' => true, 'price_show' => Self::priceFormat($shippingPrice['price']), 'price_calculate' => Self::numberFormat($shippingPrice['price']));
        }else{
            return array('result' => false, 'message' => $shippingPrice['message']);
        }


        // $shipping = Setting::where('key','shipping')->first();
        // //print_r($shipping); die;
        // if($shipping && $shipping->value){
        //     return $shipping->value;
        // }else{
        //     return config('constants.CONFIG.shipping_charges');
            
        // }
    }
    public static function getProductServicesAmount($cart){
        //print '<pre>'; print_r($cart); die;
        $serviceAmount = 0;
        
        $config = Self::getWebsiteConfig('product_services');
        if($config['product_services']){
            foreach($cart as $cartSingle){
            
                if(count($cartSingle->services) > 0){
                    foreach($cartSingle->services as $service){
                        //$serviceAmount = $serviceAmount + $service->price;
                        $serviceAmount = $serviceAmount + $service->getPriceNumeric();
                    }
                }
            }
        }
        //print $serviceAmount; die;
        return $serviceAmount;
        //return 10;
    }

    public static function getDiscountPercentage($product)
    {
        if($product->old_price && $product->old_price !=0){
            $discountPrice = $product->old_price - $product->price;
            $percentage = round($discountPrice / $product->old_price * 100);
            return $percentage.'%';
        }
    }

    public static function numberFormat($number){
        return number_format((float)$number, 2, '.', '');
    }

    public static function priceFormat($number){
        $number = Self::numberFormat($number);
        return preg_replace('/\B(?=(?:(\d\d)+(\d)(?!\d))+(?!\d))/',',', $number);
    }


    public static function getProductStockQuantity($product, $attribute = null){

        if($product->is_variant && $attribute != null){
            //$attribute = Self::searchForAttributeId($attribute, $product);
            $attribute = $product->attributes()->find($attribute);
            return $attribute->stock;
        }else{
            return $product->stock;
        }
    }
    

    public static function searchForAttributeId($id, $product) {
        foreach ($product->attributes as $key => $val) {
            if ($val->id === $id) {
                return $val;
            }
        }
        return null;
     }

     public static function getSelectedItemAttributes($itemattributes) {
        $selectedAttribute = [];
        foreach($itemattributes as $attribute){
            $attributeDetails = ProductAttributeDetail::where('product_attribute_id',$attribute->id)->get();
            foreach($attributeDetails as $attributeDetail){
                $selectedAttribute[] = $attributeDetail->attribute_id;
            }
        }
        $selectedAttribute = array_unique($selectedAttribute);
        //print '<pre>'; print_r($selectedAttribute);
        return $selectedAttribute;
    }

    public static function getItemAttributes($productID) {
        $ItemAttributes = ProductAttribute::where(['product_id' => $productID])->get();
        $array = [];
        foreach($ItemAttributes as $ItemAttribute){
            $array[] = $ItemAttribute->id;
        }
        return $array;
    }
     


     public static function getCartObj($user)
    {
        if($user){
            if($user == null){
                return false;
            }
            $cartObj = $user->cart()->with('services');
        }else{
            $uuid = Self::getUserUUID();
            $cartObj = Cart::with('services')->where('cart.uuid',$uuid);
        }

        $cartObj->select('cart.*')->join('products', 'products.id', '=', 'cart.product_id')->where('products.deleted_at', null);    //here

        return $cartObj;
    }

     public static function getCartShowList($user)
    {
        if($user){
            $cartObj = $user->cart();
        }else{
            $uuid = Self::getUserUUID();
            $cartObj = Cart::where('cart.uuid',$uuid);
        }

        $cart = $cartObj->with([
            'attribute.details' => function($query){
                $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_option_name');
                $query->join('attributes', 'attributes.id', '=', 'product_attribute_details.attribute_id');
                $query->join('attribute_options', 'attribute_options.id', '=', 'product_attribute_details.attribute_option_id');
            }
            , 'services' => function($query){
                //$query->select('cart_services.*', 'product_services.name as service_name', 'product_services.slug as service_slug', 'product_services.image as service_image', 'product_services.summary as service_summary', 'product_services.description as service_description', 'product_services.price as service_price', );
                $query->select('product_services.*', 'cart_services.cart_id', 'cart_services.product_service_id');
                $query->join('product_services', 'product_services.id', '=', 'cart_services.product_service_id');
            }
            ,
             'productServices'
        ])->select('products.*', 'products.id as product_row_id', 'cart.*', 'taxes.tax')
        ->leftJoin('products', 'products.id', '=', 'cart.product_id')
        ->leftJoin('taxes', 'taxes.id', '=', 'products.tax_id')
        ->where('products.deleted_at', null)    //here
        ->get();

        //print '<pre>'; print_r($cart); die;
        //print '<pre>'; print_r($cart->toArray()); die;

        // foreach($cart as $key => $cartSingle){
        //     $product = Product::find($cartSingle->product_id);
        //     //$cart[$key]->price = $product->getPrice();
        //     $cart[$key]->price = $cartSingle->productPrice();
        // }
        return $cart;
    }


     public static function alreadyInCart($product, $itemAttributeIDS = null)
    {
        $user = Auth::user();
        $cartObj = Self::getCartObj($user);
        if(!$cartObj){
            return false;
        }
        //$cart = $cartObj->where('product_id',$product->id)->first();
        
        //print_R($itemAttributeIDS); die;

        $cartObj->where('product_id',$product->id);
        if($itemAttributeIDS != null && count($itemAttributeIDS) > 0){
            $cartObj->whereIn('product_attribute_id',$itemAttributeIDS);
        }
        $cart = $cartObj->first();
        
        //print '<pre>'; print_r($cart); die;
        if(!$cart){
            return false;
        }

        $availableQuantity = Self::getProductStockQuantity($product, $cart->product_attribute_id);
        //print '<pre>'; print_r($availableQuantity); die;
        if($availableQuantity <= 0){
            $cartObj->where('product_id',$product->id)->delete();
        }
        if($cart != null && $availableQuantity < $cart->quantity){
            $cartObj->where('product_id',$product->id)->delete();
        }

        //$cartCount = $cartObj->where('product_id',$product->id)->count();

        $cartObj->where('product_id',$product->id);
        if($itemAttributeIDS != null && count($itemAttributeIDS) > 0){
            $cartObj->whereIn('product_attribute_id',$itemAttributeIDS);
        }
        $cartCount = $cartObj->count();
        //print $cartCount; die;
        
        if ($cartCount == null) {
            return false;
        }
        if ($cartCount <= 0) {
            return false;
        }

        return true;

    }

    public static function serviceAlreadyInCart($productID,$attributeID,$service)
    {
        
        
        
        $user = Auth::user();
        $cartObj = Self::getCartObj($user);
        if(!$cartObj){
            return false;
        }
        
        //$cart = $cartObj->where('product_id',$productID)->first();
        $cartObj->where('product_id',$productID);

        if($attributeID != null){
            //print $attributeID; die;
            $cartObj->where('product_attribute_id',$attributeID);
        }

        $cart = $cartObj->first();
        
        //print '<pre>'; print_r($cart); die;
        if(!$cart){
            return false;
        }
        $serviceID = $service->id;
        $serviceDB = $cartObj->with(['services' => function($subQuery) use($serviceID){
            $subQuery->where('product_service_id',$serviceID);
        }])->first();
        //print '<pre>'; print $serviceDB->services; die;
        if (count($serviceDB->services) > 0) {
            return true;
        }else{
            return false;
        }

    }

    

    public static function alreadyInWishlist($product, $attributeID = null)
    {
        //print $attributeID; die;

        $user = Auth::user();
        $wishlistObj = Self::getWishlistObj($user);
        if(!$wishlistObj){
            return false;
        }
        $wishlistObj->select('wishlist.*', 'products.is_variant')->join('products','products.id','=','wishlist.product_id');

        $wishlistObj->where('wishlist.product_id',$product->id)->first();

        if($attributeID != null){
            $wishlistObj->where('wishlist.product_attribute_id',$attributeID)->first();
        }
        
        $wishlist = $wishlistObj->first();


        if(!$wishlist){
            return false;
        }

        if($wishlist->is_variant && $attributeID == null){
            return false;
        }

        //print '<pre>'; print_r($wishlist); die;
        if(!$wishlist){
            return false;
        }

        $wishlistCount = $wishlistObj->where('product_id',$product->id)->count();
        if ($wishlistCount == null) {
            return false;
        }
        if ($wishlistCount <= 0) {
            return false;
        }

        return true;

    }

    public static function getWishlistObj($user)
    {
        if($user){
            if($user == null){
                return false;
            }
            $wishlistObj = $user->wishlist();
        }else{
            $uuid = Self::getUserUUID();
            $wishlistObj = Wishlist::where('wishlist.uuid',$uuid);
        }
        return $wishlistObj;
    }

    public static function saveCartToUser($cartWithoutLogin)
    {
        $user = Auth::user();
        $cartObj = Self::getCartObj($user);
        $cart = $cartObj->get();

        foreach($cartWithoutLogin as $cartWithoutLoginSingle){
                        
            $cartWithoutLoginSingle->uuid = null;
            $cartWithoutLoginSingle->user_id = $user->id;
            $cartWithoutLoginSingle->save();

            foreach($cart as $cartSingle){
                if(($cartWithoutLoginSingle->product_id == $cartSingle->product_id) && ($cartWithoutLoginSingle->product_attribute_id == $cartSingle->product_attribute_id)){
                    
                    $cartWithoutLoginSingle->delete();
                    //$cartWithoutLoginSingle->save();
                    //print '<pre>'; print_r($cartWithoutLoginSingle); die;
                    //print 'aa'; die;
                    break;
                }
            }

        }
    }

    public static function checkout($user, $isShipping = null, $state = null)
    {
        
        $cartObj = Self::getCartObj($user);
        if(!$cartObj){
            return false;
        }
        $cart = $cartObj->get();

        $subTotal = 0;

        if($isShipping){
            $shipping = Self::getShipping($user, $cart, $state);
        }

        // $shippingAmount = Self::getShipping();
        $shippingAmount = isset($shipping['price_calculate']) ? $shipping['price_calculate'] : 0;

        $productServicesAmount = Self::getProductServicesAmount($cart);
        
        $currency = Self::getCurrency();
        $tax = Self::getTax($cart);

        $subTotal = Self::getCartItemsTotal($cart);
        $coupon = Self::getCouponDetails($user);
        //print $coupon; die;

        $isEnquiryWebsite = Self::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        $minCartAmount = Self::getWebsiteConfig('min_cart_amount');
        $minCartAmount = $minCartAmount['min_cart_amount'];

        // $minCartAmount = 129;
        $isMinAmount = $subTotal < $minCartAmount ? false : true;

        $array = array(
            'currency' => $currency['sign'], 
            'sub_total' => Self::priceFormat($subTotal), 
            'shipping' => Self::priceFormat($shippingAmount), 
            'products_service' => Self::priceFormat($productServicesAmount), 
            'tax' => Self::priceFormat($tax), 
            'coupon_discount' => (!$isEnquiryWebsite && $coupon) ? $coupon->calculated_discount : null, 
            'total' => Self::priceFormat($subTotal + $shippingAmount + $productServicesAmount + $tax - ($coupon ? $coupon->calculated_discount : null)),
    
            'sub_total_calculate' => Self::numberFormat($subTotal),
            'shipping_calculate' => Self::numberFormat($shippingAmount),
            'products_service_calculate' => Self::numberFormat($productServicesAmount), 
            'tax_calculate' => Self::numberFormat($tax), 
            'coupon_discount_calculate' => (!$isEnquiryWebsite && $coupon) ? $coupon->calculated_discount : null, 
            'total_calculate' => Self::numberFormat($subTotal + $shippingAmount + $productServicesAmount + $tax - ($coupon ? $coupon->calculated_discount : null)),
            'min_cart_amount' => $minCartAmount,
            'is_min_amount' => $isMinAmount,
        );

        if(isset($shipping)){
            $array['shipping_data'] = $shipping;
        }

        return $array;

    }


    public static function checkout1($user, $isShipping = null, $postal = null)
    {
        
        $cartObj = Self::getCartObj($user);
        if(!$cartObj){
            return false;
        }
        $cart = $cartObj->get();

        $subTotal = 0;
        // $shippingAmount = Self::getShipping($user, $cart);
        if($isShipping){
            $shipping = Self::getShipping($user, $cart, $postal);
        }
        // print '<pre>'; print_r($shipping); die;
        
        $shippingAmount = isset($shipping['shipping_amount']) ? $shipping['shipping_amount'] : 0;
        
        $productServicesAmount = Self::getProductServicesAmount($cart);
        
        $currency = Self::getCurrency();
        $tax = Self::getTax($cart);

        $subTotal = Self::getCartItemsTotal($cart);
        $coupon = Self::getCouponDetails($user);
        //print $coupon; die;

        $isEnquiryWebsite = Self::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        $array = array(
            'currency' => $currency['sign'], 
            'sub_total' => Self::priceFormat($subTotal), 
            'shipping' => Self::priceFormat($shippingAmount), 
            'products_service' => Self::priceFormat($productServicesAmount), 
            'tax' => Self::priceFormat($tax), 
            'coupon_discount' => (!$isEnquiryWebsite && $coupon) ? $coupon->calculated_discount : null, 
            'total' => Self::priceFormat($subTotal + $shippingAmount + $productServicesAmount + $tax - ($coupon ? $coupon->calculated_discount : null)),
    
            'sub_total_calculate' => Self::numberFormat($subTotal),
            'shipping_calculate' => Self::numberFormat($shippingAmount),
            'products_service_calculate' => Self::numberFormat($productServicesAmount), 
            'tax_calculate' => Self::numberFormat($tax), 
            'coupon_discount_calculate' => (!$isEnquiryWebsite && $coupon) ? $coupon->calculated_discount : null, 
            'total_calculate' => Self::numberFormat($subTotal + $shippingAmount + $productServicesAmount + $tax - ($coupon ? $coupon->calculated_discount : null)),
            
        );

        if(isset($shipping)){
            $array['shipping'] = $shipping;
        }

        return $array;

    }

    public static function getGroupOtherItems($groupID, $productID) {
        $products = Product::
        select('products.slug','products.color_id', 'colors.name', 'colors.code')
        ->where('group_id',$groupID)->where('products.id','!=',$productID)
        ->join('colors', 'colors.id', '=', 'products.color_id')
        ->get();
        //print '<pre>'; print_r($products); die;
        return $products;
    }

    public static function getItemAttributeIDS($itemattributes) {
        $array = [];
        $i = 0;
        foreach($itemattributes as $key => $itemattribute){
            foreach($itemattribute->details as $k => $detail){
                if(!Self::in_array_r($detail['attribute_id'],$array)){
                    $array[$i]['attribute_id'] = $detail['attribute_id'];
                    $array[$i]['attribute_name'] = $detail['attribute_name'];
                    $i++;
                }
            }
        }
        return $array;
    }

    public static function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && Self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }

    public static function getAttributes($product) {

        //print '<pre>'; print_r($product); die;

        $productattributes = $product->attributes;
        //$itemattributes = $itemattributes->toArray();
        //print '<pre>'; print_r($productattributes); die;

        $attributes = Self::getItemAttributeIDS($productattributes);

        //print '<pre>'; print_r($attributes); die;

        $array = [];
        

        foreach($attributes as $attribute){
            $i = 0;
            foreach($productattributes as $key => $productattribute){
                foreach($productattribute->details as $k => $detail){
                    //$array[$k]['attribute_id'] = $detail['attribute_id'];
                    //print '<pre>'; print_R($detail); die;
                        if($attribute['attribute_id'] == $detail['attribute_id']){
                        //if(Self::in_array_r($detail['attribute_option_id'], $attributes)){
                        
                            $attributes[$k]['options'][$i]['attribute_option_id'] = $detail['attribute_option_id'];  
                            $attributes[$k]['options'][$i]['attribute_option_name'] = $detail['attribute_option_name'];  
                            
                            $i++;
                        }   
                    
                }
            }
        }
        
        //$attributes = array_unique($attributes);

        foreach($attributes as $k1 => $attribute){
            if($attribute['options']){
                $attributes[$k1]['options'] = array_map("unserialize", array_unique(array_map("serialize", $attribute['options'])));
            }
        }


        //$attributes = array_map("unserialize", array_unique(array_map("serialize", $attributes)));

        //print '<pre>'; print_R($attributes); die;

        return $attributes;
    }

    public static function getAttributeDetails($id) {
        return $attribute = Attribute::find($id);
        // return $attribute->name;
    }

    public static function getAttributeOptionDetails($id) {
        return $attributeOption = AttributeOption::find($id);
        // return $attributeOption->name;
    }


    public static function unique_code($limit)
    {
    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }


    public static function getDefaultBillingAndShippingAddress($user)
    {

        $address = [];

        $address['billing'] = Self::getDefaultBillingAddress($user);
        $address['shipping'] = Self::getDefaultShippingAddress($user);
             
        return $address;
    }

    public static function getDefaultBillingAddress($user)
    {
        $billingObj = $user->addressBilling();
        $count = $billingObj->count();
        if($count > 0){
            $billing = $billingObj->first();
            $billing->is_default = 1;
        }else{
            $billing = $user->addresses()->where('is_default',1)->first();
        }
        return $billing;
    }

    public static function getDefaultShippingAddress($user)
    {

        $shippingObj = $user->addressShipping();
        $count = $shippingObj->count();
        if($count > 0){
            $shipping = $shippingObj->first();
            $shipping->is_default = 1;
        }else{
            $shipping = $user->addresses()->where('is_default',1)->first();
        }
        return $shipping;
    }


    public static function getProductOrderPriceDetails($cartSingle, $sameShippingState)
    {

        $price = $cartSingle->is_variant ? $cartSingle->attribute->price : $cartSingle->productPrice();
        $oldPrice = $cartSingle->is_variant ? $cartSingle->attribute->old_price : $cartSingle->productOldPrice();

        $taxDetails = Self::getProductTax($cartSingle->tax_id);


        $countrySetting = Self::getCountry();
        
        if($countrySetting == 'IN'){
            if($sameShippingState == true){

                if($cartSingle->is_tax_included){
                    $stateTaxAmount = $price - (($price * 100) / (100 + $taxDetails->state_tax));
                    // print (1 + (($taxDetails->state_tax/100))); die;
                    // print $stateTaxAmount; die;
                    $centralTaxAmount = $price - (($price * 100) / (100 + $taxDetails->central_tax));
                }else{
                    $stateTaxAmount = ($taxDetails->state_tax / 100) * $price;
                    $centralTaxAmount = ($taxDetails->central_tax / 100) * $price;
                }
    
                $stateTaxAmount = Self::numberFormat($stateTaxAmount);
                $centralTaxAmount = Self::numberFormat($centralTaxAmount);
    
                $array = array(
                    'state_tax_name' => $taxDetails->state_tax_name,
                    'state_tax' => $taxDetails->state_tax,
                    'state_tax_amount' => $stateTaxAmount,
    
                    'central_tax_name' => $taxDetails->central_tax_name,
                    'central_tax' => $taxDetails->central_tax,
                    'central_tax_amount' => $centralTaxAmount,
    
                    'tax_value' => $stateTaxAmount + $centralTaxAmount,
    
                    'sale_price' => $cartSingle->is_tax_included ? ($price - ($stateTaxAmount + $centralTaxAmount)) : $price,
                    'final_price' => $cartSingle->is_tax_included ? $price : $price + $stateTaxAmount + $centralTaxAmount,
                );
            }else{
                if($cartSingle->is_tax_included){
                    $integratedTaxAmount = $price - (($price * 100) / (100 + $taxDetails->integrated_tax));
                }else{
                    $integratedTaxAmount = ($taxDetails->integrated_tax / 100) * $price;
                }
                $integratedTaxAmount = Self::numberFormat($integratedTaxAmount);
                $array = array(
                    'integrated_tax_name' => $taxDetails->integrated_tax_name,
                    'integrated_tax' => $taxDetails->integrated_tax,
                    'integrated_tax_amount' => $integratedTaxAmount,
                    'tax_value' => $integratedTaxAmount,
                    'sale_price' => $cartSingle->is_tax_included ? ($price - $integratedTaxAmount) : $price,
                    'final_price' => $cartSingle->is_tax_included ? $price : $price + $integratedTaxAmount,
                );
            }
        }else{

            if($cartSingle->is_tax_included){
                $taxAmount = $price - (($price * 100) / (100 + $taxDetails->tax));
            }else{
                $taxAmount = ($taxDetails->tax / 100) * $price;
            }
            $taxAmount = Self::numberFormat($taxAmount);
            $array = array(
                'tax_value' => $taxAmount,
                'sale_price' => $cartSingle->is_tax_included ? ($price - $taxAmount) : $price,
                'final_price' => $cartSingle->is_tax_included ? $price : $price + $taxAmount,
            );
        }
        

        $array['id'] = $taxDetails->id;
        $array['tax'] = $taxDetails->tax;
        $array['tax_name'] = $taxDetails->name;
        $array['price'] = $price;
        $array['old_price'] = $oldPrice;

        return $array;

        //return array('price' => $price, 'old_price' => $oldPrice );

        // return sale_price, taxDetails
       
    }

    public static function getOrderShipping($order){

        $shipment = $order->shipment()->first();
        // print '<pre>'; print_r($shipment->toArray()); die;
        return $shipment->price;
    }
    
    public static function getPaymentDetails($order){
        
        $shipping = 0;

        if(!$order->local_pickup){
            // $shipping = Self::getShipping($user, $cart);
            $shipping = Self::getOrderShipping($order);
        }
        

        //sOrder::find($order)
        
        $subTotal = 0;
        $tax = 0;
        $productDiscount = 0;
        $productService = 0;

        foreach($order->products as $product){
            $subTotal = $subTotal + ($product->price * $product->quantity);
            //$tax = $tax + $product->tax_value;
            if($product->old_price){
                $productDiscount = $productDiscount + ( ($product->old_price - $product->price) * $product->quantity);
            }

            if(count($product->services) > 0){
                foreach($product->services as $service){
                    $productService = $productService + $service->price;
                }
            }
        }

        $tax = Self::getOrderTax($order);
        $couponDiscount = $order->coupon_discount;

        $countrySetting = Self::getCountry();


        $isStateTax = false;
        $isCentralTax = false;
        $isIntegratedTax = false;

        if($countrySetting == 'IN'){
            //print '<pre>'; print_r($order->shipping->state); die;
            if(isset($order->shipping->state)){
                $shippingState = $order->shipping->state;

                if(strtolower($shippingState) == strtolower(config('constants.ADDRESS.state'))){
                    $isStateTax = true;
                    $isCentralTax = true;
                }else{
                    $isIntegratedTax = true;
                }
            }
            
        }

        return array('shipping' => Self::numberFormat($shipping), 'subTotal' => Self::numberFormat($subTotal), 'is_state_tax' => $isStateTax, 'is_central_tax' => $isCentralTax, 'is_integrated_tax' => $isIntegratedTax, 'tax' => Self::numberFormat($tax), 'products_service' => $productService, 'discount' => Self::numberFormat($productDiscount), 'coupon_discount' => Self::numberFormat($couponDiscount), 'total' => Self::numberFormat($shipping+$subTotal+$productService+$tax - ($order->coupon_discount ? $order->coupon_discount : 0)) );
        

    }

    public static function addOrderShipmentDetails($order){
        // print_r($order); die;
        $address = $order->shipping;
        // print '<pre>'; print_r($address->toArray()); die;
        $stateTo = $address['state'];

        $shippingAmount = 0;

        // here
        $weight = 0;
        foreach($order->products as $product){
            // print '<pre>'; print_r($product->toArray());
            $weight = $weight + ($product->shipping_weight * $product->quantity);
        }
        // print $weight; die;
        
        $state = State::where('code', $stateTo)->first();

        $weight = Self::gramsToPounds($weight);

        $shippingPrice = ShippingPrice::where('min_weight', '<=', $weight)->where('max_weight', '>=', $weight)->where('zone', $state->zone)->first();
        // print '<pre>'; print_r($shippingPrice->toArray()); die;
        if($shippingPrice){
            $shippingAmount = $shippingPrice->price;
        }
        // print $shippingAmount; die;


        $shipment = $order->shipment()->create([ 'state_to' => $stateTo, 'currency' => $order->currency, 'currency_iso_code' => $order->currency_iso_code, 'price' => $shippingAmount]);
                    
        // print '<pre>'; print_r($shipment->toArray()); die;
        return $shipment;

    }

    public static function makePayment($order, $paymentMethod, $user, $stripePaymentMethod = null)
    {

        $details = Self::getPaymentDetails($order);
        // print '<pre>'; print_r($details); die;


        $insertRow = array('total' => $details['subTotal'], 'discount' => $details['discount'], 'coupon_discount' => $details['coupon_discount'], 'shipping' => $details['shipping'], 'products_service' => $details['products_service'], 'is_state_tax' => $details['is_state_tax'], 'is_central_tax' => $details['is_central_tax'], 'is_integrated_tax' => $details['is_integrated_tax'],'tax' => $details['tax'], 'currency' => $order->currency, 'currency_iso_code' => $order->currency_iso_code, 'amount' => $details['total'], 'type' => $paymentMethod, 'payment_status' => 'Not Paid', 'status' => 0);

            if($user){
                $insertRow['user_id'] = $user->id;
            }
    
            $payment = $order->payments()->create($insertRow);
            
             if($user){
                $userName = $user->first_name.' '.$user->last_name;
                $email = $user->email;
                $phone = $user->phone;
            }else{
                $userName = $order->first_name.' '.$order->last_name;
                $email = $order->email;
                $phone = $order->phone;
            }
            
        if($paymentMethod == 'cash'){
            
            $payment->status = 1;
            $payment->save();
            $order->status = 1;
            $order->save();

            

            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Self::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);
            
            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Self::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);
            
            $logo = Self::getLightLogo();

            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));

            }else{

                $config = Self::getWebsiteConfig('country_code');
                
                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }


            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));
    
            if($payment){
                return array('result' => true);
            }else{
                return array('result' => false);
            }
        }

        if($paymentMethod == 'instamojo'){
            //print $userName; die;
            //print 'a'; die;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, env('INSTAMOJO_URL'));
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array("X-Api-Key:".env('INSTAMOJO_API_KEY'),
                            "X-Auth-Token:".env('INSTAMOJO_API_TOKEN') ));
            $payload = Array(
                'purpose' => 'Order Payment',
                'amount' => $details['total'],
                'phone' => $phone,
                'buyer_name' => $userName,
                // 'redirect_url' => 'http://localhost:8000/instamojo_redirect',
                'redirect_url' => route('instamojo.redirect'),
                'send_email' => true,
                'webhook' => 'http://www.example.com/webhook/',
                'send_sms' => false,
                'email' => $email,
                'allow_repeated_payments' => false,
                //'purpose' => $order->order_unique_id,
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch); 

            //echo $response;

            $response =json_decode($response);
            //print '<pre>'; print_r($response->payment_request->longurl); die;
            //print '<pre>'; print_r($response); die;
            //return redirect($response->payment_request->longurl);


            if($response->success){
                Session::put('instamojo',$order->order_unique_id);
                DB::commit();
                redirect()->to($response->payment_request->longurl)->send();
            }else{
                return to_route('order.placed', ['order' => $order->order_unique_id]);
            }


            //return redirect()->to($response->payment_request->longurl);
            //die;


        }

        if($paymentMethod == 'paypal'){

            // $currency = Self::getCurrency();
            //print_r($currency); die;

            $provider = new PayPalClient;
            //print '<pre>'; print_r($provider); die;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            //print '<pre>'; print_r($paypalToken); die;
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    // "return_url" => route('successTransaction'),
                    // "cancel_url" => route('cancelTransaction'),
                    "return_url" => url('paypal-redirect?payment_status=success&order_id='.$order->order_unique_id),
                    "cancel_url" => url('paypal-redirect?payment_status=failure&order_id='.$order->order_unique_id),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => $order->currency_iso_code,
                            "value" => $details['total'],
                            // "breakdown" => [
                            //     "item_total" => [
                            //         "currency_code" => "AUD",
                            //         "value" => $amount
                            //     ],
                            // ]
                        ]
                    ]
                ]
            ]);
            //print '<pre>'; print_r($response); die;
            if (isset($response['id']) && $response['id'] != null) {
                //print '<pre>'; print_r($response); die;
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        //print 'a'; die;
                        DB::commit();
                        //print_r($links['href']); die;
                        redirect()->to($links['href'])->send();
                    }
                }
                
                return to_route('order.placed', ['order' => $order->order_unique_id]);
                //print 'Something went wrong';

                // return redirect()
                //     ->route('createTransaction')
                //     ->with('error', 'Something went wrong.');
            } else {
                return to_route('order.placed', ['order' => $order->order_unique_id]);
                //print 'Something went wrong';
                
                // return redirect()
                //     ->route('createTransaction')
                //     ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }

        if($paymentMethod == 'stripe_card'){

            //print 'a'; die;
            if($payment){
                DB::commit();
                return array('result' => true);
            }else{
                return array('result' => false);
            }
        }

        if($paymentMethod == 'razorpay'){

            // print 'aa'; die;

            if($payment){
                DB::commit();
                return array('result' => true);
            }else{
                return array('result' => false);
            }
        }

        if($paymentMethod == 'stripe_checkout'){

            // print $stripePaymentMethod; die;
            DB::commit();
            
            if($user){
                $stripePaymentMethodDB = $user->paymentMethods()->find($stripePaymentMethod);
                if(isset($stripePaymentMethodDB->payment_method)){
                    $stripePaymentMethod = $stripePaymentMethodDB->payment_method;
                }
            }
            

            try {

                if($user){
                    $user->createOrGetStripeCustomer();
                    $user->updateDefaultPaymentMethod($stripePaymentMethod);
                    // $stripeCharge = $user->charge(
                    //     100 * $payment->amount, $stripePaymentMethod
                    // );
                    $stripeCharge = $user->safeCharge(
                        100 * $payment->amount, $stripePaymentMethod
                    );

                }else{
                    $order->createOrGetStripeCustomer();
                    $order->updateDefaultPaymentMethod($stripePaymentMethod);
                    // $stripeCharge = $order->charge(
                    //     100 * $payment->amount, $stripePaymentMethod
                    // );
                    $stripeCharge = $order->safeCharge(
                        100 * $payment->amount, $stripePaymentMethod
                    );
                }

                } catch (\Exception $exception) {
                    // print $exception->getMessage(); die;
                    Helper::flashMessage(false, $exception->getMessage());
                    return array('result' => false);
                    // return to_route('order.placed', ['order' => $order->order_unique_id]);
                    //return back()->with('error', $exception->getMessage());
                }


            $payment->payment_id = $stripeCharge->latest_charge;
            $payment->payment_response = json_encode($stripeCharge);
            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();
    
            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();


            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);

            $logo = Helper::getLightLogo();
            
            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);
                
                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);
                
                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }
            

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));
            
            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);

            

            if($payment){
                return array('result' => true);
            }else{
                return array('result' => false);
            }

            // print '<pre>'; print_r($order); die;

            // return to_route('order.placed', ['order' => $order->order_unique_id]);
        }

        if($paymentMethod == 'stripe_express_checkout'){


            // $payment = $order->payments()->where('order_id',$order->id)->where('type','stripe_express_checkout')->where('payment_id',null)->latest()->first(); // caution: not required here

            $productsData = [
                'price_data' => [
                            // 'currency' => 'usd',
                            'currency' => config('constants.CONFIG.currency_iso_code'),
                            'product_data' => [
                                'name' => config('constants.BUSINESS.name'),
                            ],
                            'unit_amount' => $payment->amount * 100, // $15.00
                        ],
                'quantity' => 1
            ];

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $checkoutSession = StripeCheckoutSession::create([
                // 'payment_method_types' => ['card', 'link', 'upi'], // you can add wallets here
                'payment_method_types' => ['card'],
                // 'line_items' => [[
                //     'price_data' => [
                //         'currency' => 'usd',
                //         'product_data' => [
                //             'name' => 'Express Checkout Example',
                //         ],
                //         'unit_amount' => 1500, // $15.00
                //     ],
                //     'quantity' => 1,
                // ]],
                'line_items' => [$productsData],
                'mode' => 'payment',
                'customer_email' => $order->email ?? $order->email, // ✅ Prefill email
                // 'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                // 'cancel_url' => route('checkout.cancel'),
                'success_url' => route('stripe.redirect').'?session_id={CHECKOUT_SESSION_ID}&status=success',
                'cancel_url'  => route('stripe.redirect').'?session_id={CHECKOUT_SESSION_ID}&status=cancel',
            ]);

            // print '<pre>'; print_r($checkoutSession); die;

            // Session::put('stripe_checkout_session', array('stripe_checkout_session' => $checkoutSession->id));
            // Session::save();

            Session::put('stripe_express',$order->order_unique_id);

            DB::commit();
            // return redirect($checkoutSession->url);
            redirect()->to($checkoutSession->url)->send();
            
            

            // if($payment){
            //     DB::commit();
            //     return array('result' => true);
            // }else{
            //     return array('result' => false);
            // }

        }


        return false;
        

    }



    // public static function addStockLog($order, $user, $productID = null, $productAttributeID = null, $quantity = null, $productPrice = null, $event, $type, $remarks, $userLevel, $note){
    public static function addStockLog($order, $user, $event, $type, $remarks, $userLevel, $note, $productID = null, $productAttributeID = null, $quantity = null, $productPrice = null){

        // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note

        // type (1=added, 0=subtracted etc)
        // event (sold, added, update etc)
        // userLevel (0=admin, 1=front user)

        $userID = ($user != null) ? $user->id : null;
        $orderID = ($order != null) ? $order->id : null;
        
        $log = InventoryLog::create(['order_id'=>$orderID, 'user_id'=>$userID, 'event'=>$event, 'type'=>$type, 'remarks'=>$remarks, 'user_level'=>$userLevel, 'note'=>$note]);

        if($orderID != null){
            foreach($order->products as $product){
                $log->products()->create(['product_id' => $product->product_id, 'product_attribute_id' => $product->product_attribute_id, 'quantity' => $product->quantity, 'product_price' => $product->price]);

                if($product->product_id != null && $product->product_attribute_id == null){
                    $productDB = Product::find($product->product_id);
                    $productDB->stock = $productDB->stock - $product->quantity;
                    $productDB->save();
                }
                if($product->product_id != null && $product->product_attribute_id != null){
                    //$productAttributeDB = ProductAttribute::find($product->product_attribute_id);
                    $productAttributeDB = ProductAttribute::where('id',$product->product_attribute_id)->where('product_id',$product->product_id)->first();
                    $productAttributeDB->stock = $productAttributeDB->stock - $product->quantity;
                    $productAttributeDB->save();
                }                
            }
        }

        if(($productID != null || $productAttributeID  != null) && $quantity  != null && $productPrice  != null){
            $log->products()->create(['product_id' => $productID, 'product_attribute_id' => $productAttributeID, 'quantity' => $quantity, 'product_price' => $productPrice]);

            // if($productID != null){
            //     $productDB = Product::find($productID);
            //     if($type == 0){
            //         $productDB->stock = $productDB->stock - $quantity;
            //     }else{
            //         $productDB->stock = $productDB->stock + $quantity;
            //     }
            //     $productDB->save();
            // }
            // if($productAttributeID != null){
            //     $productAttributeDB = ProductAttribute::where('id',$productAttributeID)->where('product_id',$productID)->first();
            //     if($type == 0){
            //         $productAttributeDB->stock = $productAttributeDB->stock - $quantity;
            //     }else{
            //         $productAttributeDB->stock = $productAttributeDB->stock + $quantity;
            //     }
            //     $productAttributeDB->save();
            // }
        }

        return $log ? true : false;
    }


    public static function getPriceRange(){

        $productMax = Product::where('status',1)->max('price');
        $productMin = Product::where('status',1)->min('price');
        $productAttributeMax = ProductAttribute::max('price');
        $productAttributeMin = ProductAttribute::min('price');
        //print $productAttributeMin; die; 

        // $max = ($productMax > $productAttributeMax) ? $productMax : ($productAttributeMax ? $productAttributeMax : $productMax);
        // $min = ($productMin < $productAttributeMin) ? $productMin : ($productAttributeMin ? $productAttributeMin : $productMin);
        $max = ($productMax > $productAttributeMax) ? $productMax : $productAttributeMax;
        $min = ($productMin < $productAttributeMin) ? $productMin : $productAttributeMin;
        //print_r(array('max' => $max, 'min' => $min)); die;
        return array('max' => $max, 'min' => $min);
    }




    public static function getPages(){

        $pages = Page::where('status',1)->get();
        //print_r($pages); die;
        return $pages;
    }


    public static function getCountry(){

        $country = Setting::where('key','country')->first();
        //print_r($country); die;
        if($country && $country->value){
            return $country->value;
        }else{
            //print 'a'; die;
            return config('constants.CONFIG.country');
        }
        
    }

    public static function getReviewShowStatus(){

        $reviews = Setting::where('key','reviews')->first();
        //print_r($country); die;
        if(!$reviews){
            return false;
        }
        if($reviews->value == 'true'){
            return true;
        }else{
            return false;
        }
    }


    public static function getFacebookPixelTags($product){
        $facebook = SocialMarketing::where('type','facebook')->where('status', true)->first();
        if(Route::current()->uri() == 'product/{slug}' && $facebook){
            if(isset($product)){
                //print '<pre>'; print_r($product);
                $currency = Self::getCurrency();
            
                $openGraph = '<meta property="og:title" content="'.$product->name.'">
                <meta property="og:description" content="'.$product->short_description.'">
                <meta property="og:url" content="'.route('product',$product->slug).'">';
                
                $pixelImage = asset('storage/products/').'/'.$product->id.'/'.$product->image;                
                if($pixelImage){
                $openGraph .= '<meta property="og:image" content="'.$pixelImage.'">'; 
                }                
                if(isset($product->brand)){
                $openGraph .= '<meta property="product:brand" content="'.$product->brand.'">';
                }
                $stockVal = ($product->stock > 0) ? 'in stock' : 'out of stock';
                
                // <meta property="product:condition" content="new">
                
                $openGraph .= '<meta property="product:availability" content="'.$stockVal.'">
                
                <meta property="product:price:amount" content="'.$product->getPriceNumeric().'">
                <meta property="product:price:currency" content="'.$currency['currency_iso_code'].'">';
                
                
                $jsonLd = '<div itemscope itemtype="http://schema.org/Product">';
                        
                if(isset($product->brand)){
                    $jsonLd .= '<meta itemprop="brand" content="'.$product->brand.'">';
                }
                  $jsonLd .= '
                  <meta itemprop="name" content="'.$product->name.'">
                  <meta itemprop="description" content="'.$product->short_description.'">
                  <meta itemprop="productID" content="'.$product->slug.'">
                  <meta itemprop="url" content="'.route('product',$product->slug).'">';
                  if($pixelImage){
                    $jsonLd .= '<meta itemprop="image" content="'.$pixelImage.'">'; 
                    }
                  $jsonLd .= '
                  <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <link itemprop="availability" href="'.$stockVal.'">
                    
                    <meta itemprop="price" content="'.$product->getPriceNumeric().'">
                    <meta itemprop="priceCurrency" content="'.$currency['currency_iso_code'].'">
                  </div>
                </div>';
                
                // <link itemprop="itemCondition" href="new">
                
                
                $schema = '<script type="application/ld+json">
                            {
                              "@context":"https://schema.org",
                              "@type":"Product",
                              "productID":"'.$product->slug.'",
                              "name":"'.$product->name.'",
                              "description":"'.$product->short_description.'",
                              "url":"'.route('product',$product->slug).'",
                              "image":"'.$pixelImage.'",
                              "brand":"'.$product['brand'].'",
                              "offers": [
                                {
                                  "@type": "Offer",
                                  "price": "'.$product->getPriceNumeric().'",
                                  "priceCurrency": "'.$currency['currency_iso_code'].'",
                                  
                                  "availability": "'.$stockVal.'"
                                }
                              ]
                            }
                            
                            </script>';
                
                return array('script' => $facebook->script, 'openGraph' => $openGraph, 'jsonLd' => $jsonLd, 'schema' => $schema);
            }
        }
    }
    

    public static function getSeoValues() {

        $routeKey = Route::current()->uri();
        //print_R($routeKey); die;
        if (preg_match('/\{.*\}/', $routeKey)) {
            $routeKey = Route::current()->parameter('category');
        }
        
        $seo = Seo::where('page',$routeKey)->first();
        //print '<pre>'; print_r($seo); die;

        $seoTitleDB=Setting::where('key','seo_title')->first();
        $seoTitle = ($seoTitleDB && $seoTitleDB->value) ? $seoTitleDB->value :  null;

        $seoDescriptionDB=Setting::where('key','seo_description')->first();
        $seoDescription = ($seoDescriptionDB && $seoDescriptionDB->value) ? $seoDescriptionDB->value :  null;

        $seoKeywordsDB=Setting::where('key','seo_keywords')->first();
        $seoKeywords = ($seoKeywordsDB && $seoKeywordsDB->value) ? $seoKeywordsDB->value :  null;

        if($seo){
            return $seo;
        }elseif($seoTitle || $seoDescription || $seoKeywords){
            return array('seo_title'=> $seoTitle, 'seo_keywords' => $seoKeywords, 'seo_description' => $seoDescription);
        }else{
            return array('seo_title'=> config('constants.CONFIG.seo_title') , 'seo_keywords' => config('constants.CONFIG.seo_keywords'), 'seo_description' => config('constants.CONFIG.seo_description'));
        }
    
    }


    public static function getLightLogo(){
        $logo=Setting::where('key','light_logo')->first();
        if($logo && $logo->value != null){
            return asset('storage/logo/').'/'.$logo->value;
        }else{
            return asset(config('constants.CONFIG.light_logo'));
        }
    }

    public static function getDarkLogo(){
        $logo=Setting::where('key','dark_logo')->first();
        if($logo && $logo->value != null){
            return asset('storage/logo/').'/'.$logo->value;
        }else{
            return asset(config('constants.CONFIG.dark_logo'));
        }
    }

    public static function getFavicon(){
        $logo=Setting::where('key','favicon')->first();
        if($logo && $logo->value != null){
            return asset('storage/favicon/').'/'.$logo->value;
        }else{
            return asset(config('constants.CONFIG.favicon'));
        }
    }

    
    public static function getWebsiteConfig($method = null){
        $settingObj = new Setting();
        //print '<pre>'; print_r($settingObj); die;
        $config = [];
        
        if($method == null || ($method != null && $method == 'email')){
            $email = $settingObj->where('key', 'email')->first();
            if($email && $email->value){
                $config['email'] = $email->value;
            }else{
                $config['email'] = config('constants.CONTACT.email');
            }
        }

        if($method == null || ($method != null && ($method == 'country_code' || $method == 'phone' || $method == 'whatsapp'))){
            $countryCode = $settingObj->where('key', 'country_code')->first();
            if($countryCode && $countryCode->value){
                $config['country_code'] = $countryCode->value;
            }else{
                $config['country_code'] = config('constants.CONTACT.country_code');
            }
        }

        if($method == null || ($method != null && $method == 'phone')){
            $phone = $settingObj->where('key', 'phone')->first();
            if($phone && $phone->value){
                $config['phone'] = '+'.$config['country_code'].'-'.$phone->value;
            }else{
                $phones = Self::makePhonesText($config['country_code'], config('constants.CONTACT.phone'));
                $config['phone'] = $phones;
            }
        }

        if($method == null || ($method != null && $method == 'whatsapp')){
            $whatsapp = $settingObj->where('key', 'whatsapp')->first();
            if($whatsapp && $whatsapp->value){
                $config['whatsapp'] = 'https://wa.me/'.$config['country_code'].$whatsapp->value;
            }else{
                $config['whatsapp'] = config('constants.CONTACT.whatsapp');
            }
        }

        if($method == null || ($method != null && $method == 'whatsapp_number')){
            $whatsapp = $settingObj->where('key', 'whatsapp')->first();
            if($whatsapp && $whatsapp->value){
                $config['whatsapp_number'] = '+'.$config['country_code'].$whatsapp->value;
            }else{
                $config['whatsapp_number'] = config('constants.CONTACT.whatsapp_number');
            }
        }

        if($method == null || ($method != null && $method == 'address')){
            $address = $settingObj->where('key', 'address')->first();
            if($address && $address->value){
                $config['address'] = $address->value;
            }else{
                $config['address'] = config('constants.ADDRESS.apartment').', '.config('constants.ADDRESS.street').', '.config('constants.ADDRESS.locality').' '.config('constants.ADDRESS.city').', '.config('constants.ADDRESS.state').' '.config('constants.ADDRESS.postcode').', '.config('constants.ADDRESS.country');
            }
        }

        if($method == null || ($method != null && $method == 'map_link')){
            $mapLink = $settingObj->where('key', 'map_link')->first();
            if($mapLink && $mapLink->value){
                $config['map_link'] = $mapLink->value;
            }else{
                $config['map_link'] = config('constants.ADDRESS.map_link');
            }
        }

        if($method == null || ($method != null && $method == 'timings_weekdays')){
            $timingsWeekdays = $settingObj->where('key', 'hours_week')->first();
            if($timingsWeekdays && $timingsWeekdays->value){
                $config['timings_weekdays'] = $timingsWeekdays->value;
            }else{
                $config['timings_weekdays'] = config('constants.BUSINESS.timings_weekdays');
            }
        }

        if($method == null || ($method != null && $method == 'timings_weekend')){
            $timingsWeekend = $settingObj->where('key', 'hours_week_end')->first();
            if($timingsWeekend && $timingsWeekend->value){
                $config['timings_weekend'] = $timingsWeekend->value;
            }else{
                $config['timings_weekend'] = config('constants.BUSINESS.timings_weekend');
            }
        }

        if($method == null || ($method != null && $method == 'coupon')){
            $coupon = $settingObj->where('key', 'coupon')->first();
            if($coupon && $coupon->value){
                if($coupon->value == 'true'){
                    $config['coupon'] = true;
                }else{
                    $config['coupon'] = false;
                }
            }else{
                $config['coupon'] = config('constants.CONFIG.coupon');
            }
        }

        if($method == null || ($method != null && $method == 'social')){
            $facebook = $settingObj->where('key', 'facebook_social')->first();
            if($facebook && $facebook->value && $facebook->value != '#'){
                $config['social']['facebook'] = $facebook->value;
            }else{
                $config['social']['facebook'] = config('constants.SOCIAL.facebook');
            }
        }

        if($method == null || ($method != null && $method == 'social')){
            $instagram = $settingObj->where('key', 'instagram_social')->first();
            if($instagram && $instagram->value && $instagram->value != '#'){
                $config['social']['instagram'] = $instagram->value;
            }else{
                $config['social']['instagram'] = config('constants.SOCIAL.instagram');
            }
        }

        if($method == null || ($method != null && $method == 'social')){
            $twitter = $settingObj->where('key', 'twitter_social')->first();
            if($twitter && $twitter->value && $twitter->value != '#'){
                $config['social']['twitter'] = $twitter->value;
            }else{
                $config['social']['twitter'] = config('constants.SOCIAL.twitter');
            }
        }

        if($method == null || ($method != null && $method == 'social')){
            $pinterest = $settingObj->where('key', 'pinterest_social')->first();
            if($pinterest && $pinterest->value && $pinterest->value != '#'){
                $config['social']['pinterest'] = $pinterest->value;
            }else{
                $config['social']['pinterest'] = config('constants.SOCIAL.pinterest');
            }
        }

        if($method == null || ($method != null && $method == 'social')){
            $youtube = $settingObj->where('key', 'youtube_social')->first();
            if($youtube && $youtube->value && $youtube->value != '#'){
                $config['social']['youtube'] = $youtube->value;
            }else{
                $config['social']['youtube'] = config('constants.SOCIAL.youtube');
            }
        }

        if($method == null || ($method != null && $method == 'currency_sign')){
            $currencySign = $settingObj->where('key', 'currency_sign')->first();
            if($currencySign && $currencySign->value){
                $config['currency_sign'] = $currencySign->value;
            }else{
                $config['currency_sign'] = config('constants.CONFIG.currency_sign');
            }
        }

        if($method == null || ($method != null && $method == 'product_services')){
            $productServices = $settingObj->where('key', 'product_services')->first();
            if($productServices && $productServices->value){
                if($productServices->value == 'true'){
                    $config['product_services'] = true;
                }else{
                    $config['product_services'] = false;
                }
            }else{
                $config['product_services'] = config('constants.CONFIG.product_services');
            }
        }

        if($method == null || ($method != null && $method == 'product_addon')){
            $productAddon = $settingObj->where('key', 'product_addon')->first();
            if($productAddon && $productAddon->value){
                if($productAddon->value == 'true'){
                    $config['product_addon'] = true;
                }else{
                    $config['product_addon'] = false;
                }
            }else{
                $config['product_addon'] = config('constants.CONFIG.product_addon');
            }
        }

        if($method == null || ($method != null && $method == 'local_pickup')){
            $localPickup = $settingObj->where('key', 'local_pickup')->first();
            if($localPickup && $localPickup->value){
                if($localPickup->value == 'true'){
                    $config['local_pickup'] = true;
                }else{
                    $config['local_pickup'] = false;
                }
            }else{
                $config['local_pickup'] = config('constants.CONFIG.local_pickup');
            }
        }

        if($method == null || ($method != null && $method == 'is_enquiry_website')){
            $isEnquiryWebsite = $settingObj->where('key', 'is_enquiry_website')->first();
            if($isEnquiryWebsite && $isEnquiryWebsite->value){
                if($isEnquiryWebsite->value == 'true'){
                    $config['is_enquiry_website'] = true;
                }else{
                    $config['is_enquiry_website'] = false;
                }
            }else{
                $config['is_enquiry_website'] = config('constants.CONFIG.is_enquiry_website');
            }
        }

        if($method == null || ($method != null && $method == 'reviews')){
            $isReviews = $settingObj->where('key', 'reviews')->first();
            if($isReviews && $isReviews->value){
                if($isReviews->value == 'true'){
                    $config['reviews'] = true;
                }else{
                    $config['reviews'] = false;
                }
            }else{
                $config['reviews'] = config('constants.CONFIG.reviews');
            }
        }

        if($method == null || ($method != null && $method == 'is_email_verify')){
            $isEnquiryWebsite = $settingObj->where('key', 'is_email_verify')->first();
            if($isEnquiryWebsite && $isEnquiryWebsite->value){
                if($isEnquiryWebsite->value == 'true'){
                    $config['is_email_verify'] = true;
                }else{
                    $config['is_email_verify'] = false;
                }
            }else{
                $config['is_email_verify'] = config('constants.CONFIG.is_email_verify');
            }
        }

        if($method == null || ($method != null && $method == 'min_cart_amount')){
            $minCartAmount = $settingObj->where('key', 'min_cart_amount')->first();
            if($minCartAmount && $minCartAmount->value){
                $config['min_cart_amount'] = $minCartAmount->value;
            }else{
                $config['min_cart_amount'] = config('constants.CONFIG.min_cart_amount');
            }
        }

        


        

        // $email = $settingObj->where('key', 'email')->first();
        // if($email && $email->value){
        //     $config['email'] = $email->value;
        // }else{
        //     $config['email'] = config('constants.CONTACT.email');
        // }

        //print '<pre>'; print_r($config); die;
        return $config;

    }

    public static function makePhonesText($countryCode, $phones){
        $phoneText = '';
        foreach($phones as $phone){
            $phoneText .= '+'.$countryCode.'-'.$phone.', ';
        }
        $phoneText = rtrim($phoneText, ', ');
        return $phoneText;
    }

    public static function getPaymentSettings($method = null){
        $settingObj = new Setting();
        //print '<pre>'; print_r($settingObj); die;
        $config = [];
        
        if($method == null || ($method != null && $method == 'cash')){
            $cashOnDelivery = $settingObj->where('key', 'cash_on_delivery')->first();
            //print '<pre>'; print_r($cashOnDelivery); die;
            if($cashOnDelivery){
                if($cashOnDelivery->value == true){
                    $config['cash'] = $cashOnDelivery->value;
                }
            }else{
                if(config('constants.PAYMENTS.cash_on_delivery') == true){
                    $config['cash'] = config('constants.PAYMENTS.cash_on_delivery');
                }
            }
        }
        
        if($method == null || ($method != null && $method == 'instamojo')){
            $instamojo = $settingObj->where('key', 'instamojo')->first();
            if($instamojo){
                if($instamojo->value == true){
                    $config['instamojo'] = $instamojo->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.instamojo') == true){
                    $config['instamojo'] = config('constants.PAYMENTS.instamojo');
                }
                
            }
        }

        if($method == null || ($method != null && $method == 'paypal')){
            $paypal = $settingObj->where('key', 'paypal')->first();
            if($paypal){
                if($paypal->value == true){
                    $config['paypal'] = $paypal->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.paypal') == true){
                    $config['paypal'] = config('constants.PAYMENTS.paypal');
                }
                
            }
        }

        if($method == null || ($method != null && $method == 'stripe_card')){
            $stripeCard = $settingObj->where('key', 'stripe_card')->first();
            if($stripeCard){
                if($stripeCard->value == true){
                    $config['stripe_card'] = $stripeCard->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.stripe_card') == true){
                    $config['stripe_card'] = config('constants.PAYMENTS.stripe_card');
                }
                
            }
        }

        if($method == null || ($method != null && $method == 'razorpay')){
            $stripeCard = $settingObj->where('key', 'razorpay')->first();
            if($stripeCard){
                if($stripeCard->value == true){
                    $config['razorpay'] = $stripeCard->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.razorpay') == true){
                    $config['razorpay'] = config('constants.PAYMENTS.razorpay');
                }
                
            }
        }

        if($method == null || ($method != null && $method == 'stripe_checkout')){
            $stripeCard = $settingObj->where('key', 'stripe_checkout')->first();
            if($stripeCard){
                if($stripeCard->value == true){
                    $config['stripe_checkout'] = $stripeCard->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.stripe_checkout') == true){
                    $config['stripe_checkout'] = config('constants.PAYMENTS.stripe_checkout');
                }
                
            }
        }

        if($method == null || ($method != null && $method == 'stripe_express_checkout')){
            $stripeCard = $settingObj->where('key', 'stripe_express_checkout')->first();
            if($stripeCard){
                if($stripeCard->value == true){
                    $config['stripe_express_checkout'] = $stripeCard->value;
                }
            }else{
                //print 'a'; die;
                if(config('constants.PAYMENTS.stripe_express_checkout') == true){
                    $config['stripe_express_checkout'] = config('constants.PAYMENTS.stripe_express_checkout');
                }
                
            }
        }

        //print '<pre>'; print_r($config); die;
        return $config;
    }
    public static function isPaymentMethodEnabled($method){
        $result = Self::getPaymentSettings($method);
        //print '<pre>'; print_r($result); die;
        return count($result) > 0 ? true : false;
    }

    
    public static function getAccountingSettings($method = null){
        $settingObj = new Setting();
        //print '<pre>'; print_r($settingObj); die;
        $config = [];

        if($method == null || ($method != null && $method == 'is_xero')){
            $isEnquiryWebsite = $settingObj->where('key', 'is_xero')->first();
            if($isEnquiryWebsite && $isEnquiryWebsite->value){
                if($isEnquiryWebsite->value == true){
                    $config['is_xero'] = true;
                }else{
                    $config['is_xero'] = false;
                }
            }else{
                $config['is_xero'] = config('constants.ACCOUNTING.is_xero');
            }
        }

        //print '<pre>'; print_r($config); die;
        return $config;
    }
    


    public static function getServicesAddedDetails($product, $itemAttributeIDS){
        //print '<pre>'; print_r($product->services->toArray()); die;

        $user = Auth::user();
        $cartObj = Self::getCartObj($user);
        //print $product->id; die;
        $cartObj->where('product_id',$product->id);

        if($itemAttributeIDS != null && count($itemAttributeIDS) > 0){
            $cartObj->whereIn('product_attribute_id',$itemAttributeIDS);
        }

        $cart = $cartObj->first();
        if(!$cart){
            return [];
        }
        $addedServices = $cart->services;
        //print '<pre>'; print_r($addedServices); die;
        //print '<pre>'; print_r($addedServices->toArray());

        if(count($addedServices) <= 0){
            return [];
        }

        $array = [];
        if($product && count($product->services) > 0){
            //print '<pre>'; print_r($product->services->toArray()); die;
            foreach($product->services as $k => $service){

                foreach($addedServices as $k2 => $addedService){
                    if($addedService->product_service_id == $service->id){
                        //$array[$k]['service'] = $service->slug;
                        $array[] = $service->slug;
                        
                    }
                    
                }
                // if(CartService)
                // $array[$key]['service'] = $service->slug;

            }
        }

        return $array;
    }
    


    public static function searchArray($key, $value, $array, $returnMultiArray = true){
        $result = array_filter($array, function ($item) use ($key, $value) {
            return isset($item[$key]) && $item[$key] === $value;
        });
        if($returnMultiArray){
            return $result ? reset($result) : null;
        }
        return $result;
    }



    
    public static function getCartItemsTotal($cart){
        // $cartObj = Self::getCartObj($user);
        // $cart=$cartObj->get();
        $price = 0;
        foreach($cart as $cartSingle){
            $price = $price + $cartSingle->productPrice() * $cartSingle->quantity;
        }
        return $price;
    }


    public static function getCouponObj($user){
        if($user){
            $coupon = $user->coupon()->select('user_coupons.*','coupons.code','coupons.amount_type','coupons.amount_value')->join('coupons','coupons.id','=','user_coupons.coupon_id')->first();
        }else{
            $uuid = Self::getUserUUID();
            $coupon = UserCoupon::select('user_coupons.*','coupons.code','coupons.amount_type','coupons.amount_value')->join('coupons','coupons.id','=','user_coupons.coupon_id')->where('uuid',$uuid)->first();
        }
        return $coupon;
    }

    public static function getCouponDetails($user){

        $coupon = Self::getCouponObj($user);

        if($coupon){
            //print '<pre>'; print_r($coupon); die;
            if($coupon->amount_type == 'percentage'){
                $cartObj = Self::getCartObj($user);
                $cart=$cartObj->get();
                $price = Self::getCartItemsTotal($cart);
                //print $price; die;
                $coupon->calculated_discount = Self::numberFormat(($price * $coupon->amount_value) / 100);
            }else{
                $coupon->calculated_discount = Self::numberFormat($coupon->amount_value);
            }
        }

        return $coupon;
    }

    // public static function getCouponDiscount($user){

    //     $coupon = Self::getCouponDetails($user);
    //     if($coupon){
    //         //print '<pre>'; print_r($coupon); die;
    //         if($coupon->amount_type == 'percentage'){
    //             $cartObj = Self::getCartObj($user);
    //             $cart=$cartObj->get();
    //             $price = Self::getCartItemsTotal($cart);
    //             //print $price; die;
    //             return Self::numberFormat(($price * $coupon->amount_value) / 100);
    //         }else{
    //             return Self::numberFormat($coupon->amount_value);
    //         }
    //     }
    // }


    public static function validateCoupon($user, $code = null, $email = null){

        if($code == null){
            if($user){
                $userCoupon = $user->coupon()->first();
                
            }else{
                $uuid = Self::getUserUUID();
                // user email here at checkout
                $userCoupon = UserCoupon::where('uuid',$uuid)->first();

                // user email here at checkout
            }
            // print '<pre>'; print_r($userCoupon); die;
            if(!$userCoupon){
                return array('result'=>true);
            }
            $coupon = Coupon::find($userCoupon->coupon_id);
        }else{
            $coupon = Coupon::where('code',$code)->where('status',1)->first();
        }

        // print '<pre>'; print_r($coupon->toArray()); die;

        if(!$coupon){
            return array('result'=>false, 'message' => 'Coupon code not valid', 'code' => $code);
        }
        

        if($coupon->valid_from != null){
            $today = Carbon::today();
            $from = Carbon::parse($coupon->valid_from);
            if($from > $today){
                return array('result'=>false, 'message' => 'The Coupon code is not valid yet', 'code' => $coupon->code);
            }
        }

        if($coupon->valid_to != null){
            $today = Carbon::today();
            $to = Carbon::parse($coupon->valid_to);
            if($to < $today){
                return array('result'=>false, 'message' => 'The Coupon code has expired', 'code' => $coupon->code);
            }
        }

        if($coupon->type == 'single'){
            if($user){
                // $count = $user->orders()->where(['coupon_id'=> $coupon->id, 'is_payment_done'=> 1, 'status'=> 1])->count();
                $count = $user->orders()->where(['coupon_id'=> $coupon->id, 'status'=> 1])->count();
                if($count > 0){
                    return array('result'=>false, 'message' => 'The Coupon code is already used', 'code' => $coupon->code);
                }
            }elseif($email != null){
                // $count = Order::where(['email' => $email, 'coupon_id'=> $coupon->id, 'is_payment_done'=> 1, 'status'=> 1])->count();
                $count = Order::where(['email' => $email, 'coupon_id'=> $coupon->id, 'status'=> 1])->count();
                if($count > 0){
                    return array('result'=>false, 'message' => 'The Coupon code is already used', 'code' => $coupon->code);
                }
            }
        }

        if($coupon->type == 'multiple' && $coupon->no_of_times != null){
            if($user){
                // $countMultiple = $user->orders()->where(['coupon_id'=> $coupon->id, 'is_payment_done'=> 1, 'status'=> 1])->count();
                $countMultiple = $user->orders()->where(['coupon_id'=> $coupon->id, 'status'=> 1])->count();
                if($countMultiple >= $coupon->no_of_times){
                    return array('result'=>false, 'message' => 'Number of coupon code uses are exhausted', 'code' => $coupon->code);
                }
            }elseif($email != null){
                // $countMultiple = Order::where(['email' => $email, 'coupon_id'=> $coupon->id, 'is_payment_done'=> 1, 'status'=> 1])->count();
                $countMultiple = Order::where(['email' => $email, 'coupon_id'=> $coupon->id, 'status'=> 1])->count();
                if($countMultiple >= $coupon->no_of_times){
                    return array('result'=>false, 'message' => 'Number of coupon code uses are exhausted', 'code' => $coupon->code);
                }
            }
        }

        $cartObj = Self::getCartObj($user);

        if($coupon->applicable_on_products != null){
            $productsDB = json_decode($coupon->applicable_on_products);
            $countProductsDB = count($productsDB);
            $countApplicableProducts = $cartObj->whereIn('cart.product_id', $productsDB)->count();
            if($countApplicableProducts < $countProductsDB){
                return array('result'=>false, 'message' => 'Please add remaining products to apply this coupon code', 'code' => $coupon->code);
            }
        }

        if($coupon->min_product_quantity != null){
            $countQty=$cartObj->count();
            if($countQty < $coupon->min_product_quantity){
                return array('result'=>false, 'message' => 'Please add minimum of '.$coupon->min_product_quantity.' products to apply this coupon code', 'code' => $coupon->code);
            }
        }

        if($coupon->min_price != null){
            $currency = Self::getCurrency();
            $cart=$cartObj->get();
            $price = Self::getCartItemsTotal($cart);
            if($price < $coupon->min_price){
                return array('result'=>false, 'message' => 'Please add minimum price of '.$currency['sign'].''.$coupon->min_price.' products to apply this coupon', 'code' => $coupon->code);
            }
        }

        if($coupon->no_of_times  != null){
            if($user){
                if($user->coupon()->where('coupon_id',$coupon->id)->count() > $coupon->no_of_times){
                    return array('result'=>false, 'message' => 'Maximum limit reach', 'code' => $coupon->code);
                }
            }else{
                $uuid = Self::getUserUUID();
                // user email here at checkout
                if(UserCoupon::where('coupon_id',$coupon->id)->where('uuid',$uuid)->count() > $coupon->no_of_times){
                    return array('result'=>false, 'message' => 'Maximum limit reach', 'code' => $coupon->code);
                }
                // user email here at checkout
            }
        }

        return array('result'=>true, 'coupon' => $coupon);
    }


    public static function makeOrderShowPrices($order){
        // print '<pre>'; print_R($order->toArray()); die;

        if($order->payment){
            $order->payment->total = Self::priceFormat($order->payment->total);
            $order->payment->discount = Self::priceFormat($order->payment->discount);
            $order->payment->coupon_discount = Self::priceFormat($order->payment->coupon_discount);
            $order->payment->shipping = Self::priceFormat($order->payment->shipping);
            $order->payment->products_service = Self::priceFormat($order->payment->products_service);
            $order->payment->tax = Self::priceFormat($order->payment->tax);
            $order->payment->amount = Self::priceFormat($order->payment->amount);
        }
        
        foreach($order->products as $key => $product){
            $order->products[$key]->price = Self::priceFormat($order->products[$key]->price);
            $order->products[$key]->old_price = Self::priceFormat($order->products[$key]->old_price);
            $order->products[$key]->sale_price = Self::priceFormat($order->products[$key]->sale_price);
            $order->products[$key]->final_price = Self::priceFormat($order->products[$key]->final_price);
            $order->products[$key]->state_tax_amount = $order->products[$key]->state_tax_amount != null ? Self::priceFormat($order->products[$key]->state_tax_amount) : null;
            $order->products[$key]->central_tax_amount = $order->products[$key]->central_tax_amount != null ? Self::priceFormat($order->products[$key]->central_tax_amount) : null;
            $order->products[$key]->integrated_tax_amount = $order->products[$key]->integrated_tax_amount != null ? Self::priceFormat($order->products[$key]->integrated_tax_amount) : null;
            $order->products[$key]->tax_value = Self::priceFormat($order->products[$key]->tax_value);
            $order->products[$key]->sub_total = $order->products[$key]->sub_total != null ? Self::priceFormat($order->products[$key]->sub_total) : null;
            
        }
        
        // print '<pre>'; print_R($order->toArray()); die;
        return $order;

    }

    public static function isValidDate($myDateString){
        return (bool)strtotime($myDateString);
    }

    public static function allProducts(){
        $products = Product::where(['status' => '1'])->get();
        //$products = json_decode(json_encode($products),true);
        $array = [];
        foreach($products as $key => $product){
            $array[$key]['name'] = $product->name;
            $array[$key]['price'] = $product->getPrice();
            $array[$key]['old_price'] = $product->getOldPrice();
            $array[$key]['image'] = asset('storage/products/').'/'.$product->id.'/'.$product->image;
            $array[$key]['link'] = route('product', $product->slug);
        }
        return $array;
    }

    public static function getEnquiresTotal($enquiries){
        $totalAmount = 0;
        foreach($enquiries as $key => $enquiry){
            $enquiryProductsAmount = 0;
            foreach($enquiry->products as $product){
                $enquiryProductsAmount = $enquiryProductsAmount + $product->final_price;
            }
            $enquiries[$key]->enquiries_total = $enquiryProductsAmount;
            $totalAmount = $totalAmount + $enquiryProductsAmount;
        }
        return $totalAmount;
        
    }


    public static function validateImportData($file){
        try {

            // $data = Excel::toCollection(new ValidateImportProduct, $file); // Read the file
            // $data = Excel::import(new ValidateImportProduct, $file); // Read the file

            $import = new ValidateImportProduct();
            $data = Excel::import($import, $file); // Read the file

            // if(count($import->relationErrorArray) > 0){
            //     return array('result' => false, 'errors' => $import->relationErrorArray, 'rows' => $import->data->toArray());
            // }

            return array('result' => true, 'rows' => $import->data->toArray());
            

        } catch (ValidationException $e) {

            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = [
                    'row' => $failure->row(), // Row where error occurred
                    'attribute' => $failure->attribute(), // Column index
                    'errors' => $failure->errors(), // Validation messages
                    // 'values' => $failure->values(), // Data in the row
                ];
            }
                        
            $data = Excel::toArray(new ValidateImportProduct, $file); // Read the file
            
            return array('result' => false, 'errors' => $errors, 'rows' => $data[0]);
            
        }
    }
    
    public static function gramsToPounds($grams) {
        $pounds = $grams * 0.00220462;
        return round($pounds, 4);
    }

    public static function getCartProductsWeight($user){


        $cart = Helper::getCartShowList($user);

        $weight = 0;
        foreach($cart as $cartSingle){
            // print '<pre>'; print_r($cartSingle->toArray());
            if($cartSingle->is_variant){
                $weight = $weight + ($cartSingle->attribute->shipping_weight * $cartSingle->quantity);
            }else{
                $weight = $weight + ($cartSingle->shipping_weight * $cartSingle->quantity);
            }
        }
        // return $weight;
        return Self::gramsToPounds($weight);
        
    }

    public static function getStateShippingAmount($state){
        // print'<pre>'; print_r($state); die;
        $user = Auth::user();
        $weight = Self::getCartProductsWeight($user);

        // print $weight; die;
        $shippingPrice = ShippingPrice::where('min_weight', '<=', $weight)->where('max_weight', '>=', $weight)->where('zone', $state->zone)->first();
        // print '<pre>'; print_r($shippingPrice->toArray()); die;
        if($shippingPrice){
            return array('result' => true, 'price' => $shippingPrice->price);
        }else{
            return array('result' => false, 'message' => "There is an issue with the shipping, please contact administrator");
        }
        // print $weight; die;
        // print '<pre>'; print_r($state->toArray()); die;

    }
    

    public static function savePaymentCard($paymentMethod) { 

        $user = Auth::user(); 
        // Create Stripe customer if not exists
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Add method to Stripe
        $user->addPaymentMethod($paymentMethod);

        // Set as default
        $user->updateDefaultPaymentMethod($paymentMethod);

        // Get the Stripe payment method details
        $stripePM = $user->findPaymentMethod($paymentMethod);
        // print '<pre>'; print_r($stripePM); die;

        // Optionally set all others as non-default
        $user->paymentMethods()->where('user_id', $user->id)->update(['is_default' => false]);

        // Save locally
        $paymentMethod = $user->paymentMethods()->create([
            'user_id' => $user->id,
            'type' => $stripePM->type,
            'payment_method' => $stripePM->id,
            'provider' => $stripePM->card->brand,
            'last_four' => $stripePM->card->last4,
            'is_default' => true,
        ]); 
        
        return $paymentMethod ;
    }

    public static function metaStatus($product) { 
        if($product){
            $count = 0;
            if(isset($product->seo_title) && $product->seo_title !=''){
                $count ++;
            }
            if(isset($product->seo_description) && $product->seo_description !=''){
                $count ++;
            }
            if(isset($product->seo_keywords) && $product->seo_keywords !=''){
                $count ++;
            }

            if($count == 3){
                return '<span class="badge bg-success">Completed</span>';
            } elseif($count == 2){
                return '<span class="badge bg-info">Partial</span>';
            } elseif($count == 1) {
                return '<span class="badge bg-yellow">Pending</span>';  
            }
        }
        return '<span class="badge bg-danger">Pending</span>';  
    }
    

}