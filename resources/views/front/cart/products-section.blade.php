<div class="rounded-2 overflow-hidden">
    <table class="cart-table w-100 mt-4 bg-white">
        <thead>
            <th>Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Price</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($cart as $cartSingle)
            <tr>
                <td>
                    @if($cartSingle->is_variant && $cartSingle->attribute)
                        <img class="img-fluid cart-img" src="{{ asset('storage/products/') }}/{{$cartSingle->product_id}}/{{$cartSingle->attribute->image}}" alt="{{$cartSingle->name}}">
                    @else
                        <img class="img-fluid cart-img" src="{{ asset('storage/products/') }}/{{$cartSingle->product_id}}/{{$cartSingle->image}}" alt="{{$cartSingle->name}}">    
                    @endif
                </td>
                <td class="text-start product-title">
                    <h6 class="mb-0"><a href="{{route('product',$cartSingle->slug)}}" class="text-dark">{{$cartSingle->name}}</a>
                    </h6>

                    @if($cartSingle->is_variant && $cartSingle->attribute)
                        @if(isset($cartSingle->attribute->details))
                            <p class="">
                                @foreach($cartSingle->attribute->details as $detail)
                                    <span class="badge text-dark ps-0 pe-1">{{$detail->attribute_name}}: {{$detail->attribute_option_name}}</span>
                                @endforeach
                            </p>
                        @endif
                    @endif

                </td>
                <td>
                    <div class="product-qty d-inline-flex align-items-center detail-qty">
                        <button class="qty-down update-cart" data-key="{{$cartSingle->slug}}">-</button>
                        <input type="text" class="qty-val only-numbers update-cart-input" value="{{$cartSingle->quantity}}">
                        <button class="qty-up update-cart"  data-key="{{$cartSingle->slug}}" data-stock="@if(!$cartSingle->is_variant){{$cartSingle->stock}}@else{{$cartSingle->attribute->stock}}@endif">+</button>
                    </div>

                </td>
                <td>
                    <span class="text-dark fw-bold me-2 d-lg-none">Unit Price:</span>
                    <span class="text-dark fw-bold">
                        {{$cartSingle->productPriceShow()}}
                        @if($cartSingle->is_tax_included)
                            <small>({{$cartSingle->tax}}% inc)</small>
                        @endif
                    </span>
                </td>
                <td>
                    <span class="text-dark fw-bold me-2 d-lg-none">Total Price:</span>
                    <span class="text-dark fw-bold">{{$cartSingle->productQuantityPriceShow()}}</span>
                </td>


                <td class="action" data-title="Remove"><a href="#" class="text-muted delete-cart" data-key="{{$cartSingle->slug}}"><i class="fa-solid fa-trash-can"></i></a></td>

                <input type="hidden" name="product_attribute" value="{{$cartSingle->product_attribute_id}}" />

            </tr>

            @php
                $config = App\Helper::getWebsiteConfig('product_services');
            @endphp

            @if($config['product_services'])
                @if(!empty($cartSingle->productServices) && count($cartSingle->productServices) > 0)

                    @foreach($cartSingle->productServices as $service)
                        @php
                            $alreadyService = App\Helper::serviceAlreadyInCart($cartSingle->product_row_id,$cartSingle->product_attribute_id,$service);
                        @endphp
                        <tr class="service-row">
                            <td colspan="6">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted" src="{{ asset('storage/product-services/') }}/{{$service->id}}/{{$service->image}}" alt="">
                                    </div>
                                    <div class="pl-10">
                                        <h5 class="mb-5 fw-500">
                                            {{$service->name}}
                                        </h5>
                                        <p>Price: {{$service->getPrice()}}</p>
                                        <p class="font-sm text-grey-5">{{$service->summary}}</p>
                                        <!-- <p class="text-grey-3">{{$service->description}}</p> -->

                                    </div>
                                    <div class="pl-10 align-self-center">
                                        @if($alreadyService)
                                            <button class="button btn-sm p-2 service  remove-service" data-key="{{$cartSingle->slug}}" data-service="{{$service->slug}}">Remove Service</button>
                                        @else
                                            <button class="button btn-sm p-2 service add-service" data-key="{{$cartSingle->slug}}" data-service="{{$service->slug}}">Add Service</button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                @endif
            @endif
            
            @endforeach

           
        </tbody>
    </table>
</div>