@auth('web')
@if(array_key_exists('stripe_checkout',$allowedPaymentMethods))
    @if(isset($paymentMethods) && count($paymentMethods) > 0)
        <div class="mb-5">
            @php
                $selectedPaymentMethod = old('stripe_payment_method') ?? ($paymentMethods->last()->id ?? null);
            @endphp
            @foreach($paymentMethods as $key => $paymentMethod)
                <div class="form-title d-flex align-items-center mb-3 border rounded-2 border-custom-color p-3">
                    <div class="theme-radio">
                        <input type="radio" name="stripe_payment_method" id="{{$key}}Radio" value="{{$paymentMethod->id}}"
                            {{ $selectedPaymentMethod == $paymentMethod->id ? 'checked' : '' }}  >
                        <span class="custom-radio"></span>
                    </div>
                    <label class="f-bold mb-0 ms-2 w-100 {{ $errors->has('stripe_payment_method') ? ' is-invalid' : '' }}"
                        for="{{$key}}Radio">
                        <div class="d-flex justify-content-between">
                            <span>**** **** **** {{$paymentMethod->last_four}}</span> 
                            <span class="card-image {{$paymentMethod->provider}}">
                                {{-- {{$paymentMethod->provider}} --}}
                            </span>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    @else

        @if($checkout['is_min_amount'])
            <div class="mt-3 mb-10">
                                            
                <input type="hidden" name="stripe_payment_method" class="stripe-payment-method">

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
                <div  class="text-danger" id="card-errors" role="alert"></div>
                {{-- <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary pay">Purchase</button>
                </div> --}}
                
            </div>
        @endif
        
    @endif 
@endif 

    
@endauth

@guest
    @if($checkout['is_min_amount'])
        @if(array_key_exists('stripe_checkout',$allowedPaymentMethods))
            <div class="mt-3 mb-10">
                                            
                <input type="hidden" name="stripe_payment_method" class="stripe-payment-method">

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
                <div  class="text-danger" id="card-errors" role="alert"></div>
                {{-- <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary pay">Purchase</button>
                </div> --}}
                
            </div>
        @endif
    @endif
@endguest

@if($errors->has('stripe_payment_method'))
    <div class="invalid-feedback d-block">
        <div>{{ $errors->first('stripe_payment_method') }}</div>
    </div>
@endif
{{-- <pre>{{print_r($errors)}}</pre> --}}
<div class="place-order-cont mt-5">
    @if(!$isEnquiryWebsite)

        {{-- <p class="text-danger mb-0">
            <small>
                Orders are currently closed due to tariff issues. We will reopen orders within 1–2 months once the issue is resolved.
            </small>
        </p> --}}

        @if(Auth::user()) 
            @if(count($addresses) < 1) 
                <p class="text-danger mb-0"><small>* Please add address</small></p>

                <a disabled class="btn btn-primary btn-md rounded w-100 text-white no-user-address disabled" value="">
                    Place Order
                </a>
            @elseif(!$checkout['shipping_data']['result'])

                <p class="text-danger mb-0"><small>* {{$checkout['shipping_data']['message']}}</small></p>

                <a disabled class="btn btn-primary btn-md rounded w-100 text-white no-user-address disabled" value="">
                    Place Order
                </a>

            @elseif(!$checkout['is_min_amount'])

                <p class="text-danger mb-0">
                    <small>* Minimum items of amount {{$checkout['currency']}}{{$checkout['min_cart_amount']}} to be added in cart to place an order</small>
                </p>
                <a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Order</a>


            @elseif(count($allowedPaymentMethods) <= 0)

                {{-- <p class="text-danger mb-0">
                    <small>* Currently no Payment method available </small>
                </p> --}}
                <a disabled class="btn btn-primary btn-md rounded w-100 text-white no-payment-method disabled" value="">
                    Place Order
                </a>

            @else
                <input type="submit" class="btn btn-primary btn-md rounded w-100 submit-btn" value="Place Order" />
                
            @endif

        @elseif(count($allowedPaymentMethods) <= 0)
            {{-- <p class="text-danger mb-0">
                <small>* Currently no Payment method available </small>
            </p> --}}
            <a disabled class="btn btn-primary btn-md rounded w-100 text-white no-payment-method disabled" value="">
                Place Order
            </a>

        @elseif(!$checkout['is_min_amount'])

            <p class="text-danger mb-0">
                <small>* Minimum items of amount {{$checkout['currency']}}{{$checkout['min_cart_amount']}} to be added in cart to place an order</small>
            </p>
            <a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Order</a>

        @else
            <input type="submit" class="btn btn-primary btn-md rounded w-100" value="Place Order" />

            {{-- <p class="text-danger mb-0"><small>*Please fill in valid address details first </small></p> --}}
            {{-- <a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Order</a> --}}

        @endif

    @else

        @if(count($addresses) < 1 && Auth::user()) 
            <p class="text-danger mb-0">
                <small>* Please add address</small>
            </p>
            <a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" value="">Place Enquiry</a>
                
        @elseif(!$checkout['is_min_amount'])

        <p class="text-danger mb-0">
            <small>* Minimum items of amount {{$checkout['currency']}}{{$checkout['min_cart_amount']}} to be added in cart to place an order</small>
        </p>
        <a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Enquiry</a>

        @else
            <input type="submit" class="btn btn-primary btn-md rounded w-100"
                value="Place Enquiry" />
        @endif

    @endif

</div>
