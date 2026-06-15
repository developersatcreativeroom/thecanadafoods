@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Testimonial</h1>
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
                <h3 class="card-title p-3">Testimonial details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.testimonials')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.testimonial.post') }}" method="post" enctype='multipart/form-data'>
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
                        <label for="designation">Designation </label>
                        <input type="text" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" id="designation" placeholder="Enter Designation" name="designation" value="@if(old('designation')!=null){{old('designation')}}@elseif(!empty($row->designation)){{$row->designation}}@endif">
                        @if($errors->has('designation'))
                          <span class="invalid-feedback">
                            {{ $errors->first('designation') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="image"> Image </label>
                          <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/testimonials/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
                        @if($errors->has('image'))
                          <span class="invalid-feedback d-block">
                            {{ $errors->first('image') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="rating">Rating <span class="text-danger">*</span></label>
                        <select class="form-control {{ $errors->has('rating') ? ' is-invalid' : '' }}" id="rating" name="rating">
                          <option value="">--Select--</option>
                          @foreach(config('constants.TESTIMONIAL_RATINGS') as $key => $rating)
                            <option value="{{$rating}}" @if(old('rating')!=null && old('rating')==$rating) selected @elseif(!empty($row) && $row->rating==$rating) selected @endif>{{$rating}}</option>
                          @endforeach
                        </select>
                        @if($errors->has('rating'))
                          <span class="invalid-feedback">
                            {{ $errors->first('rating') }}
                          </span>
                        @endif
                      </div>
                      
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" rows="4" placeholder="Enter Testimonial Description" name="description">@if(old('description')!=null){{old('description')}}@elseif(!empty($row->description)){{$row->description}}@endif</textarea>
                        @if($errors->has('description'))
                          <span class="invalid-feedback">
                            {{ $errors->first('description') }}
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



