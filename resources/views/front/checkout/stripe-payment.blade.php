@extends('front.layouts.app')

@section('content')

<!--breadcrumb section start-->
    <div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
        <img src="{{ URL::asset('frontend/img/shapes/bg-shape-6.png') }}" alt="bg-shape"
            class="position-absolute start-0 z--1 w-100 bg-shape">
        <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="pata"
            class="position-absolute pata-xs z--1 vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/onion.png') }}" alt="onion"
            class="position-absolute z--1 onion start-0 top-0 vector-shape bg-icon-1">
        <img src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle"
            class="position-absolute z--1 frame-circle vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/energy-drink.png') }}" alt="leaf"
            class="position-absolute z--1 leaf vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/garlic-white.png') }}" alt="garlic"
            class="position-absolute z--1 garlic vector-shape bg-icon-2">
        <img src="{{ URL::asset('frontend/img/shapes/roll-1.png') }}" alt="roll"
            class="position-absolute z--1 roll vector-shape bg-icon-3">
        <img src="{{ URL::asset('frontend/img/shapes/roll-2.png') }}" alt="roll"
            class="position-absolute z--1 roll-2 vector-shape bg-icon-4">
        <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="roll"
            class="position-absolute z--1 pata-xs-2 vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/white-bread.png') }}" alt="tomato"
            class="position-absolute z--1 tomato-half vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/cookie.png') }}" alt="tomato"
            class="position-absolute z--1 tomato-slice vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/cauliflower.png') }}" alt="tomato"
            class="position-absolute z--1 cauliflower vector-shape bg-icon-5">
        <img src="{{ URL::asset('frontend/img/shapes/leaf-gray.png') }}" alt="tomato"
            class="position-absolute z--1 leaf-gray vector-shape bg-icon-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="mb-2 text-center">Payment</h2>
                        <nav>
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                                        href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item fw-bold" aria-current="page">Checkout</li>
                                <li class="breadcrumb-item fw-bold" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb section end-->

        <!--checkout section start-->
        <div class="checkout-section ptb-80">
            <div class="container">

                <div class="row justify-content-center mt-5">
                    

                    @php
                        $subTotal = 0;
                    @endphp

                    @if(count($order->products) > 0)
                    <div class="row justify-content-center d-none">
                        <div class="col-md-8 text-center">
                            <h6 class="mt-4">Order Products</h6>
                            <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
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
                                        <td>{{$order->currency}}{{$product->sub_total}}</td>
                                        @php
                                            $subTotal = $subTotal + $product->sale_price;
                                        @endphp

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
                    

                    


                
               
                <div class="row justify-content-center">
                    <div class="col-md-8">
                    <div class="card py-10 px-6">
                        <div class="row justify-content-center1">
                        <div class="col-md-8">

                        <h4>Payment Information</h4>
                        <hr>

                        <form method="POST" action="{{ route('stripe.checkout', ['order_id' => $order->order_unique_id]) }}" class="card-form mt-3 mb-3">
                            @csrf
                            
                            
                            {{-- <div class="mt-3">
                                        
                                <input type="hidden" name="payment_method" class="payment-method">

                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0"><small>Card Information:</small></p>
                                    <img class="img-fluid payment-image" src="{{ URL::asset('frontend/img/theme/cards.png') }}" />
                                </div>
                                <input class="mb-2 form-control payment-input" name="card_holder_name" placeholder="Card holder name" required>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="card-element"></div>
                                    </div>
                                </div>
                                <div class="mb-2 text-danger" id="card-errors" role="alert"></div>
                                
                                <button type="submit" class="btn btn-primary btn-md rounded-1 mt-4 pay">Proceed Now</button>
                                
                            </div> --}}

                            @auth('web')
                                {{-- @if(array_key_exists('stripe_checkout',$allowedPaymentMethods)) --}}
                                    @if(isset($paymentMethods) && count($paymentMethods) > 0)

                                        <div class="mb-5">
                                            @php
                                                $selectedPaymentMethod = old('payment_method') ?? ($paymentMethods->last()->id ?? null);
                                            @endphp
                                            @foreach($paymentMethods as $key => $paymentMethod)
                                                <div class="form-title d-flex align-items-center mb-3 border rounded-2 border-custom-color p-3">
                                                    <div class="theme-radio">
                                                        <input type="radio" name="payment_method" id="{{$key}}Radio" value="{{$paymentMethod->payment_method}}"
                                                            {{ $selectedPaymentMethod == $paymentMethod->id ? 'checked' : '' }}  >
                                                        <span class="custom-radio"></span>
                                                    </div>
                                                    <label class="f-bold mb-0 ms-2 w-100 {{ $errors->has('payment_method') ? ' is-invalid' : '' }}"
                                                        for="{{$key}}Radio">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span>**** **** **** {{$paymentMethod->last_four}}</span> 
                                                            <span class="card-image {{$paymentMethod->provider}}">
                                                                {{-- {{$paymentMethod->provider}} --}}
                                                            </span>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach

                                            @if(isset($paymentMethods) && count($paymentMethods) > 0)
                                                <div class="row">
                                                    <div class="col">
                                                        <a class="btn btn-secondary btn-sm py-1 px-2 show-add-payment-method"><i class="fas fa-plus"></i> Card</a>
                                                    </div>
                                                </div>
                                            @endif

                                    
                                            <button type="submit" class="btn btn-primary btn-md rounded-1 mt-4 pay">Proceed Now</button>
                                            
                                        </div>
                                    @else
                                        <div class="mt-3">

                                            <input type="hidden" name="payment_method" class="payment-method">

                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0"><small>Card Information:</small></p>
                                                <img class="img-fluid payment-image" src="{{ URL::asset('frontend/img/theme/cards.png') }}" />
                                            </div>
                                            <input class="mb-2 form-control payment-input" name="card_holder_name" placeholder="Card holder name" required>
                                            <input type="hidden" name="save_card" value="1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="card-element"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2 text-danger" id="card-errors" role="alert"></div>
                                    
                                            <button type="submit" class="btn btn-primary btn-md rounded-1 mt-4 pay">Proceed Now</button>
                                            
                                        </div>
                                    @endif
                                {{-- @endif --}}

                                
                            @endauth

                            @guest
                                {{-- @if(array_key_exists('stripe_checkout',$allowedPaymentMethods)) --}}
                                    <div class="mt-3">
                                                                    
                                        <input type="hidden" name="payment_method" class="payment-method">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0"><small>Card Information:</small></p>
                                            <img class="img-fluid payment-image" src="{{ URL::asset('frontend/img/theme/cards.png') }}" />
                                        </div>
                                        <input class="mb-2 form-control payment-input" name="card_holder_name" placeholder="Card holder name" required>
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="card-element"></div>
                                            </div>
                                        </div>
                                        <div class="mb-2 text-danger" id="card-errors" role="alert"></div>
                                
                                        <button type="submit" class="btn btn-primary btn-md rounded-1 mt-4 pay">Proceed Now</button>
                                        
                                    </div>
                                {{-- @endif --}}
                            @endguest
                            
                            <input type="hidden" name="order_id" value="{{$order->order_unique_id}}" />


                        </form>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-4">
                        {{-- <h6>Order No: {{$order->order_no}}</h6> --}}
                        <div class="card py-10 px-6">

                        <h4>User Information</h4>
                        <hr>
                        

                        <div class="row">
                        <div class="col">
                        <h6>Shipping Information</h6>
                        <p>
                            <strong>Address:</strong> {{$order->shipping->address_line_1}} {{$order->shipping->address_line_2}} {{$order->shipping->street}}, {{$order->shipping->city}}<br> {{$order->shipping->state}}-{{$order->shipping->postal}}, {{$order->shipping->country}}
                           
                        </p>
                    </div>
                    
                    <hr>

                    {{-- @if($order->status) --}}
                    <div class="row">
                        <div class="col">
                        <h6>Payment Details</h6>
                        <p class="d-flex justify-content-between mb-2">
                            <strong>Sub-total:</strong> <span>{{$order->currency}}{{$subTotal}}</span>
                        </p>
                        <p class="d-flex justify-content-between mb-2">
                            <strong>Shipping:</strong> <span>{{$order->shipment->currency}}{{$order->shipment->price}}</span>
                        </p>
                            {{-- @if($order->payment->discount && $order->payment->discount > 0)
                            <strong>Discount:</strong> {{$order->currency}}{{$order->payment->discount}} <br>
                            @endif --}}
                            {{-- @if($order->payment->coupon_discount && $order->payment->coupon_discount > 0)
                            <strong>Coupon Discount:</strong> {{$order->currency}}{{$order->payment->coupon_discount}} <br>
                            @endif --}}
                            {{-- @if($order->shipping && !$order->local_pickup)
                            <strong>Shipping:</strong> {{$order->currency}}{{$order->payment->shipping}} <br>
                            @endif --}}
                            {{-- <strong>Tax:</strong> {{$order->currency}}{{$order->payment->tax}} <br> --}}
                        <p class="d-flex justify-content-between mb-2">
                            <strong>Amount:</strong> <strong><span>{{$order->currency}}{{$subTotal + $order->shipment->price}}</span></strong>
                        </p>
                    </div>
                    </div>
                    </div>
                    {{-- @endif --}}
                </div>
                </div>

                </div>

            </div>
        </div>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
