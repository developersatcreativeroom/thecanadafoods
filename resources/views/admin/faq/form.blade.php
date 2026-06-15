@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Faq</h1>
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
                                <h3 class="card-title p-3">Faq details</h3>
                                <div class="ml-auto py-2 px-3"><a class="btn btn-primary"
                                        href="{{ route('admin.faqs') }}">List</a></div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('admin.faq.post') }}" method="post" enctype='multipart/form-data'>
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">                                           

                                            <div class="form-group">
                                                <label for="type">Type <span class="text-danger">*</span></label>
                                                <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="faq_type" name="type">
                                                    <option value="">--Select--</option>
                                                    @foreach (config('constants.FAQ_TYPES') as $key => $type)
                                                        <option value="{{ $key }}"
                                                            @if (old('type') != null && old('type') == $key) selected @elseif(!empty($row) && $row->type == $key) selected @endif>
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('type') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <div id="type_id_container">                                              
                                                    @if( (old('type') === 'category') || (old('type') === 'blog') || (isset($row->type) && ($row->type === 'category' || $row->type === 'blog')) )
                                                        <label for="type_id">{{ ucfirst(old('type', $row->type ?? '')) }} <span class="text-danger">*</span></label>
                                                        <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}"  name="type_id">
                                                            <option value="">--Select--</option>
                                                            @php
                                                                $selectedType = old('type', $row->type ?? '');
                                                                $selectedId   = old('type_id', $row->type_id ?? '');
                                                            @endphp
                                                            @if ($selectedType === 'category')
                                                                @foreach ($categorys as $category)
                                                                    <option value="{{ $category->id }}" @if (old('type_id') != null && old('type_id') == $category->id) selected @elseif(!empty($row) && $row->type_id == $category->id) selected @endif> 
                                                                    {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            @elseif ($selectedType === 'blog')
                                                                @foreach ($blogs as $blog)
                                                                    <option value="{{ $blog->id }}" @if (old('type_id') != null && old('type_id') == $blog->id) selected @elseif(!empty($row) && $row->type_id == $blog->id) selected @endif> 
                                                                    {{ $blog->title }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>  
                                                    
                                                    @else
                                                        <label for="type_id">Blog/Category<span class="text-danger">*</span></label>
                                                        <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}"  name="type_id">
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    @endif
                                                </div>
                                                @if ($errors->has('type_id'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('type_id') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="question">Question <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}"
                                                    id="question" placeholder="Enter Question" name="question"
                                                    value="@if (old('question') != null) {{ old('question') }}@elseif(!empty($row->question)){{ $row->question }} @endif">
                                                @if ($errors->has('question'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('question') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="answer">Answer <span class="text-danger">*</span></label>
                                                <textarea class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}" id="answer" placeholder="Enter Answer" name="answer" rows="3">{{ old('answer', $row->answer ?? '') }}</textarea>
                                                @if ($errors->has('answer'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('answer') }}
                                                    </span>
                                                @endif
                                            </div>




                                            <div class="form-group">
                                                <label for="status">Status <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                    id="status" name="status">
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
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->
    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

        $(document).ready(function() {
            $('#faq_type').change(function() {
                var type = $(this).val();
                if(type == 'category') {
                    var html = `<div class="form-group">                                              
                        <label for="type_id">Category <span class="text-danger">*</span></label>
                        <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}"  name="type_id">
                            <option value="">--Select--</option>
                            @foreach ($categorys as $category)
                                <option value="{{ $category->id }}" @if (old('type_id') != null && old('type_id') == $category->id) selected @elseif(!empty($row) && $row->type_id == $category->id) selected @endif> 
                                {{ $category->name }}
                                </option>
                            @endforeach
                        </select>  
                    </div>`;
                    console.log(html);
                    $('#type_id_container').html(html);
                } else if( type == 'blog') {
                    var html = `<div class="form-group">                                              
                        <label for="type_id">Blog <span class="text-danger">*</span></label>
                        <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}"  name="type_id">
                            <option value="">--Select--</option>
                            @foreach ($blogs as $blog)
                                <option value="{{ $blog->id }}" @if (old('type_id') != null && old('type_id') == $blog->id) selected @elseif(!empty($row) && $row->type_id == $blog->id) selected @endif> 
                                {{ $blog->title }}
                                </option>
                            @endforeach
                        </select>  
                    </div>`;
                    console.log(html);
                    $('#type_id_container').html(html);
                } else {
                    $('#type_id_container').html('');
                }
            });
        });
    </script>
@endpush
