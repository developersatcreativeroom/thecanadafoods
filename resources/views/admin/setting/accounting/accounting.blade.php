@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
              <li class="breadcrumb-item active">Accounting</li>
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
                <div class="col-5 col-sm-3">
                  @include('admin.setting.side')
                </div>
                <div class="col-7 col-sm-9">

                  <div class="tab-content">
                    <div class="tab-pane text-left fade show active">

                    <div class="card-header1 d-flex justify-content-between p-0">
                      <h3 class="card-title py-3">Accounting Settings</h3>
                    </div>
                    
                    <form action="{{ route('admin.settings.accounting') }}" method="post" enctype='multipart/form-data'>
                      @csrf
                        <div class="card-body1">
                          <div class="row">
                            <div class="col-md-6">

                            
                            <div class="form-group">
                              <label for="is_xero">Is Xero Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('is_xero') ? ' is-invalid' : '' }}" id="is_xero" name="is_xero" @if(old('is_xero')!=null) checked @elseif(!empty($isXeroDB)) checked @endif>
                                <label class="custom-control-label" for="is_xero"></label>
                              </div>
                              @if($errors->has('is_xero'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('is_xero') }}
                                </span>
                              @endif
                            </div>

                            

                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        <!-- <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div> -->
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



