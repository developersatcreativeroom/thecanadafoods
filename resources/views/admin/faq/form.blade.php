@extends('admin.layouts.app')

@section('content')
    <style>
        #faqs-cont { margin-bottom: 10px; }
        .faq-item {
            padding: 14px 0;
            border-bottom: 1px solid #edf0f2;
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-item .faq-row-line {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .faq-item .faq-drag-handle {
            cursor: move;
            color: #ced4da;
            font-size: 15px;
            flex: 0 0 auto;
            width: 16px;
            text-align: center;
        }
        .faq-item .faq-drag-handle:hover { color: #868e96; }
        .faq-item .faq-question-input {
            flex: 1 1 auto;
            min-width: 0;
            border-radius: 6px;
        }
        .faq-item .faq-question-input:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 .15rem rgba(111,66,193,.15);
        }
        .faq-item .faq-status-switch { flex: 0 0 auto; margin-bottom: 0; }
        .faq-item .faq-add-btn,
        .faq-item .faq-remove-btn {
            flex: 0 0 auto;
            width: 30px;
            height: 30px;
            padding: 0;
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .faq-item .faq-body { padding-left: 26px; }
        .faq-item .faq-body textarea {
            border-radius: 6px;
        }
        .faq-item .faq-body textarea:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 .15rem rgba(111,66,193,.15);
        }
        .faq-item.ui-sortable-helper {
            background: #fff;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            border-radius: 6px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .faq-placeholder {
            border: 2px dashed #ced4da;
            border-radius: 6px;
            margin: 10px 0;
            height: 64px;
            background: #f8f9fa;
        }
        .faq-item.faq-highlighted {
            background: #fff8e1;
            border-radius: 6px;
            padding-left: 10px;
            padding-right: 10px;
            animation: faqHighlightFade 2.5s ease forwards;
        }
        @keyframes faqHighlightFade {
            0% { background: #fff3cd; }
            100% { background: transparent; }
        }
    </style>

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
                            <form action="{{ route('admin.faq.post') }}" method="post" id="faq-form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="faq_type">Type <span class="text-danger">*</span></label>
                                                <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="faq_type" name="type">
                                                    <option value="">--Select--</option>
                                                    @foreach (config('constants.FAQ_TYPES') as $key => $type)
                                                        <option value="{{ $key }}"
                                                            @if (old('type', $selectedType ?? '') == $key) selected @endif>
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('type') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div id="type_id_container">
                                                    @php
                                                        $selectedTypeValue = old('type', $selectedType ?? '');
                                                        $selectedIdValue = old('type_id', $selectedTypeId ?? '');
                                                    @endphp
                                                    <label for="type_id">Category/Blog/Product <span class="text-danger">*</span></label>
                                                    <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" id="type_id" name="type_id">
                                                        <option value="">--Select--</option>
                                                        @if ($selectedTypeValue === 'category')
                                                            @foreach ($categorys as $category)
                                                                <option value="{{ $category->id }}" @if ($selectedIdValue == $category->id) selected @endif>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        @elseif ($selectedTypeValue === 'blog')
                                                            @foreach ($blogs as $blog)
                                                                <option value="{{ $blog->id }}" @if ($selectedIdValue == $blog->id) selected @endif>
                                                                    {{ $blog->title }}
                                                                </option>
                                                            @endforeach
                                                        @elseif ($selectedTypeValue === 'product')
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" @if ($selectedIdValue == $product->id) selected @endif>
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                @if ($errors->has('type_id'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('type_id') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div id="faqs-cont">
                                        @php $existingRows = old('faqs', null); @endphp
                                        @if ($existingRows)
                                            @foreach ($existingRows as $index => $faqOld)
                                                @include('admin.faq.faq-row', ['index' => $index, 'faqRow' => (object) [
                                                    'id' => $faqOld['id'] ?? '',
                                                    'question' => $faqOld['question'] ?? '',
                                                    'answer' => $faqOld['answer'] ?? '',
                                                    'status' => $faqOld['status'] ?? 1,
                                                ]])
                                            @endforeach
                                        @elseif (isset($rows) && count($rows) > 0)
                                            @foreach ($rows as $index => $faqRow)
                                                @include('admin.faq.faq-row', ['index' => $index, 'faqRow' => $faqRow])
                                            @endforeach
                                        @else
                                            @include('admin.faq.faq-row', ['index' => 0, 'faqRow' => null])
                                        @endif
                                    </div>

                                    <input type="hidden" id="faq-row-template" value="{{ view('admin.faq.faq-row', ['index' => '__INDEX__', 'faqRow' => null])->render() }}">

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save FAQs</button>
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
        $(document).ready(function() {

            // Renumbers every faq-item's field names/ids sequentially based on
            // current DOM order, so add/remove/drag can never leave a gap or
            // duplicate index behind.
            function reindexFaqRows() {
                $('#faqs-cont').find('.faq-item').each(function(newIndex) {
                    var $item = $(this);
                    $item.attr('data-key', newIndex);

                    $item.find('[name]').each(function() {
                        var name = $(this).attr('name');
                        var newName = name.replace(/faqs\[\d+\]/, 'faqs[' + newIndex + ']');
                        $(this).attr('name', newName);
                    });

                    $item.find('input[type="checkbox"]').each(function() {
                        var newId = 'faq_status_' + newIndex;
                        $item.find('label.custom-control-label').attr('for', newId);
                        $(this).attr('id', newId);
                    });
                });

                refreshFaqButtons();
            }

            // The green "+" only ever appears on the LAST row (to add another
            // FAQ at the end). Every row gets its own red "-" so any single
            // FAQ can be removed directly, in any position - except when
            // only one row remains, since at least one FAQ must stay.
            function refreshFaqButtons() {
                var $items = $('#faqs-cont').find('.faq-item');
                var total = $items.length;
                var lastIndex = total - 1;

                $items.each(function(idx) {
                    var $item = $(this);
                    var isLast = idx === lastIndex;
                    $item.find('.faq-add-btn').css('display', isLast ? 'inline-flex' : 'none');
                    $item.find('.faq-remove-btn').css('display', total > 1 ? 'inline-flex' : 'none');
                });
            }

            $('body').on('click', '.faq-add-btn', function() {
                var newIndex = $('#faqs-cont').find('.faq-item').length;
                var template = $('#faq-row-template').val().replace(/__INDEX__/g, newIndex);
                $('#faqs-cont').append(template);
                refreshFaqButtons();
                return false;
            });

            $('body').on('click', '.faq-remove-btn', function() {
                if ($('#faqs-cont').find('.faq-item').length <= 1) {
                    return false;
                }
                if (!confirm('Are you sure you want to remove this FAQ?')) {
                    return false;
                }
                $(this).closest('.faq-item').remove();
                reindexFaqRows();
                return false;
            });

            $('#faqs-cont').sortable({
                handle: '.faq-drag-handle',
                placeholder: 'faq-placeholder',
                axis: 'y',
                update: function() {
                    reindexFaqRows();
                }
            });

            refreshFaqButtons();

            @if (!empty($highlightId))
                (function() {
                    var $target = $('#faqs-cont').find('.faq-item[data-faq-id="{{ $highlightId }}"]');
                    if ($target.length) {
                        $('html, body').animate({
                            scrollTop: $target.offset().top - 100
                        }, 400);
                        $target.addClass('faq-highlighted');
                        setTimeout(function() {
                            $target.removeClass('faq-highlighted');
                        }, 2500);
                    }
                })();
            @endif

            function initTypeIdSelect2() {
                if ($.fn.select2) {
                    $('#type_id').select2({
                        width: '100%',
                        placeholder: '--Select--'
                    });
                }
            }
            initTypeIdSelect2();

            $('#faq_type').change(function() {
                var type = $(this).val();
                var label = 'Category/Blog/Product';
                var html = '<label for="type_id">' + label + ' <span class="text-danger">*</span></label>' +
                    '<select class="form-control" id="type_id" name="type_id"><option value="">--Select--</option>';

                if (type == 'category') {
                    @foreach ($categorys as $category)
                        html += '<option value="{{ $category->id }}">{{ addslashes($category->name) }}</option>';
                    @endforeach
                } else if (type == 'blog') {
                    @foreach ($blogs as $blog)
                        html += '<option value="{{ $blog->id }}">{{ addslashes($blog->title) }}</option>';
                    @endforeach
                } else if (type == 'product') {
                    @foreach ($products as $product)
                        html += '<option value="{{ $product->id }}">{{ addslashes($product->name) }}</option>';
                    @endforeach
                }

                html += '</select>';

                if ($.fn.select2 && $('#type_id').data('select2')) {
                    $('#type_id').select2('destroy');
                }
                $('#type_id_container').html(html);
                initTypeIdSelect2();
            });

            $('body').on('change', '#type_id', function() {
                var type = $('#faq_type').val();
                var typeId = $(this).val();
                if (type && typeId) {
                    window.location.href = "{{ route('admin.faq') }}?type=" + encodeURIComponent(type) + "&type_id=" + encodeURIComponent(typeId);
                }
            });
        });
    </script>
@endpush
