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
              <li class="breadcrumb-item active">Payments</li>
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
                      <h3 class="card-title py-3">Payment Settings</h3>
                    </div>
                    
                    <form action="{{ route('admin.settings.payments') }}" method="post" enctype='multipart/form-data'>
                      @csrf
                        <div class="card-body1">
                          <div class="row">
                            <div class="col-md-6">

                            <div class="form-group">
                              <label for="cash_on_delivery">Is Cash on Delivery Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('cash_on_delivery') ? ' is-invalid' : '' }}" id="cash_on_delivery" name="cash_on_delivery" @if(old('cash_on_delivery')!=null) checked @elseif(!empty($cashOnDeliveryDB)) checked @endif>
                                <label class="custom-control-label" for="cash_on_delivery"></label>
                              </div>
                              @if($errors->has('cash_on_delivery'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('cash_on_delivery') }}
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="instamojo">Is Instamojo Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('instamojo') ? ' is-invalid' : '' }}" id="instamojo" name="instamojo" @if(old('instamojo')!=null) checked @elseif(!empty($instamojoDB)) checked @endif>
                                <label class="custom-control-label" for="instamojo"></label>
                              </div>
                              @if($errors->has('instamojo'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('instamojo') }}
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="paypal">Is Paypal Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('paypal') ? ' is-invalid' : '' }}" id="paypal" name="paypal" @if(old('paypal')!=null) checked @elseif(!empty($paypalDB)) checked @endif>
                                <label class="custom-control-label" for="paypal"></label>
                              </div>
                              @if($errors->has('paypal'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('paypal') }}
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="stripe_card">Is Stripe Card Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('stripe_card') ? ' is-invalid' : '' }}" id="stripe_card" name="stripe_card" @if(old('stripe_card')!=null) checked @elseif(!empty($stripeCardDB)) checked @endif>
                                <label class="custom-control-label" for="stripe_card"></label>
                              </div>
                              @if($errors->has('stripe_card'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('stripe_card') }}
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="razorpay">Is Razorpay Enable </label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input {{ $errors->has('razorpay') ? ' is-invalid' : '' }}" id="razorpay" name="razorpay" @if(old('razorpay')!=null) checked @elseif(!empty($razorpayDB)) checked @endif>
                                <label class="custom-control-label" for="razorpay"></label>
                              </div>
                              @if($errors->has('razorpay'))
                                <span class="invalid-feedback" style="display: inline;">
                                  {{ $errors->first('razorpay') }}
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



