<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | {{env('APP_NAME')}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('backend/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- select2 -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/select2/css/select2.min.css') }}">
  <!-- toastr -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/toastr/toastr.min.css') }}">

  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="{{ URL::asset('backend/css/custom.css') }}">

  <!-- jQuery -->
  <script src="{{ URL::asset('backend/plugins/jquery/jquery.min.js') }}"></script>
  
</head>


    @php 
      $config = App\Helper::getWebsiteConfig('currency_sign');
        //print '<pre>'; print_r($config); die;
    @endphp

<body class="hold-transition sidebar-mini layout-fixed">
  
<div class="wrapper">
<div id="loading" class="d-none"></div>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{App\Helper::getLightLogo()}}" alt="AdminLogo" height="60" width="60">
  </div>


          @include('admin.layouts.nav')
          @include('admin.layouts.aside')


          
            @yield('content')

          
          

      @include('admin.layouts.footer')

      @include('admin.layouts.modals')


      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

 
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ URL::asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('backend/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ URL::asset('backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ URL::asset('backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ URL::asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ URL::asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ URL::asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ URL::asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- toastr -->
    <script src="{{ URL::asset('backend/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Google charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('backend/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('backend/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ URL::asset('backend/js/pages/dashboard.js') }}"></script>
    <script src="{{ URL::asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('backend/plugins/spartan/dist/js/spartan-multi-image-picker-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::asset('backend/js/custom.js') }}"></script>

    <script>
        var site_url = "{{url('/admin')}}";
        var site_currency = "{{$config['currency_sign']}}";
    </script>
        

      @stack('scripts')

      @if(Session::has('message'))

        @if(Session::get('result')==true)
        <script type="text/javascript">
            toastr.success("{{ Session::get('message') }}",'Success');
        </script>
        @endif

        @if(Session::get('result')==false)
        <script type="text/javascript">
            toastr.error("{{ Session::get('message') }}",'Error');
        </script>
        @endif

      @endif

</body>
</html>