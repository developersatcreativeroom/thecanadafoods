<table class="sidebar-table w-100 mt-5">

    @if(!$isEnquiryWebsite)
    @php
    $config = App\Helper::getWebsiteConfig('local_pickup');
    @endphp
    @if($config['local_pickup'])
    <tr>
        <td colspan="2">Pickup</td>
        <td colspan="2">

            <div class="custom-checkbox d-flex align-items-center justify-content-end">
                <div class="theme-checkbox flex-shrink-0">
                    <input type="checkbox" id="local-pickup" name="local_pickup"
                        @if(old('local_pickup')!=null && old('local_pickup')=='on' ) checked
                        @endif>
                    <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                </div>
                <label class="ms-2" for="local-pickup">Local
                    Pickup</label>
            </div>

        </td>
    </tr>
    @endif
    @endif

    <tr>
        <td colspan="2">SubTotal</td>
        <td colspan="2" class="text-end subtotal-price">
            {{$checkout['currency']}}{{$checkout['sub_total']}}
        </td>
    </tr>
    <tr class="shipping-row-hidden">
        <td colspan="2">Shipping</td>
        <td colspan="2" class="text-end">
            <span id="shipping"
                data-value="{{$checkout['shipping_calculate']}}">{{$checkout['currency']}}{{$checkout['shipping']}}</span>
        </td>
    </tr>

</table>

<div class="checkout-section-divider"></div>

@if(!$isEnquiryWebsite)
@php
$expressConfig = config('constants.EXPRESS_SHIPPING');
$shippingOptions = $checkout['shipping_options'] ?? null;
$standardValue = config('constants.SHIPPING_STATUS.standard');
$expressValue = config('constants.SHIPPING_STATUS.express');
// Loose == on purpose: old('shipping_method') comes back as a string ("1") from the
// submitted form, while $expressValue/$standardValue are the raw ints from config.
$selectedShippingMethod = old('shipping_method', ($checkout['is_express'] ?? false) ? $expressValue : $standardValue);
@endphp
<div class="shipping-methods">
    <div class="shipping-methods-heading">
        <span class="step-badge">2</span>
        <span>Shipping method</span>
    </div>

    <label class="shipping-option {{ $selectedShippingMethod == $standardValue ? 'is-selected' : '' }}" for="shipping-method-standard">
        <span class="shipping-option-icon standard"><i class="fas fa-truck"></i></span>
        <span class="shipping-option-body">
            <span class="shipping-option-title">Standard shipping</span>
            <span class="shipping-option-sub">Delivered in 5-7 business days</span>
        </span>
        <span class="shipping-option-price">
            @if($shippingOptions && ($shippingOptions['standard']['result'] ?? false))
                {{ $checkout['currency'] }}{{ $shippingOptions['standard']['price_show'] }}
            @else
                <small class="text-muted">Select state</small>
            @endif
        </span>
        <span class="shipping-option-radio">
            <input type="radio" name="shipping_method" value="{{ $standardValue }}" id="shipping-method-standard"
                @if($selectedShippingMethod == $standardValue) checked @endif>
        </span>
    </label>

    @if($expressConfig['enabled'])
    <label class="shipping-option {{ $selectedShippingMethod == $expressValue ? 'is-selected' : '' }}" for="shipping-method-express">
        <span class="shipping-option-badge-fastest">Fastest</span>
        <span class="shipping-option-icon express"><i class="fas fa-bolt"></i></span>
        <span class="shipping-option-body">
            <span class="shipping-option-title">Express shipping</span>
            <span class="shipping-option-sub">Delivered in 2-4 business days for most destinations; rural and remote areas may take 3-4 business days</span>
        </span>
        <span class="shipping-option-price">
            @if($shippingOptions && ($shippingOptions['express']['result'] ?? false))
                {{ $checkout['currency'] }}{{ $shippingOptions['express']['price_show'] }}
            @else
                <small class="text-muted">N/A</small>
            @endif
        </span>
        <span class="shipping-option-radio">
            <input type="radio" name="shipping_method" value="{{ $expressValue }}" id="shipping-method-express"
                @if($selectedShippingMethod == $expressValue) checked @endif>
        </span>
    </label>
    @endif
</div>
@endif

<div class="checkout-section-divider"></div>

<table class="sidebar-table w-100">

    @if(($total_temp_sensitive ?? 0) > 0)
    <tr>
        <td colspan="2">Temp Sensitive Products</td>
        <td colspan="2" class="text-end">
            {{ $total_temp_sensitive }}
        </td>
    </tr>
@endif

    @if($checkout['products_service'] > 0)
    <tr>
        <td colspan="2">Product(s) Service</th>
        <td colspan="2" class="text-end">
            {{$checkout['currency']}}{{$checkout['products_service']}}
        </td>
    </tr>
    @endif

    {{-- <tr>
        <td colspan="2">Tax</td>
        <td colspan="2" class="text-end">{{$checkout['currency']}}{{$checkout['tax']}}</td>
    </tr> --}}

    @if(!$isEnquiryWebsite)
    @if($checkout['coupon_discount'])
    <tr>
        <td colspan="2">Coupon Discount</td>
        <td colspan="2" class="text-end">
            {{$checkout['currency']}}{{$checkout['coupon_discount']}}</td>
    </tr>
    @endif
    @endif

</table>

<div class="checkout-order-total">
    <h6 class="mb-0 fs-md">Total</h6>
    <h6 class="mb-0 fs-md subtotal-price" id="total" data-value="{{$checkout['total_calculate']}}">
        {{$checkout['currency']}}{{$checkout['total']}}</h6>
</div>
