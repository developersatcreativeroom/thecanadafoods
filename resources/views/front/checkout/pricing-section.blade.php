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
    <tr>
        <td colspan="2">Shipping</td>
        <td colspan="2" class="text-end">
            <span id="shipping"
                data-value="{{$checkout['shipping_calculate']}}">{{$checkout['currency']}}{{$checkout['shipping']}}</span>
        </td>
    </tr>

    <tr>
        <td colspan="2">Temp Sensitive Products</td>
        <td colspan="2" class="text-end">
            {{$total_temp_sensitive ?? 0}}
        </td>
    </tr>

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
<span class="sidebar-spacer d-block my-4 opacity-50"></span>
<div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0 fs-md">Total</h6>
    <h6 class="mb-0 fs-md subtotal-price" id="total" data-value="{{$checkout['total_calculate']}}">
        {{$checkout['currency']}}{{$checkout['total']}}</h6>
</div>