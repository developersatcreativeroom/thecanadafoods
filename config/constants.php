<?php
return [
    'ADMIN_PAGE_RECORDS' => 20,
    'FRONT_PAGE_RECORDS' => 50,
    'RATING_PAGE_RECORDS' => 10,
    'POSTED_BY' => 'TheCanadaFoods.com Team',
    'META_STATUSES' => [
        3 =>  'Completed',
        2 =>  'Partial',
        1 =>  'Pending',
        0 =>  'Totaly Pending'
    ],
    'STATUSES' => [
        1 =>  'Active',
        0 =>  'In-active'
    ],
    'TEMPERATURES' => [
        1 =>  'Sensitive',
        0 =>  'In-sensitive'
    ],
    'FAQ_TYPES' => [
        'category' => 'Category',
        'blog' => 'Blog',
        'product' => 'Product'
    ],
    'ORDER_TYPE' => [
        'Distributor',
        'Commercial',
        'Personal'
    ],

    'ORDER_TYPE_SELECTED' => 'Personal',

    'ORDER_STATUSES' => [
        'Successful',
        'Shipped',
        'Delivered',
        'Pending',
        'Cancelled',
        'Payment Refunded',
        'Returned'
    ],

    'ENQUIRY_STATUSES' => [
        'Successful',
        'Shipped',
        'Delivered',
        'Pending',
        'Cancelled',
    ],

    'PAYMENT_METHODS' => [
        'instamojo' => 'Instamojo',
        'cash' => 'Cash',
        'paypal' => 'Paypal',
        'stripe_card' => 'Stripe Card',
        'razorpay' => 'Razorpay',
        'stripe_checkout' => 'Stripe Checkout',
        'stripe_express_checkout' => 'Stripe Express Checkout'
    ],

    'TESTIMONIAL_RATINGS' => [
        1,
        2,
        3,
        4,
        5
    ],
    
    'STAR_RATINGS' => [
        1,
        2,
        3,
        4,
        5
    ],
    'BUSINESS' => [
        'name' => 'The Canada Foods',
        'gst' => '',
        'timings_weekdays' => '9:00 am to 8:00 pm',
        'timings_weekend' => 'Closed!',
    ],

    'CONTACT' => [
        'country_code' => '1',
        'phone' => ['(437) 777-8932'],
        'whatsapp' => '#',
        'whatsapp_number' => '#',   // with prefix like +91
        'email' => 'support@thecanadafoods.com',
    ],

    // this array is for sending emails
    'EMAIL' => [
        'from' => 'sales@thecanadafoods.com',
        'contact' => 'sales@thecanadafoods.com',
        // 'send' => ['contactmytechregion@gmail.com', 'preetindersingh1996@gmail.com'],
        // 'send' => 'contactmytechregion@gmail.com',
        
        // 'send' => ['contactmytechregion@gmail.com', 'support@thecanadafoods.com'],
        'send' => 'support@thecanadafoods.com',
    ],
    // this array is for sending emails

    'ADDRESS' => [
        'apartment' => 'E314',
        'street' => '1460 Queensway',
        'locality' => '',
        'city' => 'Etobicoke',
        'state' => 'Ontario',
        'postcode' => 'M8Z 1S7',
        'country' => 'Canada',
        'map_link' => '',
        'return_address' => '',
    ],

    'SOCIAL' => [
        'facebook' => 'https://www.facebook.com/thecanadafoods',
        'instagram' => 'https://www.instagram.com/thecanadafoods',
        'twitter' => '#',
        'pinterest' => '#',
        'youtube' => '#',
    ],

    'CONFIG' => [
        'currency_sign' => '$',
        'currency_iso_code' => 'USD',
        'shipping_charges' => 100,
        'country' => 'CA',  // add iso code here, refer countries table
        'coupon' => true,
        'product_services' => false,
        'product_addon' => false,
        'local_pickup' => false,
        'seo_title' => 'Buy Canadian Food, Snacks & Candy Online in USA | TheCanadaFoods',
        'seo_description' => 'Shop authentic Canadian food shipped to the USA. Order Smarties, ketchup chips, Coffee Crisp & more. Fast delivery guaranteed.',
        // 'seo_title' => 'Canadian Food, Snacks, Candy & Smarties To USA',
        // 'seo_description' => 'Buy Canadian food, snacks, smarties & candy online. We ship your favorite Canadian food straight to your home in the USA!',
        'seo_keywords' => '',
        // 'light_logo' => asset('frontend/img/theme/logo.png'),
        // 'dark_logo' => asset('frontend/img/theme/logo.png'),
        'light_logo' => 'frontend/img/theme/logo.png',
        'dark_logo' => 'frontend/img/theme/logo.png',
        'favicon' => 'frontend/img/theme/favicon.ico', // to do
        'is_enquiry_website' => false,
        'reviews' => false,
        'is_email_verify' => false,
        'min_cart_amount' => 29
    ],

    'ACCOUNTING' => [
        'xero' => false,
    ],


    'SHIPPING_STATUS'=>[
        'standard' => 0,
        'express' => 1,

    ],

    
    'EXPRESS_SHIPPING' => [
        'enabled' => true,
        'label' => 'Express Shipping',
        'tiers' => [
            ['max_weight' => 1.9,  'price' => 55],
            ['max_weight' => 4.9,  'price' => 62],
            ['max_weight' => 9.9,  'price' => 69],
            ['max_weight' => 14.9, 'price' => 75],
            ['max_weight' => 19.9, 'price' => 89],
            ['max_weight' => 29.9, 'price' => 133],
            ['max_weight' => 39.9, 'price' => 177],
            ['max_weight' => 49.9, 'price' => 229],
            ['max_weight' => 99.9, 'price' => 347],
        ],
    ],

    'PAYMENTS' => [
        'cash_on_delivery' => false,
        'instamojo' => false,
        'paypal' => false,
        'stripe_card' => false,
        'razorpay' => false,
        'stripe_checkout' => false,
        'stripe_express_checkout' => true,
        
    ],

    'MONTHS' => [
        '01' => 'January',
        '02' => 'Feburary',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ],

    'SITEMAP_PAGES' => [
        'home' => 'Home',
        'about' => 'About Us',
        'products'=> 'Our Products',
        'blogs' => 'Blog',
        'faqs' => 'FAQs',
        'contact' => 'Contact Us',
        'shipping.policy' => 'Shipping Policy',
        'terms' => 'Terms & Conditions',
        'privacy' => 'Privacy Policy',
        'cookie.policy' => 'Cookie Policy',
        'refund.policy' => 'Refund Policy',
        'disclaimer' => 'Disclaimer',
        'cart' => 'Cart',
        'checkout' => 'Checkout',
        'wishlist' => 'Wishlist',
        'register' => 'Register',
        'login' => 'Login',
    ],

];
