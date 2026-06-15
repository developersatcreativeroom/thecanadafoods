<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <title>Packing Slip</title>
        <style type="text/css">
          @font-face {
              font-family: 'junicoderegular';
              src: url('../../css/fonts/junicode-webfont.eot');
              src: url('../../css/fonts/junicode-webfont.eot?#iefix') format('embedded-opentype'),
                   url('../../css/fonts/junicode-webfont.woff2') format('woff2'),
                   url('../../css/fonts/junicode-webfont.woff') format('woff'),
                   url('../../css/fonts/junicode-webfont.ttf') format('truetype'),
                   url('../../css/fonts/junicode-webfont.svg#junicoderegular') format('svg');
              font-weight: normal;
              font-style: normal;
          }

          @font-face {
              font-family: 'open_sans';
              src: url('../../css/fonts/opensans-regular-webfont.eot');
              src: url('../../css/fonts/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),
                   url('../../css/fonts/opensans-regular-webfont.woff2') format('woff2'),
                   url('../../css/fonts/opensans-regular-webfont.woff') format('woff'),
                   url('../../css/fonts/opensans-regular-webfont.ttf') format('truetype'),
                   url('../../css/fonts/opensans-regular-webfont.svg#open_sansregular') format('svg');
              font-weight: normal;
              font-style: normal;
          }
          html{font-size: 13px;}
          body{font-size: 1rem;}
          .Btnsdiv__Invoice{margin-bottom: 30px; margin-top: 30px; text-align: center;}
          .Btnsdiv__Invoice input{background-color: #121212; color: #fff; opacity: 0.75;text-decoration: none;outline: none; border-width: 1px; border-color: transparent; border-style: solid; display: inline-block; padding: 8px 12px; margin-bottom: 0; margin-right: 15px; margin-left: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; background-clip: padding-box; float: none; cursor: pointer;}
          .Btnsdiv__Invoice input:focus,
          .Btnsdiv__Invoice input:hover,
          .Btnsdiv__Invoice input:active{color: #fff; background-color: #999; opacity: 1; text-decoration: none;outline: none; border-width: 1px; border-color: transparent; border-style: solid; cursor: pointer;}
          .fullWidth{width: 100%; float: left; display: inline-block; position: relative;}
          .InvoiceTable p{margin-bottom: 0; margin-top: 0; line-height: 1.257;letter-spacing: 0; color: #000000; font-size: 0.81275rem;}
          .InvoiceTable p.barcode:not(:last-of-type){margin-bottom: 10px;}
          .InvoiceTable tr > td:only-child{width: 100%;}
          .InvoiceTable tr > td{font-size: 0.81275rem;}
          .InvoiceTable p:not(:last-of-type){margin-bottom: 3px; margin-top: 0; display: inline-block; width: 100%; float: left;text-align: left;}
          .InvoiceTable h6{margin-bottom: 0; margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'junicoderegular', sans-serif; letter-spacing: 1px; font-weight: 600; font-size: 1rem; line-height: 1.1428;}
          .InvoiceTable h6 span{display: inline-block; float: none; font-family: "open_sans", sans-serif; font-weight: normal;}
          .InvoiceTable h1{margin-bottom: 0; margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'junicoderegular', sans-serif; font-size: 17.75px; letter-spacing: 1px;font-weight: 600;}
          .InvoiceTable h1.para{margin-bottom: 0;margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'open_sans', sans-serif; font-size: 17.75px; letter-spacing: 1px;font-weight: 600;}
          .InvoiceTable h6:not(:last-of-type){ margin-bottom: 6px;}
          .InvoiceTable h6:only-of-type{margin-bottom: 6px !important;}
          html{font-size-adjust: 100%; -webkit-text-size-adjust: 100%;}
          body{margin: 0; padding: 0; font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 1rem; font-weight: normal; font-style: normal; text-align: center;}
          /* .barcode {font-family: 'basawa_3_of_9_mhrregular';font-size:48px;} */
          .InvoiceTable h6{font-size: 14px; font-weight: bold;}
          h6.para{font-family: "open_sans", sans-serif; font-size: 12px;}
          table.InvoiceTable h6.para{margin-bottom: 0 !important;}
          *,*:after,*:before{box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;}
          table.InvoiceTable{float: none; width: 100%; border: 1px solid #ddd; table-layout: fixed; text-align: left; border-collapse: collapse;vertical-align: top;font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 14px; }
          table.InvoiceTable > tbody > tr:not(:last-of-type){border-bottom: 1px solid #ddd;}
          table.InvoiceTable td,
          table.InvoiceTable th{padding: 8px;vertical-align: top;}
          table:not(.InvoiceTable){table-layout: fixed; width: 100%; float: left;border-collapse: collapse; vertical-align: top;font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 14px; }
          table td,
          table th{padding: 3px; vertical-align: top;}
          img{max-width: 100%;}
          .text-right{
            text-align:right;
          }
          @media print {    
            @page{
                size: 8.267in 11.6929in;
            }
            #ButtonDiv{display: none;}            
          }
        </style>
    </head>
    <body>
        <div class="fullWidth Btnsdiv__Invoice" id="ButtonDiv">
            <input value="Print Invoice" onclick="javascript:window.print();" type="button">
            <input value="Close Window" onclick="window.close();" type="button">
        </div>
        <div style="max-width: 780px; text-align: center; float: none; display: inline-block; width: 100%;">
            <table width="100%" class="InvoiceTable" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
                <tr>
                	<td colspan="3">
                		<h1 class="fullWidth" style="text-align: center; margin: 0;">INVOICE</h1>
                	</td>
                </tr>
                <tr>
                    <td style="width: 105px; vertical-align: middle;"><img style="max-width:150px" src="{{ App\Helper::getLightLogo(); }}"></td>
                    <td>
                        <p>{{config('constants.BUSINESS.name')}}</p>
                        <p>{{config('constants.ADDRESS.return_address')}}</p>
                    </td>
                    <td>
                        {{-- <p>Mobile No. : {{App\Helper::makePhonesText(config('constants.CONTACT.country_code'), config('constants.CONTACT.phone'))}}
                        </p> --}}
                        <p>Email: {{config('constants.CONTACT.email')}}</p>
                        @if(config('constants.BUSINESS.gst'))
                            <p>GST No.: {{config('constants.BUSINESS.gst')}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left;">
                        <tr>
                          <td>                                    
                              <h6>Sold To:</h6>
                              <p>
                                <strong>Name:</strong> {{$order->billing->first_name}} {{$order->billing->last_name}}
                              </p>
                              <p>
                                <strong>Email:</strong> {{$order->billing->email}}
                              </p>
                              <p>
                                <strong>Phone:</strong> {{$order->billing->phone}}
                              </p>
                              @if($order->billing->company_name)
                              <p>
                                <strong>Company Name:</strong> {{$order->billing->company_name}}
                              </p>
                              @endif

                              <p>
                                <strong>Address:</strong>
                                {{$order->billing->address_line_1}} {{$order->billing->address_line_2}} {{$order->billing->street}} <br>
                                {{$order->billing->city}}-{{$order->billing->postal}}<br>
                                {{$order->billing->state}} {{$order->billing->country}} 
                              </p>
                              
                          </td>
                          @if($order->shipping)
                            <td>                                    
                                <h6>Shipped To:</h6>
                                <p>
                                    <strong>Name:</strong> {{$order->shipping->first_name}} {{$order->shipping->last_name}}
                                </p>
                                <p>
                                    <strong>Email:</strong> {{$order->shipping->email}}
                                </p>
                                <p>
                                    <strong>Phone:</strong> {{$order->shipping->phone}}
                                </p>
                                @if($order->shipping->company_name)
                                <p>
                                    <strong>Company Name:</strong> {{$order->shipping->company_name}}
                                </p>
                                @endif

                                <p>
                                    <strong>Address:</strong>
                                    {{$order->shipping->address_line_1}} {{$order->shipping->address_line_2}} {{$order->shipping->street}} <br>
                                    {{$order->shipping->city}}-{{$order->shipping->postal}}<br>
                                    {{$order->shipping->state}} {{$order->shipping->country}} 
                                </p>
                            </td>
                          @endif
                          <td>
                              <!-- <h1>{{ ($order->payment_method == "instamojo") ? "Instamojo" : 'COD' }} Order</h1> -->
                              <h1>Order</h1>
                              <p><strong>Order ID: </strong>{{$order->order_no}}</p>
                              <p><strong>Order Date: </strong>{{$order->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</p>
                              @if($order->status)
                              <p><strong>Sub-total: </strong>{{$order->currency}}{{$order->payment->total}}</p>   
                              @endif
                              @if($order->customer_gst)
                              <p><strong>Customer GST: </strong>{{$order->customer_gst}}</p>   
                              @endif
                              @if($order->local_pickup)
                              <p><strong>Pickup: </strong>Local Pickup</p>   
                              @endif

                          </td>
                        </tr>                        
                      </table>
                    </td>
                </tr>
           
                <!-- <tr>
                    <td colspan="3">
                        <h3 class="para">Grand Total in Words: &nbsp; 
                      Only</h3>   
                    </td>
                </tr> -->
                <tr>
                    <td colspan="3">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
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
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Product SKU</th>
                                        {{-- @if($order->payment->is_state_tax)<th>State Tax</th>@endif
                                        @if($order->payment->is_central_tax)<th>Central Tax</th>@endif
                                        @if($order->payment->is_integrated_tax)<th>Integrated Tax</th>@endif
                                    <th>Tax</th>
                                    <th>Tax Amount</th> --}}
                                    <th>Brand</th>
                                    <th>Sub Total</th>

                                    
                                </tr>
                                
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
                                        <td>{{$order->currency}}{{App\Helper::numberFormat($product->old_price-$product->price)}}</td>
                                        <td>{{$product->sku}}</td>
                                            {{-- @if($order->payment->is_state_tax)<td>@if($product->state_tax_amount) {{$order->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
                                            @if($order->payment->is_central_tax)<td>@if($product->central_tax_amount) {{$order->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
                                            @if($order->payment->is_integrated_tax)<td>@if($product->integrated_tax_amount) {{$order->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
                                        <td>{{$product->tax}}%</td>
                                        <td>{{$order->currency}}{{$product->tax_value}}</td> --}}
                                        <td>{{$product->brand_name}}</td>
                                        <td>{{$order->currency}}{{App\Helper::numberFormat($product->final_price * $product->quantity)}}</td>
                                    </tr>

                                        @if(!empty($product->services) && count($product->services) > 0)
                                        @php
                                            $colspan = 11;
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
                                
                                <!-- <tr style="background-color:#F5F5F5;">
                                    <td colspan="6">
                                    </td>
                                    <td colspan="3" style="text-align: left; vertical-align: middle;">
                                        <p style="margin-top: 0">
                                            Order Status: &nbsp;&nbsp;&nbsp;&nbsp;{{$order['order_status']}}
                                        </p>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>

                        @if($order->payment)
                            <table class="table mb-0 text-right">
                                <thead>
                                    <tr>
                                        <th>
                                            &nbsp;
                                        </th>
                                        <th style="width:120px">
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sub-Total:</td>
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
                        @endif	
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h6 class="fullWidth" style="text-align: left; margin-bottom: 5px; margin-top: 5px;"> 
                            Terms &amp; Conditions                            
                        </h6>
                        <ul style="float: left; width: 100%; position: relative; margin: 0; padding: 0; list-style-type: disc; list-style-position: inside;">
                            <li style="float: left; width: 100%; font-size: 0.875rem; margin-bottom: 4px;">Goods once sold are not refundable.</li>
                            <li style="float: left; width: 100%; font-size: 0.875rem; margin-bottom: 4px;">We declare that this invoice shows the actual price of goods and that all particulars are true and correct. Every article is packed after proper inspection and with due care. Our responsibility ceases after the goods leave our godown. No claim of any nature will be entertained at later date.</li>
                            <li style="float: left; width: 100%; font-size: 0.875rem;">This is a computer generated invoice and does not require signature.</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>