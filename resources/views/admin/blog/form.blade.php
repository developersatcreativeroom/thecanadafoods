@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blog</h1>
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
                <h3 class="card-title p-3">Blog details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.blogs')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.blog.post') }}" method="post" enctype='multipart/form-data'>
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

                     <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                id="title"
                name="title"
                placeholder="Enter Title"
                value="@if(old('title') != null){{ old('title') }}@elseif(!empty($row->title)){{ $row->title }}@endif">

            @if($errors->has('title'))
                <span class="invalid-feedback">
                    {{ $errors->first('title') }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="read_time">Read Time <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control {{ $errors->has('read_time') ? 'is-invalid' : '' }}"
                id="read_time"
                name="read_time"
                placeholder="e.g. 1 min"
                value="@if(old('read_time') != null){{ old('read_time') }}@elseif(!empty($row->read_time)){{ $row->read_time }}@endif">

            @if($errors->has('read_time'))
                <span class="invalid-feedback">
                    {{ $errors->first('read_time') }}
                </span>
            @endif
        </div>
    </div>
</div>

                      <div class="form-group">
                        <label for="blog_category_id">Blog Category <span class="text-danger">*</span></label>

                        <select class="form-control {{ $errors->has('blog_category_id') ? ' is-invalid' : '' }}" id="blog_category_id" name="blog_category_id">
                          <option value="">--Select--</option> 
                          @foreach($categories as $categorySingle)
                            <option @if(old('blog_category_id')!=null && $categorySingle->id == old('blog_category_id')) selected @elseif(!empty($row) && $categorySingle->id == $row->blog_category_id) selected @endif value="{{$categorySingle->id}}">{{$categorySingle->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->has('blog_category_id'))
                          <span class="invalid-feedback">
                            {{ $errors->first('blog_category_id') }}
                          </span>
                        @endif
                      </div>
               
                      <div class="form-group">
                        <label for="image">Blog Image <span class="text-danger">*</span></label>
                        <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/blogs/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
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
                              <img class="img-fluid img-thumbnail" src="{{ asset('storage/blogs/') }}/{{$row->id}}/{{$row->image}}" />
                            </div>
                          </div>
                        </div>
                      @endif --}}

                      <div class="form-group">
                        <label for="short_description">Short Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('short_description') ? ' is-invalid' : '' }}" id="short_description" placeholder="Enter Sub Title" name="short_description" value="@if(old('short_description')!=null){{old('short_description')}}@elseif(!empty($row->short_description)){{$row->short_description}}@endif">
                        @if($errors->has('short_description'))
                          <span class="invalid-feedback">
                            {{ $errors->first('short_description') }}
                          </span>
                        @endif
                      </div>

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
                        <label for="seo_title">SEO Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('seo_title') ? ' is-invalid' : '' }}" id="seo_title" placeholder="Enter SEO Title" name="seo_title" value="@if(old('seo_title')!=null){{old('seo_title')}}@elseif(!empty($row->seo_title)){{$row->seo_title}}@endif">
                        @if($errors->has('seo_title'))
                          <span class="invalid-feedback">
                            {{ $errors->first('seo_title') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="seo_description">SEO Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('seo_description') ? ' is-invalid' : '' }}" id="seo_description" placeholder="Enter SEO Description" name="seo_description" value="@if(old('seo_description')!=null){{old('seo_description')}}@elseif(!empty($row->seo_description)){{$row->seo_description}}@endif">
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
<div class="col-md-6">

    <div class="form-group">
        <label for="gallery_images">Gallery Images</label>

        <div id="multiple_images" class="row"></div>

        @error('images')
            <span class="invalid-feedback d-block">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="row">

            @forelse($row->galleries ?? [] as $image)

                @php
                    $imageUrl = asset('storage/blogs/' . $row->id . '/gallery/' . $image->image);
                @endphp

                <div class="col-md-4 mb-3">

                    <div class="gallery-img-container">

                        {{-- Copy Link --}}
                        <button
                            type="button"
                            class="btn btn-primary btn-sm gallery-copy-btn enable_copy_link"
                            data-link="{{ $imageUrl }}"
                            title="Copy Image Link">
                            <i class="fas fa-link"></i>
                        </button>

                        {{-- Delete --}}
                        <a href="{{ route('admin.delete.blog.gallery', [$row->id, $image->id]) }}"
                           class="btn btn-danger btn-sm gallery-delete-btn delete-btn btn-remove"
                           title="Delete Image">
                            <i class="fas fa-times"></i>
                        </a>

                        {{-- Image --}}
                        <img
                            src="{{ $imageUrl }}"
                            class="img-fluid img-thumbnail"
                            alt="{{ $image->image_alt }}">

                    </div>

                    <input
                        type="hidden"
                        name="gallery_image_id[]"
                        value="{{ $image->id }}">

                    <div class="mt-2">

                        <label><strong>Image Alt Text</strong></label>

                        <input
                            type="text"
                            class="form-control"
                            name="gallery_alt[{{ $image->id }}]"
                            value="{{ old('gallery_alt.'.$image->id, $image->image_alt) }}"
                            placeholder="Enter image alt text">

                    </div>

                </div>

            @empty
                {{-- No gallery images found --}}
            @endforelse

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
    <script>
		CKEDITOR.replace( 'description' , {
			filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        	filebrowserUploadMethod: 'form',
			toolbar: 'Full',
			// Disable CKEditor's default content filtering (ACF) so pasted/typed HTML
			// (inline styles, divs, tables, custom classes, etc.) is kept exactly as-is
			// instead of being stripped down to a "safe" subset of tags/attributes.
			allowedContent: true,
			// Preserve the source HTML on paste rather than CKEditor's normal "clean up
			// pasted content" behavior, which would otherwise strip inline style="" attrs.
			pasteFilter: null
		});
	</script>

@endpush



