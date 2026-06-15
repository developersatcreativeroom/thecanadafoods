@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Permissions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
				      <div class="card-header d-flex justify-content-between p-0">
                <h3 class="card-title p-3">Permission Listing</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.permission')}}">Create</a></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Permission Name</th>
                      <th>Permission Modules</th>
                      <th>Status</th>
                      <th>Added on</th>
                      <th style="width: 130px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
					        @foreach($rows as $row)
                    <tr>
                      <td>{{$row->id}}</td>
                      <td>{{$row->name}}</td>
                      <td>
                        @php
                        $permissions = unserialize($row->permission);
                        $html = '';
                        foreach($permissions as $permission){
                          $html .='<span class="badge bg-info">'.ucfirst($permission).'</span>&nbsp;';
                        }
                        @endphp
                        {!!$html!!}
                      </td>
                      <td>
                        @if($row->status)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">In-active</span>
                        @endif
                      </td>
                      <td>{{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                      <td>
                        <a href="{{route('admin.permission.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{route('admin.permission.delete', $row->id)}}" class="btn btn-danger btn-sm delete-btn">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">

                {!! $rows->withQueryString()->links() !!}

                <!-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> -->
                
              </div>
            </div>
            <!-- /.card -->

            
          </div>
       
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

    <script>

    $('ul.pagination').addClass('pagination-sm m-0 float-right')

    </script>
@endpush
