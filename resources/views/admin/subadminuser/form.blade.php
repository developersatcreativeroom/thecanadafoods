@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Admin User</h1>
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
                <h3 class="card-title p-3">Sub Admin User details</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.sub.users')}}">List</a></div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.sub.user.post') }}" method="post" enctype='multipart/form-data'>
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
                        <label for="name">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" placeholder="Enter Username" name="username" value="@if(old('username')!=null){{old('username')}}@elseif(!empty($row->username)){{$row->username}}@endif">
                        @if($errors->has('username'))
                          <span class="invalid-feedback">
                            {{ $errors->first('username') }}
                          </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="name">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Enter Password" name="password" value="">
                        @if($errors->has('password'))
                          <span class="invalid-feedback">
                            {{ $errors->first('password') }}
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
                        <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image">
                          <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        @if($errors->has('image'))
                          <span class="invalid-feedback" style="display: inline;">
                            {{ $errors->first('image') }}
                          </span>
                        @endif
                        </div>
                      </div>       
                      
                      @if(!empty($row) && ($row->image != null || $row->image != '' ))
                        <div class="form-group">
                          <div class="form-row">
                            <div class="col-md-4">
                              <img class="img-fluid img-thumbnail" src="{{ asset('storage/admin/profile/') }}/{{$row->image}}" />
                            </div>
                          </div>
                        </div>
                      @endif

                      <div class="form-group">
                        <label for="permission">Permission <span class="text-danger">*</span></label>
                        <select class="form-control {{ $errors->has('role_id') ? ' is-invalid' : '' }}" id="permission" name="role_id">
                          <option value="">--Select--</option>
                          @foreach($permissions as $permission)
                            <option value="{{$permission->id}}" @if(old('role_id')!=null && old('role_id')==$permission->id) selected @elseif(!empty($row) && $row->role_id==$permission->id) selected @endif>{{$permission->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->has('role_id'))
                          <span class="invalid-feedback">
                            {{ $errors->first('role_id') }}
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



