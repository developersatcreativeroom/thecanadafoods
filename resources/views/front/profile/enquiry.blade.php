@extends('front.layouts.app')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{route('home')}}" rel="nofollow">Home</a>
            <span></span> Pages
            <span></span> Account
        </div>
    </div>
</div>
<section class="pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-menu">
                            @include('front.profile.side')
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content dashboard-content">
                        
                            <div class="tab-pane fade active show" id="order-details">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Enquiry Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Details</h5>
                                                <hr>

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Enquiry #</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$enquiry->enquiry_no}}</p>
                                                </div>
                                            </div>

                                            

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Enquiry Status</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext order-status">{{$enquiry->enquiry_status}}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Payment Done</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">
                                                    @if($enquiry->is_payment_done)
                                                    <span class="badge bg-success">Done</span>
                                                    @else
                                                    <span class="badge bg-danger">Not Done</span>
                                                    @endif
                                                </p>
                                                </div>
                                            </div>

                                            @if($enquiry->payment)
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Payment Method</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext"><strong>{{ucfirst($enquiry->payment_method)}}</strong></p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Products Total</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$enquiry->amount()}}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Enquiry Type</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$enquiry->enquiry_type}}</p>
                                                </div>
                                            </div>

                                            @if($enquiry->local_pickup)

                                                <div class="row">
                                                    <label class="col-sm-6 col-form-label">Pickup</label>
                                                    <div class="col-sm-6">
                                                    <p class="form-control-plaintext">Local Pickup</p>
                                                    </div>
                                                </div>
                                                
                                            @endif

                                            @if($enquiry->enquiry_notes)
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Enquiry notes</label>
                                                <div class="col-sm-6">
                                                <p class="form-control-plaintext">{{$enquiry->enquiry_notes}}</p>
                                                </div>
                                            </div>
                                            @endif

                                            <hr>
                                            


                                            <h5>Billing Address</h5>
                                                <hr>

                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$enquiry->billing->first_name}} {{$enquiry->billing->last_name}}</p>
                                                </div>
                                            </div>

                                            @if($enquiry->billing->company_name != null)
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Company Name</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$enquiry->billing->company_name}}</p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$enquiry->billing->email}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Phone</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">+{{$enquiry->billing->country_code}}-{{$enquiry->billing->phone}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Address</label>
                                                <div class="col-sm-8">
                                                <p class="form-control-plaintext">{{$enquiry->billing->address_line_1}} 
                                                {{$enquiry->billing->address_line_2}} {{$enquiry->billing->street}}, {{$enquiry->billing->city}}<br> {{$enquiry->billing->state}}-{{$enquiry->billing->postal}}, {{$enquiry->billing->country}}</p>
                                                </div>
                                            </div>

                                            <hr>
                                                    

                                            @if($enquiry->shipping)

                                                <h5>Shipping Address</h5>
                                                    <hr>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->shipping->first_name}} {{$enquiry->shipping->last_name}}</p>
                                                    </div>
                                                </div>

                                                @if($enquiry->shipping->company_name != null)
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Company Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->shipping->company_name}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->shipping->email}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Phone</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">+{{$enquiry->shipping->country_code}}-{{$enquiry->shipping->phone}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Address</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->shipping->address_line_1}} {{$enquiry->shipping->address_line_2}}  {{$enquiry->shipping->street}}, {{$enquiry->shipping->city}}<br> {{$enquiry->shipping->state}}-{{$enquiry->shipping->postal}}, {{$enquiry->shipping->country}}</p>
                                                    </div>
                                                </div>

                                                <hr>

                                            @endif

                                                </div>

                                                

                                                

                                                
                                                
                                            <div class="col-md-6">

                                            <h5>User Details</h5>
                                                <hr>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->first_name}} {{$enquiry->last_name}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{$enquiry->email}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label">Phone</label>
                                                    <div class="col-sm-8">
                                                    <p class="form-control-plaintext">+{{$enquiry->country_code}}-{{$enquiry->phone}}</p>
                                                    </div>
                                                </div>

                                                <hr>


                                                <h5>Enquiry Status History</h5>
                                                    <hr>

                                                        <!-- The time line -->
                                                        <div class="timeline">
                                                            <!-- timeline time label -->
                                                            <div class="time-label">
                                                                <span class="bg-green">{{$enquiry->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                                                            </div>
                                                            <!-- /.timeline-label -->

                                                            @foreach($enquiry->history as $history)
                                                                <!-- timeline item -->
                                                                <div>
                                                                    <i class="icon fi-rs-info text-white bg-blue"></i>
                                                                    <div class="timeline-item">
                                                                    <span class="time"><i class="icon fa-clock"></i> {{$history->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</span>
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
                                                            <h5>Enquiry Products</h5>
                                                            <hr>
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
                                                                    @if($enquiry->payment)
                                                                    @if($enquiry->payment->is_state_tax)<th>State Tax</th>@endif
                                                                    @if($enquiry->payment->is_central_tax)<th>Central Tax</th>@endif
                                                                    @if($enquiry->payment->is_integrated_tax)<th>Integrated Tax</th>@endif
                                                                    @endif
                                                                    <th>Tax</th>
                                                                    <th>Tax Amount</th>
                                                                    <th>Brand</th>
                                                                    <th>Sub Total <small>(Inc. Tax)<small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($enquiry->products as $key => $product)
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
                                                                        <td>{{$enquiry->currency}}{{$product->sale_price}}</td>
                                                                        <td>
                                                                            @if($product->old_price)
                                                                            {{$enquiry->currency}}{{App\Helper::numberFormat($product->old_price-$product->price)}}
                                                                            @endif
                                                                        </td>
                                                                        <td>{{App\Helper::getDiscountPercentage($product)}}</td>
                                                                        <td>{{$product->sku}}</td>
                                                                        @if($enquiry->payment)
                                                                            @if($enquiry->payment->is_state_tax)<td>@if($product->state_tax_amount) {{$enquiry->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
                                                                            @if($enquiry->payment->is_central_tax)<td>@if($product->central_tax_amount) {{$enquiry->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
                                                                            @if($enquiry->payment->is_integrated_tax)<td>@if($product->integrated_tax_amount) {{$enquiry->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
                                                                        @endif
                                                                        <td>{{$product->tax}}%</td>
                                                                        <td>{{$enquiry->currency}}{{$product->tax_value}}</td>
                                                                        <td>{{$product->brand_name}}</td>
                                                                        <!-- <td>{{$enquiry->currency}}{{App\Helper::numberFormat(($product->sale_price + $product->tax_value) * $product->quantity)}}</td> -->
                                                                        <td>{{$enquiry->currency}}{{App\Helper::numberFormat($product->final_price * $product->quantity )}}</td>
                                                                    </tr>

                                                                    @if(!empty($product->services) && count($product->services) > 0)
                                                                        @php
                                                                            $colspan = 8;
                                                                            if($enquiry->payment){
                                                                                if($enquiry->payment->is_state_tax){
                                                                                    $colspan++;
                                                                                }
                                                                                if($enquiry->payment->is_central_tax){
                                                                                    $colspan++;
                                                                                }
                                                                                if($enquiry->payment->is_integrated_tax){
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
                                                                                            <p>Price: {{$enquiry->currency}}{{$service->price}}</p>
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

                                                        @if($enquiry->payment)
                                                        <div class="row justify-content-end">
                                                            <div class="col-md-5">
                                                            <table class="table mb-0 mt-20">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Subtotal:</td>
                                                                        <td>{{$enquiry->currency}}{{$enquiry->payment->total}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Discount:</td>
                                                                        <td>{{$enquiry->currency}}{{$enquiry->payment->discount}}</td>
                                                                    </tr>
                                                                    
                                                                    @if($enquiry->payment->coupon_discount)
                                                                    <tr>
                                                                        <td>Coupon Discount:</td>
                                                                        <td>{{$enquiry->currency}}{{$enquiry->payment->coupon_discount}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    
                                                                    @if($enquiry->shipping && !$enquiry->local_pickup)
                                                                        <tr>
                                                                            <td>Shipping:</td>
                                                                            <td>{{$enquiry->currency}}{{$enquiry->payment->shipping}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if($enquiry->payment->products_service)
                                                                        <tr>
                                                                            <td>Product(s) Service:</td>
                                                                            <td>{{$enquiry->currency}}{{$enquiry->payment->products_service}}</td>
                                                                        </tr>
                                                                        @endif
                                                                    
                                                                    <tr>
                                                                        <td>Tax:</td>
                                                                        <td>{{$enquiry->currency}}{{$enquiry->payment->tax}}</td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td><strong>Total:</strong></td>
                                                                        <td><strong>{{$enquiry->currency}}{{$enquiry->payment->amount}}</strong></td>
                                                                    </tr>
                                                                    
                                                                    
                                                                    
                                                                
                                                                </tbody>
                                                                </table>
                                                                <hr>
                                                            </div>								
                                                        </div>			
                                                        @endif					
                                            


                                                <hr>

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