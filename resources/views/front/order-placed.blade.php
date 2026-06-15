@extends('front.layouts.app')
@section('head')
<!-- Google tag (gtag.js) event -->
<script>
  gtag('event', 'conversion_event_purchase', {
    // <event_parameters>
  });
</script>
@if($order->status)
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
fbq('track', 'order-placed');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1024329659429409&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endif

@endsection
@section('content')



<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Products</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Order Success</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->


<section class="gshop-gshop-grid ptb-80 bg-white">
    <div class="container">
        
        @if($order->status)
            <div class="row">
                <div class="col text-center">
                    <h6>Thanks!</h6>
                    <h2 class="my-3 text-success">Your Order is Successful</h2>
                    <p>We will keep you updated</p>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col text-center">
                    <h6>Payment not done!</h6>
                    <h2 class="my-3 text-danger">Your Order is not Successful</h2>
                    <p>Please make the payment attempt again</p>
                </div>
            </div>
        @endif


        <div class="row justify-content-center mt-5">
            <div class="col-md-4 text-center">
                <h6>Order No: {{$order->order_no}}</h6>
                <p>
                    <strong>Name:</strong> {{$order->first_name}} {{$order->last_name}}<br>
                    <strong>Email:</strong> {{$order->email}} <br>
                    <strong>Phone:</strong> +{{$order->country_code}}-{{$order->phone}}<br>
                    {{-- @if($order->status)
                    <strong>Payment Method:</strong> {{ucfirst($order->payment_method)}}<br>
                    @endif --}}
                    @if($order->local_pickup)
                    <strong>Pickup:</strong> Local Pickup<br>
                    @endif
                </p>
            </div>
            @if($order->status)
            <div class="col-md-4 text-center mb-md-0 mb-4">
                <h6>Payment Details</h6>
                <p>
                    <strong>Sub-total:</strong> {{$order->currency}}{{$order->payment->total}}<br>
                    @if($order->payment->discount && $order->payment->discount > 0)
                    <strong>Discount:</strong> {{$order->currency}}{{$order->payment->discount}} <br>
                    @endif
                    @if($order->payment->coupon_discount && $order->payment->coupon_discount > 0)
                    <strong>Coupon Discount:</strong> {{$order->currency}}{{$order->payment->coupon_discount}} <br>
                    @endif
                    @if($order->shipping && !$order->local_pickup)
                    <strong>Shipping:</strong> {{$order->currency}}{{$order->payment->shipping}} <br>
                    @endif
                    {{-- <strong>Tax:</strong> {{$order->currency}}{{$order->payment->tax}} <br> --}}
                    <strong>Amount: {{$order->currency}}{{$order->payment->amount}}</strong>
                </p>
            </div>
            @endif
        </div>


        @if(count($order->products) > 0)
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h6 class="mt-4">Order Products</h6>
                        <table class="table">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                {{-- @if($order->payment)
                                @if($order->payment->is_state_tax)<th>State Tax</th>@endif
                                @if($order->payment->is_central_tax)<th>Central Tax</th>@endif
                                @if($order->payment->is_integrated_tax)<th>Integrated Tax</th>@endif
                                @endif
                                <th>Tax</th> 
                                <th>Tax Amount</th>  --}}
                                <th>Sub Total</th> 
                            </tr>
                            @foreach($order->products as $product)
                                <tr>
                                    <td>
                                    @if(!empty($product) && ($product->image != null || $product->image != '' ))
                                        <div class="">
                                        <img class="img-fluid img-thumbnail" style="width: 60px" src="{{ asset('storage/products/') }}/{{$product->product_id}}/{{$product->image}}" />
                                        </div>
                                    @endif
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->sku}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>
                                        {{$order->currency}}{{$product->sale_price}}
                                    </td>
                                    {{-- @if($order->payment)
                                        @if($order->payment->is_state_tax)<td>@if($product->state_tax_amount) {{$order->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
                                        @if($order->payment->is_central_tax)<td>@if($product->central_tax_amount) {{$order->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
                                        @if($order->payment->is_integrated_tax)<td>@if($product->integrated_tax_amount) {{$order->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
                                    @endif
                                    <td>{{$product->tax}}%</td>
                                    <td>{{$order->currency}}{{$product->tax_value}}</td> --}}
                                    <td>{{$order->currency}}{{$product->sub_total}}</td>
                                </tr>
                                @if(!empty($product->services) && count($product->services) > 0)
                                    @php
                                        $colspan = 8;
                                        if($order->payment){
                                            if($order->payment->is_state_tax){
                                                $colspan++;
                                            }
                                            if($order->payment->is_central_tax){
                                                $colspan++;
                                            }
                                            if($order->payment->is_integrated_tax){
                                                $colspan++;
                                            }
                                        }
                                    @endphp

                                    @foreach($product->services as $service)
                                        
                                        <tr class="service-row">
                                            <td colspan="{{$colspan}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="">
                                                        <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted" style="width:80px" src="{{ asset('storage/product-services/') }}/{{$service->id}}/{{$service->image}}" alt="">
                                                    </div>
                                                    <div class="pl-10">
                                                        <h5 class="mb-5 fw-500">
                                                            {{$service->name}}
                                                        </h5>
                                                        <p>Price: {{$order->currency}}{{$service->price}}</p>
                                                        <p class="font-sm text-grey-5">{{$service->summary}}</p>
                                                        <p class="text-grey-3">{{$service->description}}</p>

                                                    </div>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach
                                @endif

                            @endforeach
                        </table>
                    </div>
                </div>
                @endif



            
    </div>
</section>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush