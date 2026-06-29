{{-- 

@auth('web')
    <li>
        <a class="language-dropdown-active text-white" href="#"> <i class="fi-rs-user"></i> Profile <i class="fi-rs-angle-small-down"></i></a>
        <ul class="language-dropdown">
            <li><a href="{{route('profile')}}">Profile</a></li>
            <li><a href="{{route('change.password')}}">Password</a></li>
            @if ($isEnquiryWebsite)
                <li><a href="{{route('enquiries')}}">Enquiries</a></li>
            @else
                <li><a href="{{route('orders')}}">Orders</a></li>
            @endif
            <li><a href="{{route('addresses')}}">Addresses</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </li>
@endauth

@guest
    <li><i class="fi-rs-user"></i><a href="{{route('register')}}">Log In / Sign Up</a></li>
@endguest --}}


{{-- <form action="{{url('/products')}}" method="get" >
    <select class="select-active" name="categories">
        @php
            $categoriesList = App\Helper::getCategoriesList();
        @endphp
        <option>All Categories</option>
        @foreach ($categoriesList as $category)
            <option value="{{$category->slug}}">{{$category->name}}</option>
        @endforeach
    </select>
    <input type="text" placeholder="Search for items..." name="keyword" class="searchproducts" id="keyword" inputmode="search" autocomplete="off" data-smart-search="true" value="@if (isset($_GET['keyword'])){{$_GET['keyword']}}@endif">
</form> --}}


@php
    $isEnquiryWebsite = App\Helper::getWebsiteConfig('is_enquiry_website');
    $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];
@endphp


