@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Banner</h1>
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
                <h3 class="card-title p-3">Banner details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.banners')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.banner.post') }}" method="post" enctype='multipart/form-data'>
				      @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="top_title">Top Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('top_title') ? ' is-invalid' : '' }}" id="top_title" placeholder="Enter Top Title" name="top_title" value="@if(old('top_title')!=null){{old('top_title')}}@elseif(!empty($row->top_title)){{$row->top_title}}@endif">
                        @if($errors->has('top_title'))
                          <span class="invalid-feedback">
                            {{ $errors->first('top_title') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" placeholder="Enter Title" name="title" value="@if(old('title')!=null){{old('title')}}@elseif(!empty($row->title)){{$row->title}}@endif">
                        @if($errors->has('title'))
                          <span class="invalid-feedback">
                            {{ $errors->first('title') }}
                          </span>
                        @endif
                      </div>
                      

                      <div class="form-group">
                        <label for="sub_title">Sub Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-banner {{ $errors->has('sub_title') ? ' is-invalid' : '' }}" id="sub_title" placeholder="Enter Sub Title" name="sub_title" value="@if(old('sub_title')!=null){{old('sub_title')}}@elseif(!empty($row->sub_title)){{$row->sub_title}}@endif">
                        @if($errors->has('sub_title'))
                          <span class="invalid-feedback">
                            {{ $errors->first('sub_title') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="image">Banner Image <span class="text-danger">*</span></label>
                          <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/banners/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
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
                              <img class="img-fluid img-thumbnail" src="{{ asset('storage/banners/') }}/{{$row->id}}/{{$row->image}}" />
                            </div>
                          </div>
                        </div>
                      @endif --}}

                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" rows="4" placeholder="Enter Description" name="description">@if(old('description')!=null){{old('description')}}@elseif(!empty($row->description)){{$row->description}}@endif</textarea>
                        @if($errors->has('description'))
                          <span class="invalid-feedback">
                            {{ $errors->first('description') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="button_name">Button Name </label>
                        <input type="text" class="form-control form-control-banner {{ $errors->has('button_name') ? ' is-invalid' : '' }}" id="button_name" placeholder="Enter Button Name" name="button_name" value="@if(old('button_name')!=null){{old('button_name')}}@elseif(!empty($row->button_name)){{$row->button_name}}@endif">
                        @if($errors->has('button_name'))
                          <span class="invalid-feedback">
                            {{ $errors->first('button_name') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="button_link">Button Link </label>
                        <input type="text" class="form-control form-control-banner {{ $errors->has('button_link') ? ' is-invalid' : '' }}" id="button_link" placeholder="Enter Button Link" name="button_link" value="@if(old('button_link')!=null){{old('button_link')}}@elseif(!empty($row->button_link)){{$row->button_link}}@endif">
                        @if($errors->has('button_link'))
                          <span class="invalid-feedback">
                            {{ $errors->first('button_link') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="serial">Serial </label>
                        <input type="text" class="form-control form-control-banner {{ $errors->has('serial') ? ' is-invalid' : '' }}" id="serial" placeholder="Enter Serial" name="serial" value="@if(old('serial')!=null){{old('serial')}}@elseif(!empty($row->serial)){{$row->serial}}@endif">
                        @if($errors->has('serial'))
                          <span class="invalid-feedback">
                            {{ $errors->first('serial') }}
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



