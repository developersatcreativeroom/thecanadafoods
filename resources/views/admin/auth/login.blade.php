<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Admin Panel | {{env('APP_NAME')}}</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<link rel="shortcut icon" type="image/x-icon" href="{{ App\Helper::getFavicon() }}">
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!--end::Fonts-->
	
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ URL::asset('backend/css/adminlte.min.css') }}">
	</head>

	<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | {{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ URL::asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('backend/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ URL::asset('backend/css/custom.css') }}">
</head>


<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    {{-- <p><b>Welcome</b> Admin</p> --}}
    <a href="{{route('admin')}}">
      <img class="img-fluid logo-img" src="{{App\Helper::getLightLogo()}}" />
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('admin.login') }}" method="post">
	  
		@csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{old('email')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
		  @if ($errors->has('email'))
			<div class="fv-plugins-message-container invalid-feedback">
				<div>{{ $errors->first('email') }}</div>
			</div>
		@endif		
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" value="{{old('password')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		  @if ($errors->has('password'))
			<div class="fv-plugins-message-container invalid-feedback">
				<div>{{ $errors->first('password') }}</div>
			</div>
		@endif
        </div>
		
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p> -->
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ URL::asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- toastr -->
<script src="{{ URL::asset('backend/plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('backend/js/adminlte.min.js') }}"></script>
<!-- Custom JS -->
<script src="{{ URL::asset('admin/js/custom.js') }}"></script>

<script>
	var site_url = "{{url('/admin')}}";
</script>

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


