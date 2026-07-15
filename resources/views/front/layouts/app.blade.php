<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!--required meta tags-->
    <meta charset="utf-8">

    {{-- <meta http-equiv="x-ua-compatible" content="ie=edge"> --}}

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $routeKey = Route::current()->uri();
        $seo = App\Helper::getSeoValues();
    @endphp

    {{-- @if ($routeKey == 'product/{slug}' && isset($product) && $product->seo_title != null && $product->seo_description != null && $product->seo_keywords != null) --}}
    @if (
        $routeKey == 'product/{slug}' &&
            isset($product) &&
            $product->seo_title != null &&
            $product->seo_description != null)
        <title>{{ $product['seo_title'] }} | TheCanadaFoods.com</title>
        <meta name="keywords" content="{{ $product['seo_keywords'] }}">
        <meta name="description" content="{{ $product['seo_description'] }}">
        {{-- @elseif($routeKey == 'blog/{slug}' && isset($blog) && $blog->seo_title != null && $blog->seo_description != null && $blog->seo_keywords != null) --}}
    @elseif($routeKey == 'blog/{slug}' && isset($blog) && $blog->seo_title != null && $blog->seo_description != null)
        <title>{{ $blog['seo_title'] }} | TheCanadaFoods.com</title>
        <meta name="keywords" content="{{ $blog['seo_keywords'] }}">
        <meta name="description" content="{{ $blog['seo_description'] }}">
    @elseif($seo)
        @if ($routeKey == 'product/{slug}' && isset($product))
            <title>{{ $product->name }} | TheCanadaFoods.com</title>
        @else
            <title>{{ $seo['seo_title'] }} | TheCanadaFoods.com</title>
        @endif
        <meta name="keywords" content="{{ $seo['seo_keywords'] }}">
        <meta name="description" content="{{ $seo['seo_description'] }}">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ request()->url() }}" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ App\Helper::getFavicon() }}">

    <!-- Google Fonts were previously loaded via @import inside main.css, which blocks CSSOM
    construction until a second round-trip resolves. Preconnecting + linking them directly here
    lets the browser discover and start the font CSS fetch immediately from the HTML. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap">

    <!-- Warm up connections to third-party origins used further down the page (analytics/tag
    manager scripts, lazysizes CDN) so their TCP+TLS handshake overlaps with the initial HTML/CSS
    fetch instead of starting cold when the browser first reaches those <script> tags. -->
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://static.hotjar.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- The header logo renders on every page above the fold and is frequently the LCP element
    on non-homepage routes (the homepage's own banner image is preloaded separately). -->
    <link rel="preload" as="image" href="{{ App\Helper::getLightLogo() }}" fetchpriority="high">

    <!--build:css-->
    <link rel="stylesheet" href="{{ URL::asset('frontend/css/main.min.css') }}">
    <!-- endbuild -->

    <!-- toastr -->
    <link rel="stylesheet" href="{{ URL::asset('frontend/plugins/toastr/toastr.min.css') }}" media="print"
        onload="this.media='all'">


    <link rel="stylesheet" href="{{ URL::asset('frontend/css/custom.min.css') }}">


    @php
        if ($routeKey == 'product/{slug}') {
            $facebookPixel = App\Helper::getFacebookPixelTags($product);
        }
    @endphp

    @if (isset($facebookPixel))
        {!! $facebookPixel['openGraph'] !!}
    @endif

    @if (isset($facebookPixel))
        {!! $facebookPixel['script'] !!}
    @endif
    <meta name="google-site-verification" content="vFRQgvViAfwPh8RPTPcYhRJTfq-hOaRbnftOZa1l4vw" />

    <!-- Analytics/tag-manager scripts don't affect what the user sees, so none of them need to
    compete with the hero image, CSS, or app JS for bandwidth/main-thread time during the initial
    render. Loading them after window "load" (+ a short delay) keeps them out of LCP/TBT entirely
    while still firing well within a normal page visit. -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }

        function loadDeferredAnalytics() {
            // Google tag (gtag.js) - GA4
            var gtagScript1 = document.createElement('script');
            gtagScript1.async = true;
            gtagScript1.src = 'https://www.googletagmanager.com/gtag/js?id=G-HYCT01WS4J';
            document.head.appendChild(gtagScript1);
            gtag('js', new Date());
            gtag('config', 'G-HYCT01WS4J');

            // Google tag (gtag.js) - Ads
            var gtagScript2 = document.createElement('script');
            gtagScript2.async = true;
            gtagScript2.src = 'https://www.googletagmanager.com/gtag/js?id=AW-17043332732';
            document.head.appendChild(gtagScript2);
            gtag('config', 'AW-17043332732');

            // Google Tag Manager
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-NZDDK849');

            // Hotjar Tracking Code for https://thecanadafoods.com/
            (function(h, o, t, j, a, r) {
                h.hj = h.hj || function() {
                    (h.hj.q = h.hj.q || []).push(arguments)
                };
                h._hjSettings = {
                    hjid: 6406480,
                    hjsv: 6
                };
                a = o.getElementsByTagName('head')[0];
                r = o.createElement('script');
                r.async = 1;
                r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');

            // Ahrefs analytics
            var ahrefsScript = document.createElement('script');
            ahrefsScript.async = true;
            ahrefsScript.src = 'https://analytics.ahrefs.com/analytics.js';
            ahrefsScript.setAttribute('data-key', 'lhi2tz+unRZ3c2VoIMOavw');
            document.head.appendChild(ahrefsScript);
        }

        if (document.readyState === 'complete') {
            setTimeout(loadDeferredAnalytics, 3000);
        } else {
            window.addEventListener('load', function() {
                setTimeout(loadDeferredAnalytics, 3000);
            });
        }
    </script>


@if ($routeKey == 'product/{slug}' && isset($product))

@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        '@id' => url()->current(),
        'name' => $product->name,
        'categories' => $product->categories->pluck('name')->values(),
        'image' => [
            asset('storage/products/' . $product->id . '/' . $product->image)
        ],
        'description' => strip_tags($product->seo_description ?: ($product->short_description ?: $product->description)),
        'sku' => $product->sku,
        'url' => url()->current(),
        'offers' => [
            '@type' => 'Offer',
            'url' => url()->current(),
            'priceCurrency' => 'CAD',
            'price' => number_format($product->price, 2, '.', ''),
            'availability' => 'https://schema.org/' . ($product->stock > 0 ? 'InStock' : 'OutOfStock'),
            'itemCondition' => 'https://schema.org/NewCondition',
        ],
    ];

    if (!empty($product->brand_name)) {
        $schema['brand'] = [
            '@type' => 'Brand',
            'name' => $product->brand_name,
        ];
    }

    if ($product->total_rating > 0) {
        $schema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' =>4.8,
            'reviewCount' => 100,
            'bestRating' => 5,
            'worstRating' => 1,
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@endif


    @yield('head')

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NZDDK849" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @php
        $config = App\Helper::getWebsiteConfig();
        //print '<pre>'; print_r($config); die;
    @endphp

    @if (isset($facebookPixel))
        {!! $facebookPixel['jsonLd'] !!}
    @endif

    <div class="loader d-none"></div>

    <!--preloader start-->
    {{-- <div id="preloader">
        <img src="{{ URL::asset('frontend/img/preloader.gif') }}" alt="preloader" width="450" class="img-fluid">
    </div> --}}
    <!--preloader end-->


    <!--main content wrapper start-->
    <div class="main-wrapper">


        @include('front.layouts.header')



        @yield('content')




        @include('front.layouts.footer')


        <div class="mobile-toolbar d-block d-md-none d-lg-none">
            <div class="d-table table-layout-fixed w-100">

                <div class="d-table-cell mobile-toolbar-item mobile-menu-toggle">
                    <span class="mobile-toolbar-icon"><i class="fas fa-bars"></i></span><span
                        class="mobile-toolbar-label">Categories
                    </span>
                </div>

                {{-- <div class="d-table-cell mobile-toolbar-item" href="{{route('home')}}">
                    <span class="mobile-toolbar-icon"><i class="fas fa-bars"></i></span><span
                    class="mobile-toolbar-label">Home
                    </span>
                </div> --}}

                @guest
                    <a class="d-table-cell mobile-toolbar-item" href="{{ route('login') }}">
                        <span class="mobile-toolbar-icon">
                            <img width="24" height="24" src="{{ URL::asset('frontend/img/icons/user.png') }}"
                                alt="profile">
                        </span>
                        <span class="mobile-toolbar-label">Account</span>
                    </a>
                @endguest

                @auth('web')
                    <a class="d-table-cell mobile-toolbar-item" href="{{ route('profile') }}">
                        <span class="mobile-toolbar-icon">
                            <img width="24" height="24" src="{{ URL::asset('frontend/img/icons/user.png') }}"
                                alt="profile">
                        </span>
                        <span class="mobile-toolbar-label">Profile</span>
                    </a>
                @endauth


                <a class="d-table-cell mobile-toolbar-item" href="{{ route('wishlist') }}">
                    <span class="mobile-toolbar-icon mobile-cart-icon">
                        <img width="24" height="24" src="{{ URL::asset('frontend/img/icons/wishlist.png') }}"
                            alt="wishlist">
                        <small class="badge bg-primary wishlist-count">0</small>
                    </span>
                    <span class="mobile-toolbar-label">Wishlist</span>
                </a>

                <a class="d-table-cell mobile-toolbar-item" href="{{ route('cart') }}">
                    <span class="mobile-toolbar-icon mobile-cart-icon">
                        <img width="24" height="24" src="{{ URL::asset('frontend/img/icons/cart.png') }}"
                            alt="cart">
                        <small class="badge bg-primary cart-count">0</small>
                    </span>
                    {{-- <span class="mobile-toolbar-label cart-total">$0.00</span> --}}
                    <span class="mobile-toolbar-label">Cart</span>
                </a>



            </div>
        </div>
        <div class="offcanvas-left-menu position-fixed">
            <div class="mobile-menu">
                <button class="offcanvas-close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
                <a href="{{ route('home') }}" class="d-inline-block mb-5">
                    <img class="header-logo" src="{{ App\Helper::getLightLogo() }}" alt="logo">
                </a>
                <nav class="mobile-menu-wrapper">
                    <ul>
                        @php
                            $categoriesListMenu = App\Helper::getCategoriesNav(true);
                        @endphp

                        @foreach ($categoriesListMenu as $category)
                            <li
                                class="ps-3 dropdown-submenu {{ $category->subcategories->isNotEmpty() ? 'has-submenu' : '' }}">

                                <a href="{{ route('category', [$category->slug]) }}"
                                    class="d-flex align-items-center justify-content-between {{ $category->subcategories->isNotEmpty() ? 'dropdown-toggle' : '' }}"
                                    @if ($category->subcategories->isNotEmpty()) aria-expanded="false"
                   onclick="event.preventDefault();" @endif>

                                    <span>{{ $category->name }}</span>
                                    @if ($category->subcategories->isNotEmpty())
                                        <i class="fa-solid fa-chevron-right toggle-icon"></i>
                                    @endif

                                </a>

                                @if ($category->subcategories->isNotEmpty())
                                    <ul class="dropdown-menu subcategory-dropdown mobile-mega-panel">
                                        <li class="mobile-mega-title">Shop {{ $category->name }}</li>
                                        @foreach ($category->subcategories as $subcategory)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('category', [$subcategory->slug]) }}">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="mobile-mega-viewall">
                                            <a href="{{ route('category', [$category->slug]) }}">
                                                View all {{ $category->name }} <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                @endif

                            </li>
                        @endforeach

                    </ul>
                </nav>
            </div>
        </div> <!--footer section end-->


        @include('front.layouts.modals')


        {{-- @php $allProducts = App\Helper::allProducts(); @endphp
        <div class="d-none" id="autocomp">
            @php print_r(json_encode($allProducts)); @endphp
        </div> --}}


    </div>



    <!--scroll bottom to top button start-->
    <button class="scroll-top-btn">
        <i class="fa-regular fa-hand-pointer"></i>
    </button>
    <!--scroll bottom to top button end-->
    <!--build:js-->
    <script src="{{ URL::asset('frontend/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/parallax-scroll.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/isotop.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/countdown.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/range-slider.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/waypoints.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/vendors/typer.js') }}"></script>

    <script src="{{ URL::asset('frontend/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/plugins/typeahead/typeahead.js') }}"></script>

    <script src="{{ URL::asset('frontend/js/app.min.js') }}"></script>
    <!--endbuild-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

    <script src="{{ URL::asset('frontend/js/custom.min.js') }}"></script>

    <script>
        var site_url = "{{ url('/') }}";
        var site_currency = "{{ $config['currency_sign'] }}";

        function copyCoupon() {
            const code = document.getElementById('couponCode').innerText;
            navigator.clipboard.writeText(code).then(() => {
                toastr.success('Coupon code copied: ' + code, 'Success');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>


    @stack('scripts')

    @if (Session::has('message'))

        @if (Session::get('result') == true)
            <script type="text/javascript">
                toastr.success("{{ Session::get('message') }}", 'Success');
            </script>
        @endif

        @if (Session::get('result') == false)
            <script type="text/javascript">
                toastr.error("{{ Session::get('message') }}", 'Error');
            </script>
        @endif

    @endif

    @if (isset($facebookPixel))
        {!! $facebookPixel['schema'] !!}
    @endif

</body>

</html>
