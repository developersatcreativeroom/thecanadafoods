@extends('front.layouts.app')

@section('content')


@if(count($banners) > 0)
<!--hero section start-->
<section class="gshop-hero pt-80 bg-white position-relative z-1 overflow-hidden">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/chocolate.png') }}" alt="leaf" class="lazyload position-absolute chocolate z--1 rounded-circle">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/nachos.png') }}" alt="mango" class="lazyload position-absolute mango z--1" data-parallax='{"y": -120}'>
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/hero-circle-sm.png') }}" alt="circle" class="lazyload position-absolute hero-circle circle-sm z--1">
    <div class="container">
        <div class="gshop-hero-slider swiper">
            <div class="swiper-wrapper">

                @foreach($banners as $banner)


                    <div class="swiper-slide gshop-hero-single">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-xl-5 col-lg-8">
                                <div class="hero-left-content">
                                    <span class="gshop-subtitle fs-5 text-secondary mb-2 d-block">{{$banner->top_title}}</span>
                                    <h1 class="display-4 mb-3">{{$banner->title}} <mark class="p-0 bg-transparent text-secondary">{{$banner->sub_title}}</mark></h1>
                                    
                                    <p class="mb-7 fs-6">{{$banner->description}}</p>

                                    @if($banner->button_name && $banner->button_link)
                                        <div class="hero-btns d-flex align-items-center gap-3 gap-sm-5 flex-wrap">

                                            {{-- <a href="shop-grid.html" class="btn btn-secondary">Shop Now<span class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a> --}}
                                            <a href="{{$banner->button_link}}" class="btn btn-primary">{{$banner->button_name}}<span class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a>

                                        </div>

                                    @endif

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-7">
                                <div class="hero-right text-center position-relative z-1 mt-8 mt-xl-0">

                                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ asset('storage/banners/') }}/{{$banner->id}}/{{$banner->image}}" alt="fruits" class="lazyload img-fluid position-absolute end-0 top-50 hero-img">

                                    {{-- 
                                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/tree.png') }}" alt="tree" class="img-fluid position-absolute tree z-1">
                                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/orange-1.png') }}" alt="orange" class="position-absolute orange-1 z-1">
                                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/orange-2.png') }}" alt="orange" class="position-absolute orange-2 z-1"> --}}

                                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/hero-circle-lg.png') }}" alt="circle shape" class="lazyload img-fluid hero-circle">
                                    

                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach
                

            </div>
        </div>
    </div>

    @php 
        $config = App\Helper::getWebsiteConfig('social');
        $configEmail = App\Helper::getWebsiteConfig('email');
    @endphp

    @if(count($config['social']) > 0 && 
        ($config['social']['facebook'] != "" && $config['social']['facebook'] != "#" ||
        $config['social']['instagram'] != "" && $config['social']['instagram'] != "#" ||
        $config['social']['twitter'] != "" && $config['social']['twitter'] != "#" ||
        $config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#" ||
        $config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
        )
            <div class="at-header-social d-none d-sm-flex align-items-center position-absolute">
                <span class="title fw-medium">Follow on</span>
                <ul class="social-list ms-3">

                    <li><a target="_blank" aria-label="Email support" href="mailto:{{$configEmail['email']}}"><i class="fas fa-envelope"></i></a></li>

                    @if($config['social']['facebook'] != "" && $config['social']['facebook'] != "#")
                        <li><a target="_blank" aria-label="Visit us on facebook" href="{{$config['social']['facebook']}}"><i class="fab fa-facebook-f"></i></a></li>
                    @endif

                    @if($config['social']['instagram'] != "" && $config['social']['instagram'] != "#")
                        <li><a target="_blank" aria-label="Visit us on instagram" href="{{$config['social']['instagram']}}"><i class="fab fa-instagram"></i></a></li>
                    @endif

                    @if($config['social']['twitter'] != "" && $config['social']['twitter'] != "#")
                        <li><a target="_blank" aria-label="Visit us on twitter" href="{{$config['social']['twitter']}}"><i class="fab fa-twitter"></i></a></li>
                    @endif

                    @if($config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#")
                        <li><a target="_blank" aria-label="Visit us on pinterest" href="{{$config['social']['pinterest']}}"><i class="fab fa-pinterest"></i></a></li>
                    @endif

                    @if($config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                        <li><a target="_blank" aria-label="Visit us on youtube" href="{{$config['social']['youtube']}}"><i class="fab fa-youtube"></i></a></li>
                    @endif

                </ul>
            </div>
            <div class="gshop-hero-slider-pagination theme-slider-control position-absolute top-50 translate-middle-y z-5"></div>

    @endif

</section> <!--hero section end-->

@endif



                                    
@if(count($categories) > 0)
<!--category section start-->
<section class="gshop-category-section bg-white pt-80 position-relative z-1 overflow-hidden">
    {{-- <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/bg-shape.png') }}" alt="bg shape" class="position-absolute bottom-0 start-0 w-100 z--1"> --}}
    <div class="container">
        <div class="gshop-category-box bg-shade border-secondary rounded-3 ">
            <div class="text-center section-title">
                <h4 class="d-inline-block px-2 bg-white mb-4">Our Top Categories</h4>
            </div>
            <div class="row justify-content-center g-4">

                @foreach($categories as $category)
                @if ($category->is_top)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="gshop-animated-iconbox py-5 px-4 text-center border rounded-3 position-relative overflow-hidden bg-white">
                            <a href="{{route('category',[$category['slug']])}}"><div class="animated-icon d-inline-flex align-items-center justify-content-center rounded-circle position-relative">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ asset('storage/categories/') }}/{{$category->id}}/{{$category->image}}" alt="{{$category->image_alt ? $category->image_alt : $category->name ;}}" class="lazyload img-fluid">
                            </div></a>
                            <a href="{{route('category',[$category['slug']])}}" class="text-dark fs-sm fw-bold d-block mt-3">{{$category->name}}</a>
                            {{-- <span class="total-count position-relative ps-3 fs-sm fw-medium doted-primary">25 Items</span> --}}
                            <a href="{{route('category',[$category['slug']])}}" class="explore-btn position-absolute" aria-label="{{$category->name}}"><i class="fa-solid fa-arrow-up"></i></a>
                        </div>
                    </div>
                     @endif

                @endforeach

                
                {{-- <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="gshop-animated-iconbox py-5 px-4 text-center border rounded-3 position-relative overflow-hidden color-2">
                        <div class="animated-icon d-inline-flex align-items-center justify-content-center rounded-circle position-relative">
                            <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/category/fresh-fruits.png') }}" alt="flower" class="img-fluid">
                        </div>
                        <a href="shop-grid.html" class="text-dark fs-sm fw-bold d-block mt-3">Fresh Fruits</a>
                        <span class="total-count position-relative ps-3 fs-sm fw-medium doted-primary">25 Items</span>
                        <a href="shop-grid.html" class="explore-btn position-absolute"><i class="fa-solid fa-arrow-up"></i></a>
                    </div>
                </div> --}}
                
            </div>
        </div>
    </div>
</section> <!--category section end-->
@endif



@if(count($categories) > 0)
<!--trending products start-->
<section class="pt-8 pb-100 bg-white position-relative overflow-hidden z-1 trending-products-area">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/garlic.png') }}" alt="garlic" class="lazyload position-absolute garlic z--1" data-parallax='{"y": 100}'>
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/carrot.png') }}" alt="carrot" class="lazyload position-absolute carrot z--1" data-parallax='{"y": -100}'>
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/mashrom.png') }}" alt="mashrom" class="lazyload position-absolute mashrom z--1" data-parallax='{"x": 100}'>
    <div class="container mt-10">
        <div class="row align-items-center">
            <div class="col-xl-5">
                <div class="section-title text-center text-xl-start">
                    <h3 class="mb-0">Top Trending Products</h3>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="filter-btns gshop-filter-btn-group text-center text-xl-end mt-4 mt-xl-0">
                    <button class="tab-select active" data-category="all">All Products</button>
                    {{-- <button class="tab-select">Sea Food</button> --}}

                    @foreach($categories as $key => $category)
                    @if ($category->is_trending)
                        <button class="tab-select" data-category="{{$category->slug}}">{{$category->name}}</button>
 @endif
                    @endforeach

                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4 mt-5 filter_group" id="tab-products">
            
            
        </div>
    </div>
</section> <!--trending products end-->
@endif
{{-- 
<!--banner section start-->
<section class="banner-section position-relative z-1 overflow-hidden bg-white pt-10 pb-10">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/bg-shape-3.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 z--1 w-100">
    <div class="container">
        <div class="row align-items-center g-4 justify-content-center">
            <div class="col-xl-4 col-md-6">
                <div class="banner-box background-banner rounded-2 overflow-hidden" data-background="{{ URL::asset('frontend/img/banner/banner-1.jpg') }}">
                    <span class="gshop-subtitle fs-xxs mb-1 text-dark d-inline-block">100% Pur Products</span>
                    <h6 class="mb-0">Fresh Fruits</h6>
                    <h4 class="mb-6">Healthy Juice</h4>
                    <a href="product-details.html" class="explore-btn fw-bold text-dark">Shop Now<span class="ms-1"><i class="fas fa-arrow-right"></i></span></a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="banner-box rounded-2 overflow-hidden position-relative banner-color-green z-1">
                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/capsicum.png') }}" alt="capsicum" class="banner-img">
                    <span class="gshop-subtitle fs-xxs mb-1 text-dark d-inline-block">Weekly Best Seller</span>
                    <h6 class="mb-0">Fresh Fruits</h6>
                    <h4 class="mb-6">Healthy Juice</h4>
                    <a href="product-details.html" class="explore-btn fw-bold text-dark">Shop Now<span class="ms-1"><i class="fas fa-arrow-right"></i></span></a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="banner-box rounded-2 overflow-hidden position-relative z-1 banner-color-secondary">
                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/lychee.png') }}" alt="lychee" class="banner-img">
                    <span class="badge bg-danger gshop-subtitle mb-1">Top Offer</span>
                    <h6 class="mb-0">Fresh Fruits</h6>
                    <h4 class="mb-6">Healthy Juice</h4>
                    <a href="product-details.html" class="explore-btn fw-bold text-dark">Shop Now<span class="ms-1"><i class="fas fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>
    </div>
</section> <!--banner section end-->

<!--banner section start-->
<section class="banner-section position-relative z-1 overflow-hidden">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/bg-shape-4.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 w-100 z--1">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="banner-box background-banner rounded-2 banner-lg" data-background="{{ URL::asset('frontend/img/banner/banner-2.jpg') }}">
                    <span class="badge bg-danger mb-2">Top Offer</span>
                    <h3 class="mb-6 text-white gshop-title">Fresh & Natural Healthy<br class="d-none d-sm-block"> Food <mark class="position-relative text-secondary position-relative bg-transparent">Special Offer<img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/border-line.png') }}" class="position-absolute start-0 border-line w-100" alt="border line"></mark></h3>
                    <a href="product-details.html" class="btn btn-secondary btn-md">Shop Now<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="banner-img rounded-3 overflow-hidden">
                    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/banner/banner-3.png') }}" alt="banner" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section> <!--banner section end--> --}}

<!--feedback section start-->

<section class="pt-80 pb-80 position-relative overflow-hidden z-1 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <a href="{{route('category', 'canadian-smarties')}}"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/SmartiesCat.jpg') }}" alt="Canadian Smarties" class="img-fluid lazyload"></a>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="section-title text-center mt-10">
                    <h2 class="mb-10 text-center">Canadian Smarties - Imported Chocolate Candy</h2>
                    <p class="mb-5">Canadian Smarties are colourful sugar-coated milk chocolates loved by many. Made by Nestle Smarties, each piece has a crunchy candy shell and smooth chocolate inside. These best Canadian candies that bring back nostalgia and deliver pure chocolate joy. Perfect for sharing, gifting, or enjoying all to yourself anytime.</p>
                    <a href="{{route('category', 'canadian-smarties')}}" class="btn btn-primary btn-md">Shop Now<span class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a>
                </div>
                   
            </div>
        </div>
    </div>
</section>

<section class="pt-80 pb-80 position-relative overflow-hidden z-1 d-none">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center mt-10">
                    <h2 class="mb-10 text-center">Coffee Crisp – Iconic Canadian Chocolate Bar</h2>
                    <p class="mb-5">Enjoy a true taste of Canada with Coffee Crisp – a light, crispy wafer bar layered with coffee-flavored cream and coated in smooth milk chocolate. Perfectly balanced and not too sweet, it’s a classic treat beloved by Canadians for generations.</p>
                    <a href="{{route('category', 'coffee-crisp')}}" class="btn btn-primary btn-md">Shop Now<span class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <a href="{{route('category', 'coffee-crisp')}}"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/SmartiesCat.jpg') }}" alt="Canadian Smarties" class="img-fluid lazyload"></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ptb-120 bg-shade position-relative overflow-hidden z-1 feedback-section">
    <!--<img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/bg-shape-5.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 z--1 w-100">-->
    {{-- <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/map-bg.png') }}" alt="map" class="position-absolute start-50 top-50 translate-middle z--1">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/fd-1.png') }}" alt="shape" class="position-absolute z--1 fd-1">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/fd-2.png') }}" alt="shape" class="position-absolute z--1 fd-2">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/fd-3.png') }}" alt="shape" class="position-absolute z--1 fd-3">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/fd-4.png') }}" alt="shape" class="position-absolute z--1 fd-4">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/fd-5.png') }}" alt="shape" class="position-absolute z--1 fd-5"> --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <h2 class="mb-6">What Our Clients Say</h2>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="gshop-feedback-slider-wrapper">
                    <div class="swiper gshop-feedback-thumb-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide control-thumb">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/authors/client-1.png') }}" alt="clients" class="lazyload img-fluid rounded-circle">
                            </div>
                            <div class="swiper-slide control-thumb">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/authors/client-2.png') }}" alt="clients" class="lazyload img-fluid rounded-circle">
                            </div>
                            <div class="swiper-slide control-thumb">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/authors/client-3.png') }}" alt="clients" class="lazyload img-fluid rounded-circle">
                            </div>
                            <div class="swiper-slide control-thumb">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/authors/client-4.png') }}" alt="clients" class="lazyload img-fluid rounded-circle">
                            </div>
                            <div class="swiper-slide control-thumb">
                                <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/authors/client-5.png') }}" alt="clients" class="lazyload img-fluid rounded-circle">
                            </div>
                        </div>
                    </div>
                    <div class="swiper gshop-feedback-slider mt-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide feedback-single text-center">
                                <p class="mb-5">“I’ve always wanted to try authentic Canadian snacks, and this company delivers the best! The butter tarts and maple cookies were absolutely delicious. Everything was fresh and arrived quickly. Highly recommend!” </p>
                                <span class="clients_name text-dark fw-bold d-block mb-1">Jessica M., New York, NY</span>
                                <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                            <div class="swiper-slide feedback-single text-center">
                                <p class="mb-5">“Finally, I can get my favorite Canadian chips and chocolates in the U.S. without crazy shipping fees! The packaging was perfect, and the taste was just like I remember from my trips to Canada. Will order again!” </p>
                                <span class="clients_name text-dark fw-bold d-block mb-1">Mike T., Austin, TX</span>
                                <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                            <div class="swiper-slide feedback-single text-center">
                                <p class="mb-5">“This is the best place to get authentic Canadian snacks in the States. The selection is amazing—Ketchup chips, Coffee Crisp, and real maple candies! Everything arrived fresh and well-packed. Love it!” </p>
                                <span class="clients_name text-dark fw-bold d-block mb-1">Sarah L., Chicago, IL</span>
                                <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                            <div class="swiper-slide feedback-single text-center">
                                <p class="mb-5">“As a Canadian living in the U.S., I missed my favorite snacks so much. This service is a game-changer! The selection is spot-on, and I can finally enjoy my childhood favorites again. Great customer service too!” </p>
                                <span class="clients_name text-dark fw-bold d-block mb-1">Daniel R., Los Angeles, CA</span>
                                <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                            <div class="swiper-slide feedback-single text-center">
                                <p class="mb-5">“Ordered a Canadian snack box as a gift for my husband, and he loved it! The assortment of cookies, chocolates, and drinks was perfect. Such a cool way to experience new flavors!” </p>
                                <span class="clients_name text-dark fw-bold d-block mb-1">Emily C., Miami, FL</span>
                                <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<!--feedback section end-->

<section class="pt-80 pb-80 position-relative overflow-hidden z-1 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="section-title text-center">
                    <h2 class="mb-10 text-center">Bringing Authentic Canadian Food to the USA – The Canada Foods</h2>
                    <p class="mb-5">The Canada Foods, as one of the top retailers for authentic Canadian foods in the USA, has been specialising in delivering flavours of the north without having to compromise on quality. If you are craving the maple syrup, classic butter tarts, or any other Canadian staple, then you will be ready to enjoy it right in the USA, with some of the best Canadian cuisines that have been crossing the borders.</p>

                    <p class="mb-5">Our mission is simple and effortless. We have been providing high-quality Canadian products with fast and reliable shipping throughout the United States. We have partnered with a trusted Canadian brand in the country to ensure that you get fresh and genuine foods at your fingertips, right from the snacks to the sauces and the frozen specialties. You will find the range of products from The Canada Foods that will offer you a wide selection that is tailored to every palate.</p>

                    <p class="mb-5">Shipping Canadian food to the USA has never been effortless. No matter who you are - a Canadian that is missing out on the taste of the home or an American food lover that is looking forward to exploring something new from Canada, then you will be getting it at our online store because it is completely designed to make your shopping experience hassle-free and trustworthy over the decades of experience.</p>

                    <p class="mb-5"> We have a good understanding of the Canada foods that are quite popular among the masses, and we understand the importance of authenticity. So we will be ensuring that every order reflects the real taste of Canada. Be ready to explore our collections today and enjoy the flavoured ingredients from Canada with just a few clicks. Be ready to taste the tradition. Feel the comfort and discover why The Canada Foods is America's favorite source for Canadian flavours.</p> 
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 
<!--products listing start-->
<section class="pt-80 pb-120">
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-xxl-4 col-lg-6">
                <div class="product-listing-box bg-white">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                        <h4 class="mb-0">New Products</h4>
                        <a href="shop-grid.html" class="explore-btn text-secondary fw-bold">View More<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-1.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-2.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-3.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-6">
                <div class="product-listing-box bg-white">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                        <h4 class="mb-0">Organic Bestseller</h4>
                        <a href="#" class="explore-btn text-secondary fw-bold">View More<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-4.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-5.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                    <div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 mt-3 border card-md gap-4">
                        <div class="thumbnail position-relative rounded-2">
                            <a href="product-details.html"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/products/p-sm-6.png') }}" alt="product" class="img-fluid"></a>
                            <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
                                <a href="#" class="rounded-btn fs-xs"><i class="fa-regular fa-heart"></i></a>
                                <a href="#quickview_modal" data-bs-toggle="modal" class="rounded-btn fs-xs"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="rounded-btn fs-xs">
                                    <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.86193 0.189422C9.62476 0.422214 9.62476 0.799637 9.86193 1.03243L10.6472 1.80311H7.25462C5.91292 1.80311 4.82521 2.87064 4.82521 4.18749V4.78359C4.82521 5.11281 5.09713 5.37968 5.43256 5.37968C5.768 5.37968 6.03991 5.11281 6.03991 4.78359V4.18749C6.03991 3.52906 6.58374 2.9953 7.25462 2.9953H10.6472L9.86193 3.76599C9.62476 3.99877 9.62476 4.37622 9.86193 4.60899C10.0991 4.84177 10.4837 4.84177 10.7208 4.60899L12.5429 2.82071C12.7801 2.58792 12.7801 2.2105 12.5429 1.9777L10.7208 0.189422C10.4837 -0.0433652 10.0991 -0.0433652 9.86193 0.189422ZM7.86197 4.18749C7.52653 4.18749 7.25462 4.45436 7.25462 4.78359V5.37968C7.25462 6.03813 6.7108 6.57187 6.03991 6.57187H2.64736L3.43261 5.80118C3.66979 5.5684 3.66979 5.19096 3.43261 4.95818C3.19542 4.72541 2.81087 4.72541 2.57368 4.95818L0.751618 6.74647C0.514435 6.97924 0.514435 7.35669 0.751618 7.58946L2.57368 9.37775C2.81087 9.61052 3.19542 9.61052 3.43261 9.37775C3.66979 9.14497 3.66979 8.76752 3.43261 8.53475L2.64736 7.76406H6.03991C7.38162 7.76406 8.46933 6.69651 8.46933 5.37968V4.78359C8.46933 4.45436 8.19742 4.18749 7.86197 4.18749Z" fill="#5D6374"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-content mt-4 mt-sm-0">
                            <div class="d-flex align-items-center flex-nowrap star-rating">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <a href="product-details.html" class="fw-bold text-heading title d-block fs-sm">European Lemon Zest</a>
                            <div class="pricing mt-2">
                                <span class="fw-bold h4 deleted me-1">$240.00</span>
                                <span class="fw-bold h4 text-danger">$140.00</span>
                            </div>
                            <a href="product-details.html" class="fs-xs fw-bold mt-10 d-inline-block explore-btn">Shop Now<span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10">
                <div class="vertical-banner text-center bg-white rounded-2" data-background="assets/img/banner/banner-4.jpg') }}">
                    <h5 class="mb-1">Fresh & Organic Spice</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <span class="hot-badge bg-danger fw-bold fs-xs position-relative text-white">HOT</span>
                        <span class="offer-title text-danger fw-bold">30% Off</span>
                    </div>
                    <a href="product-details.html" class="explore-btn text-primary fw-bold">Shop Now<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                </div>
                <div class="counter-box bg-white rounded-2 mt-4">
                    <div class="horizontal-counter d-flex align-items-center gap-3">
                        <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-2 bg-glimpse-pink flex-shrink-0">
                          <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/icons/letter-box.svg') }}" alt="icon" class="img-fluid">
                      </span>
                        <div class="numbers">
                            <h3 class="mb-1"><span class="counter">456</span>k+</h3>
                            <h6 class="mb-0 text-gray fs-sm">Total Products</h6>
                        </div>
                    </div>
                    <span class="gradient-spacer-2 d-block my-4"></span>
                    <div class="horizontal-counter d-flex align-items-center gap-3">
                        <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-2 bg-azure-mist flex-shrink-0">
                          <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/icons/thumbs-up.svg') }}" alt="icon" class="img-fluid">
                      </span>
                        <div class="numbers">
                            <h3 class="mb-1"><span class="counter">16</span>M+</h3>
                            <h6 class="mb-0 text-gray fs-sm">Customer Satisfaction</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--products listing end--> --}}

@if(count($blogs) > 0)
<!--blog section start-->
<section class="blog-section pb-120 position-relative overflow-hidden z-1 pt-80 bg-white">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/dal.png') }}" alt="shape" class="lazyload position-absolute dal-shape z--1">
    <img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle" class="lazyload position-absolute frame-circle z--1 d-none d-md-block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-md-8">
                <div class="section-title text-center">
                    <h2 class="mb-3">Blog Posts</h2>
                    <p class="mb-0">Stay Updated with Our Latest Insights</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center mt-3">

            @foreach($blogs as $blog)
            <div class="col-xl-4 col-md-6">
                <article class="blog-card rounded-2 overflow-hidden bg-white">
                    <div class="thumbnail overflow-hidden">
                        <a href="{{route('blog', $blog->slug)}}"><img src="{{ URL::asset('frontend/img/initial-image.png') }}" data-src="{{ asset('storage/blogs/') }}/{{$blog->id}}/{{$blog->image}}" alt="blog thumb" class="lazyload img-fluid"></a>
                    </div>
                    <div class="blog-card-content">
                        <div class="blog-meta d-flex align-items-center gap-3 mb-1">
                            <span class="fs-xs fw-medium"><i class="fa-solid fa-tags me-1"></i>{{$blog->category_name}}</span>
                            <span class="fs-xs fw-medium"><i class="fa-regular fa-clock me-1"></i>{{$blog->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                        </div>
                        <a href="{{route('blog', $blog->slug)}}">
                            <h4 class="mb-3">{{$blog->title}}</h4>
                        </a>
                        <p class="mb-0 mb-5">{{$blog->short_description}}</p>
                        <a href="{{route('blog', $blog->slug)}}" class="btn btn-primary btn-md">Read More<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" >
            <a href="{{route('blogs')}}" class="btn btn-primary btn-md">View All<span class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a>
        </div>


    </div>
</section> <!--blog section end-->
@endif


@endsection