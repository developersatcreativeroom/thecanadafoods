@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Seo header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Seo</h1>
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
      <div class="card card-primary card-outline">
          <!-- <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Vertical Tabs Examples
            </h3>
          </div> -->
          <div class="card-body">
        <div class="row">
        <div class="col-5 col-sm-3">
              @include('admin.setting.side')
            </div>
          <div class="col-7 col-sm-9">
            <!-- general form elements -->
            <div class="tab-content">
                    <div class="tab-pane text-left fade show active">
            <div class="card1">
			  <div class="card-header1 d-flex justify-content-between p-0">
                <h3 class="card-title py-3">Seo details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.settings.seo.list')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.settings.seo.post') }}" method="post" enctype='multipart/form-data'>
				      @csrf
                <div class="card-body1">
                  <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="page">Page <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('page') ? ' is-invalid' : '' }}" id="page" placeholder="Enter Seo Page Name" name="page" value="@if(old('page')!=null){{old('page')}}@elseif(!empty($row->page)){{$row->page}}@endif">
                        <small>Example: <strong>products</strong> for <a target="_blank" href="{{ route('products') }}">{{ route('products') }}</a></small>
                        @if($errors->has('page'))
                          <span class="invalid-feedback">
                            {{ $errors->first('page') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="page">Seo Title <span class="text-danger">*</span></label>
                        <input type="seo_title" class="form-control count-characters {{ $errors->has('seo_title') ? ' is-invalid' : '' }}" id="seo_title" placeholder="Enter Seo Page Title" name="seo_title" value="@if(old('seo_title')!=null){{old('seo_title')}}@elseif(!empty($row->seo_title)){{$row->seo_title}}@endif">
                        <small><strong>Note: </strong> Add 45 to 80 characters for optimal results</small>
                        @if($errors->has('seo_title'))
                          <span class="invalid-feedback">
                            {{ $errors->first('seo_title') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="seo_description">SEO Description <span class="text-danger">*</span></label>
                        <textarea class="form-control count-characters {{ $errors->has('seo_description') ? ' is-invalid' : '' }}" id="seo_description" rows="4" placeholder="Enter Description" name="seo_description">@if(old('seo_description')!=null){{old('seo_description')}}@elseif(!empty($row->seo_description)){{$row->seo_description}}@endif</textarea>
                        <small><strong>Note: </strong> Add 90 to 180 characters for optimal results</small>
                        @if($errors->has('seo_description'))
                          <span class="invalid-feedback">
                            {{ $errors->first('seo_description') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="seo_keywords">SEO Keywords <span class="text-danger">*</span></label>
                        <textarea class="form-control {{ $errors->has('seo_keywords') ? ' is-invalid' : '' }}" id="seo_keywords" rows="4" placeholder="Enter SEO Keywords" name="seo_keywords">@if(old('seo_keywords')!=null){{old('seo_keywords')}}@elseif(!empty($row->seo_keywords)){{$row->seo_keywords}}@endif</textarea>
                        <small>Example: Comma separated values like <strong>Keyword1, Keyword2, Keyword3</strong></small>
                        @if($errors->has('seo_keywords'))
                          <span class="invalid-feedback">
                            {{ $errors->first('seo_keywords') }}
                          </span>
                        @endif
                      </div>

                    </div>
					        </div>

                <!-- /.card-body -->
				        <input type="hidden" name="id" value="@if(!empty($row->id)){{$row->id}}@endif">
                <div class="card-footer1">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            

          </div>
          </div>

          </div>
          <!--/.col -->
          
        </div>
        <!-- /.row -->
        </div>
        </div>
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



