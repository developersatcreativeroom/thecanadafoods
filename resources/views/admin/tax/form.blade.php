@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tax</h1>
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
                <h3 class="card-title p-3">Tax details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.taxes')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.tax.post') }}" method="post" enctype='multipart/form-data'>
				@csrf
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter Name" name="name" value="@if(old('name')!=null){{old('name')}}@elseif(!empty($row->name)){{$row->name}}@endif">
								@if($errors->has('name'))
									<span class="invalid-feedback">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="tax">Tax (Amount in %) <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('tax') ? ' is-invalid' : '' }}" id="tax" placeholder="Enter Tax" name="tax" value="@if(old('tax')!=null){{old('tax')}}@elseif(!empty($row->tax)){{$row->tax}}@endif">
								@if($errors->has('tax'))
									<span class="invalid-feedback">
										{{ $errors->first('tax') }}
									</span>
								@endif
							</div>
              
              @if($countrySetting == 'IN')

              <div class="form-group">
								<label for="state_tax_name">State Tax Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('state_tax_name') ? ' is-invalid' : '' }}" id="state_tax_name" placeholder="Enter State Name" name="state_tax_name" value="@if(old('state_tax_name')!=null){{old('state_tax_name')}}@elseif(!empty($row->state_tax_name)){{$row->state_tax_name}}@endif">
								@if($errors->has('state_tax_name'))
									<span class="invalid-feedback">
										{{ $errors->first('state_tax_name') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="state_tax">State Tax (Amount in %) <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('state_tax') ? ' is-invalid' : '' }}" id="state_tax" placeholder="Enter State Tax" name="state_tax" value="@if(old('state_tax')!=null){{old('state_tax')}}@elseif(!empty($row->state_tax)){{$row->state_tax}}@endif">
								@if($errors->has('state_tax'))
									<span class="invalid-feedback">
										{{ $errors->first('state_tax') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="central_tax_name">Central Tax Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('central_tax_name') ? ' is-invalid' : '' }}" id="central_tax_name" placeholder="Enter Central Name" name="central_tax_name" value="@if(old('central_tax_name')!=null){{old('central_tax_name')}}@elseif(!empty($row->central_tax_name)){{$row->central_tax_name}}@endif">
								@if($errors->has('central_tax_name'))
									<span class="invalid-feedback">
										{{ $errors->first('central_tax_name') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="central_tax">Central Tax (Amount in %) <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('central_tax') ? ' is-invalid' : '' }}" id="central_tax" placeholder="Enter State Tax" name="central_tax" value="@if(old('central_tax')!=null){{old('central_tax')}}@elseif(!empty($row->central_tax)){{$row->central_tax}}@endif">
								@if($errors->has('central_tax'))
									<span class="invalid-feedback">
										{{ $errors->first('central_tax') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="integrated_tax_name">Integrated Tax Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('integrated_tax_name') ? ' is-invalid' : '' }}" id="integrated_tax_name" placeholder="Enter Central Name" name="integrated_tax_name" value="@if(old('integrated_tax_name')!=null){{old('integrated_tax_name')}}@elseif(!empty($row->integrated_tax_name)){{$row->integrated_tax_name}}@endif">
								@if($errors->has('integrated_tax_name'))
									<span class="invalid-feedback">
										{{ $errors->first('integrated_tax_name') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="integrated_tax">Integrated Tax (Amount in %) <span class="text-danger">*</span></label>
								<input type="text" class="form-control only-numbers {{ $errors->has('integrated_tax') ? ' is-invalid' : '' }}" id="integrated_tax" placeholder="Enter State Tax" name="integrated_tax" value="@if(old('integrated_tax')!=null){{old('integrated_tax')}}@elseif(!empty($row->integrated_tax)){{$row->integrated_tax}}@endif">
								@if($errors->has('integrated_tax'))
									<span class="invalid-feedback">
										{{ $errors->first('integrated_tax') }}
									</span>
								@endif
							</div>

              @endif

              <div class="form-group">
								<label for="description">Description </label>
								<input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" placeholder="Enter Description" name="description" value="@if(old('description')!=null){{old('description')}}@elseif(!empty($row->description)){{$row->description}}@endif">
								@if($errors->has('description'))
									<span class="invalid-feedback">
										{{ $errors->first('description') }}
									</span>
								@endif
							</div>

              <div class="form-group">
								<label for="brand">Status <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" id="brand" name="status">
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
						<div class="col-md-6">

			
							

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



