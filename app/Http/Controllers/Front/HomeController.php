<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeDetail;
use App\Models\Banner;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\ContactRequest;
use App\Models\Order;
use App\Models\Enquiry;
use App\Models\Subscription;
use App\Models\Page;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\Rating;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\PasswordReset;
use Image;
use Validator;
use Mail;
use Str;


class HomeController extends Controller
{   
    private $prefix = 'front';
    private $folder = 'front';
    private $pagerecords;
    private $ratingPageRecords;

    public function  __construct(){
        $this->pagerecords = config('constants.FRONT_PAGE_RECORDS');
        $this->ratingPageRecords = config('constants.RATING_PAGE_RECORDS');
    }

    
    public function index(){
        //print asset(''); die;
        //return view($this->prefix.'.'.$this->folder.'.list')->with($data);
        // $categories = Helper::getCategories();
        //print '<pre>'; print_r($categories); die;
        
        // $categories = Category::where('status',1)->limit(6)->get();
        $categories = Helper::getCategoriesNav(true);

        

        $banners = Banner::where('status',1)->orderBy('serial', 'asc')->get();
        $brands = Brand::where('status',1)->get();
        $gallery = Gallery::where('status',1)->get();
        $videos = Video::where('status',1)->get();
        $testimonials = Testimonial::where('status',1)->get();

        $blogs = Blog::select('blog_categories.name as category_name', 'blogs.*')->join('blog_categories','blog_categories.id','=','blogs.blog_category_id')->where('blogs.status',true)->latest()->limit(3)->get();

        $data = array('categories' => $categories, 'banners' => $banners, 'brands' => $brands, 'videos' => $videos, 'gallery' => $gallery, 'testimonials' => $testimonials, 'blogs' => $blogs);
        return view($this->prefix.'.index')->with($data);
    }


