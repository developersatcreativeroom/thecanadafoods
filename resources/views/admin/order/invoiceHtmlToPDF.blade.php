<style>

/* body {
	 font-family: 'Montserrat', sans-serif;
	 font-weight: 400;
	 color: #322d28;
} */

.container {
	 max-width: 800px;
	 margin: 0 auto;
}
 table.invoice {
	 background-color: #fff;
}
 .num {
	 font-weight: 200;
	 text-transform: uppercase;
	 letter-spacing: 1.5px;
	 font-size: 14px;
     color: #322d28;
}
 table.invoice tr, table.invoice td {
	 background: #fff;
	 text-align: left;
	 font-weight: 400;
	 color: #322d28;
}

table.invoice tr td {
	/* border: 1px solid red; */
}

.logo{
    width: 200px;
}
.invoice-heading {
	 text-align: right;
	 font-family: 'Montserrat', sans-serif;
	 font-weight: 200;
	 font-size: 28px;
	 color: #0DBABC;
}
/*
 table.invoice tr.details > td {
	 padding-top: 4rem;
	 padding-bottom: 0;
}
 table.invoice tr.details td.id, table.invoice tr.details th.id, table.invoice tr.details td.qty, table.invoice tr.details th.qty {
	 text-align: center;
}
 table.invoice tr.details td:last-child, table.invoice tr.details th:last-child {
	 text-align: right;
}
 table.invoice tr.details table thead, table.invoice tr.details table tbody {
	 position: relative;
}
 table.invoice tr.details table thead:after, table.invoice tr.details table tbody:after {
	 content: '';
	 height: 1px;
	 position: absolute;
	 width: 100%;
	 left: 0;
	 margin-top: -1px;
	 background: #c8c3be;
}
 table.invoice tr.totals td {
	 padding-top: 0;
}
  table.invoice tr.totals table tr td {
	 padding-top: 0;
	 padding-bottom: 0;
}
 table.invoice tr.totals table tr td:nth-child(1) {
	 font-weight: 500;
}
 table.invoice tr.totals table tr td:nth-child(2) {
	 text-align: right;
	 font-weight: 200;
}
 table.invoice tr.totals table tr:nth-last-child(2) td {
	 padding-bottom: 0.5em;
}
 table.invoice tr.totals table tr:nth-last-child(2) td:last-child {
	 position: relative;
}
 table.invoice tr.totals table tr:nth-last-child(2) td:last-child:after {
	 content: '';
	 height: 4px;
	 width: 110%;
	 border-top: 1px solid #0DBABC;
	 border-bottom: 1px solid #0DBABC;
	 position: relative;
	 right: 0;
	 bottom: -0.575rem;
	 display: block;
}
 table.invoice tr.totals table tr.total td {
	 font-size: 12px;
	 padding-top: 0.5em;
	 font-weight: 700;
}
 table.invoice tr.totals table tr.total td:last-child {
	 font-weight: 700;
} */
 h5 {
	 font-size: 16px;
	 font-weight: 700;
	 text-transform: uppercase;
	 letter-spacing: 2px;
	 color: #0DBABC;
}


.text-right{
    text-align:right
}

.margin-bottom{
    padding-bottom: 30px;
}
 
.product-heading{
  font-weight: 700;
  color: #000000;
  font-size: 12px;
}

.product-data{
  font-size: 11px;
}

.total-amount{
    font-size: 18px;
}

