@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
			  <div class="card-header d-flex justify-content-between p-0">
                <h3 class="card-title p-3">Change Password</h3>
					<!-- <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.products')}}">List</a></div> -->
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.profile.change.password') }}" method="post" enctype='multipart/form-data' id="product-form">
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="old_password">Current Password <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" id="old_password" placeholder="Enter Current Password" name="old_password" value="">
								@if($errors->has('old_password'))
									<span class="invalid-feedback">
										{{ $errors->first('old_password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="new_password">New Password <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="new_password" placeholder="Enter New Password" name="new_password" value="">
								@if($errors->has('new_password'))
									<span class="invalid-feedback">
										{{ $errors->first('new_password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" id="confirm_password" placeholder="Enter New Password" name="confirm_password" value="">
								@if($errors->has('confirm_password'))
									<span class="invalid-feedback">
										{{ $errors->first('confirm_password') }}
									</span>
								@endif
							</div>
							
							
							
						</div>
						
						
					</div>

                  
                  <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div> -->
                </div>
                <!-- /.card-body -->
				<input type="hidden" name="id" value="@if(!empty($row->id)){{$row->id}}@endif">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            

          </div>
          <!--/.col -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

	<script>
		CKEDITOR.replace( 'description' , {
			filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        	filebrowserUploadMethod: 'form'
		});
	</script>

@endpush



