@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
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
                <h3 class="card-title p-3">Category Listing</h3>
				<div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.category')}}">Create</a></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Main Nav</th>
                      <th>Added on</th>
                      <th style="width: 130px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
					@foreach($rows as $row)
                    <tr>
                      <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                      <td>{{$row->name}}</td>
                      <td>
                        @if($row->status)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">In-active</span>
                        @endif
                      </td>
                      <td>
    <label class="switch">
        <input
            type="checkbox"
            class="nav-toggle"
            data-id="{{ $row->id }}"
            {{ $row->is_main_nav ? 'checked' : '' }}>
        <span class="slider"></span>
    </label>
</td>
                      <td>{{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
					  <td>
					  	<a href="{{route('admin.category.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
					  	<a href="{{route('admin.category.delete', $row->id)}}" class="btn btn-danger btn-sm delete-btn">Delete</a>
					  </td>
					</tr>
					@endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">

              {!! $rows->withQueryString()->links() !!}
            
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
    
    <script>

    $('ul.pagination').addClass('pagination-sm m-0 float-right')
    $(document).on('change', '.nav-toggle', function () {

    let checkbox = $(this);

    $.ajax({
        url: "{{ route('admin.category.togglenav') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: checkbox.data('id')
        },
        error: function () {
            checkbox.prop('checked', !checkbox.prop('checked'));
            alert('Something went wrong.');
        }
    });

});

    </script>

    

@endpush
