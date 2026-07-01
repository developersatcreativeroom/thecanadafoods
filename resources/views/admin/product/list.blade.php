@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title p-3">Product Listing</h3>
				        <div class="ml-auto py-2 px-3">
                  <div class="d-flex">
                    <a class="btn btn-success mr-2" href="{{route('admin.products.export')}}">Export</a>
                    <a class="btn btn-info mr-2 open-import-modal" >Import</a>
                    {{-- <pre>{{print_r($errors)}}</pre> --}}
                    {{-- <form class="d-flex" action="{{ route('admin.products.import') }}" method="post" enctype='multipart/form-data' id="product-form">
                      @csrf
                      <input type="file" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" name="file">
                      @if($errors->has('file'))
                        <span class="invalid-feedback">
                        {{ $errors->first('file') }}
                        </span>
                      @endif
                      <input type="submit" class="btn btn-info ml-1" value="Import">
                    </form> --}}
                    <a class="btn btn-primary" href="{{route('admin.product')}}">Create</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->

              <div class="container-fluid px-3">
                <div class="row justify-content-end">
                  <div class="col-md-3">
                    <div class="py-2">
                      <label for="categories-search">Category </label>
                      <select class="form-control" id="categories-search">
                        <option value="">All</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="py-2">
                      <label for="statuses-search">Status </label>
                      <select class="form-control" id="statuses-search">
                        <option value="">All</option>
                        @foreach(config('constants.STATUSES') as $key => $status)
                          <option value="{{$key}}">{{$status}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="py-2">
                      <label for="statuses-search">Meta Status </label>
                      <select class="form-control" id="meta-statuses-search">
                        <option value="">All</option>
                        @foreach(config('constants.META_STATUSES') as $key => $status)
                          <option value="{{$key}}">{{$status}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- <div class="d-flex justify-content-end"> --}}
                      <div class="">
  
                        <div class="py-2">
                          <label for="search">Search </label>
                          <div class="row align-items-center">
                            <div class="col flex-grow-1">
                              <input type="text" id="products-search" class="form-control" placeholder="Search">
                            </div>
                            <div class="col-auto">
                              <button class="btn btn-success" id="products-search-btn">Search</button>
                              <button class="btn btn-info" id="clear-products-search-btn">Clear</button>
                            </div>
                          </div>
                        </div>
  
                      </div>
  
                    </div>
                  </div>
                </div>
              
              <hr class="mb-0">
              
              <div id="product-rows">
                @include('admin.product.rows')
              </div>
              <div class="card-footer clearfix">

                {!! $rows->withQueryString()->links() !!}

                <!-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> -->
                
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
     $(document).on('change', '.nav-toggle', function() {

            let checkbox = $(this);

            $.ajax({
                url: "{{ route('admin.products.toggle') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: checkbox.data('id'),
                    col: checkbox.data('col')
                },
                error: function() {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    alert('Something went wrong.');
                }
            });

        });

    </script>
@endpush
