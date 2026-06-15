@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Rating</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                <h3 class="card-title p-3">Rating details</h3>
                                <div class="ml-auto py-2 px-3"><a class="btn btn-primary"
                                        href="{{ route('admin.ratings') }}">List</a></div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('admin.rating.post') }}" method="post" enctype='multipart/form-data'>
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product">Product <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('product') ? ' is-invalid' : '' }}"
                                                    id="product" name="product">
                                                    <option value="">--Select--</option>
                                                    @foreach ($products as $key => $product)
                                                        <option value="{{ $product->id }}" {{ old('product', isset($row) ? $row->product_id : '') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('product'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('product') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="user">User</label>
                                                <select
                                                    class="form-control {{ $errors->has('user') ? ' is-invalid' : '' }}"
                                                    id="user" name="user">
                                                    <option value="">--Select--</option>
                                                    @foreach ($users as $key => $user)
                                                        <option value="{{ $user->id }}" {{ old('user', isset($row) ? $row->user_id : '') == $user->id ? 'selected' : '' }} data-name="{{ $user->first_name.' '.$user->last_name }}" data-email="{{$user->email}}">
                                                            {{ $user->first_name.' '.$user->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('user') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    id="name" placeholder="Enter Name" name="name"
                                                    value="@if (old('name') != null) {{ old('name') }}@elseif(!empty($row->name)){{ $row->name }} @endif">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                    id="email" placeholder="Enter email" name="email"
                                                    value="@if (old('email') != null) {{ old('email') }}@elseif(!empty($row->email)){{ $row->email }} @endif">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="rate">Ratings <span class="text-danger">*</span></label> 
                                                <div class="d-flex mb-2 fv-row">                                                 
                                                    <div class="rate" >
                                                        <input type="radio" id="star5" name="rate" value="5" {{ old('rate', isset($row) ? $row->rating : '') == 5 ? 'checked' : '' }} />
                                                        <label for="star5" title="text">5 stars</label>
                                                        <input type="radio" id="star4" name="rate" value="4" {{ old('rate', isset($row) ? $row->rating : '') == 4 ? 'checked' : '' }} />
                                                        <label for="star4" title="text">4 stars</label>
                                                        <input type="radio" id="star3" name="rate" value="3" {{ old('rate', isset($row) ? $row->rating : '') == 3 ? 'checked' : '' }} />
                                                        <label for="star3" title="text">3 stars</label>
                                                        <input type="radio" id="star2" name="rate" value="2" {{ old('rate', isset($row) ? $row->rating : '') == 2 ? 'checked' : '' }}  />
                                                        <label for="star2" title="text">2 stars</label>
                                                        <input type="radio" id="star1" name="rate" value="1" {{ old('rate', isset($row) ? $row->rating : '') == 1 ? 'checked' : '' }} />
                                                        <label for="star1" title="text">1 star</label>
                                                    </div>                                               
                                                </div>                                               
                                                @if ($errors->has('rate'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('rate') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="review">Review</label>
                                                <textarea type="text" class="form-control {{ $errors->has('review') ? ' is-invalid' : '' }}" id="review" rows="3" placeholder="Enter Review" name="review">{{ old('review', isset($row) ? $row->review : '') }}</textarea> 
                                                @if ($errors->has('review'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('review') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="brand">Is Approved <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('is_approved') ? ' is-invalid' : '' }}"
                                                    id="is_approved" name="is_approved">
                                                    <option value="">--Select--</option>

                                                    <option value="0"
                                                        @if (old('is_approved') != null && old('is_approved') == 0) selected @elseif(!empty($row) && $row->is_approved == 0) selected @endif>
                                                        Not Approved
                                                    </option>
                                                    <option value="1"
                                                        @if (old('is_approved') != null && old('is_approved') == 1) selected @elseif(!empty($row) && $row->is_approved == 1) selected @endif>
                                                        Approved
                                                    </option>

                                                </select>
                                                @if ($errors->has('is_approved'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('is_approved') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="brand">Status <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                    id="brand" name="status">
                                                    <option value="">--Select--</option>
                                                    @foreach (config('constants.STATUSES') as $key => $status)
                                                        <option value="{{ $key }}"
                                                            @if (old('status') != null && old('status') == $key) selected @elseif(!empty($row) && $row->status == $key) selected @endif>
                                                            {{ $status }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('status'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('status') }}
                                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-6">



                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <input type="hidden" name="id"
                                    value="@if (!empty($row->id)) {{ $row->id }} @endif">
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
    <script>
        $(document).ready(function () {
            $('#user').change(function () {
                var selectedOption = $(this).find('option:selected');
                var name = selectedOption.data('name');
                var email = selectedOption.data('email');

                $('#name').val(name);
                $('#email').val(email);
            }); 
        });
    </script>
@endpush
