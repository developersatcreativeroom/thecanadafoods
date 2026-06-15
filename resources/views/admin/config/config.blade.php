@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuration</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Configuration</li>
              <li class="breadcrumb-item active">Country</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="card card-primary card-outline">
          <!-- <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Vertical Tabs Examples
            </h3>
          </div> -->
          <div class="card-body">
            <div class="row">
                <div class="col">

                  <div class="tab-content">
                    <div class="tab-pane text-left fade show active">

                    <div class="card-header1 d-flex justify-content-between p-0">
                      <h3 class="card-title py-3">Configuration Details</h3>
                    </div>
                    
                    <form action="{{ route('admin.config') }}" method="post" enctype='multipart/form-data'>
                      @csrf
                        <div class="card-body1">
                          <div class="row">
                            <div class="col-md-6">

                              
                              <div class="form-group">
                                <label for="min_cart_amount">Minimum Cart Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control only-numbers {{ $errors->has('min_cart_amount') ? ' is-invalid' : '' }}" id="min_cart_amount" placeholder="Enter Minimum Cart Amount Price" name="min_cart_amount" value="@if(old('min_cart_amount')!=null){{old('min_cart_amount')}}@elseif(!empty($minCartAmountDB)){{$minCartAmountDB}}@endif">
                                @if($errors->has('min_cart_amount'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('min_cart_amount') }}
                                  </span>
                                @endif
                              </div>


                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        <!-- <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div> -->
                      </div>
                    </div>
                  </div>
                      </form>
                    
                    </div>
                  </div>

                </div>
              </div>
          <!-- /.row -->
          </div>
          <!-- /.card -->
        </div>

        
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



