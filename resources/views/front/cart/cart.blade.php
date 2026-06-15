@extends('front.layouts.app')
@section('head')
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1024329659429409');
fbq('track', 'addtocart-page');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1024329659429409&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endsection

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--60">
    <img src="{{ URL::asset('frontend/img/shapes/bg-shape-6.png') }}" alt="bg-shape" class="position-absolute start-0 z--1 w-100 bg-shape">
    <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="pata" class="position-absolute pata-xs z--1 vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/onion.png') }}" alt="onion" class="position-absolute z--1 onion start-0 top-0 vector-shape bg-icon-1">
    <img src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle" class="position-absolute z--1 frame-circle vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/energy-drink.png') }}" alt="leaf" class="position-absolute z--1 leaf vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/garlic-white.png') }}" alt="garlic" class="position-absolute z--1 garlic vector-shape bg-icon-2">
    <img src="{{ URL::asset('frontend/img/shapes/roll-1.png') }}" alt="roll" class="position-absolute z--1 roll vector-shape bg-icon-3">
    <img src="{{ URL::asset('frontend/img/shapes/roll-2.png') }}" alt="roll" class="position-absolute z--1 roll-2 vector-shape bg-icon-4">
    <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="roll" class="position-absolute z--1 pata-xs-2 vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/white-bread.png') }}" alt="tomato" class="position-absolute z--1 tomato-half vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/cookie.png') }}" alt="tomato" class="position-absolute z--1 tomato-slice vector-shape">
    <img src="{{ URL::asset('frontend/img/shapes/cauliflower.png') }}" alt="tomato" class="position-absolute z--1 cauliflower vector-shape bg-icon-5">
    <img src="{{ URL::asset('frontend/img/shapes/leaf-gray.png') }}" alt="tomato" class="position-absolute z--1 leaf-gray vector-shape bg-icon-6">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Shopping Cart</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Shopping Cart</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<!--cart section start-->
<section class="cart-section ptb-80">
    <div class="container">
        @if(isset($cart) && count($cart) > 0)

        {{-- <div class="py-5 text-center">
            <p class="text-danger">Did you add <a href="#">Ice Packs</a> & <a href="#">Insulated Bags</a> for heat sensitive products - We will not responsible for melting or damage from heat.</p>
        </div> --}}

        <div class="select-all d-flex align-items-center justify-content-between bg-white rounded p-4">
            <div class="d-inline-flex gap-2 align-items-center">
             
            </div>
            <a href="#" class="text-gray empty-cart"><span class="me-2"><i class="fa-solid fa-trash-can"></i></span>Clear Cart</a>
        </div>

        <div id="products-section">
            @include('front.cart.products-section')
        </div>

        
        <div class="row g-4">
            <div class="col-xl-7">

                @if(!$isEnquiryWebsite)
                    @if($couponEnabled['coupon'] == true)
                        
                        <div class="voucher-box py-7 px-5 position-relative z-1 overflow-hidden bg-white rounded mt-4">
                            <img src="{{ URL::asset('frontend/img/shapes/circle-half.png') }}" alt="circle shape" class="position-absolute end-0 top-0 z--1">
                            
                            
                            <div id="coupon-cont">
                                @if($coupon)
                                    <div class="coupon-row">
                                        <span class="copyCode text-primary"> {{$coupon->code}} </span>
                                        <span class="copyBtn bg-secondary text-white" id="remove-coupon" data-code="{{$coupon->code}}">Remove</span>
                                    </div>
                                @else

                                    {{-- <div class="form-row row justify-content-center">
                                        <div class="form-group col-lg-6">
                                            <input class="font-medium form-control" name="Coupon" id="coupon-code"
                                                placeholder="Enter Your Coupon">
                                            <div id="coupon-message"></div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <button class="btn  btn-sm" id="apply-coupon"><i
                                                    class="fi-rs-label mr-10"></i>Apply</button>
                                        </div>
                                    </div> --}}

                                    <h4 class="mb-3">Apply Coupon</h4>
                                    {{-- <p class="mb-7">Unlock Your Deal - Apply a Coupon Now</p> --}}

                                    <form class="d-flex align-items-center">
                                        <input type="text" placeholder="Enter Your Coupon" class="theme-input w-100" name="Coupon" id="coupon-code">
                                        <button type="submit" class="btn btn-secondary flex-shrink-0" id="apply-coupon">Apply Coupon</button>
                                    </form>
                                    <div id="coupon-message"></div>

                                @endif
                            </div>

                        </div>

                    @endif
                @endif

                {{-- @if(!$isEnquiryWebsite)
                @if($couponEnabled['coupon'] == true)
                <div class="mb-30">
                    <div class="heading_s1 mb-3">
                        <h4>Apply Coupon</h4>
                    </div>
                    <div class="total-amount">
                        <div class="left">
                            <div class="coupon" id="coupon-cont">
                                @if($coupon)
                                <div class="form-row row justify-content-center align-items-center">
                                    <div class="form-group col-lg-6">
                                        <div class="bg-success py-3 px-1 border rounded text-center">
                                            <h5 class="text-white">Coupon: <span class="bg-white text-success p-1">{{$coupon->code}}</span> applied</h5>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <button class="btn  btn-sm" id="remove-coupon"
                                            data-code="{{$coupon->code}}"><i
                                                class="fi-rs-label mr-10"></i>Remove</button>
                                    </div>
                                </div>
                                @else

                                <div class="form-row row justify-content-center">
                                    <div class="form-group col-lg-6">
                                        <input class="font-medium form-control" name="Coupon" id="coupon-code1"
                                            placeholder="Enter Your Coupon">
                                        <div id="coupon-message1"></div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <button class="btn  btn-sm" id="apply-coupon1"><i
                                                class="fi-rs-label mr-10"></i>Apply</button>
                                    </div>
                                </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif --}}
                
            </div>
            <div class="col-xl-5">
                <div id="checkout-section">
                    @include('front.cart.checkout-section')
                </div>

                
            </div>
        </div>
        @else
            <div class="col text-center">
                <p class="my-3"> Cart is Empty</p>
            </div>
        @endif
    </div>
</section>
<!--cart section end-->




@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush