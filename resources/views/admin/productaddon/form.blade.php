@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Addon</h1>
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
                <h3 class="card-title p-3">Product Addon details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.product.addons')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.product.addon.post') }}" method="post" enctype='multipart/form-data'>
				      @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">

                      @if(!empty($row->id))
                        <div class="form-group">
                          <label for="slug">Slug <span class="text-danger">*</span></label>
                          <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" placeholder="Enter slug" name="slug" value="@if(old('slug')!=null){{old('slug')}}@elseif(!empty($row->slug)){{$row->slug}}@endif">
                          @if($errors->has('slug'))
                            <span class="invalid-feedback">
                              {{ $errors->first('slug') }}
                            </span>
                          @endif
                        </div>
                      @endif

                      <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter Addon Name" name="name" value="@if(old('name')!=null){{old('name')}}@elseif(!empty($row->name)){{$row->name}}@endif">
                        @if($errors->has('name'))
                          <span class="invalid-feedback">
                            {{ $errors->first('name') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="product_id">Product <span class="text-danger">*</span></label>

                        <select class="form-control {{ $errors->has('product_id') ? ' is-invalid' : '' }}" id="product_id" name="product_id">
                          <option value="">--Select--</option> 
                          @foreach($products as $product)
                            <option @if(old('product_id')!=null && $product->id == old('product_id')) selected @elseif(!empty($row) && $product->id == $row->product_id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->has('product_id'))
                          <span class="invalid-feedback">
                            {{ $errors->first('product_id') }}
                          </span>
                        @endif
                      </div>
               
                      <div class="form-group">
                        <label for="image">Addon Image <span class="text-danger">*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/product-addons/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
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
                              <img class="img-fluid img-thumbnail" src="{{ asset('storage/product-addons/') }}/{{$row->id}}/{{$row->image}}" />
                            </div>
                          </div>
                        </div>
                      @endif --}}

                      <div class="form-group">
                        <label for="summary">Summary <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('summary') ? ' is-invalid' : '' }}" id="summary" placeholder="Enter Summary" name="summary" value="@if(old('summary')!=null){{old('summary')}}@elseif(!empty($row->summary)){{$row->summary}}@endif">
                        @if($errors->has('summary'))
                          <span class="invalid-feedback">
                            {{ $errors->first('summary') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" rows="4" placeholder="Enter Description" name="description">@if(old('description')!=null){{old('description')}}@elseif(!empty($row->description)){{$row->description}}@endif</textarea>
                        @if($errors->has('description'))
                          <span class="invalid-feedback">
                            {{ $errors->first('description') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="price">Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" placeholder="Enter Price" name="price" value="@if(old('price')!=null){{old('price')}}@elseif(!empty($row->price)){{$row->price}}@endif">
                        @if($errors->has('price'))
                          <span class="invalid-feedback">
                            {{ $errors->first('price') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="old_price">Old Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('old_price') ? ' is-invalid' : '' }}" id="old_price" placeholder="Enter Old Price" name="old_price" value="@if(old('old_price')!=null){{old('old_price')}}@elseif(!empty($row->old_price)){{$row->old_price}}@endif">
                        @if($errors->has('old_price'))
                          <span class="invalid-feedback">
                            {{ $errors->first('old_price') }}
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



