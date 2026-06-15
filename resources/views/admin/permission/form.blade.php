@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permission</h1>
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

    @php
        $config = App\Helper::getWebsiteConfig();
    @endphp
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
			  <div class="card-header d-flex justify-content-between p-0">
                <h3 class="card-title p-3">Permission details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.permissions')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.permission.post') }}" method="post" enctype='multipart/form-data'>
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Permission Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter Name" name="name" value="@if(old('name')!=null){{old('name')}}@elseif(!empty($row->name)){{$row->name}}@endif">
								@if($errors->has('name'))
									<span class="invalid-feedback">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>

              <div class="form-group">
                <label for="permission">Permission Modules <span class="text-danger">*</span></label>
                <div class="row">
                  
                  <div class="col-md-4">
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="users"  @if(!empty($row->permission) && in_array('users', $row->permission)) checked @elseif(old('permission')!=null && in_array('users', old('permission'))) checked @endif id="users">
                      <label class="form-check-label" for="users">Users</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="attributes"  @if(!empty($row->permission) && in_array('attributes', $row->permission)) checked @elseif(old('permission')!=null && in_array('attributes', old('permission'))) checked @endif id="attribute">
                      <label class="form-check-label" for="attribute">Attributes</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="taxes"  @if(!empty($row->permission) && in_array('taxes', $row->permission)) checked @elseif(old('permission')!=null && in_array('taxes', old('permission'))) checked @endif id="taxes">
                      <label class="form-check-label" for="taxes">Taxes</label>
                    </div>
                    @if(!$config['is_enquiry_website'])
                      @if($config['coupon'])
                        <div class="form-check">
                          <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="coupons"  @if(!empty($row->permission) && in_array('coupons', $row->permission)) checked @elseif(old('permission')!=null && in_array('coupons', old('permission'))) checked @endif id="coupons">
                          <label class="form-check-label" for="coupons">Coupons</label>
                        </div>
                      @endif

                      <div class="form-check">
                        <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="orders"  @if(!empty($row->permission) && in_array('orders', $row->permission)) checked @elseif(old('permission')!=null && in_array('orders', old('permission'))) checked @endif id="orders">
                        <label class="form-check-label" for="orders">Orders</label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="payments"  @if(!empty($row->permission) && in_array('payments', $row->permission)) checked @elseif(old('permission')!=null && in_array('payments', old('permission'))) checked @endif id="payments">
                        <label class="form-check-label" for="payments">Payments</label>
                      </div>
                    @else

                      <div class="form-check">
                        <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="enquiries"  @if(!empty($row->permission) && in_array('enquiries', $row->permission)) checked @elseif(old('permission')!=null && in_array('enquiries', old('permission'))) checked @endif id="enquiries">
                        <label class="form-check-label" for="enquiries">Enquiries</label>
                      </div>
                    
                    @endif


                  </div>
                  
                  <div class="col-md-4">
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="products"  @if(!empty($row->permission) && in_array('products', $row->permission)) checked @elseif(old('permission')!=null && in_array('products', old('permission'))) checked @endif id="products">
                      <label class="form-check-label" for="products">Products</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="qr_products"  @if(!empty($row->permission) && in_array('qr_products', $row->permission)) checked @elseif(old('permission')!=null && in_array('qr_products', old('permission'))) checked @endif id="qr_products">
                      <label class="form-check-label" for="qr_products">QR Products</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="inventory"  @if(!empty($row->permission) && in_array('inventory', $row->permission)) checked @elseif(old('permission')!=null && in_array('inventory', old('permission'))) checked @endif id="inventory">
                      <label class="form-check-label" for="inventory">Inventory</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="banners"  @if(!empty($row->permission) && in_array('banners', $row->permission)) checked @elseif(old('permission')!=null && in_array('banners', old('permission'))) checked @endif id="banners">
                      <label class="form-check-label" for="banners">Banners</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="colors"  @if(!empty($row->permission) && in_array('colors', $row->permission)) checked @elseif(old('permission')!=null && in_array('colors', old('permission'))) checked @endif id="colors">
                      <label class="form-check-label" for="colors">Colors</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="brands"  @if(!empty($row->permission) && in_array('brands', $row->permission)) checked @elseif(old('permission')!=null && in_array('brands', old('permission'))) checked @endif id="brands">
                      <label class="form-check-label" for="brands">Brands</label>
                    </div>

                  </div>
                  
                  <div class="col-md-4">
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="blog"  @if(!empty($row->permission) && in_array('blog', $row->permission)) checked @elseif(old('permission')!=null && in_array('blog', old('permission'))) checked @endif id="blog">
                      <label class="form-check-label" for="blog">Blog</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="videos"  @if(!empty($row->permission) && in_array('videos', $row->permission)) checked @elseif(old('permission')!=null && in_array('videos', old('permission'))) checked @endif id="videos">
                      <label class="form-check-label" for="videos">Videos</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="pages"  @if(!empty($row->permission) && in_array('pages', $row->permission)) checked @elseif(old('permission')!=null && in_array('pages', old('permission'))) checked @endif id="pages">
                      <label class="form-check-label" for="pages">Pages</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="testimonials"  @if(!empty($row->permission) && in_array('testimonials', $row->permission)) checked @elseif(old('permission')!=null && in_array('testimonials', old('permission'))) checked @endif id="testimonials">
                      <label class="form-check-label" for="testimonials">Testimonials</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="gallery"  @if(!empty($row->permission) && in_array('gallery', $row->permission)) checked @elseif(old('permission')!=null && in_array('gallery', old('permission'))) checked @endif id="gallery">
                      <label class="form-check-label" for="gallery">Gallery</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="contact_requests"  @if(!empty($row->permission) && in_array('contact_requests', $row->permission)) checked @elseif(old('permission')!=null && in_array('contact_requests', old('permission'))) checked @endif id="contact_requests">
                      <label class="form-check-label" for="contact_requests">Contact Requests</label>
                    </div>
                    
                    <div class="form-check">
                      <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="subscription"  @if(!empty($row->permission) && in_array('subscription', $row->permission)) checked @elseif(old('permission')!=null && in_array('subscription', old('permission'))) checked @endif id="subscription">
                      <label class="form-check-label" for="subscription">Subscription</label>
                    </div>

                    @if($config['reviews'])
                      <div class="form-check">
                        <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="reviews"  @if(!empty($row->permission) && in_array('reviews', $row->permission)) checked @elseif(old('permission')!=null && in_array('reviews', old('permission'))) checked @endif id="reviews">
                        <label class="form-check-label" for="reviews">Reviews</label>
                      </div>
                    @endif

                    @if($config['product_services'])
                      <div class="form-check">
                        <input class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" type="checkbox" name="permission[]" value="product_services"  @if(!empty($row->permission) && in_array('product_services', $row->permission)) checked @elseif(old('permission')!=null && in_array('product_services', old('permission'))) checked @endif id="product_services">
                        <label class="form-check-label" for="product_services">Product Services</label>
                      </div>
                    @endif
                    

                  </div>
                  

                </div>
                @if($errors->has('permission'))
									<span class="invalid-feedback d-block">
										{{ $errors->first('permission') }}
									</span>
								@endif

              </div>
	
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



