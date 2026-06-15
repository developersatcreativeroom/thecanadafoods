@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ratings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Ratings</li>
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
                                <h3 class="card-title p-3">Rating Listing</h3>
				                <div class="ml-auto py-2 px-3"><a class="btn btn-primary" href="{{route('admin.rating')}}">Create</a></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row justify-content-end">
                                    <form action="{{ route('admin.ratings') }}" method="get" enctype='multipart/form-data' class="col mb-3">
                                        <div class="row"> 

                                            <div class="col-md-6 mt-2">
                                                <select class="form-control select2 {{ $errors->has('product') ? ' is-invalid' : '' }}" id="product-filter" name="product">
                                                    <option value="">--Select Product--</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->slug}}" {{ request('product') == $product->slug ? 'selected' : '' }} >{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <select class="form-control {{ $errors->has('star') ? ' is-invalid' : '' }}" id="star-filter" name="star">
                                                    <option value="">--Select Star--</option>
                                                    @foreach(config('constants.STAR_RATINGS') as $k=>$star)
                                                        <option value="{{$star}}" {{ request('star') == $star ? 'selected' : '' }} >
                                                            {{$star}}
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <span class="ti text-warning" style="--rating:{{ $star }}"></span>
                                                            </div>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <button class="btn btn-success" type="submit">Search</button>
                                                        <a href="{{ route('admin.ratings') }}" class="btn btn-info" >Clear</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Product</th>
                                            <th>Review</th>
                                            <th>Approved</th>
                                            <th>Status</th>
                                            <th>Added on</th>
                                            <th style="width: 130px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $row)
                                            <tr>
                                                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }} </td>
                                                <td>
                                                    {{ $row->name }}
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <span class="ti text-warning" style="--rating:{{ $row->rating }}"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{route('product', $row->product->slug )}}" target="_blank">{{ $row->product->name }}</a>
                                                </td>
                                                <td>{{ $row->review }}</td>
                                                <td>
                                                    @if ($row->is_approved)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($row->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">In-active</span>
                                                    @endif
                                                </td>
                                                <td>{{ $row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? '' }} </td>
                                                <td>
                                                    <a href="{{ route('admin.rating.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="{{route('admin.rating.delete', $row->id)}}" class="btn btn-danger btn-sm delete-btn">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {!! $rows->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
