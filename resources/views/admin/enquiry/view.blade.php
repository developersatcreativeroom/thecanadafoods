@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enquiry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">View Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
			  <div class="card-header d-flex justify-content-between p-0">
                <h3 class="card-title p-3">Enquiry details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.enquiries')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- <form action="{{ route('admin.product.post') }}" method="post" enctype='multipart/form-data'> -->
				
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<h5>Enquiry Details</h5>
							<hr>

						<div class="row">
							<label class="col-sm-3 col-form-label">Enquiry #</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->enquiry_no}}</p>
							</div>
						</div>

						

						<div class="row">
							<label class="col-sm-3 col-form-label">Enquiry Status</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext enquiry-status">{{$row->enquiry_status}}</p>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-3 col-form-label">Payment Done</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">
								@if($row->is_payment_done)
								<span class="badge bg-success">Done</span>
								@else
								<span class="badge bg-danger">Not Done</span>
								@endif
							</p>
							</div>
						</div>

						@if($row->payment)
						<div class="row">
							<label class="col-sm-3 col-form-label">Payment Method</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext"><strong>{{ucfirst($row->payment_method)}}</strong></p>
							</div>
						</div>
						@endif
						<div class="row">
							<label class="col-sm-3 col-form-label">Products Total</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->amount()}}</p>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-3 col-form-label">Type</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->order_type}}</p>
							</div>
						</div>

						@if($row->customer_gst)
						<div class="row">
							<label class="col-sm-3 col-form-label">Customer GST</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->customer_gst}}</p>
							</div>
						</div>
						@endif

						@if($row->order_notes)
						<div class="row">
							<label class="col-sm-3 col-form-label">Enquiry notes</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->order_notes}}</p>
							</div>
						</div>
						@endif

						<hr>
						


						<h5>Billing Address</h5>
							<hr>

						<div class="row">
							<label class="col-sm-3 col-form-label">Name</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->billing->first_name}} {{$row->billing->last_name}}</p>
							</div>
						</div>

						@if($row->billing->company_name != null)
						<div class="row">
							<label class="col-sm-3 col-form-label">Company Name</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->billing->company_name}}</p>
							</div>
						</div>
						@endif
						<div class="row">
							<label class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->billing->email}}</p>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-3 col-form-label">Phone</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">+{{$row->billing->country_code}}-{{$row->billing->phone}}</p>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-3 col-form-label">Address</label>
							<div class="col-sm-9">
							<p class="form-control-plaintext">{{$row->billing->address_line_1}} {{$row->billing->address_line_2}} 
								{{$row->billing->street}}, {{$row->billing->city}}<br> {{$row->billing->state}}-{{$row->billing->postal}}, {{$row->billing->country}}</p>
							</div>
						</div>

						<hr>
								

						@if($row->shipping)

							<h5>Shipping Address</h5>
								<hr>

							<div class="row">
								<label class="col-sm-3 col-form-label">Name</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->shipping->first_name}} {{$row->shipping->last_name}}</p>
								</div>
							</div>

							@if($row->shipping->company_name != null)
							<div class="row">
								<label class="col-sm-3 col-form-label">Company Name</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->shipping->company_name}}</p>
								</div>
							</div>
							@endif
							<div class="row">
								<label class="col-sm-3 col-form-label">Email</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->shipping->email}}</p>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 col-form-label">Phone</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">+{{$row->shipping->country_code}}-{{$row->shipping->phone}}</p>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 col-form-label">Address</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->shipping->address_line_1}} {{$row->shipping->address_line_2}} {{$row->shipping->street}}, {{$row->shipping->city}}<br> {{$row->shipping->state}}-{{$row->shipping->postal}}, {{$row->shipping->country}}</p>
								</div>
							</div>

							<hr>

						@endif

							</div>

							

							

							
							
						<div class="col-md-6">

						<h5>User Details</h5>
							<hr>

							<div class="row">
								<label class="col-sm-3 col-form-label">Customer Name</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->first_name}} {{$row->last_name}}</p>
								</div>
							</div>

							<div class="row">
								<label class="col-sm-3 col-form-label">Email</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">{{$row->email}}</p>
								</div>
							</div>

							<div class="row">
								<label class="col-sm-3 col-form-label">Phone</label>
								<div class="col-sm-9">
								<p class="form-control-plaintext">+{{$row->country_code}}-{{$row->phone}}</p>
								</div>
							</div>

							<hr>

							<h5>Update Enquiry Status</h5>
							<hr>

							<div class="row mb-3">
								<label class="col-sm-3 col-form-label">Enquiry Status <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" id="enquiry-status">
										<option value="">--Select--</option>
										@foreach(config('constants.ENQUIRY_STATUSES') as $key => $status)
											<option value="{{$status}}" @if(old('status')!=null && old('status')==$key) selected @endif>{{$status}}</option>
										@endforeach
									</select>
									<input type="hidden" name="id" value="@if(!empty($row->id)){{$row->id}}@endif">
								</div>
								@if($errors->has('status'))
									<span class="invalid-feedback">
										{{ $errors->first('status') }}
									</span>
								@endif

							</div>

							<div class="row mb-3">
								<label class="col-sm-3 col-form-label">Note</label>
								<div class="col-sm-9">
									<textarea class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" id="enquiry-note" rows="2" placeholder="Enter Note (Optional)" name="note">@if(old('note')!=null){{old('note')}}@endif</textarea>
								</div>
								@if($errors->has('note'))
									<span class="invalid-feedback">
										{{ $errors->first('note') }}
									</span>
								@endif

							</div>


							<div class="row">
								<label class="col-sm-3 col-form-label">&nbsp;</label>
								<div class="col-sm-9">
								<button type="submit" class="btn btn-primary" id="update-enquiry-status">Update</button>
								</div>
							</div>


							<hr>

							<div id="enquiry-history">
								@include('admin.enquiry.view-history')
							</div>
							
									</div>
								<!-- /.col -->
								</div>

								<div class="row">
									<div class="col">
										<h5>Enquiry Products</h5>
										<hr>
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
												@if($row->payment)
												@if($row->payment->is_state_tax)<th>State Tax</th>@endif
												@if($row->payment->is_central_tax)<th>Central Tax</th>@endif
												@if($row->payment->is_integrated_tax)<th>Integrated Tax</th>@endif
												@endif
												<th>Tax</th>
												<th>Tax Amount</th>
												<th>Brand</th>
												<th>Sub Total <small>(Inc. Tax)<small></th>
												</tr>
											</thead>
											<tbody>
												@foreach($row->products as $key => $product)
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
													<td>{{$row->currency}}{{$product->sale_price}}</td>
													<td>
														@if($product->old_price)
														{{$row->currency}}{{App\Helper::numberFormat($product->old_price-$product->price)}}
														@endif
													</td>
													<td>{{App\Helper::getDiscountPercentage($product)}}</td>
													<td>{{$product->sku}}</td>
													@if($row->payment)
														@if($row->payment->is_state_tax)<td>@if($product->state_tax_amount) {{$row->currency}}{{$product->state_tax_amount}} ({{$product->state_tax}}% {{$product->state_tax_name}}) @endif</td>@endif
														@if($row->payment->is_central_tax)<td>@if($product->central_tax_amount) {{$row->currency}}{{$product->central_tax_amount}} ({{$product->central_tax}}% {{$product->central_tax_name}}) @endif</td>@endif
														@if($row->payment->is_integrated_tax)<td>@if($product->integrated_tax_amount) {{$row->currency}}{{$product->integrated_tax_amount}} ({{$product->integrated_tax}}% {{$product->integrated_tax_name}}) @endif</td>@endif
													@endif
													<td>{{$product->tax}}%</td>
													<td>{{$row->currency}}{{$product->tax_value}}</td>
													<td>{{$product->brand_name}}</td>
													<!-- <td>{{$row->currency}}{{App\Helper::numberFormat(($product->sale_price + $product->tax_value) * $product->quantity)}}</td> -->
													<td>{{$row->currency}}{{App\Helper::numberFormat($product->final_price * $product->quantity )}}</td>
												</tr>

													@if(!empty($product->services) && count($product->services) > 0)
														@php
															$colspan = 12;
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
																<td colspan="{{$colspan}}">
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
									</div>
									</div>

									@if($row->payment)
									<div class="row col justify-content-end">
										<div class="col-md-5">
										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Subtotal:</td>
													<td>{{$row->currency}}{{$row->payment->total}}</td>
												</tr>

												<tr>
													<td>Discount:</td>
													<td>{{$row->currency}}{{$row->payment->discount}}</td>
												</tr>
												
												@if($row->payment->coupon_discount)
												<tr>
													<td>Coupon Discount:</td>
													<td>{{$row->currency}}{{$row->payment->coupon_discount}}</td>
												</tr>
												@endif
												
												@if($row->shipping && !$row->local_pickup)
												<tr>
													<td>Shipping:</td>
													<td>{{$row->currency}}{{$row->payment->shipping}}</td>
												</tr>
												@endif
												
												@if($row->payment->products_service)
												<tr>
													<td>Product(s) Service:</td>
													<td>{{$row->currency}}{{$row->payment->products_service}}</td>
												</tr>
												@endif
												
												<tr>
													<td>Tax:</td>
													<td>{{$row->currency}}{{$row->payment->tax}}</td>
												</tr>
												
												<tr>
													<td><strong>Total:</strong></td>
													<td><strong>{{$row->currency}}{{$row->payment->amount}}</strong></td>
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
                <!-- /.card-body -->
				<!-- <input type="hidden" name="id" value="@if(!empty($row->id)){{$row->id}}@endif">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div> -->
              <!-- </form> -->
            </div>
            <!-- /.card -->

            

          </div>
          <!--/.col -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

@endpush



