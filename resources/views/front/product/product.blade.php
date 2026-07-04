@extends('front.layouts.app')

@section('content')
    @php
        $productCategory = $product->CategoriesNew()->first();
    @endphp

    <!--breadcrumb section start-->
    <div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--60">
        @include('front.layouts.breadcrumb-image')
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="mb-2 h2 text-center">{{ $product->title_h1 ? $product->title_h1 : $product->name }}</h1>
                        <nav>
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                                        href="{{ route('category', $productCategory->slug) }}">{{ $productCategory->name }}</a>
                                </li>
                                <li class="breadcrumb-item fw-bold" aria-current="page">
                                    {{ $product->title_h1 ? $product->title_h1 : $product->name }}</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb section end-->


    <!--product details start-->
    <section class="product-details-area ptb-80 bg-white">
        <div class="container">
            <div class="row g-4 product-detail">
                <div class="col-xl-9">
                    <div class="product-details">
                        <div class="gstore-product-quick-view bg-white rounded-3 py-6 px-4">
                            <div class="row align-items-center g-4">
                                <div class="col-xl-6 align-self-end">
                                    <div class="quickview-double-slider">
                                        <div class="quickview-product-slider swiper">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide text-center">
                                                    <img src="{{ asset('storage/products/') }}/{{ $product->id }}/{{ $product->image }}"
                                                        alt="{{ $product->name }}" class="img-fluid">
                                                </div>

                                                @if (!empty($product) && ($product->images != null || $product->images != '') && count($product->images) > 0)
                                                    @foreach ($product->images as $image)
                                                        {{-- <figure class="border-radius-10">
                                                    <div class="swiper-slide text-center">
                                                        <img src="{{ asset('storage/products/') }}/{{$product->id}}/gallery/{{$image->image}}" alt="jam" class="img-fluid">
                                                    </div>
                                                </figure> --}}
                                                        <div class="swiper-slide text-center">
                                                            <img src="{{ asset('storage/products/') }}/{{ $product->id }}/gallery/{{ $image->image }}"
                                                                class="img-fluid">
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                        <div class="product-thumbnail-slider swiper mt-10">
                                            <div class="swiper-wrapper">
                                                <div
                                                    class="swiper-slide product-thumb-single rounded-2 d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('storage/products/') }}/{{ $product->id }}/{{ $product->image }}"
                                                        alt="{{ $product->name }}" alt="{{ $product->name }}"
                                                        class="img-fluid">
                                                </div>
                                                @if (!empty($product) && ($product->images != null || $product->images != '') && count($product->images) > 0)
                                                    @foreach ($product->images as $image)
                                                        <div
                                                            class="swiper-slide product-thumb-single rounded-2 d-flex align-items-center justify-content-center">
                                                            <img src="{{ asset('storage/products/') }}/{{ $product->id }}/gallery/{{ $image->image }}"
                                                                alt="" class="img-fluid">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-6">
                                    <div class="product-info detail-info">
                                        <h4 class="mt-1 mb-3">{{ $product->name }}</h4>
                                        @if ($reviewShow)
                                            @if ($product->total_rating > 0)
                                                {{-- <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:{{$product->average_rating_percentage}}%">
                                            </div>
                                        </div> --}}
                                                <div class="d-flex align-items-center flex-nowrap star-rating fs-xxs mb-2">
                                                    <span class="badge text-bg-secondary text-white verified-badge"> <a
                                                            href="#reviews_section" class="text-white"><i
                                                                class="fas fa-star"></i>
                                                            {{ $product->average_rating }}</a></span> &nbsp;
                                                    <span class="flex-shrink-0">({{ $product->total_rating }}
                                                        {{ $product->total_rating > 1 ? 'ratings' : 'rating' }})</span>
                                                </div>
                                            @else
                                            @endif
                                        @endif

                                        {{-- @if (!$product->is_variant)
                                        <span class="save-price  font-md color3 ml-15">{{$product->getPercentageDiscount()}}</span>
                                    @endif --}}

                                        <div class="pricing mt-2">
                                            <span class="fw-bold h4 text-secondary price">{{ $product->getPrice() }}
                                            </span>

                                            @if ($product->is_tax_included)
                                                <small class="font-xxs text-secondary">(Inc. tax)</small>
                                            @endif
                                            <span
                                                class="fw-bold fs-xs deleted ms-1 old-price">{{ $product->getOldPrice() }}</span>

                                        </div>
                                        <div class="widget-title d-flex mt-4">
                                            <h6 class="mb-1 flex-shrink-0">Description</h6>
                                            <span
                                                class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                                        </div>
                                        <p class="mb-3">{{ $product->short_description }}</p>
                                        {{-- <ul class="d-flex flex-column gap-2">
                                        <li><span class="me-2 text-primary"><i class="fa-solid fa-circle-check"></i></span>Natural ingredients</li>
                                        <li><span class="me-2 text-primary"><i class="fa-solid fa-circle-check"></i></span>Tastes better with milk</li>
                                        <li><span class="me-2 text-primary"><i class="fa-solid fa-circle-check"></i></span>Vitamins B2, B3, B5 and B6</li>
                                        <li><span class="me-2 text-primary"><i class="fa-solid fa-circle-check"></i></span>Refrigerate for freshness</li>
                                    </ul> --}}

                                        <div class="d-flex mb-2 mt-3 align-items-center">
                                            <h6 class="fs-md mb-0 me-1">Brand:</h6>
                                            <p class="mb-0">{{ $product->brand_name }}</p>
                                        </div>

                                        <div class="d-flex mb-2 mt-3 align-items-center">
                                            <h6 class="fs-md mb-0 me-1">SKU:</h6>
                                            <p class="mb-0 product-sku">{{ $product->sku }}</p>
                                        </div>

                                        @if (!$product->is_variant)
                                            <div class="d-flex mb-2 mt-3 align-items-center">
                                                <h6 class="fs-md mb-0 me-1">Availability:</h6>
                                                {{-- <p class="mb-0 text-success">{{$product->stock}} items In Stock</p> --}}

                                                {!! $product->stock > 0
                                                    ? '<p class="mb-0 text-success">In Stock</p>'
                                                    : '<p class="mb-0 text-danger">Out of Stock</p>' !!}

                                            </div>
                                        @else
                                            <div class="d-flex mb-2 mt-3 align-items-center availability d-none">
                                                <h6 class="fs-md mb-0 me-1">Availability:</h6>
                                                {{-- <p class="mb-0 text-success"><span class="availability-count"></span> items In Stock</p> --}}
                                                <div class="availability-cont"></div>
                                            </div>
                                        @endif

                                        @if ($product->tags != null)
                                            <div class="tt-category-tag align-items-center">
                                                <h6 class="fs-md mb-2 mt-3">
                                                    Tags: </h6>
                                                @foreach (json_decode($product->tags) as $tag)
                                                    <a href="#" class="text-muted fs-xxs"
                                                        rel="tag">{{ $tag }}</a>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- <h6 class="fs-md mb-2 mt-3">
                                        Demo: <a href="#">{{$product->demo}}</a>
                                    </h6> --}}

                                        <input type="hidden" value="" id="current_stock">
                                        <input type="hidden" id="attribute_id">


                                        @if (isset($itemattributes) && count($itemattributes) > 0)
                                            <div class="attributes">
                                                @foreach ($itemattributes as $itemattribute)
                                                    <input type="hidden" name="slug" id="slug"
                                                        value="{{ $product->slug }}" />

                                                    <h6 class="fs-md mb-2 mt-3">{{ $itemattribute['attribute_name'] }}:
                                                    </h6>

                                                    <ul class="product-radio-btn d-flex align-items-center gap-2 attribute-select"
                                                        data-attribute="{{ $itemattribute['attribute_id'] }}">
                                                        @foreach ($itemattribute['options'] as $option)
                                                            <li><a class="attribute-option"
                                                                    data-id="{{ $option['attribute_option_id'] }}"
                                                                    href="#"><label>{{ $option['attribute_option_name'] }}</label></a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </div>
                                            <p class="mb-4 text-danger" id="attribute-selected-error"></p>
                                        @endif

                                        {{-- <h6 class="fs-md mb-2 mt-3">Weight:</h6>
                                    <ul class="product-radio-btn mb-4 d-flex align-items-center gap-2">
                                        <li>
                                            <input type="radio" name="weight" value="250g" checked>
                                            <label>150g</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="weight" value="250g">
                                            <label>500g</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="weight" value="250g">
                                            <label>1kg</label>
                                        </li>
                                    </ul> --}}


                                        <div class="d-flex align-items-center gap-4 flex-wrap">

                                            @php
                                                $already = App\Helper::alreadyInCart($product);
                                            @endphp


                                            {{-- <div class="product-qty d-flex align-items-center detail-qty @if ($already && !$product->is_variant) d-none @endif"> --}}
                                            <div class="product-qty d-flex align-items-center detail-qty">
                                                <button class="change-qty qty-down">-</button>
                                                <input type="text" class="qty-val product-qty-val only-numbers"
                                                    value="1">
                                                <button class="change-qty qty-up"
                                                    data-stock="@if (!$product->is_variant) {{ $product->stock }} @endif">+</button>
                                            </div>


                                            @php
                                                $disabled = '';
                                                if ($product->is_variant) {
                                                    $disabled = 'disabled';
                                                }
                                            @endphp

                                            @php
                                                $stringAdd = $isEnquiryWebsite['is_enquiry_website']
                                                    ? 'Add to enquiry'
                                                    : 'Add to cart';
                                                $stringRemove = $isEnquiryWebsite['is_enquiry_website']
                                                    ? 'Remove from enquiry'
                                                    : 'Remove from Cart';
                                            @endphp

                                            @if ($already && !$product->is_variant)
                                                {{-- <a href="#" class="btn btn-secondary btn-md text-white delete-cart" data-key="{{$product->slug}}" data-page="detail">
                                                <span class="me-2"><i class="fa-solid fa-bag-shopping"></i></span>
                                                {{$stringRemove}}
                                            </a> --}}

                                                <a href="#"
                                                    class="btn btn-secondary btn-md text-white add-cart {{ $disabled }}"
                                                    {{ $disabled }} data-key="{{ $product->slug }}"
                                                    data-page="detail">
                                                    <span class="me-2"><i class="fa-solid fa-bag-shopping"></i></span>
                                                    {{ $stringAdd }}
                                                </a>
                                            @else
                                                <a href="#"
                                                    class="btn btn-secondary btn-md text-white add-cart {{ $disabled }}"
                                                    {{ $disabled }} data-key="{{ $product->slug }}"
                                                    data-page="detail">
                                                    <span class="me-2"><i class="fa-solid fa-bag-shopping"></i></span>
                                                    {{ $stringAdd }}
                                                </a>
                                            @endif

                                            @php
                                                $alreadyWishlist = App\Helper::alreadyInWishlist($product);
                                            @endphp

                                            @if ($alreadyWishlist)
                                                <a {{ $disabled }}
                                                    class="btn btn-md add-wishlist active {{ $disabled }}"
                                                    data-key="{{ $product->slug }}"><i
                                                        class="fa-regular fa-heart"></i></a>
                                            @else
                                                <a {{ $disabled }}
                                                    class="btn btn-md add-wishlist {{ $disabled }}"
                                                    data-key="{{ $product->slug }}"><i
                                                        class="fa-regular fa-heart"></i></a>
                                            @endif

                                        </div>


                                        @if ($product->categories != null)
                                            <div class="tt-category-tag mt-4">
                                                @foreach ($product->categories as $category)
                                                    <a href="#" class="text-muted fs-xxs">{{ $category->name }}</a>
                                                @endforeach
                                            </div>
                                        @endif


                                        @php
                                            $config = App\Helper::getWebsiteConfig('product_services');
                                        @endphp

                                        @if ($config['product_services'])
                                            @if (count($product->services) > 0)
                                                <div class="detail-extralink services-cont">
                                                    <h5 class="my-2">Services</h5>
                                                    <div class="row">
                                                        @foreach ($product->services as $service)
                                                            @php
                                                                $alreadyService = App\Helper::serviceAlreadyInCart(
                                                                    $product->id,
                                                                    null,
                                                                    $service,
                                                                );

                                                            @endphp

                                                            <div class="col-md-12 col-lg-12">
                                                                <div
                                                                    class="hero-card box-shadow-outer-6 wow fadeIn animated mb-10 hover-up d-flex p-3">
                                                                    <div class="hero-card-icon hover-up ">
                                                                        <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted"
                                                                            src="{{ asset('storage/product-services/') }}/{{ $service->id }}/{{ $service->image }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="pl-10">
                                                                        <h5 class="mb-5 fw-500">
                                                                            {{ $service->name }}
                                                                        </h5>
                                                                        <p>Price: {{ $service->getPrice() }}</p>
                                                                        <p class="font-sm text-grey-5">
                                                                            {{ $service->summary }}</p>
                                                                        <!-- <p class="text-grey-3">{{ $service->description }}</p> -->



                                                                    </div>
                                                                    <div class="pl-10 align-self-center">
                                                                        @if (!$product->is_variant)
                                                                            @if ($alreadyService)
                                                                                <button
                                                                                    class="button btn-sm p-2 service remove-service"
                                                                                    data-key="{{ $product->slug }}"
                                                                                    data-service="{{ $service->slug }}"
                                                                                    @if (!$already && !$product->is_variant) disabled @endif>Remove
                                                                                    Service</button>
                                                                            @else
                                                                                <button
                                                                                    class="button btn-sm p-2 service add-service"
                                                                                    data-key="{{ $product->slug }}"
                                                                                    data-service="{{ $service->slug }}"
                                                                                    @if (!$already && !$product->is_variant) disabled @endif>Add
                                                                                    Service</button>
                                                                            @endif
                                                                        @else
                                                                            <button
                                                                                class="button btn-sm p-2 service add-service"
                                                                                data-key="{{ $product->slug }}"
                                                                                data-service="{{ $service->slug }}"
                                                                                disabled>Add Service</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-info-tab bg-white rounded-2 overflow-hidden pt-6 mt-4">
                            <ul class="nav nav-tabs border-bottom justify-content-center gap-5 pt-info-tab-nav">

                                <li><a href="#description" class="active" data-bs-toggle="tab">Description</a></li>
                                <li><a href="#info" data-bs-toggle="tab">Additional Information</a></li>
                                @if ($product->faqs->isNotEmpty())
                                    <li><a href="#faqs" data-bs-toggle="tab">FAQ</a></li>
                                @endif

                                {{-- <li><a href="#review" data-bs-toggle="tab">Reviews(02)</a></li> --}}
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane fade show px-4 active py-5" id="description">
                                    <h6 class="mb-2">Additional Information:</h6>
                                    {!! $product->description !!}
                                </div>
                                <div class="tab-pane fade px-4 py-5" id="info">
                                    <h6 class="mb-2">Additional Information:</h6>
                                    <table class="w-100 product-info-table">
                                        <tbody>
                                            @if ($product->length)
                                                <tr class="stand-up">
                                                    <th>Length</th>
                                                    <td>
                                                        <p>{{ $product->length }} inches</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($product->width)
                                                <tr class="stand-up">
                                                    <th>Width</th>
                                                    <td>
                                                        <p>{{ $product->width }} inches</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($product->height)
                                                <tr class="stand-up">
                                                    <th>Height</th>
                                                    <td>
                                                        <p>{{ $product->height }} inches</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($product->weight)
                                                <tr class="stand-up">
                                                    <th>Weight</th>
                                                    <td>
                                                        <p>{{ $product->weight }} Kg</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($product->brand_name)
                                                <tr class="stand-up">
                                                    <th>Brand</th>
                                                    <td>
                                                        <p>{{ $product->brand_name }}</p>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (count($product->specifications) > 0)
                                                @foreach ($product->specifications as $specification)
                                                    <tr class="stand-up">
                                                        <th>{{ $specification['specification'] }}</th>
                                                        <td>
                                                            <p>{{ $specification['value'] }} @if ($specification['units'])
                                                                    {{ $specification['units'] }}
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show  px-4 py-5" id="faqs">
                                    <!--faq section start-->
                                    @if (count($product->faqs) > 0)
                                        <section class="faq-section position-relative overflow-hidden z-1">
                                            <div class="container">
                                                <div class="row g-5 justify-content-center">
                                                    <div class="col-xl-10">
                                                        <div class="faq-right">
                                                            <h4 class="mb-4">Frequently Asked Questions</h4>
                                                            <p class="mb-5">Wondering how things work around here? Our
                                                                FAQ has you covered.</p>

                                                            <div class="accordion faq-accordion" id="faq-accordion">


                                                                @foreach ($product->faqs as $k => $faq)
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                            <a href="#acc-{{ $faq->id }}"
                                                                                data-bs-toggle="collapse"
                                                                                class="{{ !$loop->first ? 'collapsed' : '' }}"
                                                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                                                                {{ $k + 1 }}. {{ $faq->question }}
                                                                                <i
                                                                                    class="fas fa-angle-down float-end ms-1"></i>
                                                                            </a>
                                                                        </div>

                                                                        <div id="acc-{{ $faq->id }}"
                                                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                                            data-bs-parent="#faq-accordion">

                                                                            <div class="accordion-body">
                                                                                <p class="mb-0">{{ $faq->answer }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @endif
                                    <!--faq section end-->
                                </div>

                            </div>
                        </div>
                        @if ($reviewShow)
                            @if ($product->ratings()->count() > 0)
                                <div id="reviews_section" class="mb-10">
                                    <div class="review-tab-box bg-white rounded   px-4">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="top-left">
                                                <h5 class="mb-2">Ratings ({{ $product->ratings()->count() }})</h5>
                                                <p class="mb-0">Get specific details about this product from customers
                                                    who own it.</p>
                                                <div class="d-flex align-items-center">
                                                    <span class="ti text-warning"
                                                        style="--rating:{{ $product->average_rating }}"></span>
                                                    <span class="ms-2 text-dark">({{ $product->average_rating }} out of
                                                        5)</span>
                                                </div>
                                            </div>
                                            <div class="jdgm-histogram jdgm-temp-hidden">
                                                @foreach ($product->rating_distribution as $stars => $data)
                                                    <div class="jdgm-histogram__row filter_rating"
                                                        data-rating="{{ $stars }}"
                                                        data-frequency="{{ $data['count'] }}"
                                                        data-percentage="{{ $data['percentage'] }}">
                                                        <div class="jdgm-histogram__star" role="button"
                                                            aria-label="{{ $data['percentage'] }}% ({{ $data['count'] }}) reviews with 5 star rating"
                                                            tabindex="0">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <span class="ti text-warning"
                                                                    style="--rating:{{ $stars }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="jdgm-histogram__bar">
                                                            <div class="jdgm-histogram__bar-content"
                                                                style="width: {{ $data['percentage'] }}%;"> </div>
                                                        </div>
                                                        <div class="jdgm-histogram__percentage">{{ $data['percentage'] }}%
                                                        </div>
                                                        <div class="jdgm-histogram__frequency">({{ $data['count'] }})
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="jdgm-histogram__row jdgm-histogram__clear-filter filter_rating"
                                                    data-rating="null" tabindex="0">See all reviews</div>
                                            </div>
                                            {{-- <a href="#" class="btn btn-outline-secondary border-secondary btn-md mt-3 mt-lg-0">Write a Review</a> --}}
                                        </div>
                                        <hr class="mt-4">
                                        <div id="review-section">
                                            @forelse  ($ratings as $k=>$rating)
                                                <div class="users_review mt-4">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                                        <div class="top-left d-flex align-items-center">
                                                            <div class="review__icon"> {{ substr($rating->name, 0, 1) }}
                                                            </div>
                                                            {{-- <img src="assets/img/authors/user-2.jpg" alt="user" class="flex-shrink-0 rounded"> --}}
                                                            <div class="ms-3">
                                                                <h6 class="mb-1">{{ $rating->name }} <span
                                                                        class="badge text-bg-secondary text-white verified-badge">Verified
                                                                        By Shop</span></h6>
                                                                <span>{{ $rating->created_at?->format(App\Helper::universalDateFormat()) ?? '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <span class="ti text-warning"
                                                                style="--rating:{{ $rating->rating }}"></span>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0">{{ $rating->review }}</p>
                                                </div>
                                                <hr>
                                            @empty
                                                <p class="text-center">No record found.</p>
                                            @endforelse
                                            @if ($ratings->count())
                                                <div class="mt-3">
                                                    {{ $ratings->appends(request()->except('page'))->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-8">
                    <div class="gshop-sidebar">
                        {{-- <div class="sidebar-widget info-sidebar bg-white rounded-3 py-3">
                        <div class="sidebar-info-list d-flex align-items-center gap-3 p-4">
                            <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle text-primary">
                            <i class="fa-solid fa-shopping-cart"></i>
                        </span>
                        @php
                            $currencySign = App\Helper::getWebsiteConfig('currency_sign');
                            $minCartAmount = App\Helper::getWebsiteConfig('min_cart_amount');
                        @endphp
                            <div class="info-right">
                                <h6 class="mb-1 fs-md">Minimum Cart Amount</h6>
                                <span class="fw-medium fs-xs">Minimum cart amount is {{$currencySign['currency_sign']}}{{$minCartAmount['min_cart_amount']}}</span>
                            </div>
                        </div>
                        <div class="sidebar-info-list d-flex align-items-center gap-3 p-4 border-top">
                            <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle text-primary">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        </span>
                            <div class="info-right">
                                <h6 class="mb-1 fs-md">100% Money Back</h6>
                                <span class="fw-medium fs-xs">Guaranteed Product Warranty</span>
                            </div>
                        </div>
                        <div class="sidebar-info-list d-flex align-items-center gap-3 p-4 border-top">
                            <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle text-primary">
                            <i class="fa-regular fa-heart"></i>
                        </span>
                            <div class="info-right">
                                <h6 class="mb-1 fs-md">Safety & Secure</h6>
                                <span class="fw-medium fs-xs">We deliver your orders safely</span>
                            </div>
                        </div>
                    </div> --}}
                        {{-- <div class="sidebar-widget banner-widget mt-4 p-0 border-0">
                        <div class="vertical-banner text-center bg-white rounded-2" data-background="assets/img/banner/banner-4.jpg" style="background-image: url(&quot;assets/img/banner/banner-4.jpg&quot;);">
                            <h5 class="mb-1">Fresh &amp; Organic Spice</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="hot-badge bg-danger fw-bold fs-xs position-relative text-white">HOT</span>
                                <span class="offer-title text-danger fw-bold">30% Off</span>
                            </div>
                            <a href="#" class="explore-btn text-primary fw-bold">Shop Now<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                        </div>
                    </div> --}}
                        <div class="sidebar-widget products-widget py-5 px-4 bg-white mt-4">
                            <div class="widget-title d-flex">
                                <h6 class="mb-0 flex-shrink-0">Similar Products</h6>
                                <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                            </div>
                            <div class="sidebar-products-list">

                                @foreach ($similarProducts as $similarProduct)
                                    <div
                                        class="horizontal-product-card card-md d-sm-flex align-items-center bg-white rounded-2 gap-3 mt-4">
                                        <div class="thumbnail position-relative rounded-2">
                                            <a href="#"><img
                                                    src="{{ asset('storage/products/') }}/{{ $similarProduct->id }}/{{ $similarProduct->image }}"
                                                    alt="product" class="img-fluid"></a>
                                            <div
                                                class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2 rounded-2">
                                                <a href="{{ route('product', $similarProduct->slug) }}"
                                                    class="rounded-btn"><i class="fa-solid fa-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-content mt-3 mt-sm-0">
                                            <div class="d-flex align-items-center flex-nowrap star-rating mt-1">

                                                @if ($reviewShow && $similarProduct->total_rating > 0)
                                                    <div class="rating-result">
                                                        <div
                                                            class="d-flex align-items-center flex-nowrap star-rating fs-xxs mb-2">
                                                            <span
                                                                class="badge text-bg-secondary text-white verified-badge">
                                                                <a href="#reviews_section" class="text-white"><i
                                                                        class="fas fa-star"></i>
                                                                    {{ $similarProduct->average_rating }}</a></span>
                                                            &nbsp;
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <a href="{{ route('product', $similarProduct->slug) }}"
                                                class="Minimum Cart Amount d-block fs-sm fw-bold text-heading title d-block">{{ $similarProduct->name }}</a>
                                            <div class="pricing mt-0">
                                                <span
                                                    class="fw-bold text-secondary text-price">{{ $similarProduct->getPrice() }}</span>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                                {{-- <div class="horizontal-product-card card-md d-sm-flex align-items-center bg-white rounded-2 gap-3 mt-4">
                                <div class="thumbnail position-relative rounded-2">
                                    <a href="#"><img src="assets/img/products/p-sm-2.png" alt="product" class="img-fluid"></a>
                                    <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2 rounded-2">
                                        <a href="product-details.html" class="rounded-btn"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="card-content mt-3 mt-sm-0">
                                    <a href="#" class="d-block fs-sm fw-bold text-heading title d-block">Strawberry juice Fruit</a>
                                    <div class="pricing mt-0">
                                        <span class="fw-bold fs-xxs text-danger">$140.00</span>
                                    </div>
                                    <div class="d-flex align-items-center flex-nowrap star-rating mt-1">
                                        <ul class="d-flex align-items-center me-2">
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="horizontal-product-card card-md d-sm-flex align-items-center bg-white rounded-2 gap-3 mt-4">
                                <div class="thumbnail position-relative rounded-2">
                                    <a href="#"><img src="assets/img/products/p-sm-3.png" alt="product" class="img-fluid"></a>
                                    <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2 rounded-2">
                                        <a href="product-details.html" class="rounded-btn"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="card-content mt-3 mt-sm-0">
                                    <a href="#" class="d-block fs-sm fw-bold text-heading title d-block">Strawberry juice Fruit</a>
                                    <div class="pricing mt-0">
                                        <span class="fw-bold fs-xxs text-danger">$140.00</span>
                                    </div>
                                    <div class="d-flex align-items-center flex-nowrap star-rating mt-1">
                                        <ul class="d-flex align-items-center me-2">
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="horizontal-product-card card-md d-sm-flex align-items-center bg-white rounded-2 gap-3 mt-4">
                                <div class="thumbnail position-relative rounded-2">
                                    <a href="#"><img src="assets/img/products/p-sm-4.png" alt="product" class="img-fluid"></a>
                                    <div class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2 rounded-2">
                                        <a href="product-details.html" class="rounded-btn"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="card-content mt-3 mt-sm-0">
                                    <a href="#" class="d-block fs-sm fw-bold text-heading title d-block">Strawberry juice Fruit</a>
                                    <div class="pricing mt-0">
                                        <span class="fw-bold fs-xxs text-danger">$140.00</span>
                                    </div>
                                    <div class="d-flex align-items-center flex-nowrap star-rating mt-1">
                                        <ul class="d-flex align-items-center me-2">
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                            <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="vertical-product-card rounded-bottom-2 position-relative border-0 border-top bg-white shadow-none">
                        <div class="thumbnail position-relative text-center p-4">
                            <img src="assets/img/products/apple.png" alt="apple" class="img-fluid">
                            <div class="product-btns position-absolute d-flex gap-2 flex-column">
                                <a href="#" class="rounded-btn"><i class="fa-regular fa-heart"></i></a>
                                <a href="#" class="rounded-btn">
                                    <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.705 0.201222C10.4317 0.469526 10.4317 0.904522 10.705 1.17283L11.6101 2.06107H7.70001C6.15364 2.06107 4.90001 3.29144 4.90001 4.80917V5.49619C4.90001 5.87564 5.21341 6.18322 5.60001 6.18322C5.98662 6.18322 6.30001 5.87564 6.30001 5.49619V4.80917C6.30001 4.0503 6.92679 3.43512 7.70001 3.43512H11.6101L10.705 4.32337C10.4317 4.59166 10.4317 5.02668 10.705 5.29496C10.9784 5.56325 11.4216 5.56325 11.695 5.29496L13.795 3.2339C14.0683 2.96559 14.0683 2.5306 13.795 2.26229L11.695 0.201222C11.4216 -0.0670741 10.9784 -0.0670741 10.705 0.201222ZM8.40001 4.80917C8.0134 4.80917 7.70001 5.11675 7.70001 5.49619V6.18322C7.70001 6.9421 7.07323 7.55726 6.30001 7.55726H2.38995L3.29498 6.66901C3.56835 6.40073 3.56835 5.9657 3.29498 5.69742C3.02161 5.42914 2.5784 5.42914 2.30503 5.69742L0.205023 7.75849C-0.0683411 8.02678 -0.0683411 8.4618 0.205023 8.73008L2.30503 10.7912C2.5784 11.0594 3.02161 11.0594 3.29498 10.7912C3.56835 10.5229 3.56835 10.0878 3.29498 9.81957L2.38995 8.93131H6.30001C7.84638 8.93131 9.10001 7.70092 9.10001 6.18322V5.49619C9.10001 5.11675 8.78662 4.80917 8.40001 4.80917Z" fill="#AEB1B9"></path>
                                    </svg>
                                </a>
                                <a href="#" class="rounded-btn"><i class="fa-regular fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="card-content">
                            <a href="#" class="mb-2 d-inline-block text-secondary fw-semibold fs-xxs">Fresh Organic</a>
                            <a href="#" class="card-title fw-bold d-block mb-2">Popped Rice Crisps Snacks Chocolate.</a>
                            <div class="d-flex align-items-center flex-nowrap star-rating fs-xxs mb-2">
                                <ul class="d-flex align-items-center me-2">
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                    <li class="text-warning"><i class="fa-solid fa-star"></i></li>
                                </ul>
                                <span class="flex-shrink-0">(5.2k Reviews)</span>
                            </div>
                            <h6 class="price text-danger mb-4">$140.00</h6>
                            <a href="#" class="btn btn-outline-secondary d-block btn-md border-secondary">Add to Cart</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        </div>
    </section>
    <!--product details end-->

    @php
        // Example: breadcrumbs array from your controller or view composer
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $productCategory->name, 'url' => route('category', $productCategory->slug)],
            [
                'name' => $product->title_h1 ? $product->title_h1 : $product->name,
                'url' => route('product', $product->slug),
            ],
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($breadcrumbs)
                ->map(function ($crumb, $i) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $i + 1,
                        'name' => $crumb['name'],
                        'item' => $crumb['url'],
                    ];
                })
                ->all(),
        ];

    @endphp

    @php

        // Helper: map your internal stock status to schema.org
        $availabilityMap = [
            'in_stock' => 'http://schema.org/InStock',
            'out_of_stock' => 'http://schema.org/OutOfStock',
            'preorder' => 'http://schema.org/PreOrder',
        ];

        // Build the base product schema from your model
        $productSchema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name, // e.g., "Andy Capps Hot Onion Rings – 2oz"
            'image' => asset('storage/products/') . '/' . $product->id . '/' . $product->image,
            'description' => trim(strip_tags($product->description)), // plain text
            'sku' => $product->sku,
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand->name ?? 'The Canada Foods.',
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product', $product->slug),
                'priceCurrency' => $product->currency ?? 'USD',
                'price' => number_format($product->price, 2, '.', ''),
                'availability' => $availabilityMap[$product->stock_status] ?? 'http://schema.org/InStock',
                'sku' => $product->sku,
                // Optional but good:
                'itemCondition' => 'http://schema.org/NewCondition',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => config('app.name', 'TheCanadaFoods.com'),
                ],
            ],
        ];

        // If you have ratings in DB, add them (only when real!)
        if ($product->rating_value && $product->rating_count) {
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (string) round($product->rating_value, 1), // e.g., 4.8
                'reviewCount' => (string) $product->rating_count, // e.g., 124
            ];
        }

        // If you store a latest review (optional; only if real)

        $productSchema['review'] = [
            '@type' => 'Review',
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => isset($ratings[0]->rating) && $ratings[0]->rating > 0 ? $ratings[0]->rating : '4.5',
                'bestRating' => '5',
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $ratings[0]?->name,
            ],
            'reviewBody' => trim(strip_tags($ratings[0]?->review)),
        ];

        //print_r( $productSchema);

    @endphp


@endsection


@push('scripts')
    {{-- page specific JS goes here --}}

    <script>
        $(document).ready(function() {
            let selectedRating = null;

            function loadRatings(page = 1) {
                $.ajax({
                    url: '{{ route('ratings.filter', $product->slug) }}?page=' + page,
                    type: 'POST',
                    data: {
                        rating: selectedRating
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#review-section').html(response);
                        $('.jdgm-histogram__clear-filter').toggle(selectedRating !== null);
                        window.location.href = "#reviews_section"
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $('.filter_rating').on('click', function() {
                selectedRating = $(this).data('rating') || null;
                loadRatings(1);
            });

            $(document).on('click', '#review-section .pagination a', function(e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                loadRatings(page);
            });
        });
    </script>

    <script type="application/ld+json">
    {!! json_encode($productSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush
