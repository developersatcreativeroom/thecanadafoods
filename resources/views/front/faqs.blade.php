@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">FAQs</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Frequently Asked Questions</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<!--faq section start-->
<section class="faq-section ptb-120 position-relative overflow-hidden z-1">
    
    <div class="container">
        <div class="row g-5 justify-content-center">
            {{-- <div class="col-xl-7">
                <div class="feature-image p-3 text-center">
                    <img src="{{ URL::asset('frontend/img/about/girl.png') }}" alt="girl" class="img-fluid">
                </div>
            </div> --}}
            <div class="col-xl-10">
                <div class="faq-right">
                    <h4 class="mb-4">Frequently Asked Questions</h4>
                    <p class="mb-5">Wondering how things work around here? Our FAQ has you covered.</p>
                    
                    <div class="accordion faq-accordion" id="faq-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-1" data-bs-toggle="collapse">1.Do you ship to the US?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse show" id="acc-1" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">Yes, We only ship to the US.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-2" data-bs-toggle="collapse" class="collapsed"> 2.How long will it take for my order to arrive?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-2" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">Your order will be shipped out in 2-4 business days, and it will be delivered between 3-7 business days depending upon location in the US.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-3" data-bs-toggle="collapse" class="collapsed">3.Do you offer free shipping?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-3" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">Shipping is paid and calculated based on weight, size and location of each order.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-4" data-bs-toggle="collapse" class="collapsed">4.Are prices in US or Canadian dollars?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-4" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">All prices are in US dollars.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-5" data-bs-toggle="collapse" class="collapsed">5.Is there a minimum order amount?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-5" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    @php
                                        $currencySign = App\Helper::getWebsiteConfig('currency_sign');
                                        $minCartAmount = App\Helper::getWebsiteConfig('min_cart_amount');
                                    @endphp
                                    <p class="mb-0">Yes, the minimum order is {{$currencySign['currency_sign']}}{{$minCartAmount['min_cart_amount']}} (Cart value).</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-6" data-bs-toggle="collapse" class="collapsed">6.Can I pick up the order from your warehouse?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-6" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">No, we only offer online deliveries.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-7" data-bs-toggle="collapse" class="collapsed">7.Do we do wholesale?<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-7" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">Yes, we do offer wholesale pricing for minimum of $1000 orders</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--faq section end-->
        
@endsection