@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Profile Information</li>
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
                <h3 class="card-title p-3">Profile Information</h3>
					<!-- <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.products')}}">List</a></div> -->
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.profile') }}" method="post" enctype='multipart/form-data' id="product-form">
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter name" name="name" value="@if(old('name')!=null){{old('name')}}@elseif(!empty($row->name)){{$row->name}}@endif">
								@if($errors->has('name'))
									<span class="invalid-feedback">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="email">Email <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter Email" name="email" value="@if(old('email')!=null){{old('email')}}@elseif(!empty($row->email)){{$row->email}}@endif">
								@if($errors->has('email'))
									<span class="invalid-feedback">
										{{ $errors->first('email') }}
									</span>
								@endif
							</div>
							
							<div class="form-group">
								<label for="image">Profile Image </label>
								<input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/admin/profile/').'/'.$row->image : '' }}" id="image" name="image">
								@if($errors->has('image'))
									<span class="invalid-feedback d-block">
										{{ $errors->first('image') }}
									</span>
								@endif
								</div>
							
							{{-- @if(!empty($row) && ($row->image != null || $row->image != '' ))
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-4">
											<img class="img-fluid img-thumbnail" src="{{ asset('storage/admin/profile/') }}/{{$row->image}}" />
										</div>
									</div>
								</div>
							@endif --}}

							

							

							
							
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



