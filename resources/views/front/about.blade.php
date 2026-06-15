@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Bringing authentic Canadian flavors to your doorstep since 2020.</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<!--about section start-->
<section class="pt-120 pb-120 ab-about-section position-relative z-1 overflow-hidden">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-4.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 w-100 z--1 bg-shape">
    <img src="{{ URL::asset('frontend/img/shapes/mango.png') }}" alt="mango" class="position-absolute mango z--1">
    <div class="container">
        <div class="row g-5 g-xl-4 align-items-center">
            <div class="col-xl-6">
                <div class="ab-left position-relative">
                    <img src="{{ URL::asset('frontend/img/about/ab-1.png') }}" alt="image" class="img-fluid rounded-2 shadow-lg">
                    {{-- <div class="text-end">
                        <div class="ab-quote p-4 text-start">
                            <h4 class="mb-0 fw-normal text-white">“Assertively target market Lorem ipsum is simply free consectetur notted elit sed do eiusmod” <span class="fs-md fw-medium position-relative">George Scholll</span></h4>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ab-about-right">
                    <div class="subtitle d-flex align-items-center gap-3 flex-wrap">
                        <span class="gshop-subtitle">100% Organic Food Provide</span>
                        <span>
                          <svg width="78" height="16" viewBox="0 0 78 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <line x1="0.0138875" y1="7.0001" x2="72.0139" y2="8.0001" stroke="#FF7C08" stroke-width="2"/>
                              <path d="M78 8L66 14.9282L66 1.0718L78 8Z" fill="#FF7C08"/>
                          </svg>    
                      </span>
                    </div>
                    <h2 class="mb-4">Taste Canada, Anywhere!</h2>

                    <p class="mb-8">Welcome to our cozy corner of the internet, where passion meets flavor! As a proud Toronto-based, family-owned business, we’re on a heartfelt mission to bring the cherished tastes of Canada right to your doorstep. Whether you’re a snowbird savoring memories of home or a long-term resident craving that familiar flavor, we're here for you!
                    </p>
                    <p class="mb-8">Dive into our lovingly curated selection of iconic Canadian treats, featuring nationwide favorites alongside unique regional gems that might be hard to find elsewhere. Have a specific product in mind? Don't hesitate to reach out—we'll hunt it down for you!</p>

                    <p class="mb-8">For all the dreamers who’ve strolled the scenic streets of Canada or have a special place in their heart for certain Canadian delights, our secure online shopping experience is designed just for you. Rediscover those beloved items that make you feel at home, no matter where you are!</p>

                    <p class="mb-8">Happy shopping, and welcome to our family!</p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="image-box py-6 px-4 image-box-border">
                                <div class="icon position-relative">
                                    <img src="{{ URL::asset('frontend/img/icons/mission.png') }}" alt="hand icon" class="img-fluid about-icons">
                                </div>
                                <h4 class="mt-3">Our Mission</h4>
                                <p class="mb-0">To deliver high-quality Canadian food products worldwide, ensuring authenticity, freshness, and customer satisfaction.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="image-box py-6 px-4 image-box-border">
                                <div class="icon position-relative">
                                    <img src="{{ URL::asset('frontend/img/icons/vision.png') }}" alt="hand icon" class="img-fluid about-icons">
                                </div>
                                <h4 class="mt-3">Our Vision</h4>
                                <p class="mb-0">To be the leading e-commerce platform for Canadian food, making local flavors accessible to everyone, everywhere.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--about section end-->

{{-- 
<!--brands section start-->
<section class="brands-section ptb-120 position-relative z-1 overflow-hidden service-section">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-4.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 w-100 z--1 bg-shape">
    <div class="container">
        <div class="brand-wrapper px-5 rounded-4">
            <h4 class="section-title mb-0">The Most Popular Brands</h4>
            <div class="brands-slider swiper px-2 pt-4 pb-7">
                <div class="swiper-wrapper">
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-1.png') }}" alt="brand" class="img-fluid">
                    </div>
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-2.png') }}" alt="brand" class="img-fluid">
                    </div>
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-3.png') }}" alt="brand" class="img-fluid">
                    </div>
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-4.png') }}" alt="brand" class="img-fluid">
                    </div>
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-5.png') }}" alt="brand" class="img-fluid">
                    </div>
                    <div class="swiper-slide brand-item rounded">
                        <img src="{{ URL::asset('frontend/img/brands/brand-2.png') }}" alt="brand" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--brands section end--> --}}

<!--feature section start-->
{{-- <section class="about-section bg-shade position-relative z-1">
    
    <img src="{{ URL::asset('frontend/img/shapes/roll-color.png') }}" alt="roll" class="position-absolute roll-color z--1" data-parallax='{"y": -50}'>
    <img src="{{ URL::asset('frontend/img/shapes/roll-color-curve.png') }}" alt="roll" class="position-absolute roll-color-curve z--1" data-parallax='{"y": 50}'>
    <img src="{{ URL::asset('frontend/img/shapes/onion-color.png') }}" alt="onion" class="position-absolute onion-color z--1" data-parallax='{"x": -30}'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <h2 class="mb-3">Our Performance at a Glance</h2>
                    <p class="mb-0">Delivering Quality & Excellence with Every Order!</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4 mt-4">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="horizontal-counter d-flex align-items-center gap-3 bg-white rounded p-4">
                    <span class="icon-wrapper d-inline-flex align-items-center justify-content-center flex-shrink-0">
                      <img src="{{ URL::asset('frontend/img/icons/icon-1.png') }}" alt="icon" class="img-fluid">
                  </span>
                    <div class="numbers">
                        <h3 class="mb-1"><span class="counter">3256</span>k+</h3>
                        <h6 class="mb-0 text-gray fs-sm">Total Products</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="horizontal-counter d-flex align-items-center gap-3 bg-white rounded p-4">
                    <span class="icon-wrapper d-inline-flex align-items-center justify-content-center flex-shrink-0">
                      <img src="{{ URL::asset('frontend/img/icons/icon-2.png') }}" alt="icon" class="img-fluid">
                  </span>
                    <div class="numbers">
                        <h3 class="mb-1"><span class="counter">2456</span>k+</h3>
                        <h6 class="mb-0 text-gray fs-sm">Total Orders</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="horizontal-counter d-flex align-items-center gap-3 bg-white rounded p-4">
                    <span class="icon-wrapper d-inline-flex align-items-center justify-content-center flex-shrink-0">
                      <img src="{{ URL::asset('frontend/img/icons/icon-3.png') }}" alt="icon" class="img-fluid">
                  </span>
                    <div class="numbers">
                        <h3 class="mb-1"><span class="counter">1250</span>k+</h3>
                        <h6 class="mb-0 text-gray fs-sm">Total Visitors</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="horizontal-counter d-flex align-items-center gap-3 bg-white rounded p-4">
                    <span class="icon-wrapper d-inline-flex align-items-center justify-content-center flex-shrink-0">
                      <img src="{{ URL::asset('frontend/img/icons/icon-4.png') }}" alt="icon" class="img-fluid">
                  </span>
                    <div class="numbers">
                        <h3 class="mb-1"><span class="counter">1245</span>k+</h3>
                        <h6 class="mb-0 text-gray fs-sm">Total Delivery</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--feature section end--> --}}

<!--feedback section start-->
<section class="light-pink-bg pt-100 pb-120 position-relative z-1 overflow-hidden service-section">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-4.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 w-100 z--1 bg-shape">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-5.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 z--1 w-100">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-xl-7">
                <div class="clients_thumb">
                    <img src="{{ URL::asset('frontend/img/about/clients.png') }}" alt="clients" class="img-fluid">
                </div>
            </div>
            <div class="col-xl-5">
                <div class="swiper feedback-slider-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide feedback-card bg-white rounded py-6 px-4">
                            <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                                <img src="{{ URL::asset('frontend/img/authors/client-1.png') }}" alt="client" class="img-fluid rounded-circle flex-shrink-0">
                                <div class="clients-info">
                                    <h5 class="mb-1">Jessica M., New York, NY</h5>
                                    <ul class="d-flex align-items-center fs-xs text-warning">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">“I’ve always wanted to try authentic Canadian snacks, and this company delivers the best! The butter tarts and maple cookies were absolutely delicious. Everything was fresh and arrived quickly. Highly recommend!”</p>
                        </div>
                        <div class="swiper-slide feedback-card bg-white rounded py-6 px-4">
                            <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                                <img src="{{ URL::asset('frontend/img/authors/client-2.png') }}" alt="client" class="img-fluid rounded-circle flex-shrink-0">
                                <div class="clients-info">
                                    <h5 class="mb-1">Mike T., Austin, TX</h5>
                                    <ul class="d-flex align-items-center fs-xs text-warning">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">“Finally, I can get my favorite Canadian chips and chocolates in the U.S. without crazy shipping fees! The packaging was perfect, and the taste was just like I remember from my trips to Canada. Will order again!”</p>
                        </div>
                        <div class="swiper-slide feedback-card bg-white rounded py-6 px-4">
                            <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                                <img src="{{ URL::asset('frontend/img/authors/client-3.png') }}" alt="client" class="img-fluid rounded-circle flex-shrink-0">
                                <div class="clients-info">
                                    <h5 class="mb-1">Sarah L., Chicago, IL</h5>
                                    <ul class="d-flex align-items-center fs-xs text-warning">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">“This is the best place to get authentic Canadian snacks in the States. The selection is amazing—Ketchup chips, Coffee Crisp, and real maple candies! Everything arrived fresh and well-packed. Love it!”</p>
                        </div>
                        <div class="swiper-slide feedback-card bg-white rounded py-6 px-4">
                            <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                                <img src="{{ URL::asset('frontend/img/authors/client-3.png') }}" alt="client" class="img-fluid rounded-circle flex-shrink-0">
                                <div class="clients-info">
                                    <h5 class="mb-1">Daniel R., Los Angeles, CA</h5>
                                    <ul class="d-flex align-items-center fs-xs text-warning">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">“As a Canadian living in the U.S., I missed my favorite snacks so much. This service is a game-changer! The selection is spot-on, and I can finally enjoy my childhood favorites again. Great customer service too!”</p>
                        </div>
                        <div class="swiper-slide feedback-card bg-white rounded py-6 px-4">
                            <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                                <img src="{{ URL::asset('frontend/img/authors/client-3.png') }}" alt="client" class="img-fluid rounded-circle flex-shrink-0">
                                <div class="clients-info">
                                    <h5 class="mb-1">Emily C., Miami, FL</h5>
                                    <ul class="d-flex align-items-center fs-xs text-warning">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">“Ordered a Canadian snack box as a gift for my husband, and he loved it! The assortment of cookies, chocolates, and drinks was perfect. Such a cool way to experience new flavors!”</p>
                        </div>
                    </div>
                    <div class="slider-arrows text-end mt-5">
                        <button type="button" class="fd2-arrow-left"><i class="fas fa-angle-left"></i></button>
                        <button type="button" class="fd2-arrow-right"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--feedback section end-->
{{-- 
<!--team section start-->
<section class="grostore-team-section pt-6 bg-shade position-relative z-1 overflow-hidden">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-5.png') }}" alt="bg shape" class="position-absolute start-0 bottom-0 z--1 w-100">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-xl-3">
                <div class="section-title">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h6 class="mb-0 gshop-subtitle text-secondary">Team Members</h6>
                        <span>
                          <svg width="58" height="10" viewBox="0 0 58 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <line x1="-6.99382e-08" y1="5.2" x2="52" y2="5.2" stroke="#FF7C08" stroke-width="1.6"/>
                              <path d="M58 5L50.5 9.33013L50.5 0.669872L58 5Z" fill="#FF7C08"/>
                          </svg>
                      </span>
                    </div>
                    <h2 class="mb-3">Our Online Customer Help! Member</h2>
                    <p class="mb-7">Rationally encounter extremely painful there anyone.</p>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="team-slider-prev-btn team-slider-btn"><i class="fas fa-angle-left"></i></button>
                        <button type="button" class="team-slider-next-btn team-slider-btn"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="swiper team-slider">
                    <div class="swiper-wrapper">
                        <div class="team-card text-center bg-white rounded py-7 px-4 swiper-slide">
                            <div class="team-thumb mb-5">
                                <img src="{{ URL::asset('frontend/img/authors/team-1.jpg') }}" alt="team" class="img-fluid rounded-circle">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                            <h5>Frances Gilmartin</h5>
                            <span>CEO &amp; Founder</span>
                        </div>
                        <div class="team-card text-center bg-white rounded py-7 px-4 swiper-slide">
                            <div class="team-thumb mb-5">
                                <img src="{{ URL::asset('frontend/img/authors/team-2.jpg') }}" alt="team" class="img-fluid rounded-circle">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                            <h5>Frances Gilmartin</h5>
                            <span>CEO &amp; Founder</span>
                        </div>
                        <div class="team-card text-center bg-white rounded py-7 px-4 swiper-slide">
                            <div class="team-thumb mb-5">
                                <img src="{{ URL::asset('frontend/img/authors/team-1.jpg') }}" alt="team" class="img-fluid rounded-circle">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                            <h5>Frances Gilmartin</h5>
                            <span>CEO &amp; Founder</span>
                        </div>
                        <div class="team-card text-center bg-white rounded py-7 px-4 swiper-slide">
                            <div class="team-thumb mb-5">
                                <img src="{{ URL::asset('frontend/img/authors/team-2.jpg') }}" alt="team" class="img-fluid rounded-circle">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                            <h5>Frances Gilmartin</h5>
                            <span>CEO &amp; Founder</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--team section end-->

<!--call to action start-->
<section class="cta-section pb-120">
    <div class="container">
        <div class="cta-box rounded text-center" data-background="assets/img/banner/cta-banner.jpg') }}">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 mb-2">
                <h6 class="mb-0 text-secondary gshop-subtitle">Weekend Offer</h6>
                <span>
                  <svg width="58" height="10" viewBox="0 0 58 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <line x1="-6.99382e-08" y1="5.2" x2="52" y2="5.2" stroke="#FF7C08" stroke-width="1.6"/>
                      <path d="M58 5L50.5 9.33013L50.5 0.669872L58 5Z" fill="#FF7C08"/>
                  </svg>   
              </span>
            </div>
            <h3 class="mb-5">Organic Foods Up to 40% off</h3>
            <a href="shop-grid.html" class="btn btn-secondary">Shop Now<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
        </div>
    </div>
</section> <!--call to action end-->

<!--about us section-->
<section class="about-us-section pb-120">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-xl-5">
                <div class="about-us-left position-relative">
                    <img src="{{ URL::asset('frontend/img/about/ab-2.png') }}" alt="not found" class="img-fluid">
                    <div class="exp-box p-3 bg-white rounded-circle position-absolute">
                        <div class="bg-secondary w-100 h-100 rounded-circle d-flex align-items-center justify-content-center flex-column">
                            <h2 class="text-white">14+</h2>
                            <span class="h6 text-white">Year's Experience</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="about-us-right">
                    <div class="section-title-mx mb-6">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                            <h6 class="mb-0 gshop-subtitle text-secondary">Why Choose Us</h6>
                            <span>
                              <svg width="58" height="10" viewBox="0 0 58 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <line x1="-6.99382e-08" y1="5.2" x2="52" y2="5.2" stroke="#FF7C08" stroke-width="1.6"/>
                                  <path d="M58 5L50.5 9.33013L50.5 0.669872L58 5Z" fill="#FF7C08"/>
                              </svg>
                          </span>
                        </div>
                        <h2 class="mb-3">We do not Buy from the Open Market</h2>
                        <p class="mb-0">Compellingly fashion intermandated opportunities and multimedia based fnsparent e-business.</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="horizontal-icon-box d-flex align-items-center gap-4 bg-white rounded p-4 hover-shadow flex-wrap flex-xxl-nowrap">
                                <span class="icon-wrapper position-relative flex-shrink-0">
                                  <img src="{{ URL::asset('frontend/img/icons/hand-icon.svg') }}" alt="hand icon" class="img-fluid">
                              </span>
                                <div class="content-right">
                                    <h5 class="mb-3">Trusted Partner</h5>
                                    <p class="mb-0">Compellingly fashion intermandat opportunities e-business fashion intermandated business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="horizontal-icon-box d-flex align-items-center gap-4 bg-white rounded p-4 hover-shadow flex-wrap flex-xxl-nowrap">
                                <span class="icon-wrapper position-relative flex-shrink-0">
                                  <img src="{{ URL::asset('frontend/img/icons/hand-icon.svg') }}" alt="hand icon" class="img-fluid">
                              </span>
                                <div class="content-right">
                                    <h5 class="mb-3">Return Policy</h5>
                                    <p class="mb-0">Compellingly fashion intermandat opportunities e-business fashion intermandated business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="horizontal-icon-box d-flex align-items-center gap-4 bg-white rounded p-4 hover-shadow flex-wrap flex-xxl-nowrap">
                                <span class="icon-wrapper position-relative flex-shrink-0">
                                  <img src="{{ URL::asset('frontend/img/icons/hand-icon.svg') }}" alt="hand icon" class="img-fluid">
                              </span>
                                <div class="content-right">
                                    <h5 class="mb-3">100% Organic Fresh</h5>
                                    <p class="mb-0">Compellingly fashion intermandat opportunities e-business fashion intermandated business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="horizontal-icon-box d-flex align-items-center gap-4 bg-white rounded p-4 hover-shadow flex-wrap flex-xxl-nowrap">
                                <span class="icon-wrapper position-relative flex-shrink-0">
                                  <img src="{{ URL::asset('frontend/img/icons/hand-icon.svg') }}" alt="hand icon" class="img-fluid">
                              </span>
                                <div class="content-right">
                                    <h5 class="mb-3">Secured Payment</h5>
                                    <p class="mb-0">Compellingly fashion intermandat opportunities e-business fashion intermandated business.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--about us section end--> --}}


@endsection