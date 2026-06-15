@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blog Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Create or Update</li>
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
                <h3 class="card-title p-3">Blog Category details</h3>
					<div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.blog.categories')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.blog.category.post') }}" method="post" enctype='multipart/form-data'>
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
              @if(!empty($row->id))
                <div class="form-group">
                  <label for="slug">Slug <span class="text-danger">*</span></label>
                  <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" placeholder="Enter slug" name="slug" value="@if(old('slug')!=null){{old('slug')}}@elseif(!empty($row->slug)){{$row->slug}}@endif">
                  @if($errors->has('slug'))
                    <span class="invalid-feedback">
                      {{ $errors->first('slug') }}
                    </span>
                  @endif
                </div>
              @endif

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
								<label for="status">Status <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" name="status">
									<option value="">--Select--</option>
									@foreach(config('constants.STATUSES') as $key => $status)
										<option value="{{$key}}" @if(old('status')!=null && old('status')==$key) selected @elseif(!empty($row) && $row->status==$key) selected @endif>{{$status}}</option>
									@endforeach
								</select>
								@if($errors->has('status'))
									<span class="invalid-feedback">
										{{ $errors->first('status') }}
									</span>
								@endif
							</div>
	
						</div>
					</div>
               
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

@endpush



