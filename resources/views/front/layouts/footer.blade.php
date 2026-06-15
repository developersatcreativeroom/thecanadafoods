<button class="btn btn-primary d-block d-md-none category-btn-mobile mobile-menu-toggle">
    All Categories
</button>
<!--footer section start-->
<div class="footer-curve position-relative overflow-hidden bg-white">
    <span class="position-absolute section-curve-wrapper top-0 h-100" data-background="{{ URL::asset('frontend/img/shapes/section-curve.png') }}"></span>
</div>
<footer class="gshop-footer position-relative pt-8 bg-dark z-1 overflow-hidden">
    {{-- <img src="{{ URL::asset('frontend/img/shapes/cookie.png') }}" alt="tomato" class="position-absolute z--1 tomato vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/white-bread.png') }}" alt="pata" class="position-absolute z--1 pata-lg vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/bread-outline.png') }}" alt="pata" class="position-absolute z--1 pata-xs vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/nachos1.svg') }}" alt="frame" class="position-absolute z--1 frame-circle vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/nachos1.png') }}" alt="leaf" class="position-absolute nachos z--1 leaf vector-shape">
    <!--shape right -->
    <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="pata" class="position-absolute chocolate-bar leaf-2 z--1 vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/beer.png') }}" alt="pata" class="position-absolute pata-xs-2 z--1 vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/energy-drink.png') }}" alt="tomato slice" class="position-absolute tomato-slice vector-shape z--1">
    <img src="{{ URL::asset('frontend/img/shapes/crisps.png') }}" alt="tomato" class="position-absolute tomato-half z--1 vector-shape"> --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6">
                <div class="gshop_subscribe_form text-center">
                    <h4 class="text-white gshop-title">Subscribe to the <mark class="p-0 position-relative text-secondary bg-transparent">{{config('constants.BUSINESS.name')}} <img src="{{ URL::asset('frontend/img/shapes/border-line.svg') }}" alt="border line" class="position-absolute border-line"></mark>
                        <br>for new updates </h4>
                    <form class="mt-5 d-flex align-items-center bg-white rounded subscribe_form">
                        <input type="email" class="form-control" placeholder="Enter Email Address" id="subscribe-email">
                        <button type="submit" class="btn btn-primary flex-shrink-0" id="subscribe">Subscribe Now</button>
                    </form>
                    <div class="text-start" id="subscribe-message"></div>
                </div>
            </div>
        </div>
        <span class="gradient-spacer my-8 d-block"></span>
        <div class="row g-5">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <a href="{{route('home')}}" class="footer-logo"><img class="img-fluid" src="{{App\Helper::getDarkLogo()}}" alt="logo"></a>

                <p class="text-white mt-5">
                    Since 2020, The Canada Foods has been delivering authentic Canadian treats like chocolates, chips, and beverages with quality and care!
                </p>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">Categories</h5>
                    <ul class="footer-nav">

                        @php
                            //$categoriesList = App\Helper::getCategoriesList(6);
                            $categoriesList = App\Helper::getCategoriesNav(true);
                        @endphp

                        @foreach($categoriesList as $category)
                            <li><a href="{{route('category',[$category['slug']])}}">{{$category->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <ul class="footer-nav">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('about')}}">About</a></li>
                        <li><a href="{{route('products')}}">Products</a></li>
                        <li><a href="{{route('blogs')}}">Blog</a></li>
                        <li><a href="{{route('faqs')}}">FAQs</a></li>
                        <li><a href="{{route('contact')}}">Contact</a></li>
                        <li><a href="{{route('shipping.policy')}}">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">Other Links</h5>
                    <ul class="footer-nav">
                        <li><a href="{{route('terms')}}">Terms & Conditions</a></li>
                        <li><a href="{{route('privacy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('cookie.policy')}}">Cookie Policy</a></li>
                        <li><a href="{{route('refund.policy')}}">Return And Refund Policy</a></li>
                        <li><a href="{{route('disclaimer')}}">Disclaimer</a></li>
                        <li><a href="{{route('sitemap')}}">Sitemap</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">Contact Us</h5>

                    <ul class="footer-nav">
                        <li class="nav-item text-white">
                            <a href="mailto:{{$config['email']}}">
                                <span class="me-1">
                                    <svg width="16" height="14" viewBox="0 0 20 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.2422 0H1.75781C0.790547 0 0 0.783572 0 1.75V12.25C0 13.2168 0.791055 14 1.75781 14H18.2422C19.2095 14 20 13.2164 20 12.25V1.75C20 0.783339 19.2091 0 18.2422 0ZM17.9723 1.16667C17.4039 1.73433 10.7283 8.40194 10.4541 8.67588C10.225 8.90462 9.77512 8.90478 9.54594 8.67588L2.02773 1.16667H17.9723ZM1.17188 12.0355V1.96447L6.21348 7L1.17188 12.0355ZM2.02773 12.8333L7.04078 7.82631L8.71598 9.49951C9.40246 10.1852 10.5978 10.1849 11.2841 9.49951L12.9593 7.82635L17.9723 12.8333H2.02773ZM18.8281 12.0355L13.7865 7L18.8281 1.96447V12.0355Z"
                                            fill="white" />
                                    </svg>
                                </span>
                                {{$config['email']}}
                            </a>
                        </li>
                        {{-- <li class="nav-item text-white">
                            <a href="mailto:{{$config['phone']}}">
                                <span class="me-1">
                                    <i class="fa fa-phone"></i>
                                </span>
                                {{$config['phone']}}
                            </a>
                        </li> --}}
                        {{-- <li><a href="javascript:void(0)"> <i class="fa fa-map-marker"></i> &nbsp; {!!$config['address']!!} </a></li> --}}
                    </ul>
                    
                    @if(count($config['social']) > 0 && 
                            ($config['social']['facebook'] != "" && $config['social']['facebook'] != "#" ||
                            $config['social']['instagram'] != "" && $config['social']['instagram'] != "#" ||
                            $config['social']['twitter'] != "" && $config['social']['twitter'] != "#" ||
                            $config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#" ||
                            $config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                            )
                                <div class="mt-5">
                                    <span class="fw-bold text-white mb-3 d-block">Follow us on:</span>
                                    <div class="social-links d-flex align-items-center gap-2">

                                        @if($config['social']['facebook'] != "" && $config['social']['facebook'] != "#")
                                            <a target="_blank" aria-label="Visit us on facebook" href="{{$config['social']['facebook']}}"><i class="fab fa-facebook-f"></i></a>
                                        @endif

                                        @if($config['social']['instagram'] != "" && $config['social']['instagram'] != "#")
                                            <a target="_blank" aria-label="Visit us on instagram" href="{{$config['social']['instagram']}}"><i class="fab fa-instagram"></i></a>
                                        @endif

                                        @if($config['social']['twitter'] != "" && $config['social']['twitter'] != "#")
                                            <a target="_blank" aria-label="Visit us on twitter" href="{{$config['social']['twitter']}}"><i class="fab fa-twitter"></i></a>
                                        @endif

                                        @if($config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#")
                                            <a target="_blank" aria-label="Visit us on pinterest" href="{{$config['social']['pinterest']}}"><i class="fab fa-pinterest"></i></a>
                                        @endif

                                        @if($config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                                            <a target="_blank" aria-label="Visit us on youtube" href="{{$config['social']['youtube']}}"><i class="fab fa-youtube"></i></a>
                                        @endif

                                    </div>
                                </div>

                        @endif

                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright pt-20 pb-3">
        <span class="gradient-spacer d-block mb-3"></span>
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-4">
                    <div class="copyright-text">
                        <p class="mb-0 text-white">&copy; All rights reserved. Made by <a target="_blank" href="https://mytechregion.com" class="text-white text-decoration-underline">MyTechRegion</a></p>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="logo-wrapper text-center">
                        <a href="{{route('home')}}" class="logo"><img src="{{ App\Helper::getLightLogo() }}" alt="logo" class="img-fluid"></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-payments-info d-flex align-items-center justify-content-lg-end gap-2">
                        <div class="supported-payment-box rounded-1 bg-dark-light d-inline-flex align-items-center justify-content-center p-2 flex-shrink-0">
                            <img src="{{ URL::asset('frontend/img/brands/visa.png') }}" alt="visa" class="img-fluid">
                        </div>
                        <div class="supported-payment-box rounded-1 bg-dark-light d-inline-flex align-items-center justify-content-center p-2 flex-shrink-0">
                            <img src="{{ URL::asset('frontend/img/brands/mastercard.png') }}" alt="visa" class="img-fluid">
                        </div>
                        <div class="supported-payment-box rounded-1 bg-dark-light d-inline-flex align-items-center justify-content-center p-2 flex-shrink-0">
                            <img src="{{ URL::asset('frontend/img/brands/payoneer.png') }}" alt="visa" class="img-fluid">
                        </div>
                        <div class="supported-payment-box rounded-1 bg-dark-light d-inline-flex align-items-center justify-content-center p-2 flex-shrink-0">
                            <img src="{{ URL::asset('frontend/img/brands/paypal.png') }}" alt="visa" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>



{{-- 
<footer class="main">
        <section class="newsletter p-30 text-white wow fadeIn animated">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-md-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col flex-horizontal-center">
                                <img class="icon-email" src="{{ URL::asset('frontend/img/theme/icons/icon-email.svg') }}" alt="">
                                <h4 class="font-size-20 mb-0 ml-3">Sign up to Newsletter</h4>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <!-- Subscribe Form -->
                        <form class="form-subcriber d-flex wow fadeIn animated">
                            <input type="email" class="form-control bg-white font-small" placeholder="Enter your email" id="subscribe-email">
                            <button class="btn bg-dark text-white" type="submit" id="subscribe">Subscribe</button>
                        </form>
                        <div id="subscribe-message"></div>
                        <!-- End Subscribe Form -->
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widget-about font-md mb-md-5 mb-lg-0">
                            <div class="logo logo-width-1 wow fadeIn animated">
                                <a href="{{route('home')}}"><img src="{{App\Helper::getDarkLogo()}}" alt="logo"></a>
                            </div>
                            <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                            @if(!$config['is_enquiry_website'])
                                <p class="wow fadeIn animated text-white">
                                    <strong>Address: </strong>{!!$config['address']!!}
                                </p>
                            @endif
                            <p class="wow fadeIn animated">
                                <strong>Phone: </strong>{{$config['phone']}}
                            </p>
                            <p class="wow fadeIn animated">
                                <strong>Hours: </strong>{{$config['timings_weekdays']}}, Monday - Saturday and Sunday {{$config['timings_weekend']}}
                            </p>
                            @if(count($config['social']) > 0 && 
                            ($config['social']['facebook'] != "" && $config['social']['facebook'] != "#" ||
                            $config['social']['instagram'] != "" && $config['social']['instagram'] != "#" ||
                            $config['social']['twitter'] != "" && $config['social']['twitter'] != "#" ||
                            $config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#" ||
                            $config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                            )
                                <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>
                                <div class="mobile-social-icon wow fadeIn animated mb-sm-5 mb-md-0">
                                    @if($config['social']['facebook'] != "" && $config['social']['facebook'] != "#")
                                        <a target="_blank" href="{{$config['social']['facebook']}}"><img src="{{ URL::asset('frontend/img/theme/icons/icon-facebook.svg') }}" alt=""></a>
                                    @endif

                                    @if($config['social']['instagram'] != "" && $config['social']['instagram'] != "#")
                                        <a target="_blank" href="{{$config['social']['instagram']}}"><img src="{{ URL::asset('frontend/img/theme/icons/icon-instagram.svg') }}" alt=""></a>
                                    @endif

                                    @if($config['social']['twitter'] != "" && $config['social']['twitter'] != "#")
                                        <a target="_blank" href="{{$config['social']['twitter']}}"><img src="{{ URL::asset('frontend/img/theme/icons/icon-twitter.svg') }}" alt=""></a>
                                    @endif

                                    @if($config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#")
                                        <a target="_blank" href="{{$config['social']['pinterest']}}"><img src="{{ URL::asset('frontend/img/theme/icons/icon-pinterest.svg') }}" alt=""></a>
                                    @endif

                                    @if($config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                                        <a target="_blank" href="{{$config['social']['youtube']}}"><img src="{{ URL::asset('frontend/img/theme/icons/icon-youtube.svg') }}" alt=""></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <h5 class="widget-title wow fadeIn animated">Links</h5>
                        <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                            <li><a href="{{route('about')}}">About Us</a></li>
                            <li><a href="{{route('contact')}}">Contact Us</a></li>
                            <li><a href="{{route('login')}}">Sign In</a></li>
                            <li><a href="{{route('cart')}}">View Cart</a></li>
                            <li><a href="{{route('wishlist')}}">My Wishlist</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-lg-2  col-md-3">
                        <h5 class="widget-title wow fadeIn animated">Pages</h5>
                        @php
                            $pages = App\Helper::getPages();
                        @endphp
                        <ul class="footer-list wow fadeIn animated">
                            @foreach($pages as $page)
                                <li><a href="{{route('page',$page->slug)}}">{{$page->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        @if($config['is_enquiry_website'])
                            <h5 class="widget-title wow fadeIn animated text-white">Reach Us</h5>
                            <p class="wow fadeIn animated text-white">
                                <strong>Address: </strong>{!!$config['address']!!}
                            </p>
                        </p>
                        @else
                            <h5 class="widget-title wow fadeIn animated text-white">Secured Payment Gateways</h5>
                            <img class="wow fadeIn animated text-white" src="{{ URL::asset('frontend/img/theme/payment-method.png') }}" alt="Payments">
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container pb-20 wow fadeIn animated">
            <div class="row">
                <div class="col-12 mb-20">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-lg-6">
                    <p class="float-md-left font-sm text-muted mb-0">&copy; copyright {{date('Y')}} <strong class="text-brand"></strong> </p>
                </div>
                <div class="col-lg-6">
                    <p class="text-lg-end text-start font-sm text-muted mb-0">
                        Design and developed by <a href="https://www.creativeroom.in" target="_blank">Creative Room</a>. All rights reserved
                    </p>
                </div>
            </div>
        </div>


        @if($config['whatsapp'] && $config['whatsapp'] != null && $config['whatsapp'] != '')
        <div class="whatsapp">
            <div class="cr-chat-btn"><a href="{{$config['whatsapp']}}"><img src="{{ URL::asset('frontend/img/whatsapp-2.png') }}" alt="whatsapp"></a></div>
        </div>
        @endif


    </footer> --}}