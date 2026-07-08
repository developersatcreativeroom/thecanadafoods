<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\UserCoupon;

use Carbon\Carbon;
use App\Helper;
use App\Models\State;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Image;
use Validator;
use Mail;


class CartController extends Controller
{
    private $prefix = 'front';
    private $folder = 'cart';


    public function addCart(Request $request)
    {

    
        $quantity = $request->quantity;
        $attribute = $request->attribute;
        $slug = $request->key;
        $page = $request->page;

        if ($quantity < 1) {
            $quantity = 1;
        }

        $product = Product::with(['attributes.details'])->where('slug', $slug)->first();
    $hasTempSensitive = optional($product)->temp_sensitive == 1;

    









        $user = Auth::user();
        $cartObj = Helper::getCartObj($user);

        $count = $cartObj->count();

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        //work here
        //$stockQuantity = 1;
        $stockQuantity = Helper::getProductStockQuantity($product, $attribute);
        //print $stockQuantity; die;
        if ($product != null && $stockQuantity > 0) {

            $attributeID = null;
            if ($product->is_variant) {
                $attribute = $product->attributes()->find($attribute);
                $attributeID = $attribute->id;
            }

            // $already = $cartObj->where('product_id',$product->id)->where('product_attribute_id',$attributeID);



            $alreadyObj = $cartObj;
            $alreadyObj->where('product_id', $product->id);
            if ($attributeID != null) {
                $alreadyObj->where('product_attribute_id', $attributeID);
            }

            $alreadyCount = $alreadyObj->count();
            //print $alreadyCount; die;
            if ($alreadyCount > 0) {
                $inCartQuantity = $alreadyObj->first()->quantity;
                if (($inCartQuantity + $quantity) > $stockQuantity) {
                    return array('result' => false, 'message' => 'Product quantity is more than available');
                }
                $query = $alreadyObj->update(['quantity' => ($inCartQuantity + $quantity)]);
            } else {
                if ($quantity > $stockQuantity) {
                    return array('result' => false, 'message' => 'Product quantity is more than available');
                }
                if ($user) {
                    $query = $cartObj->create(['product_id' => $product->id, 'quantity' => $quantity, 'product_attribute_id' => $attributeID]);
                } else {
                    $uuid = Helper::getUserUUID();
                    $query = $cartObj->create(['product_id' => $product->id, 'quantity' => $quantity, 'uuid' => $uuid,  'product_attribute_id' => $attributeID]);
                }
            }

            if($hasTempSensitive){
                $iceProduct=Product::find(2907);
        $already=Helper::alreadyInCart($iceProduct);
        $stockQuantityIce = Helper::getProductStockQuantity($product, $attribute);

        if(!$already){
            if (1 > $stockQuantityIce) {
                    return array('result' => false, 'message' => 'Product quantity is more than available');
                }
                if ($user) {
                    $query = $cartObj->create(['product_id' => $iceProduct->id, 'quantity' => 1, 'product_attribute_id' => $attributeID]);
                } else {
                    $uuid = Helper::getUserUUID();
                    $query = $cartObj->create(['product_id' => $iceProduct->id, 'quantity' => 1, 'uuid' => $uuid,  'product_attribute_id' => $attributeID]);
                }

        }

      
    }

            if ($page == 'wishlist') {
                $wishlistObj = Helper::getWishlistObj($user);
                $wishlistObj->where('product_id', $product->id);
                if ($attributeID != null) {
                    $alreadyObj->where('product_attribute_id', $attributeID);
                }
                $wishlist = $wishlistObj->delete();

                // $wishlist = $user->wishlist();
                // $wishlist->where('product_id',$productID)->delete();
            }

            $wishlistObj = Helper::getWishlistObj($user);
            $wishlistCount = $wishlistObj->count();

            $count = $cartObj->count();

            if ($query) {

                $validateCoupon = Helper::validateCoupon($user);
                $couponError = '';
                $couponCode = '';
                if (!$validateCoupon['result']) {
                    $couponError = $validateCoupon['message'];
                    $couponCode = $validateCoupon['code'];
                    $coupon = Coupon::where('code', $couponCode)->first();
                    if ($user) {
                        $user->coupon()->where('coupon_id', $coupon->id)->delete();
                    } else {
                        $uuid = Helper::getUserUUID();
                        UserCoupon::where('coupon_id', $coupon->id)->where('uuid', $uuid)->delete();
                    }
                }

                return array('count' => $count, 'wishlistCount' => $wishlistCount, 'result' => true, 'message' => $isEnquiryWebsite ? 'Product added to enquiry cart' : 'Product added to cart', 'update_html' => $isEnquiryWebsite ? 'Remove from enquiry' : 'Remove from cart', 'coupon_error' => $couponError, 'coupon_code' => $couponCode);
            } else {
                return array('count' => $count, 'result' => false, 'message' => 'Something is wrong');
            }
        } else {
            return array('count' => $count, 'result' => false, 'message' => 'Product is out of stock');
        }
    }

