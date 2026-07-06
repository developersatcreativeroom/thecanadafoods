<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Cart;
use App\Models\Wishlist;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Exports\ExportProduct;
use App\Imports\ValidateImportProduct;
use App\Imports\ImportProduct;

use Carbon\Carbon;
use App\Helper;
use App\Models\Faq;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Image;
use Validator;
use Mail;
use Session;
use View;


class ProductController extends Controller implements HasMiddleware
{
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'product';

    public function  __construct()
    {
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }


    public function list(Request $request)
    {
        $page = $request->page;
        $rows = Product::latest()->paginate($this->pagerecords, ['*'], 'page', $page);
        $categories = Category::where('status', 1)->get();
        //print '<pre>'; print_r($rows); die;
        $data = array('rows' => $rows, 'categories' => $categories);
        return view($this->prefix . '.' . $this->folder . '.list')->with($data);
    }

    public function add()
    {
        $categories = Helper::getCategories();
        $taxes = Tax::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $attributes = Attribute::where('status', 1)->get();

        return view($this->prefix . '.' . $this->folder . '.form', [
            'categories' => $categories,
            'taxes' => $taxes,
            'brands' => $brands,
            'attributes' => $attributes,
        ]);
    }

    public function edit($id)
    {
        $categories = Helper::getCategories();
        $taxes = Tax::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $attributes = Attribute::where('status', 1)->get();

        $row = Product::with([
            'attributes.details' => function ($query) {
                $query->select(
                    'product_attribute_details.*',
                    'attributes.name as attribute_name',
                    'attribute_options.name as attribute_value'
                )
                    ->join('attributes', 'attributes.id', '=', 'product_attribute_details.attribute_id')
                    ->join('attribute_options', 'attribute_options.id', '=', 'product_attribute_details.attribute_option_id');
            },
            'categories',
            'images',
            'specifications',
            'faqs'
        ])->find($id);

        if (!$row) {
            return redirect()->route('admin.products');
        }

        $categoriesProduct = $row->categories
            ->pluck('category_id')
            ->toArray();

        $variants = [];

        foreach ($row->attributes as $attribute) {
            foreach ($attribute->details as $detail) {
                $variants[] = $detail->attribute_id;
            }
        }

        $variants = array_unique($variants);

        return view($this->prefix . '.' . $this->folder . '.form', [
            'categories' => $categories,
            'taxes' => $taxes,
            'brands' => $brands,
            'attributes' => $attributes,
            'row' => $row,
            'categoriesProduct' => $categoriesProduct,
            'variants' => $variants,
        ]);
    }

    // public function add(){        
    //     $categories = Helper::getCategories();
    //     $taxes = Tax::where('status',1)->get();
    //     $brands = Brand::where('status',1)->get();
    //     // $colors = Color::where('status',1)->get();
    //     $attributes = Attribute::where('status',1)->get();
    //     $data=array('categories'=>$categories, 'taxes'=>$taxes, 'brands'=>$brands, 'attributes' => $attributes);
    //     return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    // }

    // public function edit($id){
    //     $categories = Helper::getCategories();  
    //     $taxes = Tax::where('status',1)->get();
    //     $brands = Brand::where('status',1)->get();
    //     // $colors = Color::where('status',1)->get();
    //     $attributes=Attribute::where('status',1)->get();

    //     //print '<pre>'; print_r($attributes[0]['values']); die;
    //     //$product = Product::join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->find($id);
    //     $row = Product::with(
    //         //['attributes', 'attributes.details','categories]
    //         ['attributes.details' => function($query){

    //             $query->select('product_attribute_details.*', 'attributes.name as attribute_name', 'attribute_options.name as attribute_value')
    //             ->join('attributes','attributes.id','=', 'product_attribute_details.attribute_id')
    //             ->join('attribute_options','attribute_options.id','=', 'product_attribute_details.attribute_option_id');

    //         },
    //         'categories','images','specifications']
    //     )->find($id);
    //     if($row == null){
    //         return to_route('admin.products');
    //     } 

    //     //print '<pre>'; print_r($row); die;
    //     $selectedCategories = $row->categories;
    //     //print '<pre>'; print_r($selectedCategories); die;

    //     $categoriesProduct = [];
    //     foreach($selectedCategories as $selectedCategory){
    //         $categoriesProduct[] = $selectedCategory->category_id;
    //     }
    //     //print '<pre>'; print_r($categoriesProduct); die;

    //     $variants = [];
    //     foreach($row->attributes as $attribute){
    //         foreach($attribute->details as $detail){
    //             $variants[] = $detail->attribute_id;
    //         }
    //     }

    //     $variants = array_unique($variants);
    //     //print_r($variants); die;

    //     $data=array('categories'=>$categories, 'taxes'=>$taxes, 'brands'=>$brands, 'attributes' => $attributes, 'row' => $row, 'categoriesProduct' => $categoriesProduct, 'variants' => $variants);
    //     return view($this->prefix.'.'.$this->folder.'.form')->with($data);
    // }