</style>


  <table class="container">
    <tbody>
      <tr>
      <td>
   
          <table class="invoice">
            
            <tr>
              <td>
                <br>
                <br>
                <br>
                <img src="{{$logo}}" alt="Yourminiweb" class="logo" />
              </td>
              <td>
                <h2 class="invoice-heading">Invoice</h2>
              </td>
            </tr>

            <br>
            <br>
            <br>

            <tr class="margin-bottom">
              <td>
                Hello, {{$row->billing->first_name}} {{$row->billing->last_name}}.<br>
                Thank you for your order.
              </td>
              <td style="text-align: right;">
                <span class="num">Order #{{$row->order_no}}</span><br>
                {{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}
              </td>
            </tr>
            
            <br>
            <br>
            <br>
            <br>
            
            <tr class="details">
              <td colspan="2">
                <table>
                  <thead>
                    <tr style="background-color:#ddd;">
                      <!-- <td>
                          <h6 class="para">Sr No.</h6>
                      </td>
                      <td style="width:30%;" >
                          <h6 class="para">Product Name </h6>
                      </td>
                      <td>
                          <h6 class="para">Size</h6>
                      </td>
                      <td >
                          <h6 class="para">Package</h6>
                      </td>
                      <td>
                          <h6 class="para">Quantity</h6>
                      </td>
                      <td>
                          <h6 class="para">Unit Price</h6>
                      </td>
                      <td>
                          <h6 class="para">Price</h6>
                      </td>
                      <td >
                          <h6 class="para">Tax</h6>
                      </td>
                       -->
                      <th style="width: 10px">#</th>
                      <th class="product-heading" style="text-align: center;">Image</th>
                      <th class="product-heading" style="text-align: center; width: 100px">Name</th>
                      <th class="product-heading" style="text-align: center;">Quantity</th>
                      <th class="product-heading" style="text-align: center;">Price</th>
                      <th class="product-heading" style="text-align: center;">Discount</th>
                      <th class="product-heading" style="text-align: center;">SKU</th>
                          @if($row->payment->is_state_tax)<th class="product-heading" style="text-align: center;">State Tax</th>@endif
                          @if($row->payment->is_central_tax)<th class="product-heading" style="text-align: center;">Central Tax</th>@endif
                          @if($row->payment->is_integrated_tax)<th class="product-heading" style="text-align: center;">Integrated Tax</th>@endif
                      <th class="product-heading" style="text-align: center;">Tax</th>
                      <th class="product-heading" style="text-align: center;">Tax Amount</th>
                      <th class="product-heading" style="text-align: center;">Brand</th>
                      <th class="product-heading" style="text-align: right;">Sub Total</th>

                      
                  </tr>
                  </thead>
                  <tbody>
                 
                    @foreach($row->products as $key => $product)
                      <tr>
                          <td class="product-data">
                          {{$key+1}}
                          </td>
                          <td class="product-data">
                          @if(!empty($product) && ($product->image != null || $product->image != '' ))
                              <img class="img-fluid img-thumbnail img-thumb-custom" src="{{ asset('storage/products/') }}/{{$product->product_id}}/{{$product->image}}" />
                          @endif
                          </td>
                          <td class="product-data">
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
                          <td class="product-data">{{$product->quantity}}</td>
                          <td class="product-data">{{$row->currency}}{{$product->sale_price}}</td>
                          <td class="product-data">{{$row->currency}}{{App\Helper::numberFormat($product->old_price-$product->price)}}</td>
                          <td class="product-data">{{$product->sku}}</td>
                              @if($row->payment->is_state_tax)<td class="product-data">@if($product->state_tax_amount) {{$row->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
                              @if($row->payment->is_central_tax)<td class="product-data">@if($product->central_tax_amount) {{$row->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
                              @if($row->payment->is_integrated_tax)<td class="product-data">@if($product->integrated_tax_amount) {{$row->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
                          <td class="product-data">{{$product->tax}}%</td>
                          <td class="product-data">{{$row->currency}}{{$product->tax_value}}</td>
                          <td class="product-data">{{$product->brand_name}}</td>
                          <td class="product-data">{{$row->currency}}{{App\Helper::numberFormat($product->final_price * $product->quantity)}}</td>
                      </tr>

                      @if(!empty($product->services) && count($product->services) > 0)
                        @php
                            $colspan = 11;
                            if($row->payment){
                                if($row->payment->is_state_tax){
                                    $colspan++;
                                }
                                if($row->payment->is_central_tax){
                                    $colspan++;
                                }
                                if($row->payment->is_integrated_tax){
                                    $colspan++;
                                }
                            }
                        @endphp

                        @foreach($product->services as $service)
                          <tr class="service-row">
                              <td class="product-data" colspan="{{$colspan}}">
                                  <div class="d-flex align-items-center">
                                      <div class="">
                                          <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted" style="width:80px" src="{{ asset('storage/product-services/') }}/{{$service->id}}/{{$service->image}}" alt="">
                                      </div>
                                      <div class="pl-10">
                                          <h5 class="mb-5 fw-500">
                                              {{$service->name}}
                                          </h5>
                                          <p>Price: {{$row->currency}}{{$service->price}}</p>
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
              </td> 
            </tr>

            <br>
            <br>
            <br>
            <br>

            @if($row->payment)
            <tr class="totals">
              <td></td>
              <td>
                <table>
                  <tr class="subtotal" style="text-align: right;">
                    <td class="">Subtotal</td>
                    <td class="">{{$row->currency}}{{$row->payment->total}}</td>
                  </tr>
                  <tr style="text-align: right;">
                    <td class="">Discount</td>
                    <td class="">{{$row->currency}}{{$row->payment->discount}}</td>
                  </tr>
                  @if($row->payment->coupon_discount)
                    <tr style="text-align: right;">
                      <td>Coupon Discount:</td>
                      <td>{{$row->currency}}{{$row->payment->coupon_discount}}</td>
                    </tr>
                  @endif
                  @if($row->shipping && !$row->local_pickup)
                    <tr style="text-align: right;">
                      <td>Shipping:</td>
                      <td>{{$row->currency}}{{$row->payment->shipping}}</td>
                    </tr>
                  @endif
                  @if($row->payment->products_service)
                    <tr style="text-align: right;">
                      <td>Product(s) Service:</td>
                      <td>{{$row->currency}}{{$row->payment->products_service}}</td>
                    </tr>
                  @endif
                  <tr style="text-align: right;">
                    <td>Tax:</td>
                    <td>{{$row->currency}}{{$row->payment->tax}}</td>
                  </tr>
                  
                  <tr class="total-amount" style="text-align: right;">
                    <td>Total</td>
                    <td>{{$row->currency}}{{$row->payment->amount}}</td>
                  </tr>
                </table>
              </td>
            </tr>
            @endif
         <br>
         <br>
         <br>
            <tr>
              
                <td>
                    
                    <h5>Billing Information</h5>
                    
                      <p>
                        <strong>Name:</strong> {{$row->billing->first_name}} <br> 
                        <strong>Email:</strong> {{$row->billing->email}} <br> 
                        <strong>Phone:</strong> {{$row->billing->phone}} <br> 
                        {{$row->billing->address_line_1}} {{$row->billing->address_line_2}} {{$row->billing->street}} <br>
                        @if($row->billing->company_name)
                          <strong>Company Name:</strong> {{$row->billing->company_name}}<br>
                          @endif
                        {{$row->billing->city}}-{{$row->billing->postal}}<br>
                        {{$row->billing->state}} {{$row->billing->country}}<br>
                      </p>

                    
                </td>
                <td style="text-align: right">
                    <h5>Payment Information</h5>
                    <p>
                    <!--Credit Card
                    <br>
                    Card Type: Visa
                    <br>
                    &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 1234<br>
                    -->
                    {{ucfirst($row->payment_method)}}
                    </p>
                </td>
            </tr>
            @if($row->shipping)
            <tr>
                <td>
                    <h5>Shipping Information</h5>
                    
                      <p>
                        <strong>Name:</strong> {{$row->shipping->first_name}} <br> 
                        <strong>Email:</strong> {{$row->shipping->email}} <br> 
                        <strong>Phone:</strong> {{$row->shipping->phone}} <br> 
                        {{$row->shipping->address_line_1}} {{$row->shipping->address_line_2}} {{$row->shipping->street}} <br>
                        @if($row->shipping->company_name)
                          <strong>Company Name:</strong> {{$row->shipping->company_name}}<br>
                          @endif
                        {{$row->shipping->city}}-{{$row->shipping->postal}}<br>
                        {{$row->shipping->state}} {{$row->shipping->country}}<br>
                      </p>

                    
                </td>
            </tr>
            @endif
        </table>
   

    </td>
    </tr>
    </tbody>
</table>