    public function updateCart(Request $request)
    {
        $slug = $request->key;
        $quantity = $request->quantity;
        $attribute = $request->attribute;

        $product = Product::with(['attributes.details'])->where('slug', $slug)->first();
        $user = Auth::user();
        $cartObj = Helper::getCartObj($user);

        //print_r($cart->get()); die;
        $cart = $cartObj->where('product_id', $product->id)->where('product_attribute_id', $attribute)->first();

        if ($cart == null) {
            $count = $cart->count();
            return array('count' => $count, 'result' => false, 'message' => 'Something went wrong');
        } else {
            //print '<pre>'; print_r($cart); die;
            $stockQuantity = Helper::getProductStockQuantity($product, $attribute);
            //print $stockQuantity; die;
            if ($stockQuantity >= $quantity) {
                $cart->quantity = $quantity;
                $cart->save();
            }
            $count = $cart->count();
            //$view = (String)View::make('front.cart.checkout-section')->with(compact('cart'));
            $checkout = Helper::checkout($user);

            $cart = Helper::getCartShowList($user);

            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

            $validateCoupon = Helper::validateCoupon($user);
            $couponError = '';
            $couponCode = '';
            if (!$validateCoupon['result']) {
                $couponError = $validateCoupon['message'];
                $couponCode = $validateCoupon['code'];
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($user) {
                    $user->coupon()->where('coupon_id', $coupon->id)->delete();
                } else {
                    $uuid = Helper::getUserUUID();
                    UserCoupon::where('coupon_id', $coupon->id)->where('uuid', $uuid)->delete();
                }
            }

            return array('count' => $count, 'result' => true, 'productsHtml' => (string)View::make('front.cart.products-section')->with(compact('cart')), 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')), 'message' => 'Cart upated', 'coupon_error' => $couponError, 'coupon_code' => $couponCode);
        }
    }

    public function deleteCart(Request $request)
    {

        $p_id="2907";
        $slug = $request->key;
        $attribute = $request->attribute;

        //$cart=Auth::user()->cart();
        //print $productID; die;
        $product = Product::with(['attributes.details'])->where('slug', $slug)->first();
        $user = Auth::user();
        $cartObj = Helper::getCartObj($user);



        $cart = $cartObj->where('product_id', $product->id)->where('product_attribute_id', $attribute)->first();


        //print '<pre>'; print_r($cart); die;
        //$query = $cart->create(['product_id'=>$productID, 'quantity'=> $quantity]);

        if ($cart == null) {
            //$count=$cart->count();
            $count = 0;
            return array('count' => $count, 'result' => false, 'message' => 'Something went wrong');
        } else {
            $deleted = $cart->delete();
            $cartObj = Helper::getCartObj($user);

            $hasTempSensitive = $cartObj->get()->contains(fn($cart) => optional($cart->product)->temp_sensitive == 1);

            if ($hasTempSensitive) {

                 $cart = $cartObj->where('product_id', $p_id)->where('product_attribute_id', $attribute)->first();
                $cart->delete();
            }

            $count = $cartObj->count();

            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

            // if($deleted){

            //     $validateCoupon = Helper::validateCoupon($user);
            //     $couponError = '';
            //     $couponCode = '';
            //     if(!$validateCoupon['result']){
            //         $couponError = $validateCoupon['message'];
            //         $couponCode = $validateCoupon['code'];
            //         $coupon = Coupon::where('code', $couponCode)->first();
            //         // print '<pre>'; print_r($coupon); die;
            //         if($user){
            //             $user->coupon()->where('coupon_id', $coupon->id)->delete();
            //         }else{
            //             $uuid = Helper::getUserUUID();
            //             UserCoupon::where('coupon_id', $coupon->id)->where('uuid', $uuid)->delete();
            //         }
            //     }

            // updated code by abhi
            if ($deleted) {



                // Check if any temperature-sensitive product still exists
                $hasTempSensitive = $cartObj->where('temp_sensitive', 1)->exists();

                // If no temperature-sensitive products remain,
                // remove the Ice Bag (Product ID: 2907)
                if (!$hasTempSensitive) {
                    $cartObj->where('product_id', 2907)->delete();
                }

                // Refresh cart again after removing Ice Bag (if removed)
                $cartObj = Helper::getCartObj($user);
                $count = $cartObj->count();

                // Validate Coupon
                $validateCoupon = Helper::validateCoupon($user);
                $couponError = '';
                $couponCode = '';

                if (!$validateCoupon['result']) {

                    $couponError = $validateCoupon['message'];
                    $couponCode = $validateCoupon['code'];

                    $coupon = Coupon::where('code', $couponCode)->first();

                    if ($coupon) {
                        if ($user) {
                            $user->coupon()->where('coupon_id', $coupon->id)->delete();
                        } else {
                            $uuid = Helper::getUserUUID();
                            UserCoupon::where('coupon_id', $coupon->id)
                                ->where('uuid', $uuid)
                                ->delete();
                        }
                    }


                    $checkout = Helper::checkout($user);
                    $cart = Helper::getCartShowList($user);

                    return [
                        'count' => $count,
                        'result' => true,
                        'productsHtml' => (string) View::make('front.cart.products-section')->with(compact('cart')),
                        'checkoutHtml' => (string) View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')),
                        'message' => $isEnquiryWebsite ? 'Product removed from enquiry cart' : 'Product removed from cart',
                        'update_html' => $isEnquiryWebsite ? 'Add to enquiry' : 'Add to cart',
                        'coupon_error' => $couponError,
                        'coupon_code' => $couponCode,
                    ];
                }

                $checkout = Helper::checkout($user);
                $cart = Helper::getCartShowList($user);
                return array('count' => $count, 'result' => true, 'productsHtml' => (string)View::make('front.cart.products-section')->with(compact('cart')), 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')), 'message' => $isEnquiryWebsite ? 'Product removed from enquiry cart' : 'Product removed from cart', 'update_html' => $isEnquiryWebsite ? 'Add to enquiry' : 'Add to cart', 'coupon_error' => $couponError, 'coupon_code' => $couponCode);
            } else {
                return array('count' => $count, 'result' => false, 'message' => 'Something went wrong');
            }
        }
    }

    public function emptyCart(Request $request)
    {
        //return array('count'=>1,'result'=>false, 'message' => 'Something went wrong');
        $user = Auth::user();
        $cartObj = Helper::getCartObj($user);
        $deleted = $cartObj->delete();
        $count = $cartObj->count();
        if ($deleted) {
            return array('count' => $count, 'result' => true, 'message' => 'Cart is empty');
        } else {
            return array('count' => $count, 'result' => false, 'message' => 'Something went wrong');
        }
    }


    public function cartDetails()
    {
        $user = Auth::user();
        $cartDetails = Helper::getCartShowList($user);
        //print_R($cartDetails->toArray()); die;
        //$count = $cartDetails->count();

        $total = 0;
        $shipping = 0;

        $count = 0;


        $details = '';

        $couponDiscount = 0;
        if (count($cartDetails) > 0) {
            foreach ($cartDetails as $key => $cart) {
                $couponSingleDiscount = 0;
                // if($cart->coupon_id != null){
                //     $coupon = Helper::getCouponDetails($cart->coupon_id, $cart);
                //     //print_r($coupon); die;
                //     $couponSingleDiscount = $coupon['discount_amount'];
                //     $couponDiscount += $coupon['discount_amount'] * $cart->quantity;
                // }

                $couponDiscount = Helper::numberFormat($couponDiscount);

                $total = $total + (($cart->productPrice() - $cart->discount) * $cart->quantity) - $couponDiscount;

                $count = $count + $cart->quantity;

                $couponDiscount = Helper::numberFormat($couponDiscount);



                //print '<pre>'; print_r($cart); die;
                $details .= '
                        
                        <li class="d-flex align-items-center">
                            <input type="hidden" value="' . $cart->id . '" name="cart[' . $key . '][id]" />
                            <div class="thumb-wrapper" data-index="' . $key . '">
                                <a href="' . route('product', $cart->slug) . '">';
                if ($cart->is_variant && $cart->attribute) {
                    $details .= '<img class="img-fluid" src="' . asset('storage/products/') . '/' . $cart->product_id . '/' . $cart->attribute->image . '" alt="{{$cart->attribute->name}}">';
                } else {
                    $details .= '<img class="img-fluid" src="' . asset('storage/products/') . '/' . $cart->product_id . '/' . $cart->image . '" alt="' . $cart->name . '">';
                }

                $details .= '</div>

                            <div class="items-content ms-3 flex-grow-1">
                                <a href="' . route('product', $cart->slug) . '">
                                    <h6 class="mb-1" title="' . $cart->name . '"><a href="' . route('product', $cart->slug) . '" class="text-dark text-limit-1">' . substr($cart->name, 0, 30) . '...</a></h6>';

                // if((strlen($cart->name) > 30)){
                //     $details .= '<h6 class="mb-1" title="'.$cart->name.'"><a href="'.route('product',$cart->slug).'">'.substr($cart->name, 0, 30).'...</a></h6>';
                // }else{
                //     $details .= '<h6 class="mb-1"><a href="'.route('product',$cart->slug).'">'.$cart->name.'</a></h6>';
                // }

                $attribute = null;

                if ($cart->is_variant && $cart->attribute) {
                    if (isset($cart->attribute->details)) {
                        $details .= '<p class="">';
                        foreach ($cart->attribute->details as $detail) {
                            $details .= '<span class="badge text-dark ps-0 pe-1">' . $detail->attribute_name . ': ' . $detail->attribute_option_name . '</span>';
                        }
                        $details .= '</p>';
                    }
                    $attribute = $cart->attribute->id;
                }

                $details .= '</a>
                                        </div>


                                <div class="products_meta d-flex align-items-center">
                                    <div class="d-flex">
                                        <span class="price text-primary fw-semibold">' . $cart->productPriceShow() . '</span>&nbsp;
                                        <span class="count">x&nbsp;' . $cart->quantity . '</span>
                                    </div>';


                $details .= '                                     
                                    <button class="text-primary remove_cart_btn delete-cart position-relative ms-2" data-key="' . $cart->slug . '" data-attribute="' . $attribute . '">
                                        <i class="fa-solid fa-trash-can "></i>
                                    </span>
                                
                            </div>
                        </li>';
            }
        } else {

            $details .= '
                <li>
                    <small class="m-auto">No Products added in cart yet</small>
                </li>';
        }

        $currency = Helper::getCurrency();
        $totalHtml = $currency['sign'] . (Helper::priceFormat($total + $shipping));


        $total = Helper::priceFormat($total);

        return array('count' => $count, 'details' => $details, 'total' => $totalHtml, 'totalAmount' => $total);
    }

    public function cart()
    {
        $user = Auth::user();
        $cart = Helper::getCartShowList($user);


        //print '<pre>'; print_r($cart); die;
        // $couponDiscount = 0;
        // $servicePrices = 0;
        // foreach($cart as $key => $cartSingle){
        //     if($cartSingle->coupon_id != null){
        //         $coupon = Helper::getCouponDetails($cartSingle->coupon_id, $cartSingle);
        //         //print_r($coupon); die;
        //         $cart[$key]->discount_type = $coupon['discount_type'];
        //         $cart[$key]->discount_value = $coupon['discount_value'];
        //         $cart[$key]->discounted_amount = $coupon['discounted_amount'];
        //         $cart[$key]->discount_amount = $coupon['discount_amount'];

        //         $couponDiscount += $coupon['discount_amount'] * $cart[$key]->quantity;
        //     }
        //     $cart[$key]->services = Cart_service::leftjoin('services','services.id','=','cart_services.service_id')->where('cart_id',$cartSingle->id)->get();

        //     foreach($cart[$key]->services as $service){
        //         $servicePrices += ($service->price-$service->discount) * $cartSingle->quantity;
        //     }
        // }
        //print '<pre>'; print_r($cart); die;
        //$couponDiscount = Helper::numberFormat($couponDiscount);


        //return view('front.cart')->with(compact('cart','couponDiscount','servicePrices'));
        $checkout = Helper::checkout($user);

        $couponEnabled = Helper::getWebsiteConfig('coupon');
        //print_r($couponEnabled['coupon']); die;
        if ($couponEnabled['coupon'] == true) {
            $coupon = Helper::getCouponDetails($user);
        } else {
            $coupon = '';
        }

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];


        //print '<pre>'; print_r($coupon); die;
        //print '<pre>'; print_r($cart); die;
        return view($this->prefix . '.' . $this->folder . '.cart')->with(compact('cart', 'checkout', 'coupon', 'couponEnabled', 'isEnquiryWebsite'));
    }


    public function applyCoupon(Request $request)
    {
        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];
        if ($isEnquiryWebsite) {
            return array('result' => false, 'message' => 'The Coupon cannot be applied');
        }

        $couponEnabled = Helper::getWebsiteConfig('coupon');
        if ($couponEnabled['coupon'] == false) {
            return array('result' => false, 'message' => 'The Coupon cannot be applied at the moment');
        }

        $code = trim($request->code);
        //print $code; die;

        $user = Auth::user();
        //return $user->coupon()->get();

        $validateCoupon = Helper::validateCoupon($user, $code);
        if (!$validateCoupon['result']) {
            return $validateCoupon;
        }
        $coupon = $validateCoupon['coupon'];

        if ($user) {
            $user->coupon()->where('coupon_id', '!=', $coupon->id)->delete();
            $query = $user->coupon()->create(['coupon_id' => $coupon->id]);
        } else {
            $uuid = Helper::getUserUUID();
            UserCoupon::where('coupon_id', '!=', $coupon->id)->where('uuid', $uuid)->delete();
            $query = UserCoupon::create(['coupon_id' => $coupon->id, 'uuid' => $uuid]);
        }

        if ($query) {
            $state = null;
            if (isset($request->state_code) && $request->state_code != '') {
                $state = State::where('code', $request->state_code)->first();
            }
            $checkout = Helper::checkout($user, true, $state);
            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

            return array('result' => true, 'message' => 'Coupon applied Successfully', 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')), 'price_html' => (string)View::make('front.checkout.pricing-section')->with(compact('checkout', 'isEnquiryWebsite')));
        } else {
            return array('result' => false, 'message' => 'Something went wrong');
        }
    }

    public function removeCoupon(Request $request)
    {
        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];
        if ($isEnquiryWebsite) {
            return array('result' => false, 'message' => 'The Coupon cannot be applied');
        }

        $couponEnabled = Helper::getWebsiteConfig('coupon');
        if ($couponEnabled['coupon'] == false) {
            return array('result' => false, 'message' => 'The Coupon cannot be applied at the moment');
        }

        $code = ($request->code);
        //print $code; die;

        $user = Auth::user();

        $coupon = Coupon::where('code', $code)->where('status', 1)->first();
        //print '<pre>'; print_r($coupon); die;

        if (!$coupon) {
            return array('result' => false, 'message' => 'Coupon code not valid');
        }


        if ($user) {
            $couponObj = $user->coupon()->where('coupon_id', $coupon->id);
            if ($couponObj->count() > 0) {
                $query = $couponObj->delete();
            } else {
                return array('result' => false, 'message' => 'Something went wrong');
            }
        } else {
            $uuid = Helper::getUserUUID();
            $couponObj = UserCoupon::where('coupon_id', $coupon->id)->where('uuid', $uuid);
            if ($couponObj->count() > 0) {
                $query = $couponObj->delete();
            } else {
                return array('result' => false, 'message' => 'Something went wrong');
            }
        }



        if ($query) {
            $state = null;
            if (isset($request->state_code) && $request->state_code != '') {
                $state = State::where('code', $request->state_code)->first();
            }
            $checkout = Helper::checkout($user, true, $state);
            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

            return array('result' => true, 'message' => 'Coupon removed Successfully', 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')), 'price_html' => (string)View::make('front.checkout.pricing-section')->with(compact('checkout', 'isEnquiryWebsite')));
        } else {
            return array('result' => false, 'message' => 'Something went wrong');
        }
    }


    public function addService(Request $request)
    {
        $config = Helper::getWebsiteConfig('product_services');
        if (!$config['product_services']) {
            return array('result' => false, 'message' => 'Product Service not available');
        }

        $slug = $request->key;
        $attribute = $request->attribute;
        $service = $request->service;

        $user = Auth::user();
        $product = Product::with(['services'])->where('slug', $slug)->first();
        if (!$product) {
            return array('result' => false, 'message' => 'Product does not exists');
        }
        $service = $product->services()->where('slug', $service)->first();

        //attribute

        if (!$service) {
            return array('result' => false, 'message' => 'Service does not exists');
        }
        //print '<pre>'; print_r($service); die;
        $cartObj = Helper::getCartObj($user);
        //$abc = $cartObj->get();
        //print '<pre>'; print_r($abc); die;

        //$cart = $cartObj->where('product_id',$product->id)->first();

        $cartObj->where('product_id', $product->id);
        if ($attribute) {
            $cartObj->where('product_attribute_id', $attribute);
        }
        $cart = $cartObj->first();

        //print '<pre>'; print_r($cart); die;
        if (!$cart) {
            return array('result' => false, 'message' => 'Product is not in the Cart');
        }
        $serviceDB = $cart->services();
        $query = $serviceDB->updateOrCreate(['product_service_id' => $service->id]);
        if ($query) {
            $checkout = Helper::checkout($user);
            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];
            return array('result' => true, 'message' => 'Service added to cart', 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')));
        } else {
            return array('result' => false, 'message' => 'Something is wrong');
        }
    }


    public function removeService(Request $request)
    {
        $config = Helper::getWebsiteConfig('product_services');
        if (!$config['product_services']) {
            return array('result' => false, 'message' => 'Product Service not available');
        }

        $slug = $request->key;
        $attribute = $request->attribute;
        $service = $request->service;

        $user = Auth::user();
        $product = Product::with(['services'])->where('slug', $slug)->first();
        if (!$product) {
            return array('result' => false, 'message' => 'Product does not exists');
        }
        $service = $product->services()->where('slug', $service)->first();
        if (!$service) {
            return array('result' => false, 'message' => 'Service does not exists');
        }
        //print '<pre>'; print_r($service); die;
        $cartObj = Helper::getCartObj($user);
        //$abc = $cartObj->get();
        //print '<pre>'; print_r($abc); die;
        //$cart = $cartObj->where('product_id',$product->id)->first();

        $cartObj->where('product_id', $product->id);
        if ($attribute) {
            $cartObj->where('product_attribute_id', $attribute);
        }
        $cart = $cartObj->first();
        //print '<pre>'; print_r($cart); die;
        if (!$cart) {
            return array('result' => false, 'message' => 'Product is not in the Cart');
        }
        $serviceDB = $cart->services();
        $query = $serviceDB->where('product_service_id', $service->id)->delete();
        if ($query) {
            $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
            $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];
            $checkout = Helper::checkout($user);
            return array('result' => true, 'message' => 'Service deleted Successfully', 'checkoutHtml' => (string)View::make('front.cart.checkout-section')->with(compact('checkout', 'isEnquiryWebsite')));
        } else {
            return array('result' => false, 'message' => 'Something is wrong');
        }
    }
}