    public function postData(Request $request)
    {

        // dd($request->all());

        $id = trim($request->input('id'));
        $name = trim($request->input('name'));
        $title_h1 = trim($request->input('title_h1'));
        $slug = trim($request->input('slug'));
        $categories = $request->input('categories');
        $shortDescription = trim($request->input('short_description'));
        $description = trim($request->input('description'));

        $sku = $request->filled('sku') ? trim($request->input('sku')) : null;
        $price = $request->filled('price') ? trim($request->input('price')) : null;
        $oldPrice = $request->filled('old_price') ? trim($request->input('old_price')) : null;
        $taxId = trim($request->input('tax_id'));
        $isTaxIncluded = trim($request->input('is_tax_included'));
        $brandId = trim($request->input('brand_id'));
        $colorId = $request->input('color_id') ? trim($request->input('color_id')) : null;
        $isFeatured = trim($request->input('is_featured'));
        $isSample = trim($request->input('is_sample'));
        $isSale = trim($request->input('is_sale'));
        $isNew = trim($request->input('is_new'));
        $isHot = trim($request->input('is_hot'));
        $isBestSell = trim($request->input('is_best_sell'));
        $isVariant = trim($request->input('is_variant'));
        $variants = $request->input('variants');
        $attributes = $request->input('attributes');
        $attributesFile = $request->file('attributes');
        $stock = $request->filled('stock') ? trim($request->input('stock')) : null;
        $minQuantity = $request->filled('min_quantity') ? trim($request->input('min_quantity')) : null;
        $threshold = $request->filled('threshold') ? trim($request->input('threshold')) : null;
        $length = $request->filled('length') ? trim($request->input('length')) : null;
        $width = $request->filled('width') ? trim($request->input('width')) : null;
        $height = $request->filled('height') ? trim($request->input('height')) : null;
        $weight = $request->filled('weight') ? trim($request->input('weight')) : null;
        $shippingWeight = $request->filled('shipping_weight') ? trim($request->input('shipping_weight')) : null;
        $seoTitle = $request->filled('seo_title') ? trim($request->input('seo_title')) : null;
        $seoDescription = $request->filled('seo_description') ? trim($request->input('seo_description')) : null;
        $seoKeywords = $request->filled('seo_keywords') ? trim($request->input('seo_keywords')) : null;
        $purchaseNote = trim($request->input('purchase_note'));
        $status = trim($request->input('status'));
        $temp_sensitive = trim($request->input('temp_sensitive'));
        $tagsArray = $request->input('tags');
        // $demo = trim($request->input('demo'));
        $image = $request->file('image');
        $hoverImage = $request->file('hover_image');
        $images = $request->file('images');
        $imageAlt = $request->input('image_alt');
        $imagesAlt = $request->input('images_alt');
        //$files = $request->file('images');

        $specifications = $request->input('specifications');
        $faqs = $request->input('faqs');

        //print '<pre>'; print_r($specifications); die;
        // print '<pre>'; print_r($images); die;
        // print '<pre>'; print_r($files); die;
        // print '<pre>'; print_r($image); die;
        //print '<pre>'; print_r($attributes); die;
        //print '<pre>'; print_r($tags); die;
        //  print '<pre>'; print_r($attributes); 
        //  print '<pre>'; print_r($attributesFile); die;

        // $attributes = array_values($attributes);
        // $attributesFile = array_values($attributesFile);

        // print '<pre>'; print_r($attributes); 
        // print '<pre>'; print_r($attributesFile); die;

        //array_values

        //Session::put('tags', $tagsArray);
        Session::forget('tags');






        //print $id; die;

        //if(empty($id)){
        $validationArray = array(
            'categories' => 'required|array',
            'categories.*' => 'required|min:1',
            'short_description' => 'required',
            'description' => 'required',
            'hover_image' => 'mimes:jpeg,jpg,png,webp,avif',
            //'sku'=>'required',
            // 'price'=>'required',
            // 'old_price'=>'required',
            'tax_id' => 'required',
            'brand_id' => 'required',
            'color_id' => '',
            'is_featured' => '',
            'is_sample' => '',
            'is_sale' => '',
            'is_new' => '',
            'is_hot' => '',
            'is_best_sell' => '',
            'is_variant' => '',
            // 'quantity'=>'required',
            // 'min_quantity'=>'required',
            // 'threshold'=>'required',
            // 'length'=>'required',
            // 'width'=>'required',
            // 'height'=>'required',
            // 'weight'=>'required',
            'seo_title' => '',
            'seo_description' => '',
            'seo_keywords' => '',
            'tags' => 'array',
            'status' => 'required',
            'temp_sensitive' => 'required',
            //'images.image' => 'image|mimes:jpeg,jpg,png,webp',
            //'images.front' => 'required',
            'specifications' => 'array',
            'specifications.*.specification' => 'required_with:specifications.*.value',
            'specifications.*.value' => 'required_with:specifications.*.specification',
            'specifications.*.units' => '',

            'faqs' => 'nullable|array',
            'faqs.*.id' => 'nullable|integer',
            'faqs.*.question' => 'required_with:faqs.*.answer',
            'faqs.*.answer' => 'required_with:faqs.*.question',
            'faqs.*.status' => 'nullable|boolean',
        );
        if ($isVariant == 'on') {
            $validationArray['attributes'] = 'required|array';
            $validationArray['attributes.*'] = 'required|min:1';
            $validationArray['attributes.*.price'] = 'required';
            //$validationArray['attributes.*.old_price']='required|gt:attributes.*.price';
            $validationArray['attributes.*.old_price'] = 'nullable|gt:attributes.*.price';
            $validationArray['attributes.*.sku'] = 'required';
            // $validationArray['attributes.*.image']='required|mimes:jpeg,jpg,png,webp';
            $validationArray['attributes.*.hover_image'] = 'mimes:jpeg,jpg,png,webp,avif';
            $validationArray['attributes.*.stock'] = 'required';
            $validationArray['attributes.*.min_quantity'] = '';
            $validationArray['attributes.*.shipping_weight'] = 'required';
        } else {
            $validationArray['price'] = 'required';
            //$validationArray['old_price']='required|gt:price';
            $validationArray['old_price'] = 'nullable|gt:price';
            $validationArray['sku'] = 'required';
            $validationArray['stock'] = 'required';
            $validationArray['min_quantity'] = '';
            $validationArray['threshold'] = '';
            $validationArray['length'] = '';
            $validationArray['width'] = '';
            $validationArray['height'] = '';
            $validationArray['weight'] = '';
            $validationArray['shipping_weight'] = 'required';
        }

        if (empty($id)) {
            $validationArray['image'] = 'required|mimes:jpeg,jpg,png,webp,avif';
            $validationArray['name'] = 'required|unique:products,name';

            $validationArray['attributes.*.image'] = 'required|mimes:jpeg,jpg,png,webp,avif';
            //'images'=>'required|array',
        } else {
            $validationArray['image'] = 'mimes:jpeg,jpg,png,webp,avif';
            $validationArray['name'] = 'required|unique:products,name,' . $id;

            $validationArray['attributes.*.image'] = 'mimes:jpeg,jpg,png,webp,avif';
            $validationArray['slug'] = 'required|alpha_dash|unique:products,slug,' . $id;
        }


        $request->validate($validationArray);


        //SESSION::put('attributes', $attributes);

        $productType = 'physical';
        $affiliateLink = '';
        $licenceName = '';
        $licenceKey = '';
        $fileType = '';
        $link = '';
        $file = '';

        $isFeaturedDB = ($isFeatured == 'on') ? 1 : 0;
        $isSampleDB = ($isSample == 'on') ? 1 : 0;
        $isSaleDB = ($isSale == 'on') ? 1 : 0;
        $isNewDB = ($isNew == 'on') ? 1 : 0;
        $isHotDB = ($isHot == 'on') ? 1 : 0;
        $isBestSellDB = ($isBestSell == 'on') ? 1 : 0;
        $isVariantDB = ($isVariant == 'on') ? 1 : 0;

        $isTaxIncludedDB = ($isTaxIncluded == 'on') ? 1 : 0;

        //$tags = count($tagsArray) > 0 ? json_encode($tagsArray) : null;
        $tags = ($tagsArray != null && count($tagsArray) > 0) ? json_encode($tagsArray) : null;

        $config = Helper::getAccountingSettings('is_xero');
        $isXero = $config['is_xero'];


        DB::beginTransaction();

        //print $price; die;

        if (empty($id)) {
            if ($isXero) {
                $oldProduct = null;
            }

            $insertRow = ['name' => $name, 'title_h1' => $title_h1,  'short_description' => $shortDescription, 'image_alt' => $imageAlt, 'description' => $description, 'sku' => $sku, 'product_type' => $productType, 'affiliate_link' => $affiliateLink, 'licence_name' => $licenceName, 'licence_key' => $licenceKey, 'file_type' => $fileType, 'link' => $link, 'file' => $file, 'price' => $price, 'old_price' => $oldPrice, 'tax_id' => $taxId, 'is_tax_included' => $isTaxIncludedDB, 'brand_id' => $brandId, 'color_id' => $colorId, 'is_featured' => $isFeaturedDB, 'is_sample' => $isSampleDB, 'is_sale' => $isSaleDB, 'is_new' => $isNewDB, 'is_hot' => $isHotDB, 'is_best_sell' => $isBestSellDB, 'is_variant' => $isVariantDB, 'stock' => $stock, 'min_quantity' => $minQuantity, 'threshold' => $threshold, 'length' => $length, 'width' => $width, 'height' => $height, 'weight' => $weight, 'shipping_weight' => $shippingWeight, 'tags' => $tags, 'seo_title' => $seoTitle, 'seo_description' => $seoDescription, 'seo_keywords' => $seoKeywords, 'purchase_note' => $purchaseNote, 'status' => $status, 'temp_sensitive' => $temp_sensitive];

            $product = Product::create($insertRow);

            if ($product->is_variant == false) {
                $quantity = $product->stock;
                $event = 'initial_added';
                $type = 1;
                $remarks = 'Initial Stock quantity added';

                // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
                // Helper::addStockLog(null, null, $product->id, null, $quantity, $product->price, $event, $type, $remarks, 0, null);

                // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
                Helper::addStockLog(null, null, $event, $type, $remarks, 0, null, $product->id, null, $quantity, $product->price);
            }
        } else {
            $product = Product::with(
                ['attributes.details', 'categories']
            )->find($id);

            if ($isXero) {
                $oldProduct = Product::with(
                    ['attributes.details', 'categories']
                )->find($id);
            }

            $oldStock = $product->stock;

            $product->name = $name;
            $product->slug = $slug;
            $product->title_h1 = $title_h1;
            $product->short_description = $shortDescription;
            $product->description = $description;
            $product->sku = $sku;
            $product->product_type = $productType;
            $product->affiliate_link = $affiliateLink;
            $product->licence_name = $licenceName;
            $product->licence_key = $licenceKey;
            $product->file_type = $fileType;
            $product->link = $link;
            $product->file = $file;
            $product->price = $price;
            $product->old_price = $oldPrice;
            $product->tax_id = $taxId;
            $product->is_tax_included = $isTaxIncludedDB;
            $product->brand_id = $brandId;
            $product->color_id = $colorId;
            $product->is_featured = $isFeaturedDB;
            $product->is_sample = $isSampleDB;
            $product->is_sale = $isSaleDB;
            $product->is_new = $isNewDB;
            $product->is_hot = $isHotDB;
            $product->is_best_sell = $isBestSellDB;
            $product->is_variant = $isVariantDB;
            $product->stock = $stock;
            $product->min_quantity = $minQuantity;
            $product->threshold = $threshold;
            $product->length = $length;
            $product->width = $width;
            $product->height = $height;
            $product->weight = $weight;
            $product->shipping_weight = $shippingWeight;
            $product->tags = $tags;
            $product->image_alt = $imageAlt;
            $product->seo_title = $seoTitle;
            $product->seo_description = $seoDescription;
            $product->seo_keywords = $seoKeywords;
            $product->purchase_note = $purchaseNote;
            $product->status = $status;
            $product->temp_sensitive = $temp_sensitive;
            $product->save();

            if ($oldStock != $product->stock && $product->is_variant == false) {

                if ($oldStock < $product->stock) {
                    $quantity = $product->stock - $oldStock;
                    $event = 'added';
                    $type = 1;
                    $remarks = 'Stock quantity added';
                }
                if ($oldStock > $product->stock) {
                    $quantity = $oldStock - $product->stock;
                    $event = 'reduced';
                    $type = 2;
                    $remarks = 'Stock quantity reduced';
                }

                // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
                // Helper::addStockLog(null, null, $product->id, null, $quantity, $product->price, $event, $type, $remarks, 0, null);

                // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice,
                Helper::addStockLog(null, null, $event, $type, $remarks, 0, null, $product->id, null, $quantity, $product->price,);
            }
        }

        $isPreviousImageDelete = Helper::isPreviousProductImageDelete($product->id);

        if (count($categories) > 0) {
            $product->categories()->delete();
            foreach ($categories as $category) {
                $product->categories()->create(['category_id' => $category]);
            }
        }

        if ($faqs !== null) {

            // Existing FAQ IDs
            $existingFaqIds = $product->faqs()->pluck('id')->toArray();

            $submittedFaqIds = [];

            foreach ($faqs as $faq) {

                if (
                    empty($faq['question']) &&
                    empty($faq['answer'])
                ) {
                    continue;
                }

                $status = isset($faq['status']) ? 1 : 0;

                /*
        |--------------------------------------------------------------------------
        | Update Existing FAQ
        |--------------------------------------------------------------------------
        */
                if (!empty($faq['id'])) {

                    $faqRow = Faq::where('id', $faq['id'])
                        ->where('type', 'product')
                        ->where('type_id', $product->id)
                        ->first();

                    if ($faqRow) {

                        $faqRow->question = $faq['question'];
                        $faqRow->answer = $faq['answer'];
                        $faqRow->status = $status;
                        $faqRow->save();

                        $submittedFaqIds[] = $faqRow->id;
                    }
                } else {

                    /*
            |--------------------------------------------------------------------------
            | Create New FAQ
            |--------------------------------------------------------------------------
            */

                    $faqRow = Faq::create([
                        'question' => $faq['question'],
                        'answer'   => $faq['answer'],
                        'type'     => 'product',
                        'type_id'  => $product->id,
                        'status'   => $status,
                    ]);

                    $submittedFaqIds[] = $faqRow->id;
                }
            }

            /*
    |--------------------------------------------------------------------------
    | Delete Removed FAQs
    |--------------------------------------------------------------------------
    */

            $deleteIds = array_diff($existingFaqIds, $submittedFaqIds);

            if (!empty($deleteIds)) {

                Faq::whereIn('id', $deleteIds)
                    ->where('type', 'product')
                    ->where('type_id', $product->id)
                    ->delete();
            }
        }

        if ($isVariant == 'on' && count($attributes) > 0) {
            //print 'Mulitple'; die;
            //print '<pre>'; print_r($attributes); die;
            //print '<pre>'; print_r($product->attributes); die;

            $attributesArrayDB = [];
            foreach ($product->attributes as $attributeDB) {
                $attributesArrayDB[] = $attributeDB->id;
            }
            $attributesArrayDB = array_unique($attributesArrayDB);
            //print_r($attributesArrayDB); die;


            $varaintCountDB = count($product->attributes);
            $varaintCount = count($attributes);
            // print $varaintCountDB. ' ';
            // print $varaintCount;
            // die;

            //print '<pre>'; print_r($attributes); die;
            //print '<pre>'; print_r($attributesFile); die;

            $attributesArray = [];
            foreach ($attributes as $key => $attribute) {

                $attributeDB = null;

                if (!isset($attribute['id'])) {
                    //print 'a'; die;

                    $attributeDB = $product->attributes()->create(['price' => $attribute['price'], 'old_price' => isset($attribute['old_price']) ? $attribute['old_price'] : null, 'stock' => $attribute['stock'], 'sku' => $attribute['sku'], 'min_quantity' => isset($attribute['min_quantity']) ? $attribute['min_quantity'] : null, 'threshold' => isset($attribute['threshold']) ? $attribute['threshold'] : null, 'length' => isset($attribute['length']) ? $attribute['length'] : null, 'width' => isset($attribute['width']) ? $attribute['width'] : null, 'height' => isset($attribute['height']) ? $attribute['height'] : null, 'weight' => isset($attribute['weight']) ? $attribute['weight'] : null, 'shipping_weight' => isset($attribute['shipping_weight']) ? $attribute['shipping_weight'] : null]);

                    foreach ($attribute['details'] as $detailKey => $detail) {
                        //print '<pre>'; print_r($detail); die;
                        $attributeDB->details()->create(['product_id' => $product->id, 'product_attribute_id' => $attributeDB->id, 'attribute_id' => $detail['attribute'], 'attribute_option_id' => $detail['attributes_option']]);
                    }

                    $quantityAttribute = $attributeDB->stock;
                    $eventAttribute = 'initial_added';
                    $typeAttribute = 1;
                    $remarksAttribute = 'Initial Stock quantity added';

                    // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
                    // Helper::addStockLog(null, null, $product->id, $attributeDB->id, $quantityAttribute, $attributeDB->price, $eventAttribute, $typeAttribute, $remarksAttribute, 0, null);

                    // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
                    Helper::addStockLog(null, null, $eventAttribute, $typeAttribute, $remarksAttribute, 0, null, $product->id, $attributeDB->id, $quantityAttribute, $attributeDB->price);
                } else {
                    //print 'b'; die;
                    $attributesArray[] = $attribute['id'];
                    if (in_array($attribute['id'], $attributesArrayDB)) {
                        $attributeDB = $product->attributes()->find($attribute['id']);

                        $oldAttributeStock = $attributeDB->stock;

                        $attributeDB->price = $attribute['price'];
                        $attributeDB->old_price = isset($attribute['old_price']) ? $attribute['old_price'] : null;
                        $attributeDB->stock = $attribute['stock'];
                        $attributeDB->sku = $attribute['sku'];
                        $attributeDB->min_quantity = isset($attribute['min_quantity']) ? $attribute['min_quantity'] : null;
                        $attributeDB->threshold = isset($attribute['threshold']) ? $attribute['threshold'] : null;
                        $attributeDB->length = isset($attribute['length']) ? $attribute['length'] : null;
                        $attributeDB->width = isset($attribute['width']) ? $attribute['width'] : null;
                        $attributeDB->height = isset($attribute['height']) ? $attribute['height'] : null;
                        $attributeDB->weight = isset($attribute['weight']) ? $attribute['weight'] : null;
                        $attributeDB->shipping_weight = isset($attribute['shipping_weight']) ? $attribute['shipping_weight'] : null;
                        $attributeDB->save();

                        //if($oldAttributeStock != $attributeDB->stock && $product->is_variant == true){
                        if ($oldAttributeStock < $attributeDB->stock) {

                            if ($oldAttributeStock < $attributeDB->stock) {
                                $quantityAttribute = $attributeDB->stock - $oldAttributeStock;
                                $eventAttribute = 'added';
                                $typeAttribute = 1;
                                $remarksAttribute = 'Stock quantity added';
                            }
                            if ($oldAttributeStock > $attributeDB->stock) {
                                $quantityAttribute = $oldAttributeStock - $attributeDB->stock;
                                $eventAttribute = 'reduced';
                                $typeAttribute = 2;
                                $remarksAttribute = 'Stock quantity reduced';
                            }

                            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
                            // Helper::addStockLog(null, null, $product->id, $attributeDB->id, $quantityAttribute, $attributeDB->price, $eventAttribute, $typeAttribute, $remarksAttribute, 0, null);

                            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
                            Helper::addStockLog(null, null, $eventAttribute, $typeAttribute, $remarksAttribute, 0, null, $product->id, $attributeDB->id, $quantityAttribute, $attributeDB->price);
                        }

                        // $attributeDB->details()->delete();
                        // foreach($attribute['details'] as $detailKey=>$detail){
                        //     //print '<pre>'; print_r($detail); die;
                        //     $attributeDB->details()->create(['product_id'=>$product->id, 'product_attribute_id'=>$attributeDB->id, 'attribute_id'=>$detail['attribute'], 'attribute_option_id'=>$detail['attributes_option']]);
                        // }
                    }
                }


                if (isset($attributesFile[$key]['image']) && $attributeDB != null) {
                    //print '<pre>'; print_r($attributesFile[$key]['image']); die;
                    $operation = !isset($attribute['id']) ? 'add' : 'update';
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($attributesFile[$key]['image'], $attributeDB, 'products', true, $operation, 'image', true, true, $isPreviousImageDelete, $product->id);
                }

                if (isset($attributesFile[$key]['hover_image']) && $attributeDB != null) {
                    //print '<pre>'; print_r($attributesFile[$key]['hover_image']); die;
                    $operation = !isset($attribute['id']) ? 'add' : 'update';
                    // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
                    Helper::uploadImage($attributesFile[$key]['hover_image'], $attributeDB, 'products', true, $operation, 'hover_image', true, true, $isPreviousImageDelete, $product->id);
                }
            }
            $attributesArray = array_unique($attributesArray);

            $ids = array_diff($attributesArrayDB, $attributesArray);
            //print_r($ids); die;
            if (count($ids) > 0) {
                $remaining = $product->attributes()->whereIn('id', $ids);
                foreach ($remaining as $remainingSingle) {
                    $remainingSingle->details()->delete();
                }
                $remaining->delete();

                Cart::whereIn('product_attribute_id', $ids)->delete();
            }

            //die;
        }

        if ($specifications != null && count($specifications) > 0) {
            $product->specifications()->delete();
            foreach ($specifications as $specification) {
                if ($specification['specification'] && $specification['value']) {
                    $product->specifications()->create(['specification' => $specification['specification'], 'value' => $specification['value'], 'units' => $specification['units']]);
                }
            }
        }

        if ($isVariant != 'on' && $product->attributes()->count() > 0) {
            $attributesDB = $product->attributes()->get();
            foreach ($attributesDB as $attributesDBSingle) {
                $attributesDBSingle->details()->delete();
            }
            $attributesDBSingle->delete();
        }

        $operation = empty($id) ? 'add' : 'update';
        $altText = isset($imageAlt) && !empty($imageAlt) ? trim($imageAlt) : false;

        // add products images here start
        if (isset($image)) {
            // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id

            
            Helper::uploadImage($image, $product, 'products', true, $operation, 'image', true, true, $isPreviousImageDelete, false,$altText);
        }
        if (isset($hoverImage)) {
            // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
            Helper::uploadImage($hoverImage, $product, 'products', true, $operation, 'hover_image', true, true, $isPreviousImageDelete, false,$altText);
        }
        if (isset($images) && is_array($images) && count($images) > 0) {
            //print '<pre>'; print_r($images); die;
            // image, model, directory, is_directory_id, add_or_update, column_name ,is_column_update, is_thumb, delete_prev_image, sub_folder_id
            // uploadImages($images,$model,$directory,$isDirectoryID,$operation,$columnName,$isColumn,$isAltText=false,$altText=null,$isThumb,$deletePrevImage,$subFolderID) {
            Helper::uploadImages($images, $product->images(), 'products/' . $product->id . '/gallery/', false, $operation, 'image', false, $imagesAlt, true, false, false);
            // Helper::uploadImages($images, $product->images(), 'products/' . $product->id . '/gallery/', false, $operation, 'image', false, true, false, false);
        }
        //die;
        // add products images here ends

        if ($product) {
            DB::commit();
            if ($isXero) {
                $product = $product->refresh();
                Helper::xeroItemAddUpdate($product, $oldProduct);
            }
            Helper::flashMessage(true, 'Product added/updated successfully!');
            return to_route('admin.products');
        } else {
            DB::rollBack();
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


    public function delete(Request $request)
    {
        //return true;
        $id = trim($request->id);
        $row = Product::find($id);
        //print 'a'; die;
        if (!$row) {
            return to_route('admin.products');
        }
        Wishlist::where('product_id', $row->id)->delete();
        Cart::where('product_id', $row->id)->delete();
        $row->delete();

        if ($row) {
            Helper::flashMessage(true, 'Product deleted successfully!');
            return to_route('admin.products');
        } else {
            Helper::flashMessage(false, 'Something went wrong');
            return redirect()->back();
        }
    }


    public function filter(Request $request)
    {
        $page = $request->page;
        $category = $request->category;
        $status = $request->filled('status') ? trim($request->input('status')) : null;
        $metaStatus = $request->meta_status;
        $search = $request->search;
        $clear = $request->clear;

        $query = Product::latest();

        if ($search) {

            $query->where(function ($subQuery) use ($search) {
                // $subQuery->where('enquiries.full_name','like','%'.$search.'%');
                $subQuery->where('name', 'like', '%' . $search . '%');
                $subQuery->orWhere('slug', 'like', '%' . $search . '%');
                $subQuery->orWhere('sku', 'like', '%' . $search . '%');
                $subQuery->orWhere('short_description', 'like', '%' . $search . '%');
                $subQuery->orWhere('description', 'like', '%' . $search . '%');
                $subQuery->orWhere('product_type', 'like', '%' . $search . '%');
                $subQuery->orWhere('affiliate_link', 'like', '%' . $search . '%');
                $subQuery->orWhere('tags', 'like', '%' . $search . '%');
            });
        }

        if ($metaStatus !== null) {
            $query->where(function ($q) use ($metaStatus) {
                $metaStatus = (int) $metaStatus;

                if ($metaStatus == 0) {
                    // Pending: all 3 meta fields missing
                    $q->whereNull('seo_title')->orWhere('seo_title', '')
                        ->whereNull('seo_description')->orWhere('seo_description', '')
                        ->whereNull('seo_keywords')->orWhere('seo_keywords', '');
                } elseif ($metaStatus == 3) {
                    // Completed: all 3 meta fields filled
                    $q->whereNotNull('seo_title')->where('seo_title', '!=', '')
                        ->whereNotNull('seo_description')->where('seo_description', '!=', '')
                        ->whereNotNull('seo_keywords')->where('seo_keywords', '!=', '');
                } elseif ($metaStatus == 2) {
                    // Partial: any 2 fields filled, 1 missing
                    $q->where(function ($sub) {
                        $sub->whereNotNull('seo_title')->where('seo_title', '!=', '')
                            ->whereNotNull('seo_description')->where('seo_description', '!=', '')
                            ->where(function ($inner) {
                                $inner->whereNull('seo_keywords')->orWhere('seo_keywords', '');
                            });
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('seo_title')->where('seo_title', '!=', '')
                            ->whereNotNull('seo_keywords')->where('seo_keywords', '!=', '')
                            ->where(function ($inner) {
                                $inner->whereNull('seo_description')->orWhere('seo_description', '');
                            });
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('seo_description')->where('seo_description', '!=', '')
                            ->whereNotNull('seo_keywords')->where('seo_keywords', '!=', '')
                            ->where(function ($inner) {
                                $inner->whereNull('seo_title')->orWhere('seo_title', '');
                            });
                    });
                } elseif ($metaStatus == 1) {
                    // Pending: exactly 1 field filled (other 2 missing)
                    $q->where(function ($sub) {
                        $sub->whereNotNull('seo_title')->where('seo_title', '!=', '')
                            ->where(function ($inner) {
                                $inner->where(function ($q2) {
                                    $q2->whereNull('seo_description')->orWhere('seo_description', '');
                                })->where(function ($q2) {
                                    $q2->whereNull('seo_keywords')->orWhere('seo_keywords', '');
                                });
                            });
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('seo_keywords')->where('seo_keywords', '!=', '')
                            ->where(function ($inner) {
                                $inner->where(function ($q2) {
                                    $q2->whereNull('seo_title')->orWhere('seo_title', '');
                                })->where(function ($q2) {
                                    $q2->whereNull('seo_description')->orWhere('seo_description', '');
                                });
                            });
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('seo_description')->where('seo_description', '!=', '')
                            ->where(function ($inner) {
                                $inner->where(function ($q2) {
                                    $q2->whereNull('seo_title')->orWhere('seo_title', '');
                                })->where(function ($q2) {
                                    $q2->whereNull('seo_keywords')->orWhere('seo_keywords', '');
                                });
                            });
                    });
                }
            });
        }

        if ($category) {
            // $query->where('products.truck_id', $category);
            $categoryDB = Category::find($category);
            if ($categoryDB) {
                $categoryID = $categoryDB->id;
                $query->whereHas('categories', function ($subQuery) use ($categoryID) {
                    $subQuery->where('category_id', $categoryID);
                });
            }
        }

        if ($status != null) {
            $query->where('status', $status);
        }

        if ($clear == 'true') {
            $rows = $query->paginate($this->pagerecords, ['*'], 'page', $page);
        } else {
            $rows = $query->get();
        }
        //print '<pre>'; print_r($rows->toArray()); die;
        return array('html' => (string)View::make($this->prefix . '.' . $this->folder . '.rows')->with(compact('rows')));
    }



    public function deleteProductGallery($product_id, $id)
    {
        // print $product_id;
        // print ' ';
        // print $id; die;

        $product = Product::find($product_id);
        $image = $product->image()->find($id);
        if ($image) {
            //print 'products/'.$image->products_id.'/gallery/'.$image->image_name; die;
            Storage::disk('public')->delete('products/' . $product->id . '/gallery/' . $image->image);
            Storage::disk('public')->delete('products/' . $product->id . '/gallery/thumb/' . $image->image);
            $image->delete();
            Helper::flashMessage(true, 'Product Image deleted successfully!');
        }

        return redirect()->back();
    }


    public function deleteProductSpecification(Request $request)
    {
        //return true;
        $productID = trim($request->key);
        $id = trim($request->id);
        $row = Product::find($productID);
        if (!$row) {
            return array('result' => false, 'message' => 'Product does not exist');
        }
        $productSpecification = $row->specifications()->find($id);
        //print '<pre>'; print_r($productSpecification); die;
        if (!$productSpecification) {
            return array('result' => false, 'message' => 'Product Specification does not exist');
        }

        $productSpecification->delete();

        if ($row) {
            return array('result' => true, 'message' => 'Product Specification deleted successfully!');
        } else {
            return array('result' => false, 'message' => 'Something went wrong');
        }
    }


    public function export(Request $request)
    {
        return Excel::download(new ExportProduct, 'Products.xlsx');
    }

    public function validateImport(Request $request)
    {
        $file = $request->file('file');
        $validationArray = array(
            'file' => 'required|mimes:xlsx,csv'
        );
        $request->validate($validationArray);

        $validateData = Helper::validateImportData($file);
        // print '<pre>'; print_r($validateData['errors']); die;

        $html = '<div class="card mt-2">';
        $html .= '<div class="card-header">';
        if (isset($validateData['errors'])) {
            $html .= '<h6 class="card-title text-danger"><strong>Note:</strong> There are total of ' . count($validateData['errors']) . ' errors' . '<br><small> (Please resolve the errors, then retry upload)</small></h6>';
        } else {
            $html .= '<h6 class="card-title text-success">All the products can be imported</h6>';
        }
        $html .= '</div>';
        $html .= '<div class="card-body p-0">';
        $html .= '<table class="table">';
        $html .= '<tr><th>Name</th><th>Status</th><th>Message</th></tr>';

        $key = 2;
        if ($validateData['result']) {

            foreach ($validateData['rows'] as $row) {
                $html .= '<tr><td>' . $row['name'] . '</td><td><span class="badge bg-success">Okay</span></td><td>Can be imported.</td></tr>';
            }
        } else {

            foreach ($validateData['rows'] as $row) {

                $searchKey = 'row';
                $searchValue = $key;
                $searchedErrorRow = array_filter($validateData['errors'], function ($item) use ($searchKey, $searchValue) {
                    return isset($item[$searchKey]) && $item[$searchKey] == $searchValue;
                });

                // Reset array keys
                $searchedErrorRow = array_values($searchedErrorRow);

                if (count($searchedErrorRow) > 0) {
                    $html .= '<tr><td>' . $row['name'] . '</td><td><span class="badge bg-danger">Error</span></td><td>';
                    $html .= '<ul class="list-group">';
                    // Can be imported
                    $errorMessage = '';
                    foreach ($searchedErrorRow as $searchedErrorRowErrors) {
                        $errorMessage .= '<li>';
                        foreach ($searchedErrorRowErrors['errors'] as $searchedErrorRowError) {
                            $errorMessage .= $searchedErrorRowError . ', ';
                        }
                        $errorMessage = rtrim($errorMessage, ', ');
                        $errorMessage .= '</li>';
                    }
                    // $html .= rtrim($errorMessage, ', ');
                    $html .= $errorMessage;
                    $html .= '</ul>';
                    $html .= '</td></tr>';
                } else {
                    $html .= '<tr><td>' . $row['name'] . '</td><td><span class="badge bg-success">Okay</span></td><td>Can be imported.</td></tr>';
                }

                $key++;
            }
        }

        $html .= '</table></div>';
        if ($validateData['result']) {
            $html .= '<div class="card-footer text-center">
                        <button type="button" class="btn btn-success import-now">Import Now</button>
                      </div>';
        }
        $html .= '</div>';

        $validateData['html'] = $html;
        return $validateData;
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $validationArray = array(
            'file' => 'required|mimes:xlsx,csv'
        );
        $request->validate($validationArray);

        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        try {
            Excel::import(new ImportProduct(storage_path('app/' . $filePath)), $file);
            return array('result' => true, 'message' => 'Import successful!');
        } catch (\Exception $e) {
            return array('result' => false, 'message' => 'Import failed', 'error' => $e->getMessage());
        }
    }


    public function attributeCombinations(Request $request)
    {
        $attributes = $request->input('attributes');
        //print_r($attributes); die;

        $attributes_options_arr = [];
        $final_arr = [];
        foreach ($attributes as $key => $attribute) {
            //print 'b';
            $attribute_options = AttributeOption::select('attribute_options.*', 'attributes.name as attribute_name')->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')->where('attribute_id', $attribute)->get();
            $temp_arr = [];
            foreach ($attribute_options as $key2 => $attribute_option) {
                //$temp_arr[] = $attribute_option->name."_".$attribute_option->id."_".$attribute;
                $temp_arr[$key2]['attribute_name'] = $attribute_option->attribute_name;
                $temp_arr[$key2]['attribute_value'] = $attribute_option->name;
                $temp_arr[$key2]['attribute'] = $attribute;
                $temp_arr[$key2]['attribute_option'] = $attribute_option->id;
            }
            $attributes_options_arr[] = $temp_arr;
            //$attributes_options_arr = $temp_arr;
        }

        //print_R($attributes_options_arr); die;

        $level = Helper::getLevel($attributes_options_arr);
        //print $level; die;

        if (count($attributes) == 1) {
            //print 'a'; 
            $single_attribute_arr = [];
            foreach (Helper::combinations($attributes_options_arr, $level) as $key3 => $value) {
                $temp_arr = [];
                $temp_arr[] = $value;
                //$temp_arr = $value;
                $single_attribute_arr[] = $temp_arr;
                //$single_attribute_arr = $temp_arr;
            }
            //return $single_attribute_arr;
            $final_arr = $single_attribute_arr;
        } else {
            //print 'c ';
            //return Helper::combinations($attributes_options_arr);
            $final_arr = Helper::combinations($attributes_options_arr, $level);
        }

        //print_R($final_arr); die;
        return array('result' => true, 'combinations' => $final_arr, 'count' => count($final_arr));
    }


    public function attributeCustomCombinations(Request $request)
    {
        $attributes = $request->input('attributes');
        //print_r($attributes); die;

        $final_arr = [];

        foreach ($attributes as $key => $attribute) {
            //print 'b';
            $attribute_options = AttributeOption::select('attribute_options.*', 'attributes.name as attribute_name')->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')->where('attribute_id', $attribute)->get();

            foreach ($attribute_options as $key2 => $attribute_option) {

                $final_arr[$key]['attribute_name'] = $attribute_option->attribute_name;
                $final_arr[$key]['attribute'] = $attribute;
                $final_arr[$key]['options'][$key2]['id'] = $attribute_option->id;
                $final_arr[$key]['options'][$key2]['name'] = $attribute_option->name;
            }
        }
        //print '<pre>'; print_R($final_arr); die;
        return array('result' => true, 'attributes' => $final_arr);
        //return array('result' => true, 'attributes' => []);

    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id'  => 'required|exists:products,id',
            'col' => 'required|in:temp_sensitive',
        ]);
        $category = Product::findOrFail($request->id);
        $column = $request->col;
        $category->$column = !$category->$column;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $column)) . ' status updated successfully.',
            'status'  => (bool) $category->$column,
            'column'  => $column,
        ]);
    }
}
