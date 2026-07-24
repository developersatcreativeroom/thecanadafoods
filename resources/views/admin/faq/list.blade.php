@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Faqs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Faqs</li>
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
                <h3 class="card-title p-3">Faq Listing</h3>
				        <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.faq')}}">Create</a></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row justify-content-end">
                    <form action="{{ route('admin.faqs') }}" method="get" enctype='multipart/form-data' class="col mb-3">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <select class="form-control select2 " id="type-filter" name="type">
                                    <option value="">--Select Type--</option>
                                    @foreach (config('constants.FAQ_TYPES') as $key => $type)
                                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mt-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <button class="btn btn-success" type="submit">Search</button>
                                        <a href="{{ route('admin.faqs') }}" class="btn btn-info" >Clear</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Total Faqs</th>
                      <th>Status</th>
                      <th>Added on</th>
                      <th style="width: 150px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
					        @foreach($rows as $row)
                    <tr>
                      <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                      <td>{{ $row->entity_name }}</td>
                      <td>{{ ucfirst($row->type) }}</td>
                      <td>{{ $row->total_faqs }}</td>
                      <td>
                        @if($row->active_count == $row->total_faqs)
                          <span class="badge bg-success">Active</span>
                        @elseif($row->active_count == 0)
                          <span class="badge bg-danger">In-active</span>
                        @else
                          <span class="badge bg-warning">{{ $row->active_count }}/{{ $row->total_faqs }} Active</span>
                        @endif
                      </td>
                      <td>{{ $row->added_on ? \Carbon\Carbon::parse($row->added_on)->format(App\Helper::universalDateTimeFormat()) : '' }}</td>
                      <td>
                        <a href="{{ route('admin.faq', ['type' => $row->type, 'type_id' => $row->type_id]) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('admin.faq.group.delete', ['type' => $row->type, 'type_id' => $row->type_id]) }}" class="btn btn-danger btn-sm delete-btn">Delete</a>
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
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

    <script>

    $('ul.pagination').addClass('pagination-sm m-0 float-right')

    </script>
@endpush
