@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category</h1>
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
                <h3 class="card-title p-3">Category details</h3>
					<div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.categories')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.category.post') }}" method="post" enctype='multipart/form-data'>
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
								<label for="title_h1">H1 Title</label>
								<input type="text" class="form-control {{ $errors->has('title_h1') ? ' is-invalid' : '' }}" id="title_h1" placeholder="Enter H1 Title" name="title_h1" value="@if(old('title_h1')!=null){{old('title_h1')}}@elseif(!empty($row->title_h1)){{$row->title_h1}}@endif">
								@if($errors->has('title_h1'))
									<span class="invalid-feedback">
										{{ $errors->first('title_h1') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="parent_category_id">Parent Category <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('parent_category_id') ? ' is-invalid' : '' }}" id="parent_category_id" name="parent_category_id">
									<option value="">--Select Value--</option>
									@foreach($categories as $categorySingle)
										<option @if(!empty($row) && $row->id == $categorySingle['id']) disabled @endif @if(old('parent_category_id')!=null && old('parent_category_id')==$categorySingle['id']) selected @elseif(!empty($row) && $row->parent_category_id==$categorySingle['id']) selected @endif value="{{$categorySingle['id']}}">{{$categorySingle['name']}}</option>

										@foreach($categorySingle['children'] as $children1)
											<option @if(!empty($row) && $row->id == $children1['id']) disabled @endif @if(old('parent_category_id')!=null && old('parent_category_id')==$children1['id']) selected @elseif(!empty($row) && $row->parent_category_id==$children1['id']) selected @endif value="{{$children1['id']}}">&nbsp;&nbsp; &#9679; {{$children1['name']}}</option>

											@foreach($children1['children'] as $children2)
												<option disabled @if(old('parent_category_id')!=null && old('parent_category_id')==$children2['id']) selected @elseif(!empty($row) && $row->parent_category_id==$children2['id']) selected @endif value="{{$children2['id']}}">&nbsp;&nbsp;&nbsp;&nbsp; &#9675; {{$children2['name']}}</option>
											@endforeach
											
										@endforeach

									@endforeach
								</select>
								@if($errors->has('parent_category_id'))
									<span class="invalid-feedback">
										{{ $errors->first('parent_category_id') }}
									</span>
								@endif
							</div>
							 
							<div class="form-group">
								<label for="short_description">Short Description</label>
								<textarea class="form-control {{ $errors->has('short_description') ? ' is-invalid' : '' }}" id="short_description" rows="4" placeholder="Enter Short description" name="short_description">@if(old('short_description')!=null){{old('short_description')}}@elseif(!empty($row->short_description)){{$row->short_description}}@endif</textarea>
								@if($errors->has('short_description'))
									<span class="invalid-feedback">
										{{ $errors->first('short_description') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="description">Description</label>
								<textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" rows="4" placeholder="Enter description" name="description">@if(old('description')!=null){{old('description')}}@elseif(!empty($row->description)){{$row->description}}@endif</textarea>
								@if($errors->has('description'))
									<span class="invalid-feedback">
										{{ $errors->first('description') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="image">Category Image <span class="text-danger">*</span></label>
									<input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($row) && ($row->image != null || $row->image != '' )) ? asset('storage/categories/').'/'.$row->id.'/'.$row->image : '' }}" id="image" name="image">
								@if($errors->has('image'))
									<span class="invalid-feedback d-block">
										{{ $errors->first('image') }}
									</span>
								@endif
							</div>

							<div class="form-group">
								<label for="image_alt">Image Alt</label>
								<input type="text" class="form-control {{ $errors->has('image_alt') ? ' is-invalid' : '' }}" id="image_alt" placeholder="Enter Image Alt" name="image_alt" value="@if(old('image_alt')!=null){{old('image_alt')}}@elseif(!empty($row->image_alt)){{$row->image_alt}}@endif">
								@if($errors->has('image_alt'))
									<span class="invalid-feedback">
										{{ $errors->first('image_alt') }}
									</span>
								@endif
							</div>
							
							{{-- @if(!empty($row) && ($row->image != null || $row->image != '' ))
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-4">
											<img class="img-fluid img-thumbnail" src="{{ asset('storage/categories/') }}/{{$row->id}}/{{$row->image}}" />
										</div>
									</div>
								</div>
							@endif --}}
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

							<div class="form-group">
    <label for="priority">Priority <span class="text-danger">*</span></label>

    <select class="form-control {{ $errors->has('priority') ? 'is-invalid' : '' }}"
            id="priority"
            name="priority">

        <option value="">-- Select Priority --</option>

        @for($i = 1; $i <= $maxPriority; $i++)

            @php
                $category = $priorityCategories->firstWhere('priority', $i);

                $disabled = $category && (!isset($row) || $category->id != $row->id);
            @endphp

            <option value="{{ $i }}"
                {{ old('priority', $row->priority ?? '') == $i ? 'selected' : '' }}
                {{ $disabled ? 'disabled' : '' }}>

                {{ $i }}

                @if($category)
                    - {{ $category->name }}
                @endif

            </option>

        @endfor

    </select>

    @error('priority')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
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
        	filebrowserUploadMethod: 'form'
		});
	</script>

@endpush