    public function category(Request $request, $category, $type=null){
        // print $category; die;
        $page = $request->page;
        $query = Product::with(['categories' => function($subQuery){
            $subQuery->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        }]);

        $categoryID = [];

       
        
        $categoryDB = Category::where('slug', $category)->first();

        
        if(!$categoryDB){
            return to_route('products');
        }
        $categoryID = $categoryDB->id;

        $page = $request->page;
        $query = Product::with(['categories' => function($subQuery){
            $subQuery->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        }]);


        $countFilters = 0;
         
        $keyword = ($request->keyword != null) ? $request->keyword : null; 
        // $categories = ($request->categories != null) ? explode(",", $request->categories) : []; 
        $brands = ($request->brands != null) ? explode(",", $request->brands) : []; 
        $colors = ($request->colors != null) ? explode(",", $request->colors) : []; 
        $minprice =  $request->minprice; 
        $maxprice =  $request->maxprice; 
        $sort =  $request->sort; 
        $page = $request->page;
        //print_r($categories); die;
        // print_r($make); die;
        // die;
        // print_r($request->all()); die;

        $categoryID = null;
        
        $categoryDB = Category::where('slug', $category)->first();
        if(!$categoryDB){
            return to_route('products');
        }
        $categoryID = $categoryDB->id;

        
        if($categoryDB->title_h1){
            $categoryName = $categoryDB->title_h1;
        } else{
            $categoryName = "Canadian ".$categoryDB->name;
        }
        

        $query->whereHas('categories', function ($subQuery) use($categoryID){
            $subQuery->where('category_id', $categoryID);
        });

        $query->orderBy('is_best_sell', 'desc');


        if($keyword != null){
            $countFilters++;
            $query->where('name', 'like', '%'.$keyword.'%');
        }

        if($minprice && $maxprice){
            
            $query->where(function ($subQuery) use ($minprice,$maxprice) {
                $subQuery->where('price','>=', $minprice);
                $subQuery->where('price','<=', $maxprice);

                $subQuery->orWhereHas('attributes', function ($subSubQuery) use($minprice,$maxprice){
                    $subSubQuery->where('price','>=', $minprice);
                    $subSubQuery->where('price','<=', $maxprice);
                });

            });
        }

        // if($maxprice){
        //     $query->where('price','<=', $maxprice);
        //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
        //         $subQuery->where('price','<=', $maxprice);
        //     });
        // }

        $brandIDArray = [];
        foreach($brands as $brand){
            $brandDB = Brand::where('name', $brand)->first();
            if($brandDB){
                $brandIDArray[] = $brandDB->id;
            }
        }
        if(count($brandIDArray) > 0){
            $countFilters++;
            $query -> whereIn('brand_id', $brandIDArray);
        }

        // if(count($years) > 0){
        //     $countFilters++;
        //     $query -> whereIn('year', $years);
        // }
            

        if($sort != null){
            if($sort == "oldest"){
                $query->oldest();
            }
            if($sort == "latest"){
                $query->latest();
            }
            
            // if($sort == "price-ascending"){
            //     $query->orderBy('price', 'asc')->where('is_variant',0);                
            //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
            //         $subQuery->orderBy('price', 'asc');
            //     })->where('is_variant',1);
            // }
            // if($sort == "price-descending"){
            //     $query->orderBy('price', 'desc')->where('is_variant',0);
            //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
            //         $subQuery->orderBy('price', 'desc');
            //     })->where('is_variant',1);
            // }

            if ($sort == "price-ascending") {
                $query->orderByRaw("
                    CASE 
                        WHEN is_variant = 0 THEN price 
                        ELSE (
                            SELECT MIN(price) 
                            FROM product_attributes 
                            WHERE product_attributes.product_id = products.id
                        )
                    END ASC
                ");
            }
            
            if ($sort == "price-descending") {
                $query->orderByRaw("
                    CASE 
                        WHEN is_variant = 0 THEN price 
                        ELSE (
                            SELECT MAX(price) 
                            FROM product_attributes 
                            WHERE product_attributes.product_id = products.id
                        )
                    END DESC
                ");
            }
        }

         if($type=='abhi'){
             $products = $query->where('status',0)->paginate($this->pagerecords, ['*'], 'page', $page);
             $brandsFilters = Brand::where('status',1)->get();
        }else{
$products = $query->where('status',1)->paginate($this->pagerecords, ['*'], 'page', $page);

        $brandsFilters = Brand::where('status',1)->get();
        }


        

        $priceRangeFilters = Helper::getPriceRange();

        //print '<pre>'; print_r($priceRangeFilters); die;

        return view($this->prefix.'.product.category-products')->with(compact('products','brandsFilters','priceRangeFilters','category','categoryName', 'categoryDB'));
        

    }

    public function products(Request $request){
        $page = $request->page;
        $query = Product::with(['categories' => function($subQuery){
            $subQuery->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        }]);


        $countFilters = 0;
         
        $keyword = ($request->keyword != null) ? $request->keyword : null; 
        $categories = ($request->categories != null) ? explode(",", $request->categories) : []; 
        $brands = ($request->brands != null) ? explode(",", $request->brands) : []; 
        $colors = ($request->colors != null) ? explode(",", $request->colors) : []; 
        $minprice =  $request->minprice; 
        $maxprice =  $request->maxprice; 
        $sort =  $request->sort; 
        $page = $request->page;
        //print_r($categories); die;
        // print_r($make); die;
        // die;
        // print_r($request->all()); die;


        if($keyword != null){
            $countFilters++;
            $query->where('name', 'like', '%'.$keyword.'%');
        }

        $categoryIDArray = [];
        $categoryTitleArray = [];
        foreach($categories as $category){
            $categoryDB = Category::where('slug', $category)->first();
            if($categoryDB){
                $categoryIDArray[] = $categoryDB->id;
                $categoryTitleArray[] = $categoryDB->title;
            }
        }
       
        //print_r($categoryIDArray); die;
        if(count($categoryIDArray) > 0){
            $countFilters++;
            //$query -> whereIn('category_id', $categoryIDArray);
            //->has('categories')
            $query->whereHas('categories', function ($subQuery) use($categoryIDArray){
                $subQuery->whereIn('category_id', $categoryIDArray);
            });
        }

        if($minprice && $maxprice){
            
            $query->where(function ($subQuery) use ($minprice,$maxprice) {
                $subQuery->where('price','>=', $minprice);
                $subQuery->where('price','<=', $maxprice);

                $subQuery->orWhereHas('attributes', function ($subSubQuery) use($minprice,$maxprice){
                    $subSubQuery->where('price','>=', $minprice);
                    $subSubQuery->where('price','<=', $maxprice);
                });

            });
        }

        // if($maxprice){
        //     $query->where('price','<=', $maxprice);
        //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
        //         $subQuery->where('price','<=', $maxprice);
        //     });
        // }

        $brandIDArray = [];
        foreach($brands as $brand){
            $brandDB = Brand::where('name', $brand)->first();
            if($brandDB){
                $brandIDArray[] = $brandDB->id;
            }
        }
        if(count($brandIDArray) > 0){
            $countFilters++;
            $query -> whereIn('brand_id', $brandIDArray);
        }


        $colorIDArray = [];
        foreach($colors as $color){
            $colorDB = Color::where('name', $color)->first();
            if($colorDB){
                $colorIDArray[] = $colorDB->id;
            }
        }
        //print_r($colorIDArray); die;
        if(count($colorIDArray) > 0){
            $countFilters++;
            $query -> whereIn('color_id', $colorIDArray);
        }

        // if(count($years) > 0){
        //     $countFilters++;
        //     $query -> whereIn('year', $years);
        // }
            

        if($sort != null){
            if($sort == "oldest"){
                $query->oldest();
            }
            if($sort == "latest"){
                $query->latest();
            }
            // if($sort == "price-ascending"){
            //     $query->orderBy('price', 'asc')->where('is_variant',0);                
            //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
            //         $subQuery->orderBy('price', 'asc');
            //     })->where('is_variant',1);
            // }
            // if($sort == "price-descending"){
            //     $query->orderBy('price', 'desc')->where('is_variant',0);
            //     $query->orWhereHas('attributes', function ($subQuery) use($maxprice){
            //         $subQuery->orderBy('price', 'desc');
            //     })->where('is_variant',1);
            // }

            if ($sort == "price-ascending") {
                $query->orderByRaw("
                    CASE 
                        WHEN is_variant = 0 THEN price 
                        ELSE (
                            SELECT MIN(price) 
                            FROM product_attributes 
                            WHERE product_attributes.product_id = products.id
                        )
                    END ASC
                ");
            }
            
            if ($sort == "price-descending") {
                $query->orderByRaw("
                    CASE 
                        WHEN is_variant = 0 THEN price 
                        ELSE (
                            SELECT MAX(price) 
                            FROM product_attributes 
                            WHERE product_attributes.product_id = products.id
                        )
                    END DESC
                ");
            }
        }


        $products = $query->where('status',1)->paginate($this->pagerecords, ['*'], 'page', $page);

        $categoriesFilters = Category::where('status',1)->get();
        $colorsFilters = Color::where('status',1)->get();
        $brandsFilters = Brand::where('status',1)->get();

        $priceRangeFilters = Helper::getPriceRange();

        //print '<pre>'; print_r($priceRangeFilters); die;

        return view($this->prefix.'.product.products')->with(compact('products','categoriesFilters','colorsFilters','brandsFilters','priceRangeFilters'));
    }
    
    
    public function product($slug){ 
        $product = Product::select('products.*','brands.name as brand_name')->with(['categories' => function($query){
            $query->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        },'attributes.details' => function($query){
            $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_option_name');
            $query->join('attributes', 'attributes.id', '=', 'product_attribute_details.attribute_id');
            $query->join('attribute_options', 'attribute_options.id', '=', 'product_attribute_details.attribute_option_id');
        },'images','ratings' => function($query){
            $query->where('status',1)->where('review','!=','')->orderBy('created_at', 'desc');
        },'services','addons','specifications'])
        ->leftjoin('brands', 'brands.id','=','products.brand_id')
        ->where('products.status',1)->where('products.slug',$slug)->first();

        if(!$product){
            return to_route('products');
        }

        $similarProducts = Product::where('status', 1)->where('id', '!=', $product->id)->limit(6)->get();
        $groupOthers = [];
        if($product->group_id != null){
            $groupOthers = Helper::getGroupOtherItems($product->group_id,$product->id);
        }
        
        //print '<pre>'; print_r($groupOthers); die;
        $itemattributes = Helper::getAttributes($product);
        //print '<pre>'; print_r($itemattributes); die;
        $reviewShow = Helper::getReviewShowStatus();
        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        
        $ratings = $product->ratings()->where('status', 1)->where('is_approved', 1)->paginate($this->ratingPageRecords);
        return view($this->prefix.'.product.product')->with(compact('product','groupOthers','itemattributes','reviewShow','isEnquiryWebsite','similarProducts','ratings'));
    }

    // public function blogCategory(Request $request, $slug){
    //     $page = $request->page;
    //     $categoryObj = BlogCategory::where('status',true);
    //     $categories = $categoryObj->paginate($this->pagerecords, ['*'], 'page', $page);
    //     return view($this->prefix.'.blog-categories')->with(compact('blogs','count','categoryCount','categories'));
    // }

    public function blogs(Request $request){
        $page = $request->page;
        // $categoryObj = BlogCategory::where('status',true);
        // $categoryCount = $categoryObj->count();
        // $categories = $categoryObj->with('blogs')->get();
        $blogObj = Blog::select('blog_categories.name as category_name', 'blogs.*')->join('blog_categories','blog_categories.id','=','blogs.blog_category_id')->where('blogs.status',true);
        $count = $blogObj->count();
        $blogs = $blogObj->latest()->paginate($this->pagerecords, ['*'], 'page', $page);

        // return view($this->prefix.'.blogs')->with(compact('blogs','count','categoryCount','categories'));
        return view($this->prefix.'.blogs')->with(compact('blogs','count'));
    }

    public function blog($slug){
        $blog = Blog::select('blog_categories.name as category_name', 'blogs.*')->join('blog_categories','blog_categories.id','=','blogs.blog_category_id')->where('blogs.status',true)->where('blogs.slug',$slug)->first();
        $categoryObj = BlogCategory::where('status',true);
        $categories = $categoryObj->with('blogs')->get();
        //print '<pre>'; print_r($categories); die;
        return view($this->prefix.'.blog')->with(compact('blog','categories'));
    }

    public function about(){
        return view($this->prefix.'.about');
    }

    public function videos(Request $request){
        $page = $request->page;
        $videoObj = Video::where('status',1);
        $videos = $videoObj->paginate($this->pagerecords, ['*'], 'page', $page);
        $count = $videoObj->count();
        if(!$videos){
            return to_route('home');
        }
        return view($this->prefix.'.videos')->with(compact('videos','count'));
    }

    public function gallery(){
        $gallery = Gallery::where('status',1)->get();
        $data = array('gallery' => $gallery);
        return view($this->prefix.'.gallery')->with($data);
    }

    public function testimonials(){
        $testimonials = Testimonial::where('status',1)->get();
        $data = array('testimonials' => $testimonials);
        return view($this->prefix.'.testimonials')->with($data);
    }

    public function faqs(){
        return view($this->prefix.'.faqs');
    }

    public function privacy(){
        return view($this->prefix.'.privacy');
    }
    
    public function disclaimer(){
        return view($this->prefix.'.disclaimer');
    }
    
    
    public function shippingPolicy(){
        return view($this->prefix.'.shipping-policy');
    }
    public function cookiePolicy(){
        return view($this->prefix.'.cookie-policy');
    }
    
    public function refund(){
        return view($this->prefix.'.refund');
    }
    

    public function terms(){
        return view($this->prefix.'.terms');
    }

    public function forgotPassword(Request $request){

        if ($request->isMethod('post')) {
            $request->validate(['email' => 'required|email']);
 
            $status = Password::sendResetLink(
                $request->only('email')
            );
        
            // return $status === Password::RESET_LINK_SENT
            //         ? back()->with(['status' => __($status)])
            //         : back()->withErrors(['email' => __($status)]);

            if($status === Password::RESET_LINK_SENT){
                Helper::flashMessage(true, 'Email sent successfully!');
                return back()->with('status', __($status));
            }else{
                Helper::flashMessage(false, 'Something went wrong');
                return back()->withErrors(['email' => [__($status)]]);
            }
            
        }

        return view($this->prefix.'.forgot-password');
    }

    public function passwordReset(Request $request){

        

        if ($request->isMethod('post')) {

            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);
        
            // print $request->token;
            // print $request->email;
            // print $request->password;
            // print 'a'; die;

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
        
                    $user->save();
        
                    event(new PasswordReset($user));
                }
            );
        
            // return $status === Password::PASSWORD_RESET
            //         ? redirect()->route('login')->with('status', __($status))
            //         : back()->withErrors(['email' => [__($status)]]);

            //print '<pre>'; print_r($status); die; 

            if($status === Password::PASSWORD_RESET){
                Helper::flashMessage(true, 'Password reset successfully!');
                return redirect()->route('login')->with('status', __($status));
            }else{
                Helper::flashMessage(false, 'Something went wrong');
                return back()->withErrors(['email' => [__($status)]]);
            }

        }

        return view($this->prefix.'.password-reset');
    }

    public function demo(Request $request){

        //$data=array('email'=>'singhashu95@gmail.com');
        //$data=array('email'=>'amardeep0602@hotmail.com'); 
        
        // $data=array('email'=>config('constants.EMAIL.send')); 
        // //$data=array('email'=>'admin@milduratrading.com');
        // Mail::send('emails.demo', $data, function($message) use ($data)
        // {
        //     $message->from('amardeep0602@hotmail.com', "Demo testing");
        //     $message->subject("Demo testing");
        //     $message->to($data['email']);
        // });

        // if(Mail::flushMacros()){
        //     print 'sent';
        // }else{
        //     print ' not sent';
        // }

        try{
            // $data=array('email'=>config('constants.EMAIL.send')); 
            $data=array('email'=>'preetindersingh1996@gmail.com');
            Mail::send('emails.demo', $data, function($message) use ($data)
            {
                $message->from('amardeep0602@hotmail.com', "Demo testing");
                $message->subject("Demo testing");
                $message->to($data['email']);
            });
        }
        catch(\Exception $e){
            print '<pre>'; print_r($e->getMessage()); die;
        }

        die;
      
        
    }

    public function selectAttribute(Request $request){
        //$attribute = $request->attribute;
        //$attributeOptions = $request->attributeOptions;
        $slug = $request->slug;
        //$selectedVal = $request->selectedVal;
        //$selectedAttribute = $request->selectedAttribute;
        $selectedValues = $request->selectedValues;


        $product = Product::with(['attributes','services'])->where('slug',$slug)->first();

        $defaultAttributes = Helper::getSelectedItemAttributes($product->attributes);
        $defaultAttributeCount = count($defaultAttributes);
        $selectedValuesCount = count($selectedValues);

        $itemAttributes = Helper::getItemAttributes($product->id);

       
        $array = [];
        foreach($selectedValues as $key => $selectedValue){
            $attributeDetailQuery = ProductAttributeDetail::whereIn('product_attribute_id',$itemAttributes);
            $attributeDetailQuery->where(function($query) use ($key, $selectedValue){
                $query->where('attribute_id', $key);
                $query->where('attribute_option_id', $selectedValue);
            });
            $attributeDetail = $attributeDetailQuery->get();
            $attributeDetail = $attributeDetail->toArray();
            foreach($attributeDetail as $attributeDetailSingle){
                $array[] = $attributeDetailSingle['product_attribute_id'];
            }
        }

        $vals = array_count_values($array);
        //print '<pre>'; print_R($vals);
        $filterArray = array_filter($vals, function($v, $k) use($selectedValuesCount) {
            return $v == $selectedValuesCount;
        }, ARRAY_FILTER_USE_BOTH);


        $itemAttributeIDS = [];
        foreach($filterArray as $key => $filterArraySingle){
            $itemAttributeIDS[] = $key;
        }

        //print_r($itemAttributeIDS); die;

        $itemAttributes = ProductAttribute::with('details')->where('product_id', $product->id)->whereIn('id', $itemAttributeIDS)->get();
        //print '<pre>'; print_r($itemAttributes); die;

        $arrayFinal = [];
        foreach($itemAttributes as $itemAttribute){
            foreach($itemAttribute->details as $detail){
                $arrayFinal[$detail->attribute_id][] = $detail->attribute_option_id;
            }
        }

        foreach($arrayFinal as $key => $arrayFinalSingle){
            $arrayFinal[$key] = array_unique($arrayFinalSingle, SORT_REGULAR);
        }

        //print '<pre>'; print_r($itemAttributeIDS); die; 
        //print '<pre>'; print_r($itemAttributeIDS); die; 

        // die;
        
        if($defaultAttributeCount == count($selectedValues) && count($arrayFinal) > 0){
            //$price = Helper::getAttributesBasedprice($itemAttributeIDS);
            $price = ProductAttribute::where('id', $itemAttributeIDS[0])->first();
            //print_r($price); die;

            $alreadyInWishlist = Helper::alreadyInWishlist($product, $price->id);
            $alreadyInCart = Helper::alreadyInCart($product, $itemAttributeIDS);
            //print $alreadyInCart; die;
            $currency = Helper::getCurrency();

            $services = [];
            $config = Helper::getWebsiteConfig('product_services');
            if($config['product_services']){
                $services = Helper::getServicesAddedDetails($product, $itemAttributeIDS);
            }
 
            return array('result' => true, 'price' => $currency['sign'].Helper::priceFormat($price->price), 'old_price' => isset($price->old_price) ? $currency['sign'].Helper::priceFormat($price->old_price) : null, 'stock' => $price->stock, 'threshold' => $price->threshold, 'min_quantity' => $price->min_quantity, 'stock' => $price->stock, 'attribute_id' => $price->id, 'attributes' => $arrayFinal, 'sku_value' => $price->sku, 'image' => isset($price->image) ? asset('storage/products/'.$product->id.'/'.$price->image) : null, 'hover_image' => isset($price->hover_image) ? asset('storage/products/'.$product->id.'/'.$price->hover_image) : null, 'already_in_wishlist' => $alreadyInWishlist, 'already_in_cart' => $alreadyInCart, 'services' => $services);
        }else{
            return array('result' => false, 'attributes' => $arrayFinal);
        }

    }


    
    public function tabProducts(Request $request){
        
        $category = trim($request->category);

        //print $category; die;

        if($category != 'all'){
            $categoryDB = Category::where('slug', $category)->first();
            //print_r($categoryDB); die;
            $categoryID = $categoryDB->id;
        }
        
        $query = Product::with(['categories' => function($subQuery) {
            $subQuery->select('product_categories.product_id','product_categories.category_id','categories.name')->leftjoin('categories', 'categories.id','=','product_categories.category_id');
        }]);

        if($category != 'all'){
            $query->whereHas('categories', function ($subQuery) use($categoryID){
                $subQuery -> where('category_id', $categoryID);
            });
        }

        $products = $query->where('is_featured', 1)->where('status',1)->limit(8)->get();
        //print '<pre>'; print_r($products); die;
        $html = '';

        foreach($products as $product){
            $html .= '<div class="col-6 col-sm-6 col-md-4 col-lg-3 filter_item sea_food">';
            $html .= Helper::getProductHtml($product);
            $html .= '</div>';
        }

        return array('result' => true, 'html' => $html);

    }


    public function ajaxProductSearch(Request $request)
    {
        $keyword = $request->get('query');
        
        $products = Product::where('status', 1)
            ->where('name', 'like', "%$keyword%")
            ->limit(10)
            ->get();

        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'name' => $product->name,
                'price' => $product->getPrice(),
                'old_price' => $product->getOldPrice(),
                'image' => asset('storage/products/' . $product->id . '/' . $product->image),
                'link' => route('product', $product->slug),
            ];
        }

