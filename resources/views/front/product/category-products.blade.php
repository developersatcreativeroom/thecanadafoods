@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--60">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h1 class="mb-2 text-center">{!!ucfirst($categoryName)!!}</h1>
                    <nav>
                     
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">{{ucfirst($category)}}</li>
                        </ol>
                        
                        @if ($categoryDB->short_description)                            
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item fw-bold" aria-current="page">{{$categoryDB->short_description}}</li>
                            </ol>
                        @endif
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<!--shop grid section start-->
<section class="gshop-gshop-grid ptb-80 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3 d-none">
                <div class="gshop-sidebar bg-white rounded-2 overflow-hidden" id="filters">
                    <div class="sidebar-widget search-widget bg-white py-5 px-4">
                        <div class="widget-title d-flex">
                            <h6 class="mb-0 flex-shrink-0">Search Now</h6>
                            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                        </div>
                        <form class="search-form d-flex align-items-center mt-4">
                            <input type="text" placeholder="Search..." id="keyword">
                            <button type="submit" class="submit-icon-btn-secondary" id="keyword-search"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    {{-- @if(count($colorsFilters) > 0)
                    <div class="sidebar-widget category-widget bg-white py-5 px-4 border-top">
                        <div class="widget-title d-flex">
                            <h6 class="mb-0 flex-shrink-0">Color</h6>
                            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                        </div>

                        <ul class="mt-4 sidebar-rating-list">

                            @foreach($colorsFilters as $colorsFilter)

                            <li class="d-flex align-items-center justify-content-between">
                                <div class="custom-checkbox d-flex align-items-center">
                                    <div class="theme-checkbox flex-shrink-0">
                                        <input type="checkbox" name="color" class="color" id="color-{{$key}}"
                                            value="{{$colorsFilter->name}}">
                                        <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                                    </div>
                                    <span class="color-palette ms-2"
                                        style="background:{{$colorsFilter->code}}">&nbsp;</span>
                                    <label class="ms-2" for="color-{{$key}}">
                                        {{$colorsFilter->name}}</label>
                                </div>
                            </li>

                            @endforeach

                        </ul>
                    </div>
                    @endif --}}


                    @if(count($brandsFilters) > 0)
                    <div class="sidebar-widget category-widget bg-white py-5 px-4 border-top">
                        <div class="widget-title d-flex">
                            <h6 class="mb-0 flex-shrink-0">Brands</h6>
                            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                        </div>

                        <ul class="mt-4 sidebar-rating-list">
                            @php
                            $brandCount = 0 ;
                            @endphp

                            @foreach($brandsFilters as $key => $brandsFilter)

                            <li class="d-flex align-items-center justify-content-between">
                                <div class="custom-checkbox d-flex align-items-center">
                                    <div class="theme-checkbox flex-shrink-0">
                                        <input type="checkbox" name="brands" class="brand" id="brand-{{$key}}"
                                            value="{{$brandsFilter->name}}">
                                        <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                                    </div>
                                    <label class="ms-2" for="brand-{{$key}}">{{$brandsFilter->name}}</label>
                                </div>
                                {{-- <span class="fw-bold fs-xs total-count">48</span> --}}
                            </li>

                            @php 
                            $brandCount++;
                            if($brandCount == 6){
                                break;
                            }
                            @endphp

                            @endforeach
                        </ul>




                        <div class="modal fade" id="addBrandsModal" tabindex="-1" aria-labelledby="addBrandsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h2 class="modal-title fs-5 mt-1 mb-2">All Brands</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mt-4 sidebar-rating-list" id="brands-modal-list">
                                            <div class="row">
                                                @foreach($brandsFilters as $key => $brandsFilter)
                    
                                                <div class="col-md-3">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="custom-checkbox d-flex align-items-center">
                                                            <div class="theme-checkbox flex-shrink-0">
                                                                <input type="checkbox" name="brands" class="brand-modal" id="brand-modal-{{$key}}"
                                                                    value="{{$brandsFilter->name}}">
                                                                <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                                                            </div>
                                                            <label class="ms-2" for="brand-modal-{{$key}}">{{$brandsFilter->name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-end">

                                        <div class="px-3">
                                            <button class="btn btn-secondary btn-md me-3 submit" name="submit"
                                                value="Submit" id="select-brands">Filter</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <a class="btn btn-link all-brands">All Brands</a>

                    </div>
                    @endif



                    @if(!empty($priceRangeFilters['max']) && !empty($priceRangeFilters['min']))
                    <div class="sidebar-widget price-filter-widget bg-white py-5 px-4 border-top">
                        <div class="widget-title d-flex">
                            <h6 class="mb-0 flex-shrink-0">Filter by Price</h6>
                            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                        </div>
                        <div class="at-pricing-range mt-4">
                            <form class="range-slider-form">
                                <div class="price-filter-range"></div>
                                <div class="d-flex align-items-center mt-3">
                                    <input type="text" class="min_price price-range-field price-input"
                                        data-min="{{$priceRangeFilters['min']}}"
                                        data-min-selected="{{(isset($_GET['minprice']) && $priceRangeFilters['min'] < $_GET['minprice']) ? $_GET['minprice'] : $priceRangeFilters['min']}}">
                                    <span class="d-inline-block ms-2 me-2 fw-bold">-</span>
                                    <input type="text" class="max_price price-range-field price-input"
                                        data-max="{{$priceRangeFilters['max']}}"
                                        data-max-selected="{{(isset($_GET['maxprice']) && $priceRangeFilters['max'] > $_GET['maxprice']) ? $_GET['maxprice'] : $priceRangeFilters['max']}}">
                                </div>

                                <input type="hidden" id="min-amount"
                                    value="{{isset($_GET['minprice']) ? $_GET['minprice'] : '' }}" />
                                <input type="hidden" id="max-amount"
                                    value="{{isset($_GET['maxprice']) ? $_GET['maxprice'] : '' }}" />

                                <button class="btn btn-primary btn-sm mt-3" id="set-price-range">Set Filter</button>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            <div class="col-xl-12">
                <div class="shop-grid">
                    <div
                        class="listing-top d-flex align-items-center justify-content-between flex-wrap gap-3 bg-white rounded-2 px-4 py-5 mb-6">
                        <p class="mb-0 fw-bold">We found {{$products->total()}} items for you!</p>
                        <div class="listing-top-right text-end d-inline-flex align-items-center gap-3 flex-wrap">
                            <div class="select-filter d-inline-flex align-items-center gap-3">
                                <label class="fw-bold fs-xs text-dark flex-shrink-0">Sort by:</label>
                                <select class="form-select fs-xxs fw-medium theme-select select-sm sort">
                                    <option value="default">Default</option>
                                    <option value="latest">Published - New to Old</option>
                                    <option value="oldest">Published - Old to New</option>
                                    <option value="price-ascending">Price: Low to High</option>
                                    <option value="price-descending">Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @include('front.product.products-list')

                </div>
            </div>
            <div class="col-xl-12 mb-5">
                {!! $categoryDB->description !!}
            </div>
        </div>
    </div>
</section>
<!--shop grid section end-->

<!--faq section start-->
@if (count($categoryDB->faqs) > 0)
<section class="faq-section ptb-120 position-relative overflow-hidden z-1">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-xl-10">
                <div class="faq-right">
                    <h4 class="mb-4">Frequently Asked Questions</h4>
                    <p class="mb-5">Wondering how things work around here? Our FAQ has you covered.</p>
                    
                    <div class="accordion faq-accordion" id="faq-accordion">
                         
                        
                        @foreach($categoryDB->faqs as $k=>$faq)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-{{$faq->id}}" data-bs-toggle="collapse" class="collapsed"> {{$k+1}}. {{$faq->question}}<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-{{$faq->id}}" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">{{$faq->answer}}</p>
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

@php
    // Example: breadcrumbs array from your controller or view composer
    $breadcrumbs = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => ucfirst($category) , 'url' => route('category', $category)],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($breadcrumbs)->map(function ($crumb, $i) {
            return [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ];
        })->all(),
    ];
@endphp

@php
    if ($categoryDB->faqs && $categoryDB->faqs->isNotEmpty()) {
        $schemaFaq = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => collect($categoryDB->faqs ?? [])->map(function ($item) {
                return [
                    '@type' => 'Question',
                    'name'  => trim(strip_tags($item->question ?? '')),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => trim(strip_tags($item->answer ?? '')),
                    ],
                ];
            })->values()->all(),
        ];
    }
     
@endphp

@endsection


@push('scripts')
    @if($categoryDB->faqs && $categoryDB->faqs->isNotEmpty())
    <script type="application/ld+json">
    {!! json_encode($schemaFaq, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
    @endif
    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>

@endpush