<!--header section start-->
<header class="gheader position-relative z-2 header-sticky">
    <div class="ghead-topbar bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-4 col-xl-4 d-none d-xl-block">
                    <div class="topbar-info">
                        @php
                            $currencySign = App\Helper::getWebsiteConfig('currency_sign');
                            $minCartAmount = App\Helper::getWebsiteConfig('min_cart_amount');
                        @endphp



                        <p id="top-nav-text-left" class="text-white fs-sm fw-medium mb-0 top-nav-text-left"
                            data-text="Minimum Order {{ $currencySign['currency_sign'] }}{{ $minCartAmount['min_cart_amount'] }}">
                            Minimum Order {{ $currencySign['currency_sign'] }}{{ $minCartAmount['min_cart_amount'] }}
                        </p>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6">
                    {{-- <div class="text-center text-xl-start offer-class text-white">
                        Celebrate Canada Day with 20% Off: Use Code
                        <strong id="couponCode" class="text-decoration-underline" style="cursor: pointer;" onclick="copyCoupon()">SAVE20</strong>
                        - Limited Time!
                    </div> --}}
                </div>
                <div class="col-xxl-2 col-xl-2 d-none d-lg-block">
                    <ul
                        class="d-flex align-items-center justify-content-center justify-content-xl-end topbar-info-right">
                        <li class="nav-item text-white">
                            {{-- <a href="mailto:{{$config['email']}}"> --}}
                            <a href="{{ route('contact') }}">
                                <span class="me-1">
                                    <svg width="16" height="14" viewBox="0 0 20 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.2422 0H1.75781C0.790547 0 0 0.783572 0 1.75V12.25C0 13.2168 0.791055 14 1.75781 14H18.2422C19.2095 14 20 13.2164 20 12.25V1.75C20 0.783339 19.2091 0 18.2422 0ZM17.9723 1.16667C17.4039 1.73433 10.7283 8.40194 10.4541 8.67588C10.225 8.90462 9.77512 8.90478 9.54594 8.67588L2.02773 1.16667H17.9723ZM1.17188 12.0355V1.96447L6.21348 7L1.17188 12.0355ZM2.02773 12.8333L7.04078 7.82631L8.71598 9.49951C9.40246 10.1852 10.5978 10.1849 11.2841 9.49951L12.9593 7.82635L17.9723 12.8333H2.02773ZM18.8281 12.0355L13.7865 7L18.8281 1.96447V12.0355Z"
                                            fill="white" />
                                    </svg>
                                </span>
                                Contact Us
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="tel:{{$config['phone']}}">
                                <span class="me-1">
                                  <svg width="16" height="14" viewBox="0 0 20 14" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path
                                          d="M18.2422 0H1.75781C0.790547 0 0 0.783572 0 1.75V12.25C0 13.2168 0.791055 14 1.75781 14H18.2422C19.2095 14 20 13.2164 20 12.25V1.75C20 0.783339 19.2091 0 18.2422 0ZM17.9723 1.16667C17.4039 1.73433 10.7283 8.40194 10.4541 8.67588C10.225 8.90462 9.77512 8.90478 9.54594 8.67588L2.02773 1.16667H17.9723ZM1.17188 12.0355V1.96447L6.21348 7L1.17188 12.0355ZM2.02773 12.8333L7.04078 7.82631L8.71598 9.49951C9.40246 10.1852 10.5978 10.1849 11.2841 9.49951L12.9593 7.82635L17.9723 12.8333H2.02773ZM18.8281 12.0355L13.7865 7L18.8281 1.96447V12.0355Z"
                                          fill="white" />
                                  </svg>
                              </span>
                                {{$config['phone']}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="me-1">
                              <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                      d="M6.00011 8.16427C7.44543 8.16427 8.62131 6.98781 8.62131 5.54175C8.62131 4.09569 7.44543 2.91925 6.00011 2.91925C4.55478 2.91925 3.37891 4.09569 3.37891 5.54175C3.37891 6.98781 4.55478 8.16427 6.00011 8.16427ZM6.00011 3.85662C6.92883 3.85662 7.68441 4.61259 7.68441 5.54175C7.68441 6.47093 6.92886 7.2269 6.00011 7.2269C5.07136 7.2269 4.31581 6.47093 4.31581 5.54175C4.31581 4.61259 5.07139 3.85662 6.00011 3.85662Z"
                                      fill="white" stroke="white" stroke-width="0.3" />
                                  <path
                                      d="M3.14593 10.2541C3.85594 11.2159 3.57069 10.8418 5.61579 13.7635C5.80167 14.0301 6.19695 14.0314 6.38389 13.7639C8.43824 10.8284 8.15557 11.2002 8.85403 10.254C9.56155 9.29555 10.2932 8.30443 10.6941 7.14299C11.2744 5.46171 11.0236 3.79818 9.9879 2.45881C9.98787 2.45881 9.98787 2.45878 9.98784 2.45878C9.03913 1.23225 7.54834 0.5 5.99998 0.5C4.45163 0.5 2.96083 1.23225 2.01209 2.45884C0.976407 3.79821 0.725568 5.46177 1.30588 7.14305C1.70675 8.30446 2.43841 9.29558 3.14593 10.2541ZM2.75305 3.03246C3.52562 2.03369 4.73944 1.43737 5.99998 1.43737C7.26052 1.43737 8.47434 2.03369 9.24691 3.03246L9.24684 3.03243C10.0828 4.11343 10.2822 5.46462 9.80852 6.83705C9.4544 7.86293 8.76606 8.79539 8.10039 9.69717C7.5821 10.3993 7.73721 10.1845 5.99998 12.6763C4.26456 10.187 4.41771 10.399 3.89957 9.69717C3.2339 8.79539 2.54556 7.86289 2.19144 6.83705C1.71775 5.46459 1.91718 4.11343 2.75305 3.03246Z"
                                      fill="white" stroke="white" stroke-width="0.3" />
                                  <path
                                      d="M3.53116 12.2865C3.393 12.0677 3.10369 12.0023 2.88495 12.1405L1.55299 12.9823C1.26243 13.1659 1.26214 13.591 1.55299 13.7748L5.75031 16.4276C5.90312 16.5242 6.09787 16.5241 6.25065 16.4276L10.448 13.7748C10.7386 13.5912 10.7388 13.1661 10.448 12.9823L9.116 12.1405C8.8972 12.0023 8.60792 12.0677 8.46979 12.2865C8.3316 12.5053 8.39693 12.7948 8.61567 12.933L9.32065 13.3786L6.00046 15.4769L2.6803 13.3786L3.38529 12.933C3.60402 12.7948 3.66933 12.5053 3.53116 12.2865Z"
                                      fill="white" stroke="white" stroke-width="0.3" />
                              </svg>
                          </span>
                          {!!$config['address']!!}
                        </li> --}}


                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="gshop-navbar bg-white rounded ps-lg-5 position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-4 col-xl-4 col-md-3 col-5">
                    <a href="{{ route('home') }}" class="logo"><img src="{{ App\Helper::getLightLogo() }}"
                            alt="logo" class="img-fluid header-logo"></a>
                </div>
                <div class="col-xxl-8 col-xl-8 col-md-9 col-7">
                    <div
                        class="gshop-navbar-right d-flex align-items-center justify-content-end justify-content-sm-between position-relative">




                        <div class="d-none d-sm-block search-main w-100">
                            <form class="search-form d-flex align-items-center poposition-relative"
                                action="{{ route('products') }}">
                                <input type="text" placeholder="Search products..." class="w-100" name="keyword"
                                    inputmode="search" autocomplete="off" data-smart-search="true"
                                    value="@if (isset($_GET['keyword'])) {{ $_GET['keyword'] }} @endif">
                                <div class="search-loader">
                                    <img src="{{ URL::asset('frontend/img/image-loading.gif') }}" height="30"
                                        alt="Loading..." />
                                </div>
                                <button id="search-btn-m" class="submit-icon-btn-secondary" type="submit"
                                    aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>

                        <div
                            class="gshop-header-icons d-none d-md-inline-flex align-items-center justify-content-end ms-3 me-10">


                            @guest

                                <a href="{{ route('login') }}" class="header-icon">
                                    <img width="24" height="24"
                                        src="{{ URL::asset('frontend/img/icons/user.png') }}" alt="profile">
                                </a>
                            @endguest

                            @auth('web')
                                <div class="gshop-header-user position-relative">
                                    <button type="button" class="header-icon">
                                        <img width="24" height="24"
                                            src="{{ URL::asset('frontend/img/icons/user.png') }}" alt="profile">
                                    </button>





                                    <div class="user-menu-wrapper">
                                        <ul class="user-menu">

                                            <li>
                                                <a href="{{ route('profile') }}"><span class="me-2"><i
                                                            class="fa-solid fa-user"></i></span>My Profile</a></a>
                                            </li>
                                            <li>
                                                <a href="{{ route('change.password') }}"><span class="me-2"><i
                                                            class="fa-solid fa-lock"></i></span>Password</a>
                                            </li>

                                            @if ($isEnquiryWebsite)
                                                <li>
                                                    <a href="{{ route('enquiries') }}"><span class="me-2"><i
                                                                class="fa-solid fa-question-circle"></i></span>Enquiries</a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ route('orders') }}"><span class="me-2"><i
                                                                class="fa-solid fa-cart-arrow-down"></i></span>Orders</a>
                                                </li>
                                            @endif

                                            <li>
                                                <a href="{{ route('addresses') }}"><span class="me-2"><i
                                                            class="fa-solid fa-map-marker-alt"></i></span>Addresses</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logout') }}"><span class="me-2"><i
                                                            class="fa-solid fa-sign-out"></i></span>Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endauth

                            <div class="gshop-header-search dropdown">
                                <span class="pro-count wishlist-count">0</span>
                                <a href="{{ route('wishlist') }}" class="header-icon">
                                    <img width="24" height="24"
                                        src="{{ URL::asset('frontend/img/icons/wishlist.png') }}" alt="wishlist">

                                </a>
                            </div>


                            <div class="gshop-header-cart position-relative">
                                <span class="pro-count cart-count">0</span>
                                <a @if (Route::currentRouteName() != 'cart') href="{{ route('cart') }}" @else href="#" @endif
                                    class="header-icon">
                                    <img width="24" height="24"
                                        src="{{ URL::asset('frontend/img/icons/cart.png') }}" alt="cart">
                                </a>
                                <div class="cart-box-wrapper">
                                    <div class="apt_cart_box theme-scrollbar">
                                        <ul class="at_scrollbar scrollbar custom-scroll cart-products-cont">

                                        </ul>
                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                            <h6 class="mb-0">Subtotal:</h6>
                                            <span class="fw-semibold text-primary cart-total">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between gap-2">
                                            <a href="{{ route('cart') }}"
                                                class="btn btn-primary btn-md flex-grow-1 mt-4">View Cart</a>
                                            @if (Route::currentRouteName() != 'checkout')
                                                <a href="{{ route('checkout') }}"
                                                    class="btn btn-secondary btn-md flex-grow-1 mt-4">Checkout</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="gshop-header-contact ms-7 position-relative d-none d-lg-flex d-xl-none d-xxl-flex">
                            <a href="tel:{{$config['phone']}}" class="d-flex align-items-center">
                                <span
                                  class="icon d-inline-flex rounded-circle justify-content-center align-items-center bg-secondary-light">
                                  <svg width="20" height="24" viewBox="0 0 23 24" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path
                                          d="M1.98193 3.44444C1.98193 2.09441 2.97352 1 4.19672 1H7.82812C8.30477 1 8.72795 1.33664 8.87867 1.83572L10.5373 7.3277C10.7116 7.90472 10.475 8.53538 9.98206 8.8074L7.48236 10.1868C8.70297 13.1748 10.884 15.5821 13.5913 16.9292L14.8411 14.1703C15.0876 13.6263 15.659 13.3651 16.1818 13.5575L21.1577 15.3881C21.61 15.5545 21.915 16.0215 21.915 16.5476V20.5556C21.915 21.9056 20.9234 23 19.7002 23H18.5928C9.41887 23 1.98193 14.7919 1.98193 4.66667V3.44444Z"
                                          stroke="#FF7C08" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                  </svg>
                              </span>
                                <div class="ms-3">
                                    <span class="text-muted fs-xs">Phone</span>
                                    <h6 class="mb-0 mt-1 fs-sm">{{$config['phone']}}</h6>
                                </div>
                            </a>
                        </div> --}}
                        <button class="gshop-offcanvas-btn offcanvas-toggle ms-3 text-white d-block d-sm-none"
                            aria-label="Open menu">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.5892 0C1.66061 0 0.0917969 1.56893 0.0917969 3.4974C0.0917969 5.42588 1.65997 6.9947 3.5892 6.9947C5.51844 6.9947 7.08661 5.42588 7.08661 3.4974C7.08661 1.56893 5.51768 0 3.5892 0Z"
                                    fill="white" />
                                <path
                                    d="M14.909 0C12.9805 0 11.4116 1.56893 11.4116 3.4974C11.4116 5.42588 12.9805 6.9947 14.909 6.9947C16.8376 6.9947 18.4068 5.42588 18.4068 3.4974C18.4068 1.56893 16.8383 0 14.909 0Z"
                                    fill="white" />
                                <path
                                    d="M26.411 6.99481C28.3391 6.99481 29.9084 5.42599 29.9084 3.49751C29.9084 1.56903 28.3404 0 26.411 0C24.4815 0 22.9136 1.56893 22.9136 3.4974C22.9136 5.42588 24.4827 6.99481 26.411 6.99481Z"
                                    fill="white" />
                                <path
                                    d="M3.49805 18.2016C5.42653 18.2016 6.99578 16.6331 6.99578 14.7043C6.99578 12.7754 5.42653 11.2066 3.49805 11.2066C1.56958 11.2066 0 12.7755 0 14.7043C0 16.6331 1.56958 18.2016 3.49805 18.2016Z"
                                    fill="white" />
                                <path
                                    d="M14.8172 18.2016C16.7454 18.2016 18.3146 16.6331 18.3146 14.7043C18.3146 12.7754 16.7467 11.2066 14.8172 11.2066C12.8881 11.2066 11.3198 12.7754 11.3198 14.7043C11.3198 16.6331 12.8888 18.2016 14.8172 18.2016Z"
                                    fill="white" />
                                <path
                                    d="M26.3205 18.2016C28.2494 18.2016 29.8179 16.6331 29.8179 14.7043C29.8179 12.7754 28.2494 11.2066 26.3205 11.2066C24.3916 11.2066 22.8218 12.7754 22.8218 14.7043C22.8218 16.6331 24.391 18.2016 26.3205 18.2016Z"
                                    fill="white" />
                                <path
                                    d="M3.57813 22.3786C1.64965 22.3786 0.0800781 23.9471 0.0800781 25.876C0.0800781 27.8041 1.64965 29.3733 3.57813 29.3733C5.50661 29.3733 7.07543 27.8049 7.07543 25.876C7.07543 23.9471 5.50661 22.3786 3.57813 22.3786Z"
                                    fill="white" />
                                <path
                                    d="M14.898 22.3786C12.9694 22.3786 11.3999 23.9471 11.3999 25.876C11.3999 27.8041 12.9688 29.3733 14.898 29.3733C16.8261 29.3733 18.3953 27.8049 18.3953 25.876C18.3953 23.9471 16.8261 22.3786 14.898 22.3786Z"
                                    fill="white" />
                                <path
                                    d="M26.4002 22.3786C24.4721 22.3786 22.9028 23.9471 22.9028 25.876C22.9028 27.8041 24.4721 29.3733 26.4002 29.3733C28.3291 29.3733 29.8976 27.8049 29.8976 25.876C29.8976 23.9471 28.3284 22.3786 26.4002 22.3786Z"
                                    fill="white" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="bg-red category-nav-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    @php
                        $categoriesListMenu = App\Helper::getCategoriesNav(true);
                        $categoriesList = App\Helper::getCategoriesNav();
                    @endphp

                    <ul class="category-dropdown-menu category-nav-list1">
                        @foreach ($categoriesListMenu as $categoriesListMenuSingle)
                            <li>
                                <a href="{{ route('category', [$categoriesListMenuSingle['slug']]) }}">
                                    {{ $categoriesListMenuSingle->name }}
                                </a>
                            </li>
                        @endforeach

                        <li class="category-dropdown position-relative">
                            <button type="button" class="category-dropdown-btn fw-bold" aria-expanded="false">
                                More
                                <span class="ms-1">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </button>

                            <div class="category-dropdown-box">
                                <ul class="category-more-list">
                                    @foreach ($categoriesList as $category)
                                        <li>
                                            <a href="{{ route('category', [$category['slug']]) }}">
                                                <span class="avatar-icon">
                                                    @if (!empty($category->image))
                                                        <img src="{{ asset('storage/categories/' . $category->id . '/' . $category->image) }}"
                                                            alt="{{ $category->image_alt ?: $category->name }}">
                                                    @else
                                                        <i class="fa-solid fa-layer-group"></i>
                                                    @endif
                                                </span>
                                                <span>{{ $category->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header> <!--header section end-->

<!--offcanvas menu start-->
<div class="offcanvas_menu position-fixed">
    <div class="tt-short-info d-none d-md-none d-lg-none d-xl-block">
        <button class="offcanvas-close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
        <a href="#" class="logo-wrapper d-inline-block mb-5"><img class="img-fluid drawer-logo"
                src="{{ App\Helper::getLightLogo() }}" alt="logo" /></a>
        <div class="offcanvas-content">
            <h4 class="mb-4">About Us</h4>
            <p>
                Explain to you how all this mistaken denouncing pleasure and praising pain was born and we will give you
                a complete account of the system, and expound the actual teachings.
            </p>
            <p>
                Mistaken denouncing pleasure and praising pain was born and we will give you complete account of the
                system expound.
            </p>
            <a href="{{ route('about') }}" class="btn btn-primary mt-4">About Us</a>
        </div>
        <div class="offcanvas-contact mt-5">
            <h5 class="mb-20">Contact Info</h5>
            <address>
                {{-- {!!$config['address']!!} <br />
                <a href="tel:{{$config['phone']}}">{{$config['phone']}}</a> <br /> --}}
                <a href="mailto:{{ $config['email'] }}">{{ $config['email'] }}</a>
            </address>
        </div>

        @if (count($config['social']) > 0 &&
                (($config['social']['facebook'] != '' && $config['social']['facebook'] != '#') ||
                    ($config['social']['instagram'] != '' && $config['social']['instagram'] != '#') ||
                    ($config['social']['twitter'] != '' && $config['social']['twitter'] != '#') ||
                    ($config['social']['pinterest'] != '' && $config['social']['pinterest'] != '#') ||
                    ($config['social']['youtube'] != '' && $config['social']['youtube'] != '#')))
            <div class="social-contact offcanvas_social mt-4">
                @if ($config['social']['facebook'] != '' && $config['social']['facebook'] != '#')
                    <a target="_blank" aria-label="Visit us on Facebook"
                        href="{{ $config['social']['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                @endif

                @if ($config['social']['instagram'] != '' && $config['social']['instagram'] != '#')
                    <a target="_blank" aria-label="Visit us on instagram"
                        href="{{ $config['social']['instagram'] }}"><i class="fab fa-instagram"></i></a>
                @endif

                @if ($config['social']['twitter'] != '' && $config['social']['twitter'] != '#')
                    <a target="_blank" aria-label="Visit us on twitter" href="{{ $config['social']['twitter'] }}"><i
                            class="fab fa-twitter"></i></a>
                @endif

                @if ($config['social']['pinterest'] != '' && $config['social']['pinterest'] != '#')
                    <a target="_blank" aria-label="Visit us on pinterest"
                        href="{{ $config['social']['pinterest'] }}"><i class="fab fa-pinterest"></i></a>
                @endif

                @if ($config['social']['youtube'] != '' && $config['social']['youtube'] != '#')
                    <a target="_blank" aria-label="Visit us on youtube" href="{{ $config['social']['youtube'] }}"><i
                            class="fab fa-youtube"></i></a>
                @endif

            </div>

        @endif

    </div>
    <div class="mobile-menu d-md-block d-lg-block d-xl-none">
        <button class="offcanvas-close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
        <a href="#" class="d-inline-block mb-5"><img class="img-fluid drawer-logo"
                src="{{ App\Helper::getLightLogo() }}" alt="logo" /></a>

        <form class="search-form d-flex align-items-center poposition-relative" action="{{ route('products') }}">
            <input type="text" placeholder="Search products..." class="w-100" name="keyword" inputmode="search"
                autocomplete="off" data-smart-search="true"
                value="@if (isset($_GET['keyword'])) {{ $_GET['keyword'] }} @endif">
            <div class="search-loader">
                <img src="{{ URL::asset('frontend/img/image-loading.gif') }}" height="30" alt="Loading..." />
            </div>
            <button id="search-btn-w" class="submit-icon-btn-secondary" type="submit" aria-label="Search"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <nav class="mobile-menu-wrapper mt-4">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('about') }}">About Us</a>
                </li>
                <li>
                    <a href="{{ route('blogs') }}">Blog</a>
                </li>
                <li>
                    <a href="{{ route('products') }}">Products</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>
        </nav>
        <div class="contact-info mt-8">
            {{-- <h5 class="mb-20">Contact Info</h5> --}}
            <address>
                {{-- {!!$config['address']!!}<br />
                <a href="tel:+8801682648101">{{$config['phone']}}</a> <br /> --}}
                <a href="mailto:info@example.com">{{ $config['email'] }}</a>
            </address>

            @if (count($config['social']) > 0 &&
                    (($config['social']['facebook'] != '' && $config['social']['facebook'] != '#') ||
                        ($config['social']['instagram'] != '' && $config['social']['instagram'] != '#') ||
                        ($config['social']['twitter'] != '' && $config['social']['twitter'] != '#') ||
                        ($config['social']['pinterest'] != '' && $config['social']['pinterest'] != '#') ||
                        ($config['social']['youtube'] != '' && $config['social']['youtube'] != '#')))
                <div class="social-contact">

                    @if ($config['social']['facebook'] != '' && $config['social']['facebook'] != '#')
                        <a target="_blank" aria-label="Visit us on Facebook"
                            href="{{ $config['social']['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                    @endif

                    @if ($config['social']['instagram'] != '' && $config['social']['instagram'] != '#')
                        <a target="_blank" aria-label="Visit us on instagram"
                            href="{{ $config['social']['instagram'] }}"><i class="fab fa-instagram"></i></a>
                    @endif

                    @if ($config['social']['twitter'] != '' && $config['social']['twitter'] != '#')
                        <a target="_blank" aria-label="Visit us on twitter"
                            href="{{ $config['social']['twitter'] }}"><i class="fab fa-twitter"></i></a>
                    @endif

                    @if ($config['social']['pinterest'] != '' && $config['social']['pinterest'] != '#')
                        <a target="_blank" aria-label="Visit us on pinterest"
                            href="{{ $config['social']['pinterest'] }}"><i class="fab fa-pinterest"></i></a>
                    @endif

                    @if ($config['social']['youtube'] != '' && $config['social']['youtube'] != '#')
                        <a target="_blank" aria-label="Visit us on youtube"
                            href="{{ $config['social']['youtube'] }}"><i class="fab fa-youtube"></i></a>
                    @endif

                </div>

            @endif

        </div>
    </div>
</div>
<!--offcanvas menu end-->
