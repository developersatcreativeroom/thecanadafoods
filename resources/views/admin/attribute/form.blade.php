@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attribute</h1>
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
                <h3 class="card-title p-3">Attribute details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.attributes')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- <pre>{{$errors}}</pre> -->
              <form action="{{ route('admin.attribute.post') }}" method="post" enctype='multipart/form-data'>
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
							
              <!-- <div class="form-group">
								<label for="keyword">Keyword <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('keyword') ? ' is-invalid' : '' }}" id="keyword" placeholder="Enter Name" name="keyword" value="@if(old('keyword')!=null){{old('keyword')}}@elseif(!empty($row->keyword)){{$row->keyword}}@endif">
								@if($errors->has('keyword'))
									<span class="invalid-feedback">
										{{ $errors->first('keyword') }}
									</span>
								@endif
							</div> -->
<hr>

              <label>Options </label>

            


            @if(!empty($row) && count($row->options) > 0)

            <div id="options-cont">

              @foreach($row->options as $key => $option)
              
                <div class="row" data-key="{{$key}}">
                  <div class="col-md-10">
                    <div class="form-group">
                      <input type="text" class="form-control {{ $errors->has('options') ? ' is-invalid' : '' }}" disabled placeholder="Enter Option Value" name="options[]" value="@if(!empty($option)){{$option->name}}@endif">
                      @if($errors->has('options.'.$key))
                        <span class="invalid-feedback">
                          {{ $errors->first('options.'.$key) }}
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-success add-option"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-danger remove-option" data-id="@if(!empty($option)){{$option->id}}@endif"><i class="fa fa-minus"></i></button>
                  </div>
                </div>

              @endforeach

              <div class="row" data-key="{{$key+1}}">
                  <div class="col-md-10">
                    <div class="form-group">
                      <input type="text" class="form-control {{ $errors->has('options') ? ' is-invalid' : '' }}" placeholder="Enter Option Value" name="options[]" value="">
                      @if($errors->has('options.'.$key+1))
                        <span class="invalid-feedback">
                          {{ $errors->first('options.'.$key+1) }}
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-success add-option"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-danger remove-option"><i class="fa fa-minus"></i></button>
                  </div>
                </div>

              </div>

            @else

            <div id="options-cont">
              <div class="row" data-key="0">
                <div class="col-md-10">
                  <div class="form-group">
                    <input type="text" class="form-control {{ $errors->has('options') ? ' is-invalid' : '' }}" placeholder="Enter Option Value" name="options[]" value="@if(old('keyword')!=null){{old('keyword')}}@elseif(!empty($row->keyword)){{$row->keyword}}@endif">
                    @if($errors->has('options'))
                      <span class="invalid-feedback">
                        {{ $errors->first('options') }}
                      </span>
                    @endif
                  </div>
							  </div>
                <div class="col-md-2">
                  <button class="btn btn-success add-option"><i class="fa fa-plus"></i></button>
                  <button class="btn btn-danger remove-option"><i class="fa fa-minus"></i></button>
                </div>
							</div>
							
            </div>

            @endif


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