<script src="https://js.stripe.com/v3/"></script>

@if(!(isset($paymentMethods) && count($paymentMethods) > 0))
<script>
    let stripe = Stripe("{{ config('services.stripe.key') }}");
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    
    let card = elements.create('card', { hidePostalCode: true, style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('.card-form').on('submit', function (e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)
                $('.card-form').submit()
            }
        })
        return false
    })
</script>
@endif


@auth('web')
    <script>
        // const stripePaymentMethod = Stripe("{{ config('services.stripe.key') }}");
        // const {paymentMethod, error} = await stripePaymentMethod.createPaymentMethod({
        //     type: 'card',
        //     card: cardElement,
        // });

        // console.log(paymentMethod);
        // console.log(error);

        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        
        let cardElement = elements.create('card', {
                hidePostalCode: true
            });
        cardElement.mount('#card-element')

        document.getElementById('payment-form').addEventListener('submit', async (e) => {
        // $('body').on('click', '#payment-form #submit', function (e) {
        // $('#payment-form').on('submit', function (e) {
            e.preventDefault();

            const cardholderName = document.getElementById('cardholder-name').value;

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: cardholderName
                },
                //hidePostalCode: true
            });

            if (error) {
                alert(error.message);
            } else {
                // send to backend
                // const res = await fetch('/api/payment-methods', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                //         'Authorization': 'Bearer YOUR_USER_TOKEN' // if using auth via token
                //     },
                //     body: JSON.stringify({
                //         payment_method: paymentMethod.id
                //     })
                // });

                // const data = await res.json();
                // alert(data.message);

                $('.loader').removeClass('d-none');

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: site_url + "/save-payment-method",
                    data: {
                        payment_method: paymentMethod.id
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.result) {
                            $('#addPaymentMethodModal').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(response.message, 'Error');
                        }

                        return false;

                    },
                    error: function(xhr, textStatus) {
                        if (xhr.status == 422) {
                            var responseText = $.parseJSON(xhr.responseText);
                            validateAfterCall(responseText, modalBody);
                        }
                        return false;
                    },
                    complete: function(xhr, textStatus) {
                        $('.loader').addClass('d-none');
                        // console.log(response);

                        that.prop("disabled", false);
                        that.find('i').remove();

                        if (xhr.status == 401) {
                            window.location.href = site_url + "/login";
                        }
                    }
                });
            }
        });
    </script>
@endauth


@endpush