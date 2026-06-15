@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inventory Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Inventory Add</li>
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
                <h3 class="card-title p-3">Inventory Add</h3>
				        
              </div>
              <!-- /.card-header -->
              <div class="card-body">
           
              <div class="py-3">
                <div class="row">
                  <div class="col-6">
                    <label for="product-inventory-add">Product </label>
                    <select class="form-control {{ $errors->has('product') ? ' is-invalid' : '' }}" id="product-inventory-add" name="product">
                      <option value="">--Select Value--</option>
                      @foreach($products as $product)
                        <option value="{{$product->slug}}">{{$product->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <!-- <div class="col">
                    <label for="attribute-inventory-add">Attribute </label>
                    <select class="form-control {{ $errors->has('attribute') ? ' is-invalid' : '' }}" id="attribute-inventory-add" name="attribute">
                      <option value="">--Select Product First--</option>
                      @foreach($attributes as $attribute)
                        <option value="{{$attribute->slug}}">{{$attribute->name}}</option>
                      @endforeach
                    </select>
                  </div> -->

                  

              </div>
              </div>

              <div class="row d-none" id="stock-quantity" data-type="product">
                <label class="col-sm-2 col-form-label">Product Stock</label>
                <div class="col-sm-1">
                  <p class="form-control-plaintext"></p>
                  </div>
                  <div class="col-sm-2">
                  <select class="form-control" required name="event">
                    <option value="">--Select Event--</option>
                    <option value="added">Add</option>
                    <option value="remove">Remove</option>
                  </select>
                  </div>
                    <div class="col-sm-2">
                    <input type="text" placeholder="Stock Quantity" required class="form-control only-numbers" name="stock"  />
                    </div>
                    <div class="col-sm-2">
                    <input type="text" placeholder="Note (Optional)" class="form-control" name="note" />
                    </div>
                    <div class="col-sm-2">
                    <button class="btn btn-success update-stock">Update</button>
                    </div>
                  </div>



                  <div class="d-none" id="stock-attribute-quantity">
                
                  </div>


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
