@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupon</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Create or Update</li>
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
                <h3 class="card-title p-3">Coupon details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.coupons')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.coupon.post') }}" method="post" enctype='multipart/form-data'>
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<label for="code">Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="Enter Code" name="code" value="@if(old('code')!=null){{old('code')}}@elseif(!empty($row->code)){{$row->code}}@endif" id="coupon-code">
										@if($errors->has('code'))
											<span class="invalid-feedback">
												{{ $errors->first('code') }}
											</span>
										@endif
									</div>
									<div class="col-md-4">
										<label>&nbsp;</label>
										<button type="button" class="btn-block btn btn-primary" id="generate-coupon">Generate Coupon</button>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="users">For User</label>

								@php
									$couponsFor = !empty($row) ? $row->ForUsers()->pluck('users.id')->toArray() : [];
								@endphp

								<select class="select2 form-control {{ $errors->has('users') ? 'is-invalid' : '' }}" id="users" name="users[]" multiple>
									@foreach($users as $user)
										@php
											$isSelected = in_array($user->id, old('users', $couponsFor ?? []));
										@endphp
										<option value="{{ $user->id }}" {{ $isSelected ? 'selected' : '' }}>
											{{ $user->first_name . ' ' . $user->last_name }}
										</option>
									@endforeach
								</select>

								@if($errors->has('users'))
									<span class="invalid-feedback">
										{{ $errors->first('users') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="image">Coupon Image </label>
								<input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/coupons/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
								@if($errors->has('image'))
									<span class="invalid-feedback d-block">
										{{ $errors->first('image') }}
									</span>
								@endif
							</div>
							{{-- @if(!empty($row) && ($row->image != null || $row->image != '' ))
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-4">
											<img class="img-fluid img-thumbnail" src="{{ asset('storage/coupons/') }}/{{$row->id}}/{{$row->image}}" />
										</div>
									</div>
								</div>
							@endif --}}
							<div class="form-group">
								<label for="coupon-type">Type <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="coupon-type" name="type">
									<option value="">--Select--</option>
									<option value="single" @if(old('type')!=null && old('type')=="single") selected @elseif(!empty($row) && $row->type=="single") selected @endif>Single</option>
									<option value="multiple" @if(old('type')!=null && old('type')=="multiple") selected @elseif(!empty($row) && $row->type=="multiple") selected @endif>Multiple</option>
								</select>
								@if($errors->has('type'))
									<span class="invalid-feedback">
										{{ $errors->first('type') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="no_of_times">No of times <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('no_of_times') ? ' is-invalid' : '' }}" id="no_of_times" placeholder="Enter no of times" name="no_of_times" value="@if(old('no_of_times')!=null){{old('no_of_times')}}@elseif(!empty($row->no_of_times)){{$row->no_of_times}}@endif">
								@if($errors->has('no_of_times'))
									<span class="invalid-feedback">
										{{ $errors->first('no_of_times') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="amount_type">Amount Type <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('amount_type') ? ' is-invalid' : '' }}" id="amount_type" name="amount_type">
									<option value="">--Select--</option>
									<option value="percentage" @if(old('type')!=null && old('type')=="percentage") selected @elseif(!empty($row) && $row->amount_type=="percentage") selected @endif>Percentage</option>
									<option value="numeric" @if(old('type')!=null && old('type')=="numeric") selected @elseif(!empty($row) && $row->amount_type=="numeric") selected @endif>Numeric Amount</option>
								</select>
								@if($errors->has('amount_type'))
									<span class="invalid-feedback">
										{{ $errors->first('amount_type') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="amount_value">Amount Value <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('amount_value') ? ' is-invalid' : '' }}" id="amount_value" placeholder="Enter value" name="amount_value" value="@if(old('amount_value')!=null){{old('amount_value')}}@elseif(!empty($row->amount_value)){{$row->amount_value}}@endif">
								@if($errors->has('amount_value'))
									<span class="invalid-feedback">
										{{ $errors->first('amount_value') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="products">Products </label>

								@php
									if(!empty($row) && $row->applicable_on_products != null){
										$couponsProduct = json_decode($row->applicable_on_products);
									}else{
										$couponsProduct = [];
									}
								@endphp

								<select class="select2 form-control {{ $errors->has('products') ? ' is-invalid' : '' }}" id="products" name="products[]" multiple>
									@foreach($products as $product)
										<option @if(old('products')!=null && is_array(old('products')) && in_array($product['id'],old('products'))) selected @elseif(!empty($row) && is_array($couponsProduct) && count($couponsProduct) > 0 && in_array($product['id'], $couponsProduct)) selected @endif value="{{$product->id}}">{{$product->name}}</option>
									@endforeach
								</select>
								@if($errors->has('products'))
									<span class="invalid-feedback">
										{{ $errors->first('products') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="min_product_quantity">Min Product Quantity </label>
								<input type="text" class="form-control only-numbers {{ $errors->has('min_product_quantity') ? ' is-invalid' : '' }}" id="min_product_quantity" placeholder="Enter minimum product quantity, if any" name="min_product_quantity" value="@if(old('min_product_quantity')!=null){{old('min_product_quantity')}}@elseif(!empty($row->min_product_quantity)){{$row->min_product_quantity}}@endif">
								@if($errors->has('min_product_quantity'))
									<span class="invalid-feedback">
										{{ $errors->first('min_product_quantity') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="min_price">Min Price </label>
								<input type="text" class="form-control only-numbers {{ $errors->has('min_price') ? ' is-invalid' : '' }}" id="min_price" placeholder="Enter minimum cart price to add coupon" name="min_price" value="@if(old('min_price')!=null){{old('min_price')}}@elseif(!empty($row->min_price)){{$row->min_price}}@endif">
								@if($errors->has('min_price'))
									<span class="invalid-feedback">
										{{ $errors->first('min_price') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="valid_from">Valid From </label>
								<div class="input-group date datepicker" id="date_picker" data-target-input="nearest">
								<input type="text" class="form-control {{ $errors->has('valid_from') ? ' is-invalid' : '' }}" id="valid_from" placeholder="Enter Coupon valid from date" name="valid_from" value="@if(old('valid_from')!=null){{old('valid_from')}}@elseif(!empty($row->valid_from)){{$row->valid_from}}@endif">
								<div class="input-group-append" data-target="#date_picker" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								@if($errors->has('valid_from'))
									<span class="invalid-feedback" style="display: inline;">
										{{ $errors->first('valid_from') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="valid_to">Valid to </label>
								<div class="input-group date datepicker" id="date_picker1" data-target-input="nearest">
								<input type="text" class="form-control {{ $errors->has('valid_to') ? ' is-invalid' : '' }}" id="valid_to" placeholder="Enter Coupon valid from date" name="valid_to" value="@if(old('valid_to')!=null){{old('valid_to')}}@elseif(!empty($row->valid_to)){{$row->valid_to}}@endif">
								<div class="input-group-append" data-target="#date_picker1" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								@if($errors->has('valid_to'))
									<span class="invalid-feedback" style="display: inline;">
										{{ $errors->first('valid_to') }}
									</span>
								@endif
							</div>

							
							

							<div class="form-group">
								<label for="status">Status <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" name="status">
									<option value="">--Select--</option>
									@foreach(config('constants.STATUSES') as $key => $status)
										<option value="{{$key}}" @if(old('status')!=null && old('status')==$key) selected @elseif(!empty($row) && $row->status==$key) selected @endif>{{$status}}</option>
									@endforeach
								</select>
								@if($errors->has('status'))
									<span class="invalid-feedback">
										{{ $errors->first('status') }}
									</span>
								@endif
							</div>

							

							

							
							
						</div>
						<div class="col-md-6">

					
						</div>
					</div>

                
                </div>
                <!-- /.card-body -->
				<input type="hidden" name="id" value="@if(!empty($row->id)){{$row->id}}@endif">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
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



