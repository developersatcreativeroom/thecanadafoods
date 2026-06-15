@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Testimonials</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Testimonials</li>
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
                <h3 class="card-title p-3">Testimonial Listing</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.testimonial')}}">Create</a></div>
              </div>
              <!-- /.card-header -->
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-end">
        
                    <div class="py-2 px-3">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <input type="text" id="testimonials-search" class="form-control" placeholder="Search">
                        </div>
                        <div class="col-auto">
                          <button class="btn btn-success" id="testimonials-search-btn">Search</button>
                          <button class="btn btn-info" id="clear-testimonials-search-btn">Clear</button>
                        </div>
                      </div>
                    </div>
  
                  </div>
                  <hr class="my-0">
                </div>
              </div>
              <div id="testimonial-rows">
                @include('admin.testimonial.rows')
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

    </script>
@endpush
