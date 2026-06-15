<div class="cart-summery bg-white rounded-2 pt-4 pb-6 px-5 mt-4">
    <table class="w-100">
        <tr>
            <td class="py-3">
                <h5 class="mb-0 fw-medium">Subtotal</h5>
            </td>
            <td class="py-3">
                <h5 class="mb-0 fw-semibold text-end">{{$checkout['currency']}}{{$checkout['sub_total']}}</h5>
            </td>
        </tr>


        @if($checkout['products_service'] > 0)
        <tr>
            <td class="py-3">
                <h5 class="mb-0 fw-medium">Product(s) Service</h5>
            </td>
            <td class="py-3">
                <h5 class="mb-0 fw-semibold text-end">{{$checkout['currency']}}{{$checkout['products_service']}}</h5>
            </td>
        </tr>
        @endif

        {{-- <tr>
            <td class="py-3">
                <h5 class="mb-0 fw-medium">Tax</h5>
            </td>
            <td class="py-3">
                <h5 class="mb-0 fw-semibold text-end">{{$checkout['currency']}}{{$checkout['tax']}}</h5>
            </td>
        </tr> --}}
        
        @if(!$isEnquiryWebsite)
            @if($checkout['coupon_discount'])
            <tr>
                <td class="py-3">
                    <h5 class="mb-0 fw-medium">Coupon Discount</h5>
                </td>
                <td class="py-3">
                    <h5 class="mb-0 fw-semibold text-end">{{$checkout['currency']}}{{$checkout['coupon_discount']}}</h5>
                </td>
            </tr>
            @endif
        @endif

        <tr class="border-top">
            <td class="py-3">
                <h5 class="mb-0">Total</h5>
            </td>
            <td class="text-end py-3">
                <h5 class="mb-0">{{$checkout['currency']}}{{$checkout['total']}}</h5>
            </td>
        </tr>
    </table>
    <p class="mb-5 mt-2">Shipping options will be updated during checkout.</p>
    <div class="btns-group d-flex gap-3">
        @if($isEnquiryWebsite)
            <a href="{{route('checkout')}}" class="btn btn-primary btn-md rounded-1">Proceed To Enquiry</a>
        @else

            @if(!$checkout['is_min_amount'])
                <div class="flex-row">
                <p class="text-danger mb-0">
                    <small>* Minimum items of amount {{$checkout['currency']}}{{$checkout['min_cart_amount']}} to be added in cart to place an order</small>
                </p>
                <a disabled class="btn btn-primary btn-md rounded-1 text-white disabled" >Proceed To Checkout</a>
                </div>
            @else
                <a href="{{route('checkout')}}" class="btn btn-primary btn-md rounded-1">Proceed To Checkout</a>
            @endif
        @endif
    </div>
</div>

