@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inventory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Inventory</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
				      <div class="card-header d-flex justify-content-between p-0">
                <h3 class="card-title p-3">Inventory Logs</h3>
				        
              </div>
              <!-- /.card-header -->
              <div class="card-body">
           
              <div class="py-3">
                <div class="row">
                  <div class="col">
                    <label for="product-filter">Product </label>
                    <select class="form-control {{ $errors->has('product') ? ' is-invalid' : '' }}" id="product-filter" name="product">
                      <option value="">--Select Value--</option>
                      @foreach($products as $product)
                        <option value="{{$product->slug}}">{{$product->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col">
                    <label for="attribute">Attribute </label>
                    <select class="form-control {{ $errors->has('attribute') ? ' is-invalid' : '' }}" id="attribute-filter" name="attribute">
                      <option value="">--Select Product First--</option>
                      @foreach($attributes as $attribute)
                        <option value="{{$attribute->slug}}">{{$attribute->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col">
                    <label for="users">Users </label>
                    <select class="form-control {{ $errors->has('users') ? ' is-invalid' : '' }}" id="users-filter" name="users">
                      <option value="">--Select User--</option>
                      @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}} ({{$user->email}})</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col">
                    <label for="stock">Stock </label>
                    <select class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}" id="stock-filter" name="stock">
                      <option value="">--Select Stock--</option>
                      <option value="1">Added</option>
                      <option value="2">Removed</option>
                    </select>
                  </div>

                  <div class="col">
                    <label for="event">Event </label>
                    <select class="form-control {{ $errors->has('event') ? ' is-invalid' : '' }}" id="event-filter" name="event">
                      <option value="">--Select Event--</option>
                      <option value="initial_added">Initial added</option>
                      <option value="added">Added</option>
                      <option value="reduced">Reduced</option>
                      <option value="sold">Sold</option>
                    </select>
                  </div>

                  <div class="col">
                    <label for="inventory-date-range">Date Range </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" id="inventory-date-range" class="form-control float-right date-range-picker" placeholder="Select date range">
                  </div>
                  </div>

                </div>
              </div>
					        
              <div id="inventory-logs">
                @include('admin.inventory.inventory-logs')
              </div>
                    

              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">

                
              </div>
            </div>
            <!-- /.card -->

            
          </div>
       
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

    <script>

    $('ul.pagination').addClass('pagination-sm m-0 float-right')

    </script>
@endpush
