@extends('front.layouts.app')

@section('content')

<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" rel="nofollow">Home</a>
                    <span></span> Enquiry
                    <span></span> Success
                </div>
            </div>
        </div>
        <section id="work" class="mt-40 pt-50 pb-50 section-border">
            <div class="container">
                @if($enquiry->status)
                <div class="row mb-50">
                    <div class="col-lg-12 col-md-12 text-center">
                        <h6 class="mt-0 mb-5 text-uppercase  text-brand font-sm wow fadeIn animated animated" style="visibility: visible;">Thanks!</h6>
                        <h2 class="mt-15 mb-15 text-grey-1 wow fadeIn animated animated" style="visibility: visible;"> Your Enquiry is Successful</h2>
                        <p class="w-50 m-auto text-grey-3 wow fadeIn animated animated" style="visibility: visible;">We will keep you updated</p>
                    </div>
                </div>
                @endif
                <div class="row justify-content-center">
                    <div class="col-md-4 text-center mb-md-0 mb-4">
                        <h4 class="mt-30 mb-15 wow fadeIn animated animated" style="visibility: visible;">Enquiry No: {{$enquiry->enquiry_no}}</h4>
                        <p class="text-grey-3 wow fadeIn animated animated" style="visibility: visible;">
                            <strong>Name:</strong> {{$enquiry->first_name}} {{$enquiry->last_name}}<br>
                            <strong>Email:</strong> {{$enquiry->email}} <br>
                            <strong>Phone:</strong> +{{$enquiry->country_code}}-{{$enquiry->phone}}
                        </p>
                    </div>
                    
                </div>

                @if(count($enquiry->products) > 0)
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center mb-md-0 mb-4">
                        <h4 class="mt-30 mb-15 wow fadeIn animated animated" style="visibility: visible;">Enquiry Products</h4>
                        <table class="table">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                
                                <th>Tax</th> 
                                <th>Tax Amount</th> 
                                <th>Sub Total</th> 
                            </tr>
                            @foreach($enquiry->products as $product)
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
                                        {{$enquiry->currency}}{{$product->sale_price}}
                                    </td>
                                    <td>{{$product->tax}}%</td>
                                    <td>{{$enquiry->currency}}{{$product->tax_value}}</td>
                                    <td>{{$enquiry->currency}}{{$product->sub_total}}</td>
                                </tr>
                                @if(!empty($product->services) && count($product->services) > 0)
                                    @php
                                        $colspan = 8;
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