        return response()->json($result);
    }

    public function contact(Request $request){
        
        $config = Helper::getWebsiteConfig();

        if ($request->isMethod('post')) {
            $name = trim($request->name);
            $email = trim($request->email);
            $phone = trim($request->phone);
            $subject = trim($request->subject);
            $message = trim($request->message);
    
            $validationArray=array(
                'name'=>'required',
                'email' => 'required|email',
                'phone'=>'required|numeric|digits:10',
                'subject'=>'required',
                'message'=>'required',
            );
            $request->validate($validationArray);

            $config = Helper::getWebsiteConfig('country_code');
    
            $query = ContactRequest::create(['name'=>$name, 'email'=>$email, 'country_code'=>$config['country_code'], 'phone'=>$phone, 'subject'=>$subject, 'message'=>$message]);
            if($query){
                $logo = Helper::getLightLogo();
                $emailData = array('logo' => $logo, 'name' => $name, 'email' => $email, 'country_code'=>$config['country_code'], 'phone' => $phone, 'subject' => $subject, 'user_message' => $message, 'to' => config('constants.EMAIL.send'));

                dispatch(new \App\Jobs\ContactQueue($emailData));
    
                Helper::flashMessage(true, 'Query submitted successfully!');
                return to_route('contact');
            }else{
                Helper::flashMessage(false, 'Something went wrong');
                return to_route('contact');
            }
        }

        $data = array('config' => $config);
        return view($this->prefix.'.contact')->with($data);
    }

    public function orderPlaced(Request $request){
        $user = Auth::user();
        $order=$request->order;
        if(!$order){
            return view($this->prefix.'.order-placed-sco');
            //return to_route('home');
        }
        $order = Order::with('payment','products')->where('order_unique_id',$order)->first();
        if(!$order){
            return to_route('home');
        }

        if($order->user_id != null && !$user){
            return to_route('login');
        }

        if($user){
            $order->first_name = $user->first_name;
            $order->last_name = $user->last_name;
            $order->email = $user->email;
            $order->country_code = $user->country_code;
            $order->phone = $user->phone;
        }
        
        foreach($order->products as $key => $product){
            $order->products[$key]->sub_total = $product->final_price * $product->quantity;
        }

        $order = Helper::makeOrderShowPrices($order);

        return view($this->prefix.'.order-placed')->with(compact('order'));
    }
    // public function failure(){
    //     return view($this->prefix.'.failure');
    // }


    public function enquiryPlaced(Request $request){
        $user = Auth::user();
        $enquiry=$request->enquiry;
        if(!$enquiry){
            return to_route('home');
        }
        $enquiry = Enquiry::with('products')->where('enquiry_unique_id',$enquiry)->first();
        if(!$enquiry){
            return to_route('home');
        }

        if($user){
            $enquiry->first_name = $user->first_name;
            $enquiry->last_name = $user->last_name;
            $enquiry->email = $user->email;
            $enquiry->country_code = $user->country_code;
            $enquiry->phone = $user->phone;
        }

        foreach($enquiry->products as $key => $product){
            $enquiry->products[$key]->sub_total = $product->final_price * $product->quantity;
        }

        $enquiry = Helper::makeOrderShowPrices($enquiry);

        return view($this->prefix.'.enquiry-placed')->with(compact('enquiry'));
    }


    public function addWishlist(Request $request){
        //print 'a'; die;

        $slug=$request->key;
        $attribute=$request->attribute;
        
        $product = Product::with(['attributes.details'])->where('slug', $slug)->first();

        $user = Auth::user();
        $wishlistObj = Helper::getWishlistObj($user);

        $attributeID = null;
        if($product->is_variant && $attribute != null){
            $attribute = $product->attributes()->find($attribute);
            $attributeID = $attribute->id;
        }

        $alreadyObj = $wishlistObj;
        $alreadyObj->where('product_id',$product->id);
        if($attributeID != null){
            $alreadyObj->where('product_attribute_id',$attributeID);
        }

        $alreadyCount = $alreadyObj->count();
            //print $alreadyCount; die;
            if($alreadyCount > 0){
                $query = $alreadyObj->delete();
                $message = 'Product removed from wishlist';
            }else{
                if($user){
                    $query = $wishlistObj->create(['product_id'=>$product->id, 'product_attribute_id' => $attributeID]);
                }else{
                    $uuid = Helper::getUserUUID();
                    $query = $wishlistObj->create(['product_id' => $product->id, 'uuid' => $uuid,  'product_attribute_id' => $attributeID]);
                }
                $message = 'Product added to wishlist';
            }

        $wishlistObj = Helper::getWishlistObj($user);
        $count = $wishlistObj->count();
        if($query){
            return array('count' => $count, 'result' => true, 'message' => $message);
        }else{
            return array('count' => $count, 'result' => false, 'message' => 'Something is wrong');
        }
    }

    
    public function removeWishlist(Request $request){
        //print 'a'; die;

        $slug=$request->key;
        $attributeID=$request->attribute;
        
        $product = Product::with(['attributes.details'])->where('slug', $slug)->first();

        $user = Auth::user();
        $wishlistObj = Helper::getWishlistObj($user);

        $wishlistObj->where('product_id',$product->id);
        if($attributeID != null){
            $wishlistObj->where('product_attribute_id',$attributeID);
        }

        $count = $wishlistObj->count();
            //print $alreadyCount; die;
        if($count > 0){
            $query = $wishlistObj->delete();
            $message = 'Product removed from wishlist';
        }
        
        $wishlistObj = Helper::getWishlistObj($user);
        $count = $wishlistObj->count();
        if($query){
            return array('count' => $count, 'result' => true, 'message' => $message);
        }else{
            return array('count' => $count, 'result' => false, 'message' => 'Something is wrong');
        }
    }

    public function wishlistDetails(Request $request){
        $user = Auth::user();
        $wishlistObj = Helper::getWishlistObj($user);
        $count = $wishlistObj->count();
        return array('count'=>$count);
    }
    
    public function wishlist(){
        $user = Auth::user();
        $wishlistObj = Helper::getWishlistObj($user);
        $wishlist = $wishlistObj->with([
            'attribute.details' => function($query){
                $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_option_name');
                $query->join('attributes', 'attributes.id', '=', 'product_attribute_details.attribute_id');
                $query->join('attribute_options', 'attribute_options.id', '=', 'product_attribute_details.attribute_option_id');
            }
        ])->join('products','products.id','=','wishlist.product_id')->get();
        //print '<pre>'; print_r($wishlist); die;
        //print '<pre>'; print_r($wishlist->toArray()); die;
        return view($this->prefix.'.wishlist')->with(compact('wishlist'));
    }





    
    public function search(Request $request){
        if(isset($_GET['q']) && !empty($_GET['q'])){

            $page = $request->page;
            $query = trim($_GET['q']);
            
            $products = Product::where('name','like','%'.$query.'%')->paginate($this->pagerecords, ['*'], 'page', $page);

            return view($this->prefix.'.search')->with(compact('products'));

        
                // $getproducts = Product::with('attributes')->join('categories','categories.id','=','products.category_id')->select('products.*','categories.name')->where(function ($q) use ($string) {
                //     $q->where('products.product_name', 'like', '%'.trim($query).'%')->orWhere('products.short_description', 'like', '%'.trim($string).'%')->orWhere('categories.name', 'like', '%'.trim($string).'%')->orWhere('products.product_code', 'like', '%'.trim($string).'%');
                // })->whereExists( function ($query)  {
                //     $query->from('categories')
                //     ->whereRaw('products.category_id = categories.id')
                //     ->where('categories.status',1);
                // })->where('products.status',1)->orderby('id','DESC')->paginate(30);

                // $title = $string;
        }
    }

    public function page($slug){
    
        $page = Page::where(['slug' => $slug])->first();
        if(!$page){
            return to_route('home');
        }

        return view($this->prefix.'.page')->with(compact('page'));

    }

    public function subscribe(Request $request){
        $email = trim($request->email);
    
        $validationArray=array(
            'email' => 'required|email'
        );
        $validator = $request->validate($validationArray);

        $query = Subscription::create(['email' => $email]);

        if($query){
            $logo = Helper::getLightLogo();
            $emailData = array('logo' => $logo, 'email' => $email, 'to' => $email);
            dispatch(new \App\Jobs\SubscribeQueue($emailData));
            return array('result' => true, 'message' => 'Subscription email added successfully');
        }else{
            return array('result' => false, 'message' => 'Something went wrong');
        }

    }


    public function review(Request $request){
        $key = trim($request->key);
        $rating = trim($request->rating);
        $review = trim($request->review);
        $email = trim($request->email);
        $name = trim($request->name);
    
        $validationArray=array(
            'key' => 'required',
            'rating' => 'required',
            'review' => 'required',
            'email' => 'required|email',
            'name' => 'required',
        );
        $validator = $request->validate($validationArray);

        $user = Auth::user();
        $userID = $user ? $user->id : null;

        $product = Product::where('slug',$key)->first();
        if(!$product){
            return array('result' => false, 'message' => 'Product does not exists');
        }


        $query = Rating::create(['product_id' => $product->id, 'user_id' => $userID, 'name' => $name, 'email' => $email, 'rating' => $rating, 'review' => $review ]);

        if($query){
            $product = Product::with(['ratings' => function($query){
                $query->where('status',1);
            }])->find($product->id);
            //return array('result' => true, 'message' => 'Review added successfully, will be published after approval', 'html' => (String)View::make('front.product.product-rating')->with(compact('product')));
            return array('result' => true, 'message' => 'Review added successfully', 'html' => (String)View::make('front.product.product-rating')->with(compact('product')));
        }else{
            return array('result' => false, 'message' => 'Something went wrong');
        }

    }

    public function sitemap(Request $request){
        $products = Product::where('status',1)->limit(250)->get();
        $blogs = Blog::where('status',1)->get();
        $pages = Page::where('status',1)->get();
        $categories = Category::where('status', 1)->get();
        return view($this->prefix.'.sitemap')->with(compact('products','blogs','pages','categories'));
    }

    public function filterRating(Request $request){
        $product = Product::where('slug', $request->slug)->firstOrFail();
        $query = $product->ratings()->where('status', 1)->where('is_approved', 1);
        if ($request->rating) {
            $query->where('rating', $request->rating);
        }
        $ratings = $query->paginate($this->ratingPageRecords);
        return view($this->prefix . '.product.product-rating-filter')->with(compact('product', 'ratings'));
    }

    public function updateRating(Request $request){
        $ratings = Rating::where('status',1)->get();
        foreach($ratings as $k=>$rating){
            $rate = round($rating->rating);
            $ratingGet = Rating::find($rating->id);
            $ratingGet->rating = $rate;
            $response = $ratingGet->save();
            if($response){
                echo $rating->id."Done <br>";
            }
        }
        return "finish";
    }

    public function fixGoogleCrawlingIssues(Request $request){
        //Resolving the issue of Google redirection; otherwise, it won't be used.
        return redirect()->route('product', $request->slug, 301);
    }


}
