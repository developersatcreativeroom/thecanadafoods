<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\GoogleLoginController;
use App\Http\Controllers\Front\ProfileController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AttributeController as AdminAttributeController;
use App\Http\Controllers\Admin\ColorController as AdminColorController;
use App\Http\Controllers\Admin\TaxController as AdminTaxController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Admin\ProductServiceController as AdminProductServiceController;
use App\Http\Controllers\Admin\ProductAddonController as AdminProductAddonController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ConfigController as AdminConfigController;
use App\Http\Controllers\Admin\Setting\SeoController as AdminSettingSeoController;
use App\Http\Controllers\Admin\Setting\SocialController as AdminSettingSocialController;
use App\Http\Controllers\Admin\Setting\MarketingController as AdminSettingMarketingController;
use App\Http\Controllers\Admin\Setting\PaymentController as AdminSettingPaymentController;
use App\Http\Controllers\Admin\Setting\AccountingController as AdminSettingAccountingController;
use App\Http\Controllers\Admin\CkeditorController as AdminCkeditorController;
use App\Http\Controllers\Admin\ChartController as AdminChartController;
use App\Http\Controllers\Admin\AdminUserController as AdminAdminUserController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Route;

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


// Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [HomeController::class, 'about'])->name('about');

Route::get('products', [HomeController::class, 'products'])->name('products');
Route::get('product/{slug}', [HomeController::class, 'product'])->name('product')->middleware('remove.page1');;
Route::post('product/rating/{slug}', [HomeController::class, 'filterRating'])->name('ratings.filter');
Route::get('product/rating/{slug}', [HomeController::class, 'fixGoogleCrawlingIssues']); //Only for google Crawling issue fix.
Route::get('gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::match(['get','post'], 'contact', [HomeController::class, 'contact'])->name('contact');
Route::get('blog-category', [HomeController::class, 'blogCategory'])->name('blog.category');
Route::get('blog', [HomeController::class, 'blogs'])->name('blogs');
Route::get('blog/{slug}', [HomeController::class, 'blog'])->name('blog');
Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('refund', [HomeController::class, 'refund'])->name('refund.policy');
Route::get('shipping-policy', [HomeController::class, 'shippingPolicy'])->name('shipping.policy');
Route::get('disclaimer', [HomeController::class, 'disclaimer'])->name('disclaimer');
Route::get('cookie-policy', [HomeController::class, 'cookiePolicy'])->name('cookie.policy');

Route::get('videos', [HomeController::class, 'videos'])->name('videos');

Route::post('select-attribute', [HomeController::class, 'selectAttribute'])->name('select.attribute');  
Route::get('tab-products', [HomeController::class, 'tabProducts'])->name('tab.products');  
Route::get('ajax-products-search', [HomeController::class, 'ajaxProductSearch'])->name('ajax.products.search');  


Route::get('demo', [HomeController::class, 'demo'])->name('demo');

Route::get('/cart',[CartController::class, 'cart'])->name('cart');


// Route::get('/wishlist',[CartController::class, 'wishlist'])->name('demo');
// Route::post('/add-wishlist',[CartController::class, 'addWishlist'])->name('demo');
// Route::post('/remove-wishlist',[CartController::class, 'removeWishlist'])->name('demo');

Route::post('/add-cart',[CartController::class, 'addCart'])->name('add.cart');
Route::post('/delete-cart',[CartController::class, 'deleteCart'])->name('delete.cart');
Route::post('/empty-cart',[CartController::class, 'emptyCart'])->name('empty.cart');
Route::post('/update-cart',[CartController::class, 'updateCart'])->name('update.cart');
//Route::post('/remove-cart',[CartController::class, 'removeCart'])->name('remove.cart');
Route::post('/cart-details',[CartController::class, 'cartDetails'])->name('cart.details');

Route::post('/add-service',[CartController::class, 'addService'])->name('add.service' );
Route::post('/remove-service',[CartController::class, 'removeService'])->name('remove.service' );

Route::post('/apply-coupon',[CartController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/remove-coupon',[CartController::class, 'removeCoupon'])->name('remove.coupon');

// Route::match(['get','post'],'checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::get('checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::post('checkout',[CheckoutController::class, 'checkout'])->name('checkout.post')->middleware('throttle:5,1');

Route::match(['get','post'], 'checkout-stripe-card/{order_id}',[CheckoutController::class, 'checkoutStripeCard'])->name('stripe.checkout');

Route::match(['get','post'], 'checkout-razorpay/{order_id}',[CheckoutController::class, 'checkoutRazorpay'])->name('razorpay.checkout');


Route::get('/instamojo-redirect', [CheckoutController::class, 'instamojoRedirect'])->name('instamojo.redirect');
Route::get('/paypal-redirect', [CheckoutController::class, 'paypalRedirect'])->name('paypal.redirect');
Route::post('/razorpay-redirect', [CheckoutController::class, 'razorpayRedirect'])->name('razorpay.redirect');

Route::get('/stripe-redirect', [CheckoutController::class, 'stripeRedirect'])->name('stripe.redirect');




Route::get('order-placed', [HomeController::class, 'orderPlaced'])->name('order.placed');
//Route::get('failure', [HomeController::class, 'failure'])->name('failure');

Route::get('enquiry-placed', [HomeController::class, 'enquiryPlaced'])->name('enquiry.placed');


Route::post('/add-wishlist',[HomeController::class, 'addWishlist'])->name('add.wishlist');
Route::post('/remove-wishlist',[HomeController::class, 'removeWishlist'])->name('remove.wishlist');
Route::get('/wishlist',[HomeController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist-details',[HomeController::class, 'wishlistDetails'])->name('wishlist.details');

Route::get('/page/{slug}',[HomeController::class, 'page'])->name('page');

Route::post('/subscribe',[HomeController::class, 'subscribe'])->name('subscribe');

Route::match(['get','post'],'/search',[HomeController::class, 'search']);


Route::post('/review',[HomeController::class, 'review'])->name('review');


Route::match(['get','post'],'/register', [AuthController::class, 'register'])->name('register');
Route::match(['get','post'],'/login', [AuthController::class, 'login'])->name('login');


Route::get('google-login', [GoogleLoginController::class, 'googleLogin'])->name('google.login');
Route::get('google-login-redirect', [GoogleLoginController::class, 'googleLoginRedirect'])->name('google.login.redirect');


Route::get('/get-states',[CheckoutController::class, 'getStates'])->name('get.states');
Route::get('/get-state-shipping',[CheckoutController::class, 'getStateShipping'])->name('get.state.shipping');

Route::get('/refresh-pricing',[CheckoutController::class, 'refreshPricingSection'])->name('refresh.pricing.section');

Route::get('/terms',[HomeController::class, 'terms'])->name('terms');

Route::match(['get','post'], '/forgot-password', [HomeController::class, 'forgotPassword'])->name('forgot.password');
Route::match(['get','post'], '/password-reset/{token}', [HomeController::class, 'passwordReset'])->name('password.reset');


Route::get('/demo',[HomeController::class, 'demo'])->name('demo');

Route::group(['middleware' => ['auth']], function () {



    Route::match(['get','post'], 'profile', [ProfileController::class, 'profile'])->name('profile');
    Route::match(['get','post'], 'change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::get('addresses', [ProfileController::class, 'addresses'])->name('addresses');
    Route::match(['get','post'], 'address', [ProfileController::class, 'address'])->name('address');
    Route::get('address/{id}', [ProfileController::class, 'addressEdit'])->name('address.edit');

    Route::get('fetch-addresses', [ProfileController::class, 'fetchAddresses'])->name('fetch.addresses');
    Route::get('select-address', [ProfileController::class, 'selectAddress'])->name('select.address');
    Route::get('set-default-address', [ProfileController::class, 'setDefaultAddress'])->name('set.default.address');

    Route::get('/email/verify/{id}/{hash}', [ProfileController::class, 'verificationVerify'])
    // ->middleware(['auth', 'signed'])
    ->name('verification.verify');

    Route::post('/email/verification-notification', [ProfileController::class, 'verificationNotification'])->name('verification.send');
    
    Route::get('orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('order/{order_unique_id}', [ProfileController::class, 'order'])->name('order');
    Route::get('order-invoice/{order_unique_id}', [ProfileController::class, 'orderInvoice'])->name('order.invoice');

    Route::get('enquiries', [ProfileController::class, 'enquiries'])->name('enquiries');
    Route::get('enquiry/{enquiry_unique_id}', [ProfileController::class, 'enquiry'])->name('enquiry');

    // Route::get('/profile/orders', [HomeLoginController::class,'profileOrders']);
    // Route::get('/profile/order/{id}', [HomeLoginController::class,'profileOrder']);
    // Route::get('/profile/addresses', [HomeLoginController::class,'profileAddresses']);
    // Route::get('/profile/address', [HomeLoginController::class,'profileAddress']);
    // Route::get('/profile/address/{id}', [HomeLoginController::class,'profileAddress']);
    // Route::post('post-address', [HomeLoginController::class,'postAddress']);
    // Route::post('default-address', [HomeLoginController::class,'defaultAddress']);
    // Route::post('billing-address', [HomeLoginController::class,'billingAddress']);
    // Route::post('shipping-address', [HomeLoginController::class,'shippingAddress']);
    // Route::get('/profile/password', [HomeLoginController::class,'profilePassword']);
    // Route::post('update-password', [HomeLoginController::class,'updatePassword']);

    
    Route::post('save-payment-method', [ProfileController::class, 'savePaymentMethod'])->name('save.payment.method');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});





Route::group( [ 'prefix' => 'admin' ], function(){

    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::match(['get','post'], '/forgot-password', [AdminController::class, 'forgotPassword'])->name('admin.forgot.password');
    Route::match(['get','post'], '/recover-password/{token}', [AdminController::class, 'recoverPassword'])->name('admin.recover.password');
    
		
    Route::match(['get','post'],'/login', [AdminAuthController::class, 'login'])->name('admin.login');


    Route::group(['middleware' => ['admin']], function () {
        
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::match(['get','post'],'/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::match(['get','post'],'/change-password', [AdminController::class, 'changePassword'])->name('admin.profile.change.password');

        Route::group(['middleware' => 'permissions:products'], function () {

            Route::get('categories', [AdminCategoryController::class, 'list'])->name('admin.categories');
            Route::get('category', [AdminCategoryController::class, 'add'])->name('admin.category');
            Route::post('category/toggle', [AdminCategoryController::class, 'toggle'])->name('admin.category.toggle');
            Route::get('category/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
            Route::post('category-post-data', [AdminCategoryController::class, 'postData'])->name('admin.category.post');
            Route::get('category-delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.category.delete');

            Route::get('products', [AdminProductController::class, 'list'])->name('admin.products');
            Route::get('product', [AdminProductController::class, 'add'])->name('admin.product');
            Route::post('product/toggle', [AdminProductController::class, 'toggle'])->name('admin.products.toggle');
            Route::get('product/{id}', [AdminProductController::class, 'edit'])->name('admin.product.edit');
            Route::post('product-post-data', [AdminProductController::class, 'postData'])->name('admin.product.post');
            Route::get('product-delete-data/{id}', [AdminProductController::class, 'delete'])->name('admin.product.delete');

            Route::get('filter-products', [AdminProductController::class, 'filter'])->name('admin.product.filter');

            Route::get('delete-product-gallery/{product_id}/{id}', [AdminProductController::class, 'deleteProductGallery'])->name('admin.delete.product.gallery');

            Route::post('delete-product-specification', [AdminProductController::class, 'deleteProductSpecification'])->name('admin.delete.product.specification');

            Route::get('products-export', [AdminProductController::class, 'export'])->name('admin.products.export');

            Route::post('validate-products-import', [AdminProductController::class, 'validateImport'])->name('admin.products.validate.import');
            Route::post('products-import', [AdminProductController::class, 'import'])->name('admin.products.import');

            Route::get('attribute-combinations', [AdminProductController::class, 'attributeCombinations'])->name('admin.attribute.combinations');
            Route::get('attribute-custom-combinations', [AdminProductController::class, 'attributeCustomCombinations'])->name('admin.attribute.custom.combinations');

            // TEMPORARY one-time utility — remove after running once.
            Route::get('sync-product-image-names', [AdminProductController::class, 'syncImageNamesWithAlt'])->name('admin.products.sync.image.names');

        });

        
        Route::group(['middleware' => 'permissions:attributes'], function () {
            Route::get('attributes', [AdminAttributeController::class, 'list'])->name('admin.attributes');
            Route::get('attribute', [AdminAttributeController::class, 'add'])->name('admin.attribute');
            Route::get('attribute/{id}', [AdminAttributeController::class, 'edit'])->name('admin.attribute.edit');
            Route::post('attribute-post-data', [AdminAttributeController::class, 'postData'])->name('admin.attribute.post');
            Route::get('attribute-delete/{id}', [AdminAttributeController::class, 'delete'])->name('admin.attribute.delete');

            Route::post('delete-attribute-option', [AdminAttributeController::class, 'deleteAttributeOption'])->name('admin.delete.attribute.option');
        });

        Route::group(['middleware' => 'permissions:colors'], function () {
            Route::get('colors', [AdminColorController::class, 'list'])->name('admin.colors');
            Route::get('color', [AdminColorController::class, 'add'])->name('admin.color');
            Route::get('color/{id}', [AdminColorController::class, 'edit'])->name('admin.color.edit');
            Route::post('color-post-data', [AdminColorController::class, 'postData'])->name('admin.color.post');
            Route::get('color-delete/{id}', [AdminColorController::class, 'delete'])->name('admin.color.delete');
        });
        
        Route::group(['middleware' => 'permissions:taxes'], function () {
            Route::get('taxes', [AdminTaxController::class, 'list'])->name('admin.taxes');
            Route::get('tax', [AdminTaxController::class, 'add'])->name('admin.tax');
            Route::get('tax/{id}', [AdminTaxController::class, 'edit'])->name('admin.tax.edit');
            Route::post('tax-post-data', [AdminTaxController::class, 'postData'])->name('admin.tax.post');
            Route::get('tax-delete/{id}', [AdminTaxController::class, 'delete'])->name('admin.tax.delete');
        });

        Route::group(['middleware' => 'permissions:coupons'], function () {
            Route::get('coupons', [AdminCouponController::class, 'list'])->name('admin.coupons');
            Route::get('coupon', [AdminCouponController::class, 'add'])->name('admin.coupon');
            Route::get('coupon/{id}', [AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
            Route::post('coupon-post-data', [AdminCouponController::class, 'postData'])->name('admin.coupon.post');
            Route::get('coupon-delete/{id}', [AdminCouponController::class, 'delete'])->name('admin.coupon.delete');
        });

        Route::group(['middleware' => 'permissions:banners'], function () {
            Route::get('banners', [AdminBannerController::class, 'list'])->name('admin.banners');
            Route::get('banner', [AdminBannerController::class, 'add'])->name('admin.banner');
            Route::get('banner/{id}', [AdminBannerController::class, 'edit'])->name('admin.banner.edit');
            Route::post('banner-post-data', [AdminBannerController::class, 'postData'])->name('admin.banner.post');
            Route::get('banner-delete/{id}', [AdminBannerController::class, 'delete'])->name('admin.banner.delete');
        });
        
        Route::group(['middleware' => 'permissions:blog'], function () {
            Route::get('blog-categories', [AdminBlogCategoryController::class, 'list'])->name('admin.blog.categories');
            Route::get('blog-category', [AdminBlogCategoryController::class, 'add'])->name('admin.blog.category');
            Route::get('blog-category/{id}', [AdminBlogCategoryController::class, 'edit'])->name('admin.blog.category.edit');
            Route::post('blog-category-post-data', [AdminBlogCategoryController::class, 'postData'])->name('admin.blog.category.post');
            Route::get('blog-category-delete-data/{id}', [AdminBlogCategoryController::class, 'delete'])->name('admin.blog.category.delete');
            

            Route::get('blogs', [AdminBlogController::class, 'list'])->name('admin.blogs');
            Route::get('blog', [AdminBlogController::class, 'add'])->name('admin.blog');
            Route::get('blog/{id}', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
            Route::post('blog-post-data', [AdminBlogController::class, 'postData'])->name('admin.blog.post');
            Route::get('blog-delete/{id}', [AdminBlogController::class, 'delete'])->name('admin.blog.delete');
             Route::get('delete-blog-gallery/{product_id}/{id}', [AdminBlogController::class, 'deleteBlogGallery'])->name('admin.delete.blog.gallery');
        });

        Route::group(['middleware' => 'permissions:faq'], function () {
            Route::get('faqs', [AdminFaqController::class, 'list'])->name('admin.faqs');
            Route::get('faq', [AdminFaqController::class, 'add'])->name('admin.faq');
            Route::get('faq/{id}', [AdminFaqController::class, 'edit'])->name('admin.faq.edit');
            Route::post('faq-post-data', [AdminFaqController::class, 'postData'])->name('admin.faq.post');
            Route::get('faq-delete/{id}', [AdminFaqController::class, 'delete'])->name('admin.faq.delete');
        });
        
        Route::group(['middleware' => 'permissions:users'], function () {
            Route::get('users', [AdminUserController::class, 'list'])->name('admin.users');
            // Route::get('user', [AdminUserController::class, 'add'])->name('admin.user');
            // Route::get('user/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
            // Route::post('user-post-data', [AdminUserController::class, 'postData'])->name('admin.user.post');

            Route::get('filter-users', [AdminUserController::class, 'filter'])->name('admin.users.filter');

            Route::get('users-export', [AdminUserController::class, 'export'])->name('admin.users.export');
        });
        
        
        Route::group(['middleware' => 'permissions:pages'], function () {
            Route::get('pages', [AdminPageController::class, 'list'])->name('admin.pages');
            Route::get('page', [AdminPageController::class, 'add'])->name('admin.page');
            Route::get('page/{id}', [AdminPageController::class, 'edit'])->name('admin.page.edit');
            Route::post('page-post-data', [AdminPageController::class, 'postData'])->name('admin.page.post');
            Route::get('page-delete/{id}', [AdminPageController::class, 'delete'])->name('admin.page.delete');
        });

        Route::group(['middleware' => 'permissions:videos'], function () {
            Route::get('videos', [AdminVideoController::class, 'list'])->name('admin.videos');
            Route::get('video', [AdminVideoController::class, 'add'])->name('admin.video');
            Route::get('video/{id}', [AdminVideoController::class, 'edit'])->name('admin.video.edit');
            Route::post('video-post-data', [AdminVideoController::class, 'postData'])->name('admin.video.post');
            Route::get('video-delete/{id}', [AdminVideoController::class, 'delete'])->name('admin.video.delete');
        });
        
        Route::group(['middleware' => 'permissions:testimonials'], function () {
            Route::get('testimonials', [AdminTestimonialController::class, 'list'])->name('admin.testimonials');
            Route::get('testimonial', [AdminTestimonialController::class, 'add'])->name('admin.testimonial');
            Route::get('testimonial/{id}', [AdminTestimonialController::class, 'edit'])->name('admin.testimonial.edit');
            Route::post('testimonial-post-data', [AdminTestimonialController::class, 'postData'])->name('admin.testimonial.post');
            Route::get('testimonial-delete/{id}', [AdminTestimonialController::class, 'delete'])->name('admin.testimonial.delete');

            Route::get('filter-testimonials', [AdminTestimonialController::class, 'filter'])->name('admin.testimonial.filter');
        });
        
        Route::group(['middleware' => 'permissions:gallery'], function () {
            Route::get('gallery', [AdminGalleryController::class, 'list'])->name('admin.gallery');
            Route::get('gallery-single', [AdminGalleryController::class, 'add'])->name('admin.gallery.single');
            Route::get('gallery-single/{id}', [AdminGalleryController::class, 'edit'])->name('admin.gallery.single.edit');
            Route::post('gallery-single-post-data', [AdminGalleryController::class, 'postData'])->name('admin.gallery.single.post');
            Route::get('gallery-single-delete/{id}', [AdminGalleryController::class, 'delete'])->name('admin.gallery.single.delete');
        });

        Route::group(['middleware' => 'permissions:contact_requests'], function () {
            Route::get('contacts', [AdminContactController::class, 'list'])->name('admin.contacts');
        });

        Route::group(['middleware' => 'permissions:payments'], function () {
            Route::get('payments', [AdminPaymentController::class, 'list'])->name('admin.payments');
        });
        
        Route::group(['middleware' => 'permissions:inventory'], function () {
            Route::match(['get','post'], 'inventory', [AdminInventoryController::class, 'inventory'])->name('admin.inventory');
            Route::match(['get','post'], 'inventory-add', [AdminInventoryController::class, 'inventoryAdd'])->name('admin.inventory.add');
            Route::match(['get','post'], 'inventory-add-stock', [AdminInventoryController::class, 'inventoryAddStock'])->name('admin.inventory.add.stock');
        });

        Route::group(['middleware' => 'permissions:subscriptions'], function () {
            Route::get('subscriptions', [AdminSubscriptionController::class, 'list'])->name('admin.subscriptions');
        });

        Route::group(['middleware' => 'permissions:orders'], function () {
            Route::get('orders', [AdminOrderController::class, 'list'])->name('admin.orders');
            Route::get('order/{id}', [AdminOrderController::class, 'view'])->name('admin.order.view');
            Route::get('order-invoice/{id}', [AdminOrderController::class, 'viewInvoice'])->name('admin.order.invoice');
            Route::get('order-invoice-download/{id}', [AdminOrderController::class, 'downloadInvoice'])->name('admin.order.invoice.download');

            Route::post('update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.order.update.status');

            Route::get('filter-orders', [AdminOrderController::class, 'filter'])->name('admin.order.filter');
        });

        Route::group(['middleware' => 'permissions:enquiries'], function () {
            Route::get('enquiries', [AdminEnquiryController::class, 'list'])->name('admin.enquiries');
            Route::get('enquiry/{id}', [AdminEnquiryController::class, 'view'])->name('admin.enquiry.view');

            Route::post('update-enquiry-status', [AdminEnquiryController::class, 'updateStatus'])->name('admin.enquiry.update.status');

            Route::get('filter-enquiries', [AdminEnquiryController::class, 'filter'])->name('admin.enquiry.filter');

        });

        Route::group(['middleware' => 'permissions:brands'], function () {
            Route::get('brands', [AdminBrandController::class, 'list'])->name('admin.brands');
            Route::get('brand', [AdminBrandController::class, 'add'])->name('admin.brand');
            Route::get('brand/{id}', [AdminBrandController::class, 'edit'])->name('admin.brand.edit');
            Route::post('brand-post-data', [AdminBrandController::class, 'postData'])->name('admin.brand.post');
            Route::get('brand-delete/{id}', [AdminBrandController::class, 'delete'])->name('admin.brand.delete');
        });

        Route::group(['middleware' => 'permissions:reviews'], function () {
            Route::get('ratings', [AdminRatingController::class, 'list'])->name('admin.ratings');
            Route::get('rating', [AdminRatingController::class, 'add'])->name('admin.rating');
            Route::get('rating/{id}', [AdminRatingController::class, 'edit'])->name('admin.rating.edit');
            Route::post('rating-post-data', [AdminRatingController::class, 'postData'])->name('admin.rating.post');
            Route::get('rating-delete/{id}', [AdminRatingController::class, 'delete'])->name('admin.rating.delete');
        });


        Route::group(['middleware' => 'permissions:product_services'], function () {
            Route::get('services', [AdminProductServiceController::class, 'list'])->name('admin.product.services');
            Route::get('service', [AdminProductServiceController::class, 'add'])->name('admin.product.service');
            Route::get('service/{id}', [AdminProductServiceController::class, 'edit'])->name('admin.product.service.edit');
            Route::post('service-post-data', [AdminProductServiceController::class, 'postData'])->name('admin.product.service.post');
            Route::get('service-delete/{id}', [AdminProductServiceController::class, 'delete'])->name('admin.product.service.delete');
        });


        // only crud is made, no integration yet
        Route::get('addons', [AdminProductAddonController::class, 'list'])->name('admin.product.addons');
        Route::get('addon', [AdminProductAddonController::class, 'add'])->name('admin.product.addon');
        Route::get('addon/{id}', [AdminProductAddonController::class, 'edit'])->name('admin.product.addon.edit');
        Route::post('addon-post-data', [AdminProductAddonController::class, 'postData'])->name('admin.product.addon.post');
        Route::get('addon-delete/{id}', [AdminProductAddonController::class, 'delete'])->name('admin.product.addon.delete');
        // only crud is made, no integration yet



        Route::match(['get','post'], 'config', [AdminConfigController::class, 'config'])->name('admin.config');

        Route::group( [ 'prefix' => 'settings' ], function(){
            Route::get('seo-list', [AdminSettingSeoController::class, 'list'])->name('admin.settings.seo.list');
            Route::get('seo', [AdminSettingSeoController::class, 'add'])->name('admin.settings.seo');
            Route::get('seo/{id}', [AdminSettingSeoController::class, 'edit'])->name('admin.settings.seo.edit');
            Route::post('seo-post-data', [AdminSettingSeoController::class, 'postData'])->name('admin.settings.seo.post');
            Route::get('seo-delete/{id}', [AdminSettingSeoController::class, 'delete'])->name('admin.settings.seo.delete');

            Route::match(['get','post'], 'social', [AdminSettingSocialController::class, 'social'])->name('admin.settings.social');
            Route::match(['get','post'], 'marketing-facebook', [AdminSettingMarketingController::class, 'facebook'])->name('admin.settings.marketing.facebook');
            Route::match(['get','post'], 'payments', [AdminSettingPaymentController::class, 'payments'])->name('admin.settings.payments');
            Route::match(['get','post'], 'accounting', [AdminSettingAccountingController::class, 'accounting'])->name('admin.settings.accounting');


            
            
        });


        Route::get('sales', [AdminSalesController::class, 'sales'])->name('admin.sales');
        // Route::get('addon', [AdminProductAddonController::class, 'add'])->name('admin.product.addon');
        // Route::get('addon/{id}', [AdminProductAddonController::class, 'edit'])->name('admin.product.addon.edit');
        // Route::post('addon-post-data', [AdminProductAddonController::class, 'postData'])->name('admin.product.addon.post');
        // Route::get('addon-delete/{id}', [AdminProductAddonController::class, 'delete'])->name('admin.product.addon.delete');


        
        
        Route::match(['get','post'], 'settings', [AdminSettingController::class, 'settings'])->name('admin.settings');

        Route::group( [ 'prefix' => 'settings' ], function(){
            Route::get('seo-list', [AdminSettingSeoController::class, 'list'])->name('admin.settings.seo.list');
            Route::get('seo', [AdminSettingSeoController::class, 'add'])->name('admin.settings.seo');
            Route::get('seo/{id}', [AdminSettingSeoController::class, 'edit'])->name('admin.settings.seo.edit');
            Route::post('seo-post-data', [AdminSettingSeoController::class, 'postData'])->name('admin.settings.seo.post');
            Route::get('seo-delete/{id}', [AdminSettingSeoController::class, 'delete'])->name('admin.settings.seo.delete');

            Route::match(['get','post'], 'social', [AdminSettingSocialController::class, 'social'])->name('admin.settings.social');
            Route::match(['get','post'], 'marketing-facebook', [AdminSettingMarketingController::class, 'facebook'])->name('admin.settings.marketing.facebook');
            Route::match(['get','post'], 'payments', [AdminSettingPaymentController::class, 'payments'])->name('admin.settings.payments');
            Route::match(['get','post'], 'accounting', [AdminSettingAccountingController::class, 'accounting'])->name('admin.settings.accounting');


            
            
        });
        
        Route::post('ckeditor-upload', [AdminCkeditorController::class, 'upload'])->name('ckeditor.upload');


        Route::get('sales-data', [AdminChartController::class, 'sales'])->name('admin.data.sales');
        Route::get('sales-amount-data', [AdminChartController::class, 'salesAmount'])->name('admin.data.sales.amount');
        Route::get('highest-sale-product-data', [AdminChartController::class, 'highestSaleProduct'])->name('admin.highest.sale.product');
        Route::get('highest-sale-amount-product-data', [AdminChartController::class, 'highestSaleAmountProduct'])->name('admin.highest.income.product');



        Route::group(['middleware' => 'permissions:ADMIN'], function () {
            Route::get('admin-sub-users', [AdminAdminUserController::class, 'list'])->name('admin.sub.users');
            Route::get('admin-sub-user', [AdminAdminUserController::class, 'add'])->name('admin.sub.user');
            Route::get('admin-sub-user/{id}', [AdminAdminUserController::class, 'edit'])->name('admin.sub.user.edit');
            Route::post('admin-sub-user-post-data', [AdminAdminUserController::class, 'postData'])->name('admin.sub.user.post');
            Route::get('admin-sub-user-delete/{id}', [AdminAdminUserController::class, 'delete'])->name('admin.sub.user.delete');

            Route::get('filter-admin-sub-user', [AdminAdminUserController::class, 'filter'])->name('admin.sub.user.filter');


            Route::get('permissions', [AdminPermissionController::class, 'list'])->name('admin.permissions');
            Route::get('permission', [AdminPermissionController::class, 'add'])->name('admin.permission');
            Route::get('permission/{id}', [AdminPermissionController::class, 'edit'])->name('admin.permission.edit');
            Route::post('permission-post-data', [AdminPermissionController::class, 'postData'])->name('admin.permission.post');
            Route::get('permission-role/{id}', [AdminPermissionController::class, 'delete'])->name('admin.permission.delete');
        });

        

    });



});

Route::get('/sitemap', [HomeController::class, 'sitemap'])->name('sitemap');

Route::get('/run-sitemap', function (Request $request) { 
    Artisan::call('sitemap:generate');
    return response()->json(['message' => 'Sitemap generated successfully!']);
})->name('sitemap.run');

Route::get('{category}/{type?}', [HomeController::class, 'category'])->name('category');





