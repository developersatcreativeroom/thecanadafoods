@extends('front.layouts.app')

@section('content')


<section class="my-account pt-6 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3">
                @include('front.profile.side')
            </div>
            <div class="col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                                <div class="card">
                                    <h6 class="my-4 px-4">Your Order Details</h6>
                                    <div class="card-body p-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Details</h6>

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Order #</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$order->order_no}}</p>
                                                </div>
                                            </div>

                                            

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Order Status</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext order-status">{{$order->order_status}}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Payment Done</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">
                                                    @if($order->is_payment_done)
                                                    <span class="badge bg-success">Done</span>
                                                    @else
                                                    <span class="badge bg-danger">Not Done</span>
                                                    @endif
                                                </p>
                                                </div>
                                            </div>

                                            @if($order->payment)
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Payment Method</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext"><strong>{{ucfirst($order->payment_method)}}</strong></p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Products Total</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$order->amount()}}</p>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <label class="col-sm-6 col-form-label">Order Type</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$order->order_type}}</p>
                                                </div>
                                            </div> --}}

                                            @if($order->local_pickup)

                                                <div class="row">
                                                    <label class="col-sm-6 col-form-label">Pickup</label>
                                                    <div class="col-sm-6">
                                                    <p class="form-control-plaintext">Local Pickup</p>
                                                    </div>
                                                </div>
                                                
                                            @endif

                                            @if($order->order_notes)
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Order notes</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$order->order_notes}}</p>
                                                </div>
                                            </div>
                                            @endif

                                            


                                            <h6>Billing Address</h6>

                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$order->billing->first_name}} {{$order->billing->last_name}}</p>
                                                </div>
                                            </div>

                                            @if($order->billing->company_name != null)
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Company Name</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$order->billing->company_name}}</p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$order->billing->email}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Phone</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">+{{$order->billing->country_code}}-{{$order->billing->phone}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Address</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$order->billing->address_line_1}} 
                                                {{$order->billing->address_line_2}} {{$order->billing->street}}, {{$order->billing->city}}<br> {{$order->billing->state}}-{{$order->billing->postal}}, {{$order->billing->country}}</p>
                                                </div>
                                            </div>
                                                    

                                            @if($order->shipping)

                                                <h6>Shipping Address</h6>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->shipping->first_name}} {{$order->shipping->last_name}}</p>
                                                    </div>
                                                </div>

                                                @if($order->shipping->company_name != null)
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Company Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->shipping->company_name}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->shipping->email}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Phone</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">+{{$order->shipping->country_code}}-{{$order->shipping->phone}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Address</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->shipping->address_line_1}} 
                                                    {{$order->shipping->address_line_2}} {{$order->shipping->street}}, {{$order->shipping->city}}<br> {{$order->shipping->state}}-{{$order->shipping->postal}}, {{$order->shipping->country}}</p>
                                                    </div>
                                                </div>


                                            @endif

                                                </div>

                                                

                                                

                                                
                                                
                                            <div class="col-md-6">

                                            <h6>User Details</h6>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->first_name}} {{$order->last_name}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$order->email}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Phone</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">+{{$order->country_code}}-{{$order->phone}}</p>
                                                    </div>
                                                </div>



                                                <h6>Order Status History</h6>

                                                        <!-- The time line -->
                                                        <div class="timeline">
                                                            <!-- timeline time label -->
                                                            <div class="time-label">
                                                                <span class="bg-green">{{$order->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                                                            </div>
                                                            <!-- /.timeline-label -->

                                                            @foreach($order->history as $history)
                                                                <!-- timeline item -->
                                                                <div>
                                                                    <i class="icon fi-rs-info text-white bg-blue"></i>
                                                                    <div class="timeline-item">
                                                                    <span class="time"><i class="icon fas fa-clock"></i> {{$history->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</span>
                                                                    <h3 class="timeline-header no-border"><a>{{$history->status}}</a></h3>

                                                                    @if($history->note != null)
                                                                        <div class="timeline-body">
                                                                            {{$history->note}}
                                                                        </div>
                                                                    @endif

                                                                    </div>
                                                                </div>
                                                                <!-- END timeline item -->
                                                            @endforeach

                                                            <!-- timeline item -->
                                                            <!-- <div>
                                                                <i class="fas fa-info bg-blue"></i>
                                                                <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                                                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                                                <div class="timeline-body">
                                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                                    quora plaxo ideeli hulu weebly balihoo...
                                                                </div>
                                                                </div>
                                                            </div> -->
                                                            <!-- END timeline item -->

                                                            <!-- timeline item -->
                                                            <!-- <div>
                                                                <i class="fas fa-user bg-green"></i>
                                                                <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                                                <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                                                </div>
                                                            </div> -->
                                                            <!-- END timeline item -->
                                                        
                                                            
                                                                <div>
                                                                    <i class="icon icon fi-rs-info text-white bg-gray"></i>
                                                                </div>
                                                            </div>
                                                            <!-- /.timeline -->
                                             
                                                
                                                        </div>
                                                    <!-- /.col -->
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <h6>Order Products</h6>
                                                            <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Product Image</th>
                                                                    <th>Product Name</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Discount</th>
                                                                    <th>Discount in %</th>
                                                                    <th>Product SKU</th>
                                                                    {{-- @if($order->payment)
                                                                    @if($order->payment->is_state_tax)<th>State Tax</th>@endif
                                                                    @if($order->payment->is_central_tax)<th>Central Tax</th>@endif
                                                                    @if($order->payment->is_integrated_tax)<th>Integrated Tax</th>@endif
                                                                    @endif
                                                                    <th>Tax</th>
                                                                    <th>Tax Amount</th> --}}
                                                                    <th>Brand</th>
                                                                    {{-- <th>Sub Total <small>(Inc. Tax)<small></th> --}}
                                                                    <th>Sub Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($order->products as $key => $product)
                                                                    <tr>
                                                                        <td>
                                                                        {{$key+1}}
                                                                        </td>
                                                                        <td>
                                                                        @if(!empty($product) && ($product->image != null || $product->image != '' ))
                                                                            <img class="img-fluid img-thumbnail img-thumb-custom" src="{{ asset('storage/products/') }}/{{$product->product_id}}/{{$product->image}}" />
                                                                        @endif
                                                                        </td>
                                                                        <td>
                                                                            {{$product->name}}
                                                                            
                                                                            @if($product->color_name)
                                                                                <div> <strong>Color: </strong> {{$product->color_name}}</div>
                                                                            @endif

                                                                            @if($product->attributes)
                                                                                <p class="">
                                                                                    @foreach(json_decode($product->attributes) as $attribute)
                                                                                        <span class="badge text-dark pl-0">{{$attribute->attribute_name}}: {{$attribute->attribute_option_name}}</span>
                                                                                    @endforeach
                                                                                </p>
                                                                            @endif

                                                                        </td>
                                                                        <td>{{$product->quantity}}</td>
                                                                        <td>{{$order->currency}}{{$product->sale_price}}</td>
                                                                        <td>
                                                                            @if($product->old_price)
                                                                            {{$order->currency}}{{App\Helper::numberFormat($product->old_price-$product->price)}}
                                                                            @endif
                                                                        </td>
                                                                        <td>{{App\Helper::getDiscountPercentage($product)}}</td>
                                                                        <td>{{$product->sku}}</td>
                                                                        {{-- @if($order->payment)
                                                                            @if($order->payment->is_state_tax)<td>@if($product->state_tax_amount) {{$order->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
                                                                            @if($order->payment->is_central_tax)<td>@if($product->central_tax_amount) {{$order->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
                                                                            @if($order->payment->is_integrated_tax)<td>@if($product->integrated_tax_amount) {{$order->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
                                                                        @endif
                                                                        <td>{{$product->tax}}%</td>
                                                                        <td>{{$order->currency}}{{$product->tax_value}}</td> --}}
                                                                        <td>{{$product->brand_name}}</td>
                                                                        <!-- <td>{{$order->currency}}{{App\Helper::numberFormat(($product->sale_price + $product->tax_value) * $product->quantity)}}</td> -->
                                                                        <td>{{$order->currency}}{{App\Helper::numberFormat($product->final_price * $product->quantity )}}</td>
                                                                    </tr>

                                                                    @if(!empty($product->services) && count($product->services) > 0)
                                                                        @php
                                                                            $colspan = 8;
                                                                            // if($order->payment){
                                                                            //     if($order->payment->is_state_tax){
                                                                            //         $colspan++;
                                                                            //     }
                                                                            //     if($order->payment->is_central_tax){
                                                                            //         $colspan++;
                                                                            //     }
                                                                            //     if($order->payment->is_integrated_tax){
                                                                            //         $colspan++;
                                                                            //     }
                                                                            // }
                                                                        @endphp

                                                                        @foreach($product->services as $service)
                                                                            
                                                                            <tr class="service-row">
                                                                                <td colspan="{{$colspan}}">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="">
                                                                                            <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted" style="width:80px" src="{{ asset('storage/product-services/') }}/{{$service->id}}/{{$service->image}}" alt="">
                                                                                        </div>
                                                                                        <div class="pl-10">
                                                                                            <h6 class="mb-5 fw-500">
                                                                                                {{$service->name}}
                                                                                            </h6>
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
                                                                    
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        @if($order->payment)
                                                        <div class="row justify-content-end">
                                                            <div class="col-md-5">
                                                            <table class="table mb-0 mt-20">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Subtotal:</td>
                                                                        <td>{{$order->currency}}{{$order->payment->total}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Discount:</td>
                                                                        <td>{{$order->currency}}{{$order->payment->discount}}</td>
                                                                    </tr>
                                                                    
                                                                    @if($order->payment->coupon_discount)
                                                                    <tr>
                                                                        <td>Coupon Discount:</td>
                                                                        <td>{{$order->currency}}{{$order->payment->coupon_discount}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    
                                                                    @if($order->shipping && !$order->local_pickup)
                                                                        <tr>
                                                                            <td>Shipping:</td>
                                                                            <td>{{$order->currency}}{{$order->payment->shipping}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if($order->payment->products_service)
                                                                        <tr>
                                                                            <td>Product(s) Service:</td>
                                                                            <td>{{$order->currency}}{{$order->payment->products_service}}</td>
                                                                        </tr>
                                                                        @endif
                                                                    
                                                                    {{-- <tr>
                                                                        <td>Tax:</td>
                                                                        <td>{{$order->currency}}{{$order->payment->tax}}</td>
                                                                    </tr> --}}
                                                                    
                                                                    <tr>
                                                                        <td><strong>Total:</strong></td>
                                                                        <td><strong>{{$order->currency}}{{$order->payment->amount}}</strong></td>
                                                                    </tr>
                                                                    
                                                                    
                                                                    
                                                                
                                                                </tbody>
                                                                </table>
                                                            </div>								
                                                        </div>			
                                                        @endif					
                                            



                                            </div>
                                        </div>

                                    

                                
                                            </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush