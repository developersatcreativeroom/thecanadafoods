<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Admin Panel | {{ config('app.name') }}</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<link rel="shortcut icon" type="image/x-icon" href="{{ App\Helper::getFavicon() }}">
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{ URL::asset('backend/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('backend/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ URL::asset('backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Password reset -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/unitedpalms-1/14.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="{{route('admin.dashboard')}}" class="mb-12">
						<img alt="Logo" src="{{ URL::asset('backend//media/logos/logo-1.png') }}" class="h-40px" />
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('admin.forgot.password') }}">
						{{ csrf_field() }}
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Forgot Password ?</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
								<input class="form-control form-control-solid @if($errors->has('email')) is-invalid @endif" type="email" placeholder="" name="email" value="{{ old('email') }}" autocomplete="off" />
								@if ($errors->has('email'))
								<div class="fv-plugins-message-container invalid-feedback">
									<div>{{ $errors->first('email') }}</div>
								</div>
								@endif
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="d-flex flex-wrap justify-content-center pb-lg-0">
								<input type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4" value="Submit" />
								<a href="{{route('admin.login')}}" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Password reset-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
      <!--begin::Global Javascript Bundle(used by all pages)-->
      <script src="{{ URL::asset('backend/plugins/global/plugins.bundle.js') }}"></script>
      <script src="{{ URL::asset('backend/js/scripts.bundle.js') }}"></script>
      <!--end::Global Javascript Bundle-->
      <!--begin::Page Vendors Javascript(used by this page)-->
      <script src="{{ URL::asset('backend/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
      <script src="{{ URL::asset('backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
      <!--end::Page Vendors Javascript-->
      <!--begin::Page Custom Javascript(used by this page)-->
	  <script src="{{ URL::asset('backend/js/custom/authentication/sign-up/free-trial.js') }}"></script>
      <!--end::Page Custom Javascript-->
      <!--end::Javascript-->

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

		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/authentication/sign-up/free-trial.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
