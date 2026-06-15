@extends('admin.layouts.app')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
          <a class="btn btn-info btn-sm float-sm-right mx-2" href="{{route('sitemap.run')}}" target="_blank">Re-generate Sitemap</a>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  @php
  $admin = Auth::guard('admin')->user();
  if($admin->level == 1 && $admin->role->permission != 'null'){
  //$section = json_decode(Auth::guard('admin')->user()->role->permission,true);
  $section = unserialize(Auth::guard('admin')->user()->role->permission);
  }else{
  $section = [];
  }
  $config = App\Helper::getWebsiteConfig();
  @endphp


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Small boxes (Stat box) -->
      <div class="row">

        @if ((is_array($section) && in_array('users',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.users')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">
                  {{$users}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

        @if ((is_array($section) && in_array('products',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.products')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tag"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">
                  {{$products}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

        {{-- @if ((is_array($section) && in_array('colors',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.colors')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-paint-brush"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Colors</span>
                <span class="info-box-number">
                  {{$colors}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif --}}

        @if ((is_array($section) && in_array('brands',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.brands')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="far fa-copyright"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Brands</span>
                <span class="info-box-number">
                  {{$brands}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

        @if ((is_array($section) && in_array('taxes',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.taxes')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Taxes</span>
                <span class="info-box-number">
                  {{$taxes}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

        @if(!$isEnquiryWebsite)
          @if($config['coupon'])
            @if ((is_array($section) && in_array('coupons',$section)) || $admin->level == 0)
            <div class="col-md-3">
              <a href="{{route('admin.coupons')}}">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-ticket-alt"></i></span>

                  <div class="info-box-content text-dark">
                    <span class="info-box-text">Coupons</span>
                    <span class="info-box-number">
                      {{$coupons}}
                      <!-- <small>%</small> -->
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
            </div>
            @endif
          @endif

          @if ((is_array($section) && in_array('orders',$section)) || $admin->level == 0)
          <div class="col-md-3">
            <a href="{{route('admin.orders')}}">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-arrow-down"></i></span>

                <div class="info-box-content text-dark">
                  <span class="info-box-text">Orders</span>
                  <span class="info-box-number">
                    {{$orders}}
                    <!-- <small>%</small> -->
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endif

          @if ((is_array($section) && in_array('payments',$section)) || $admin->level == 0)
          <div class="col-md-3">
            <a href="{{route('admin.payments')}}">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>

                <div class="info-box-content text-dark">
                  <span class="info-box-text">Payments</span>
                  <span class="info-box-number">
                    {{$payments}}
                    <!-- <small>%</small> -->
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endif
          
        @else
        
          @if ((is_array($section) && in_array('enquiries',$section)) || $admin->level == 0)
          <div class="col-md-3">
            <a href="{{route('admin.enquiries')}}">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-question-circle"></i></span>

                <div class="info-box-content text-dark">
                  <span class="info-box-text">Enquiries</span>
                  <span class="info-box-number">
                    {{$enquiries}}
                    <!-- <small>%</small> -->
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endif
        @endif

        @if ((is_array($section) && in_array('banners',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.banners')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-image"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Banners</span>
                <span class="info-box-number">
                  {{$banners}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

        {{-- @if ((is_array($section) && in_array('videos',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.videos')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-video"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Videos</span>
                <span class="info-box-number">
                  {{$videos}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif --}}

        {{-- @if ((is_array($section) && in_array('pages',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.pages')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Pages</span>
                <span class="info-box-number">
                  {{$pages}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif --}}

        {{-- @if ((is_array($section) && in_array('testimonials',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.testimonials')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-quote-left"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Testimonials</span>
                <span class="info-box-number">
                  {{$testimonials}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif --}}

        {{-- @if ((is_array($section) && in_array('gallery',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.gallery')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-image"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Gallery</span>
                <span class="info-box-number">
                  {{$gallery}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif --}}

        @if ((is_array($section) && in_array('contact_requests',$section)) || $admin->level == 0)
        <div class="col-md-3">
          <a href="{{route('admin.contacts')}}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-phone-square"></i></span>

              <div class="info-box-content text-dark">
                <span class="info-box-text">Contact Requests</span>
                <span class="info-box-number">
                  {{$contacts}}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        @endif

      </div>

      @if ((is_array($section) && in_array('orders',$section)) || $admin->level == 0)
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Sales
              </h3>
              <div class="card-tools">

                <div class="input-group date" id="year-date-picker" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#year-date-picker" />
                  <div class="input-group-append" data-target="#year-date-picker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>

              </div>
            </div><!-- /.card-header -->
            <div class="card-body">

              <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>

            </div>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales</h3>
                <!-- <a href="javascript:void(0);">View Report</a> -->
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg">{{$totalAmount}}</span>
                  <span>Sales Over Time</span>
                </p>
                <!-- <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p> -->
              </div>
              <!-- /.d-flex -->

              <div class="position-relative mb-4">
                <canvas id="sales-amount-chart" height="200"></canvas>
              </div>

              <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                  <i class="fas fa-square text-primary"></i> This year
                </span>

                <span>
                  <i class="fas fa-square text-gray"></i> Last year
                </span>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                    <h5 class="description-header">{{$totalAmount}}</h5>
                    <span class="description-text">TOTAL INCOME</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                    <h5 class="description-header">{{$currentYearAmount}}</h5>
                    <span class="description-text">CURRENT YEAR INCOME</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                    <h5 class="description-header">{{$currentMonthAmount}}</h5>
                    <span class="description-text">CURRENT MONTH INCOME</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                    <h5 class="description-header">{{$currentWeekAmount}}</h5>
                    <span class="description-text">CURRENT WEEK INCOME</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      @endif

      <div class="row">
        
        <div class="col-md-8">
          <!-- TABLE: LATEST ORDERS -->
          @if(!$isEnquiryWebsite)

          @if ((is_array($section) && in_array('orders',$section)) || $admin->level == 0)
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Orders</h3>

              <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Order No</th>
                      <th>Payment Done</th>
                      <th>Order Status</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($latestOrders != null && count($latestOrders) > 0)
                    @foreach($latestOrders as $latestOrder)
                    <tr>
                      <td><a target="_blank"
                          href="{{route('admin.order.view', $latestOrder->id)}}">{{$latestOrder->order_no}}</a></td>
                      <td>
                        @if($latestOrder->is_payment_done)
                        <span class="badge bg-success">Done</span>
                        @else
                        <span class="badge bg-danger">Not Done</span>
                        @endif
                      </td>
                      <td><span class="badge bg-info">{{$latestOrder->order_status}}</span></td>
                      <td>{{$latestOrder->amountWithItems()}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="4">
                        <p class="text-center mb-0">No data availaible</p>
                      </td>
                    </tr>
                    @endif

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            @if($latestOrders != null && count($latestOrders) > 0)
            <div class="card-footer clearfix">
              <a href="{{route('admin.orders')}}" class="btn btn-sm btn-info float-right">View All Orders</a>
            </div>
            <!-- /.card-footer -->
            @endif
          </div>
          <!-- /.card -->
          @endif

          @else

          @if ((is_array($section) && in_array('enquiries',$section)) || $admin->level == 0)
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Enquiries</h3>

              <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Enquiry No</th>
                      <th>Enquiry Status</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($latestEnquiries != null && count($latestEnquiries) > 0)
                    @foreach($latestEnquiries as $latestEnquiry)
                    <tr>
                      <td><a target="_blank"
                          href="{{route('admin.enquiry.view', $latestEnquiry->id)}}">{{$latestEnquiry->enquiry_no}}</a>
                      </td>
                      <td><span class="badge bg-info">{{$latestEnquiry->enquiry_status}}</span></td>
                      <td>{{$latestEnquiry->amountWithItems()}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="4">
                        <p class="text-center mb-0">No data availaible</p>
                      </td>
                    </tr>
                    @endif

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            @if($latestEnquiries != null && count($latestEnquiries) > 0)
            <div class="card-footer clearfix">
              <a href="{{route('admin.enquiries')}}" class="btn btn-sm btn-info float-right">View All Enquiries</a>
            </div>
            <!-- /.card-footer -->
            @endif
          </div>
          <!-- /.card -->
          @endif

          @endif
        </div>
        <div class="col-md-4">
          @if ((is_array($section) && in_array('products',$section)) || $admin->level == 0)
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recently Added Products</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @if(count($recentProducts) > 0)
                @foreach($recentProducts as $recentProduct)
                <li class="item">

                  @if(!empty($recentProduct) && ($recentProduct->image != null || $recentProduct->image != '' ))
                  <div class="product-img">
                    <img src="{{ asset('storage/products/') }}/{{$recentProduct->id}}/{{$recentProduct->image}}"
                      alt="Product Image" class="img-size-50">
                  </div>
                  @endif

                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{$recentProduct->name}}
                      <span class="badge badge-success float-right">{{$recentProduct->getPrice()}}</span></a>
                    <span class="product-description">
                      {{$recentProduct->short_description}}
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                @endforeach
                @else
                <p class="text-center my-3">No data availaible</p>
                @endif

              </ul>
            </div>
            <!-- /.card-body -->
            @if(count($recentProducts) > 0)
            <div class="card-footer text-center">
              <a href="{{route('admin.products')}}" class="btn btn-sm btn-info float-right">View All Products</a>
            </div>
            <!-- /.card-footer -->
            @endif
          </div>
          <!-- /.card -->
          @endif
        </div>
      </div>

      @if (((is_array($section) && in_array('products',$section)) || $admin->level == 0) && (((is_array($section) && in_array('orders',$section)) || $admin->level == 0) || ((is_array($section) && in_array('enquiries',$section)) || $admin->level == 0)))
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Highest Sale Product(s)</h3>

            </div>
            <div class="card-body">
              <canvas id="highest-sale"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Highest Income Product(s)</h3>

            </div>
            <div class="card-body">
              <canvas id="pieChart1"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      @endif



    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection