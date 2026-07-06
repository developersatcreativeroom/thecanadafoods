@extends('admin.layouts.app')

@section('content')


    @if (old('attributes') != null)
        <!-- <pre>{{ print_r(old('variants')) }}</pre> -->
    @endif

    @php

        //die;
    @endphp

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product</h1>
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
                                <h3 class="card-title p-3">Product details</h3>
                                <div class="ml-auto py-2 px-3"><a class="btn btn-primary"
                                        href="{{ route('admin.products') }}">List</a></div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('admin.product.post') }}" method="post" enctype='multipart/form-data'
                                id="product-form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            @if (!empty($row->id))
                                                <div class="form-group">
                                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                                        id="slug" placeholder="Enter slug" name="slug"
                                                        value="@if (old('slug') != null) {{ old('slug') }}@elseif(!empty($row->slug)){{ $row->slug }} @endif">
                                                    @if ($errors->has('slug'))
                                                        <span class="invalid-feedback">
                                                            {{ $errors->first('slug') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    id="name" placeholder="Enter name" name="name"
                                                    value="@if (old('name') != null) {{ old('name') }}@elseif(!empty($row->name)){{ $row->name }} @endif">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="title_h1">H1 Title</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('title_h1') ? ' is-invalid' : '' }}"
                                                    id="title_h1" placeholder="Enter H1 Title" name="title_h1"
                                                    value="@if (old('title_h1') != null) {{ old('title_h1') }}@elseif(!empty($row->title_h1)){{ $row->title_h1 }} @endif">
                                                @if ($errors->has('title_h1'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('title_h1') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="short_description">Short Description <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('short_description') ? ' is-invalid' : '' }}"
                                                    id="short_description" placeholder="Enter Short Description"
                                                    name="short_description"
                                                    value="@if (old('short_description') != null) {{ old('short_description') }}@elseif(!empty($row->short_description)){{ $row->short_description }} @endif">
                                                @if ($errors->has('short_description'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('short_description') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" rows="4"
                                                    placeholder="Enter Description" name="description">
@if (old('description') != null)
{{ old('description') }}
@elseif(!empty($row->description))
{{ $row->description }}
@endif
</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Product Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" accept="image/png, image/gif, image/jpeg, image/webp, image/avif"
                                                    class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                    data-default-file="{{ !empty($row) && ($row->image != null || $row->image != '') ? asset('storage/products/') . '/' . $row->id . '/' . $row->image : '' }}"
                                                    id="image" name="image">
                                                @if ($errors->has('image'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('image') }}
                                                    </span>
                                                @endif

                                            </div>
                                            {{-- @if (!empty($row) && ($row->image != null || $row->image != ''))
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-4">
											<img class="img-fluid img-thumbnail" src="{{ asset('storage/products/') }}/{{$row->id}}/{{$row->image}}" />
										</div>
									</div>
								</div>
							@endif --}}

                                            <div class="form-group">
                                                <label for="image_alt">Image Alt</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('image_alt') ? ' is-invalid' : '' }}"
                                                    id="image_alt" placeholder="Enter Image Alt" name="image_alt"
                                                    value="@if (old('image_alt') != null) {{ old('image_alt') }}@elseif(!empty($row->image_alt)){{ $row->image_alt }} @endif">
                                                @if ($errors->has('image_alt'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('image_alt') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="hover_image">Product Hover Image </label>
                                                <input type="file" accept="image/png, image/gif, image/jpeg, image/webp, image/avif"
                                                    class="form-control dropify {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                    data-default-file="{{ !empty($row) && ($row->hover_image != null || $row->hover_image != '') ? asset('storage/products/') . '/' . $row->id . '/' . $row->hover_image : '' }}"
                                                    id="hover_image" name="hover_image">
                                                @if ($errors->has('hover_image'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('hover_image') }}
                                                    </span>
                                                @endif
                                            </div>
                                            {{-- @if (!empty($row) && ($row->hover_image != null || $row->hover_image != ''))
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-4">
											<img class="img-fluid img-thumbnail" src="{{ asset('storage/products/') }}/{{$row->id}}/{{$row->hover_image}}" />
										</div>
									</div>
								</div>
							@endif --}}


                                            <div class="form-group">
                                                <label for="gallery_images">Gallery Images </label>
                                                {{-- <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control {{ $errors->has('images') ? ' is-invalid' : '' }}" id="gallery_images" name="images[]" multiple> --}}
                                                <div id="multiple_images" class="row"></div>
                                                @if ($errors->has('images'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('images') }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if (!empty($row) && ($row->images != null || $row->images != '') && count($row->images) > 0)
                                                <div class="form-group">
                                                    <div class="form-row">
                                                        @foreach ($row->images as $image)
<div class="col-md-4 mb-3">

    <div class="gallery-img-container">

        <a class="btn btn-sm btn-dark delete-btn btn-remove"
            href="{{ route('admin.delete.product.gallery', [$row->id,$image->id]) }}">
            <i class="fas fa-times"></i>
        </a>

        <img class="img-fluid img-thumbnail mb-2"
            src="{{ asset('storage/products/'.$row->id.'/gallery/'.$image->image) }}"
            alt="{{ $image->image_alt }}">

        <input type="hidden" name="gallery_image_id[]" value="{{ $image->id }}">

        <label>Image Alt Text</label>

        <input
            type="text"
            class="form-control"
            name="gallery_alt[{{ $image->id }}]"
            value="{{ old('gallery_alt.'.$image->id,$image->image_alt) }}"
            placeholder="Enter image alt text">

    </div>

</div>
@endforeach
                                                        {{-- @foreach ($row->images as $image)
                                                            <div class="col-md-4">
                                                                <div class="gallery-img-container">
                                                                    <a class="btn btn-sm btn-dark delete-btn btn-remove"
                                                                        href="{{ route('admin.delete.product.gallery', [$row->id, $image->id]) }}"><i
                                                                            class="fas fa-times"></i></a>
                                                                    <img class="img-fluid mb-2 img-thumbnail"
                                                                        src="{{ asset('storage/products/') }}/{{ $row->id }}/gallery/{{ $image->image }}" />
                                                                </div>
                                                            </div>
                                                        @endforeach --}}
                                                    </div>
                                                </div>
                                            @endif


                                            <div class="form-group">
                                                <label>Product variants </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_variant') ? ' is-invalid' : '' }}"
                                                        id="is_variant" name="is_variant"
                                                        @if (old('is_variant') != null) checked @elseif(!empty($row->is_variant)) checked @endif>
                                                    <label class="custom-control-label" for="is_variant"></label>
                                                </div>
                                                @if ($errors->has('is_variant'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_variant') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group" id="variants">
                                                <label for="variant">Select Variants <span
                                                        class="text-danger">*</span></label>
                                                <select class="select2" multiple="multiple" id="attributes"
                                                    data-placeholder="Select Attributes" style="width: 100%;"
                                                    name="variants[]">
                                                    @foreach ($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}"
                                                            @if (old('variants') != null && count(old('variants')) > 0 && in_array($attribute->id, old('variants'))) selected @elseif(!empty($variants) && in_array($attribute->id, $variants)) selected @endif)>
                                                            {{ $attribute->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('variants'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('variants') }}
                                                    </span>
                                                @endif

                                                <a href="#" class="btn btn-primary my-3" id="show-variations">Add
                                                    Variations</a>

                                                <div id="accordion">

                                                    @if (old('attributes') != null && count(old('attributes')) > 0)
                                                        @foreach (old('attributes') as $key => $attribute)
                                                            <div class="card card-primary"
                                                                data-key="{{ $key }}">
                                                                <div class="card-header">
                                                                    <h4 class="card-title w-100 d-flex">
                                                                        <a class="d-block w-100" data-toggle="collapse"
                                                                            href="#collapse{{ $key }}">

                                                                            @foreach ($attribute['details'] as $k => $v)
                                                                                <strong>{{ $v['attribute_name'] }}</strong>
                                                                                : {{ $v['attribute_value'] }}
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute]"
                                                                                    value="{{ $v['attribute'] }}">
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attributes_option]"
                                                                                    value="{{ $v['attributes_option'] }}">

                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute_name]"
                                                                                    value="{{ $v['attribute_name'] }}">
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute_value]"
                                                                                    value="{{ $v['attribute_value'] }}">

                                                                                <input class="combination-detail"
                                                                                    data-attribute="{{ $v['attribute'] }}"
                                                                                    data-attribute-option="{{ $v['attributes_option'] }}"
                                                                                    data-attribute-name="{{ $v['attribute_name'] }}"
                                                                                    data-attribute-value="{{ $v['attribute_value'] }}"
                                                                                    type="hidden">
                                                                            @endforeach


                                                                        </a> <a href="#" class="remove-attribute"><i
                                                                                class="fas fa-window-close text-white"></i></a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse{{ $key }}" class="collapse"
                                                                    data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Product
                                                                                        Image <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/webp"
                                                                                        class="form-control dropify"
                                                                                        id="input-{{ $key }}"
                                                                                        name="attributes[{{ $key }}][image]">
                                                                                    @if ($errors->has('attributes.' . $key . '.image'))
                                                                                        <span
                                                                                            class="invalid-feedback d-block">
                                                                                            {{ $errors->first('attributes.' . $key . '.image') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                {{-- <div class="form-group">
													<label for="input-{{$key}}">Product Hover Image </label>
													<input type="file" accept="image/png, image/gif, image/jpeg, image/webp, image/avif" class="form-control dropify" id="input-{{$key}}" name="attributes[{{$key}}][hover_image]">
													@if ($errors->has('attributes.' . $key . '.hover_image'))
														<span class="invalid-feedback d-block">
															{{ $errors->first('attributes.'.$key.'.hover_image') }}
														</span>
													@endif
												</div> --}}
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Price
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.price')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Price"
                                                                                        name="attributes[{{ $key }}][price]"
                                                                                        value="{{ $attribute['price'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.price'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.price') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Old
                                                                                        Price </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.old_price')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Old Price"
                                                                                        name="attributes[{{ $key }}][old_price]"
                                                                                        value="{{ $attribute['old_price'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.old_price'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.old_price') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">SKU
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control @if ($errors->has('attributes.' . $key . '.sku')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter SKU"
                                                                                        name="attributes[{{ $key }}][sku]"
                                                                                        value="{{ $attribute['sku'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.sku'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.sku') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Stock
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.stock')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Stock"
                                                                                        name="attributes[{{ $key }}][stock]"
                                                                                        value="{{ $attribute['stock'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.stock'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.stock') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <!--{{-- <div class="form-group">
													<label for="input-{{$key}}">Minimum Quantity <span class="text-danger">*</span></label>
													<input type="text" class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.min_quantity')) is-invalid @endif" id="input-{{$key}}" placeholder="Enter minimum quantity" name="attributes[{{$key}}][min_quantity]" value="{{$attribute['min_quantity']}}">
													@if ($errors->has('attributes.' . $key . '.min_quantity'))
														<span class="invalid-feedback">
															{{ $errors->first('attributes.'.$key.'.min_quantity') }}
														</span>
													@endif
												</div> --}}-->
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Threshold
                                                                                        Quantity </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.threshold')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Threshold"
                                                                                        name="attributes[{{ $key }}][threshold]"
                                                                                        value="{{ $attribute['threshold'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.threshold'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.threshold') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Length
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.length')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Length"
                                                                                        name="attributes[{{ $key }}][length]"
                                                                                        value="{{ $attribute['length'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.length'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.length') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Width
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.width')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Width"
                                                                                        name="attributes[{{ $key }}][width]"
                                                                                        value="{{ $attribute['width'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.width'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.width') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Height
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.height')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Height"
                                                                                        name="attributes[{{ $key }}][height]"
                                                                                        value="{{ $attribute['height'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.height'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.height') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Weight
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.weight')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Weight"
                                                                                        name="attributes[{{ $key }}][weight]"
                                                                                        value="{{ $attribute['weight'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.weight'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.weight') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Shipping
                                                                                        Weight (In gms) <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.shipping_weight')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Shipping Weight (In gms)"
                                                                                        name="attributes[{{ $key }}][shipping_weight]"
                                                                                        value="{{ $attribute['shipping_weight'] }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.shipping_weight'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.shipping_weight') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden"
                                                                                name="attributes[{{ $key }}][id]"
                                                                                value="@if (!empty($attribute['id'])) {{ $attribute['id'] }} @endif ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif(!empty($row->attributes) && count($row->attributes) > 0)
                                                        @foreach ($row->attributes as $key => $attribute)
                                                            <div class="card card-primary"
                                                                data-key="{{ $key }}">
                                                                <div class="card-header">
                                                                    <h4 class="card-title w-100 d-flex">
                                                                        <a class="d-block w-100" data-toggle="collapse"
                                                                            href="#collapse{{ $key }}">

                                                                            @foreach ($attribute->details as $k => $v)
                                                                                <strong>{{ $v->attribute_name }}</strong>
                                                                                : {{ $v->attribute_value }}
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute]"
                                                                                    value="{{ $v->attribute_id }}">
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attributes_option]"
                                                                                    value="{{ $v->attribute_option_id }}">

                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute_name]"
                                                                                    value="{{ $v->attribute_name }}">
                                                                                <input type="hidden"
                                                                                    name="attributes[{{ $key }}][details][{{ $k }}][attribute_value]"
                                                                                    value="{{ $v->attribute_value }}">

                                                                                <input class="combination-detail"
                                                                                    data-attribute="{{ $v->attribute_id }}"
                                                                                    data-attribute-option="{{ $v->attribute_option_id }}"
                                                                                    data-attribute-name="{{ $v->attribute_name }}"
                                                                                    data-attribute-value="{{ $v->attribute_value }}"
                                                                                    type="hidden">
                                                                            @endforeach


                                                                        </a> <a class="remove-attribute"><i
                                                                                class="fas fa-window-close text-white"></i></a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse{{ $key }}" class="collapse"
                                                                    data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Product
                                                                                        Image <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/webp"
                                                                                        class="form-control dropify"
                                                                                        data-default-file="{{ !empty($attribute) && ($attribute->image != null || $attribute->image != '') ? asset('storage/products/') . '/' . $row->id . '/' . $attribute->image : '' }}"
                                                                                        id="input-{{ $key }}"
                                                                                        name="attributes[{{ $key }}][image]">
                                                                                    @if ($errors->has('attributes.' . $key . '.image'))
                                                                                        <span
                                                                                            class="invalid-feedback d-block">
                                                                                            {{ $errors->first('attributes.' . $key . '.image') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                {{-- @if (!empty($attribute) && ($attribute->image != null || $attribute->image != ''))
													<div class="form-group">
														<div class="form-row">
															<div class="col-md-4">
																<img class="img-fluid img-thumbnail" src="{{ asset('storage/products/') }}/{{$row->id}}/{{$attribute->image}}" />
															</div>
														</div>
													</div>
												@endif --}}

                                                                                {{-- <div class="form-group">
													<label for="input-{{$key}}">Product Hover Image </label>
													<input type="file" accept="image/png, image/gif, image/jpeg, image/webp, image/avif" class="form-control dropify" id="input-{{$key}}" name="attributes[{{$key}}][hover_image]">
													@if ($errors->has('attributes.' . $key . '.hover_image'))
														<span class="invalid-feedback d-block">
															{{ $errors->first('attributes.'.$key.'.hover_image') }}
														</span>
													@endif
												</div>
												@if (!empty($attribute) && ($attribute->hover_image != null || $attribute->hover_image != ''))
													<div class="form-group">
														<div class="form-row">
															<div class="col-md-4">
																<img class="img-fluid img-thumbnail" src="{{ asset('storage/products/') }}/{{$row->id}}/{{$attribute->hover_image}}" />
															</div>
														</div>
													</div>
												@endif --}}
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Price
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.price')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Price"
                                                                                        name="attributes[{{ $key }}][price]"
                                                                                        value="{{ $attribute->price }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.price'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.price') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Old
                                                                                        Price </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.old_price')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Old Price"
                                                                                        name="attributes[{{ $key }}][old_price]"
                                                                                        value="{{ $attribute->old_price }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.old_price'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.old_price') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">SKU
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control @if ($errors->has('attributes.' . $key . '.sku')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter SKU"
                                                                                        name="attributes[{{ $key }}][sku]"
                                                                                        value="{{ $attribute->sku }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.sku'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.sku') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Stock
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.stock')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Stock"
                                                                                        name="attributes[{{ $key }}][stock]"
                                                                                        value="{{ $attribute->stock }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.stock'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.stock') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <!--{{-- <div class="form-group">
													<label for="input-{{$key}}">Minimum Quantity <span class="text-danger">*</span></label>
													<input type="text" class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.min_quantity')) is-invalid @endif" id="input-{{$key}}" placeholder="Enter minimum quantity" name="attributes[{{$key}}][min_quantity]" value="{{$attribute->min_quantity}}">
													@if ($errors->has('attributes.' . $key . '.min_quantity'))
														<span class="invalid-feedback">
															{{ $errors->first('attributes.'.$key.'.min_quantity') }}
														</span>
													@endif
												</div> --}}-->
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Threshold
                                                                                        Quantity </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.threshold')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Threshold"
                                                                                        name="attributes[{{ $key }}][threshold]"
                                                                                        value="{{ $attribute->threshold }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.threshold'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.threshold') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Length
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.length')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Length"
                                                                                        name="attributes[{{ $key }}][length]"
                                                                                        value="{{ $attribute->length }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.length'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.length') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Width
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.width')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Width"
                                                                                        name="attributes[{{ $key }}][width]"
                                                                                        value="{{ $attribute->width }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.width'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.width') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Height
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.height')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Height"
                                                                                        name="attributes[{{ $key }}][height]"
                                                                                        value="{{ $attribute->height }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.height'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.height') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Weight
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.weight')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Weight"
                                                                                        name="attributes[{{ $key }}][weight]"
                                                                                        value="{{ $attribute->weight }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.weight'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.weight') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="input-{{ $key }}">Shipping
                                                                                        Weight (In gms) <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control only-numbers @if ($errors->has('attributes.' . $key . '.shipping_weight')) is-invalid @endif"
                                                                                        id="input-{{ $key }}"
                                                                                        placeholder="Enter Shipping Weight (In gms)"
                                                                                        name="attributes[{{ $key }}][shipping_weight]"
                                                                                        value="{{ $attribute->shipping_weight }}">
                                                                                    @if ($errors->has('attributes.' . $key . '.shipping_weight'))
                                                                                        <span class="invalid-feedback">
                                                                                            {{ $errors->first('attributes.' . $key . '.shipping_weight') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden"
                                                                                name="attributes[{{ $key }}][id]"
                                                                                value="{{ $attribute->id }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif



                                                </div>

                                                @if ($errors->has('attributes'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('attributes') }}
                                                    </span>
                                                @endif


                                                <div class="">
                                                    <a class="btn btn-info btn-block d-none" id="add-custom-variants">Add
                                                        Selected variants</a>
                                                </div>


                                            </div>

                                            <hr>


                                            <div class="form-group">
                                                <label for="price">Price <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                    id="price" placeholder="Enter Price" name="price"
                                                    value="@if (old('price') != null) {{ old('price') }}@elseif(!empty($row->price)){{ $row->price }} @endif">
                                                @if ($errors->has('price'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('price') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="old_price">Old Price </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('old_price') ? ' is-invalid' : '' }}"
                                                    id="old_price" placeholder="Enter Old Price" name="old_price"
                                                    value="@if (old('old_price') != null) {{ old('old_price') }}@elseif(!empty($row->old_price)){{ $row->old_price }} @endif">
                                                @if ($errors->has('old_price'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('old_price') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="sku">SKU <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('sku') ? ' is-invalid' : '' }}"
                                                    id="sku" placeholder="Enter SKU" name="sku"
                                                    value="@if (old('sku') != null) {{ old('sku') }}@elseif(!empty($row->sku)){{ $row->sku }} @endif">
                                                @if ($errors->has('sku'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('sku') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="stock">Stock <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('stock') ? ' is-invalid' : '' }}"
                                                    id="stock" placeholder="Enter Stock" name="stock"
                                                    value="@if (old('stock') != null) {{ old('stock') }}@elseif(!empty($row->stock)){{ $row->stock }} @endif">
                                                @if ($errors->has('stock'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('stock') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!--{{-- <div class="form-group">
								<label for="min_quantity">Min Quantity <span class="text-danger">*</span></label>
								<input type="text" class="form-control {{ $errors->has('min_quantity') ? ' is-invalid' : '' }}" id="min_quantity" placeholder="Enter Quantity" name="min_quantity" value="@if (old('min_quantity') != null){{old('min_quantity')}}@elseif(!empty($row->min_quantity)){{$row->min_quantity}}@endif">
								@if ($errors->has('min_quantity'))
									<span class="invalid-feedback">
										{{ $errors->first('min_quantity') }}
									</span>
								@endif
							</div> --}}-->

                                            <div class="form-group">
                                                <label for="threshold">Threshold Quantity </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('threshold') ? ' is-invalid' : '' }}"
                                                    id="threshold" placeholder="Enter Threshold Quantity"
                                                    name="threshold"
                                                    value="@if (old('threshold') != null) {{ old('threshold') }}@elseif(!empty($row->threshold)){{ $row->threshold }} @endif">
                                                @if ($errors->has('threshold'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('threshold') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="length">Length </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('length') ? ' is-invalid' : '' }}"
                                                    id="length" placeholder="Enter Length" name="length"
                                                    value="@if (old('length') != null) {{ old('length') }}@elseif(!empty($row->length)){{ $row->length }} @endif">
                                                @if ($errors->has('length'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('length') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="width">Width </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('width') ? ' is-invalid' : '' }}"
                                                    id="width" placeholder="Enter Width" name="width"
                                                    value="@if (old('width') != null) {{ old('width') }}@elseif(!empty($row->width)){{ $row->width }} @endif">
                                                @if ($errors->has('width'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('width') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="height">Height </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('height') ? ' is-invalid' : '' }}"
                                                    id="height" placeholder="Enter Height" name="height"
                                                    value="@if (old('height') != null) {{ old('height') }}@elseif(!empty($row->height)){{ $row->height }} @endif">
                                                @if ($errors->has('height'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('height') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="weight">Weight </label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('weight') ? ' is-invalid' : '' }}"
                                                    id="weight" placeholder="Enter Weight" name="weight"
                                                    value="@if (old('weight') != null) {{ old('weight') }}@elseif(!empty($row->weight)){{ $row->weight }} @endif">
                                                @if ($errors->has('weight'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('weight') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="shipping_weight">Shipping Weight (In gms) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control only-numbers {{ $errors->has('shipping_weight') ? ' is-invalid' : '' }}"
                                                    id="shipping_weight" placeholder="Enter Shipping Weight (In gms)"
                                                    name="shipping_weight"
                                                    value="@if (old('shipping_weight') != null) {{ old('shipping_weight') }}@elseif(!empty($row->shipping_weight)){{ $row->shipping_weight }} @endif">
                                                @if ($errors->has('shipping_weight'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('shipping_weight') }}
                                                    </span>
                                                @endif
                                            </div>





                                            <div class="form-group">
                                                <label for="seo_title">SEO Title </label>
                                                <input type="text"
                                                    class="form-control count-characters {{ $errors->has('seo_title') ? ' is-invalid' : '' }}"
                                                    id="seo_title" placeholder="Enter SEO Title" name="seo_title"
                                                    value="@if (old('seo_title') != null) {{ old('seo_title') }}@elseif(!empty($row->seo_title)){{ $row->seo_title }} @endif">
                                                <small><strong>Note: </strong> Add 45 to 80 characters for optimal
                                                    results</small>
                                                @if ($errors->has('seo_title'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('seo_title') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="seo_description">SEO Description </label>
                                                <textarea type="text"
                                                    class="form-control count-characters {{ $errors->has('seo_description') ? ' is-invalid' : '' }}"
                                                    id="seo_description" rows="4" placeholder="Enter SEO Description" name="seo_description">
@if (old('seo_description') != null)
{{ old('seo_description') }}
@elseif(!empty($row->seo_description))
{{ $row->seo_description }}
@endif
</textarea>
                                                <small><strong>Note: </strong> Add 90 to 180 characters for optimal
                                                    results</small>
                                                @if ($errors->has('seo_description'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('seo_description') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="seo_keywords">SEO Keywords </label>
                                                <textarea class="form-control {{ $errors->has('seo_keywords') ? ' is-invalid' : '' }}" id="seo_keywords"
                                                    rows="4" placeholder="Enter SEO Keywords" name="seo_keywords">
@if (old('seo_keywords') != null)
{{ old('seo_keywords') }}
@elseif(!empty($row->seo_keywords))
{{ $row->seo_keywords }}
@endif
</textarea>
                                                <small>Example: Comma separated values like <strong>Keyword1, Keyword2,
                                                        Keyword3</strong></small>
                                                @if ($errors->has('seo_keywords'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('seo_keywords') }}
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
                                           <div class="form-group">
    <label for="temp_sensitive">
        Temperature Sensitive <span class="text-danger">*</span>
    </label>

    <select
        class="form-control {{ $errors->has('temp_sensitive') ? 'is-invalid' : '' }}"
        id="temp_sensitive"
        name="temp_sensitive">

        <option value="">--Select--</option>

        @foreach (config('constants.TEMPERATURES') as $key => $temp_sensitive)
            <option value="{{ $key }}"
                {{ old('temp_sensitive', !empty($row) ? $row->temp_sensitive : '') == $key ? 'selected' : '' }}>
                {{ $temp_sensitive }}
            </option>
        @endforeach

    </select>

    @if ($errors->has('temp_sensitive'))
        <span class="invalid-feedback">
            {{ $errors->first('temp_sensitive') }}
        </span>
    @endif
</div>


                                        </div>
                                        <div class="col-md-5">

                                            <div class="form-group">
                                                <label for="categories">Categories <span
                                                        class="text-danger">*</span></label>

                                                <select
                                                    class="form-control {{ $errors->has('categories') ? ' is-invalid' : '' }}"
                                                    id="categories" name="categories[]" multiple>
                                                    @foreach ($categories as $categorySingle)
                                                        <option
                                                            @if (old('categories') != null && in_array($categorySingle['id'], old('categories'))) selected @elseif(!empty($row) && count($categoriesProduct) > 0 && in_array($categorySingle['id'], $categoriesProduct)) selected @endif
                                                            value="{{ $categorySingle['id'] }}">
                                                            {{ $categorySingle['name'] }}</option>

                                                        @foreach ($categorySingle['children'] as $children1)
                                                            <option
                                                                @if (old('categories') != null && in_array($children1['id'], old('categories'))) selected @elseif(!empty($row) && count($categoriesProduct) > 0 && in_array($children1['id'], $categoriesProduct)) selected @endif
                                                                value="{{ $children1['id'] }}">&nbsp;&nbsp; &#9679;
                                                                {{ $children1['name'] }}</option>

                                                            @foreach ($children1['children'] as $children2)
                                                                <option
                                                                    @if (old('categories') != null && in_array($children2['id'], old('categories'))) selected @elseif(!empty($row) && count($categoriesProduct) > 0 && in_array($children2['id'], $categoriesProduct)) selected @endif
                                                                    value="{{ $children2['id'] }}">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp; &#9675;
                                                                    {{ $children2['name'] }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('categories'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('categories') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="brand">Brand <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('brand_id') ? ' is-invalid' : '' }}"
                                                    id="brand" name="brand_id">
                                                    <option value="">--Select--</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            @if (old('brand_id') != null && old('brand_id') == $brand->id) selected @elseif(!empty($row) && $row->brand_id == $brand->id) selected @endif>
                                                            {{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('brand_id'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('brand_id') }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- <div class="form-group">
								<label for="color">Color  <span class="text-danger">*</span></label>
								<select class="form-control {{ $errors->has('color_id') ? ' is-invalid' : '' }}" id="color" name="color_id">
									<option value="">--Select--</option>
									@foreach ($colors as $color)
										<option value="{{$color->id}}" @if (old('color_id') != null && old('color_id') == $color->id) selected @elseif(!empty($row) && $row->color_id==$color->id) selected @endif>{{$color->name}}</option>
									@endforeach
								</select>
								@if ($errors->has('color_id'))
									<span class="invalid-feedback">
										{{ $errors->first('color_id') }}
									</span>
								@endif
							</div> --}}

                                            <div class="form-group">
                                                <label for="tax_id">Tax <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control {{ $errors->has('tax_id') ? ' is-invalid' : '' }}"
                                                    id="tax_id" name="tax_id">
                                                    <option value="">--Select--</option>
                                                    @foreach ($taxes as $tax)
                                                        <option value="{{ $tax->id }}"
                                                            @if (old('tax_id') != null && old('tax_id') == $tax->id) selected @elseif(!empty($row) && $row->tax_id == $tax->id) selected @endif>
                                                            {{ $tax->name }} ({{ $tax->tax }}%)</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('tax_id'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('tax_id') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is Tax Included? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_tax_included') ? ' is-invalid' : '' }}"
                                                        id="is_tax_included" name="is_tax_included"
                                                        @if (old('is_tax_included') != null) checked @elseif(!empty($row->is_tax_included)) checked @endif>
                                                    <label class="custom-control-label" for="is_tax_included"></label>
                                                </div>
                                                @if ($errors->has('is_tax_included'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('is_tax_included') }}
                                                    </span>
                                                @endif
                                            </div>



                                            <div class="form-group">
                                                <label>Is featured product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_featured"
                                                        name="is_featured"
                                                        @if (old('is_featured') != null) checked @elseif(!empty($row->is_featured)) checked @endif>
                                                    <label class="custom-control-label" for="is_featured"></label>
                                                </div>
                                                @if ($errors->has('is_featured'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_featured') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is Sample product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_sample') ? ' is-invalid' : '' }}"
                                                        id="is_sample" name="is_sample"
                                                        @if (old('is_sample') != null) checked @elseif(!empty($row->is_sample)) checked @endif>
                                                    <label class="custom-control-label" for="is_sample"></label>
                                                </div>
                                                @if ($errors->has('is_sample'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_sample') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is Sale product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_sale') ? ' is-invalid' : '' }}"
                                                        id="is_sale" name="is_sale"
                                                        @if (old('is_sale') != null) checked @elseif(!empty($row->is_sale)) checked @endif>
                                                    <label class="custom-control-label" for="is_sale"></label>
                                                </div>
                                                @if ($errors->has('is_sale'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_sale') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is New product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_new') ? ' is-invalid' : '' }}"
                                                        id="is_new" name="is_new"
                                                        @if (old('is_new') != null) checked @elseif(!empty($row->is_new)) checked @endif>
                                                    <label class="custom-control-label" for="is_new"></label>
                                                </div>
                                                @if ($errors->has('is_new'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_new') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is Hot product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_hot') ? ' is-invalid' : '' }}"
                                                        id="is_hot" name="is_hot"
                                                        @if (old('is_hot') != null) checked @elseif(!empty($row->is_hot)) checked @endif>
                                                    <label class="custom-control-label" for="is_hot"></label>
                                                </div>
                                                @if ($errors->has('is_hot'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_hot') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Is Best Sell product? </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $errors->has('is_best_sell') ? ' is-invalid' : '' }}"
                                                        id="is_best_sell" name="is_best_sell"
                                                        @if (old('is_best_sell') != null) checked @elseif(!empty($row->is_best_sell)) checked @endif>
                                                    <label class="custom-control-label" for="is_best_sell"></label>
                                                </div>
                                                @if ($errors->has('is_best_sell'))
                                                    <span class="invalid-feedback d-block">
                                                        {{ $errors->first('is_best_sell') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="tags">Tags </label>

                                                <select class="select2 tags" multiple="multiple"
                                                    data-placeholder="Enter Tags" style="width: 100%;" name="tags[]">
                                                    @if (old('tags') != null)
                                                        @foreach (old('tags') as $tag)
                                                            <option value="{{ $tag }}" selected>
                                                                {{ $tag }}</option>
                                                        @endforeach
                                                    @elseif(!empty($row->tags) && $row->tags != null)
                                                        @foreach (json_decode($row->tags) as $tag)
                                                            <option value="{{ $tag }}" selected>
                                                                {{ $tag }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('tags'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('tags') }}
                                                    </span>
                                                @endif

                                            </div>


                                            <div class="form-group">

                                                <label>Product Specifications </label>

                                                <div id="specifications-cont">

                                                    @if (!empty($row->specifications) && count($row->specifications) > 0)
                                                        @foreach ($row->specifications as $key => $specification)
                                                            <div class="row" data-key="{{ $key }}">
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <div class="form-row">
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.specification') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Specification"
                                                                                    name="specifications[{{ $key }}][specification]"
                                                                                    value="{{ $specification->specification }}">
                                                                                @if ($errors->has('specifications.' . $key . '.specification'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.specification') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.value') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Value"
                                                                                    name="specifications[{{ $key }}][value]"
                                                                                    value="{{ $specification->value }}">
                                                                                @if ($errors->has('specifications.' . $key . '.value'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.value') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.units') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Units (Optional)"
                                                                                    name="specifications[{{ $key }}][units]"
                                                                                    value="{{ $specification->units }}">
                                                                                @if ($errors->has('specifications.' . $key . '.units'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.units') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button class="btn btn-success add-specification"><i
                                                                            class="fa fa-plus"></i></button>
                                                                    <button class="btn btn-danger remove-specification"
                                                                        data-product-id="@if (!empty($row->id)) {{ $row->id }} @endif"
                                                                        data-id="{{ $specification->id }}"><i
                                                                            class="fa fa-minus"></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif(old('specifications') != null && count(old('specifications')) > 0)
                                                        @foreach (old('specifications') as $key => $specification)
                                                            <div class="row" data-key="{{ $key }}">
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <div class="form-row">
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.specification') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Specification"
                                                                                    name="specifications[{{ $key }}][specification]"
                                                                                    value="{{ $specification['specification'] }}">
                                                                                @if ($errors->has('specifications.' . $key . '.specification'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.specification') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.value') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Value"
                                                                                    name="specifications[{{ $key }}][value]"
                                                                                    value="{{ $specification['value'] }}">
                                                                                @if ($errors->has('specifications.' . $key . '.value'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.value') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text"
                                                                                    class="form-control {{ $errors->has('specifications.' . $key . '.units') ? ' is-invalid' : '' }}"
                                                                                    placeholder="Units (Optional)"
                                                                                    name="specifications[{{ $key }}][units]"
                                                                                    value="{{ $specification['units'] }}">
                                                                                @if ($errors->has('specifications.' . $key . '.units'))
                                                                                    <span class="invalid-feedback">
                                                                                        {{ $errors->first('specifications.' . $key . '.units') }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button class="btn btn-success add-specification"><i
                                                                            class="fa fa-plus"></i></button>
                                                                    <button class="btn btn-danger remove-specification"><i
                                                                            class="fa fa-minus"
                                                                            data-product-id="@if (!empty($row->id)) {{ $row->id }} @endif"
                                                                            data-id="@if (!empty($specification['id'])) {{ $specification['id'] }} @endif"></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="row" data-key="0">
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <div class="form-row">
                                                                        <div class="col">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('specifications') ? ' is-invalid' : '' }}"
                                                                                placeholder="Specification"
                                                                                name="specifications[0][specification]">
                                                                            @if ($errors->has('specifications'))
                                                                                <span class="invalid-feedback">
                                                                                    {{ $errors->first('specifications') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('specifications') ? ' is-invalid' : '' }}"
                                                                                placeholder="Value"
                                                                                name="specifications[0][value]">
                                                                            @if ($errors->has('specifications'))
                                                                                <span class="invalid-feedback">
                                                                                    {{ $errors->first('specifications') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('specifications') ? ' is-invalid' : '' }}"
                                                                                placeholder="Units (Optional)"
                                                                                name="specifications[0][units]">
                                                                            @if ($errors->has('specifications'))
                                                                                <span class="invalid-feedback">
                                                                                    {{ $errors->first('specifications') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-success add-specification"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <button class="btn btn-danger remove-specification"><i
                                                                        class="fa fa-minus"></i></button>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>


                                            </div>

                                            <div class="form-group">

    <label>Product FAQs</label>

    <div id="faq-container">

        @if(!empty($row->faqs) && $row->faqs->count() > 0)

            @foreach($row->faqs as $key => $faq)

                <div class="faq-item row mb-3" data-key="{{ $key }}">

                    <input type="hidden"
                           name="faqs[{{ $key }}][id]"
                           value="{{ $faq->id }}">

                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control {{ $errors->has('faqs.'.$key.'.question') ? 'is-invalid' : '' }}"
                                   name="faqs[{{ $key }}][question]"
                                   placeholder="Question"
                                   value="{{ old('faqs.'.$key.'.question', $faq->question) }}">

                            @error('faqs.'.$key.'.question')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group text-center mt-2">
                            <label class="switch">
                                <input type="checkbox"
                                       name="faqs[{{ $key }}][status]"
                                       value="1"
                                       {{ old('faqs.'.$key.'.status', $faq->status) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 text-end action-btns">

                        @if($loop->last)
                            <button type="button" class="btn btn-success add-faq">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger remove-faq {{ $row->faqs->count() == 1 ? 'd-none' : '' }}">
                            <i class="fa fa-minus"></i>
                        </button>

                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="form-group">

                            <textarea
                                class="form-control {{ $errors->has('faqs.'.$key.'.answer') ? 'is-invalid' : '' }}"
                                rows="4"
                                name="faqs[{{ $key }}][answer]"
                                placeholder="Answer">{{ old('faqs.'.$key.'.answer', $faq->answer) }}</textarea>

                            @error('faqs.'.$key.'.answer')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                    </div>

                </div>

            @endforeach

        @elseif(old('faqs'))

            @foreach(old('faqs') as $key => $faq)

                <div class="faq-item row mb-3" data-key="{{ $key }}">

                    <input type="hidden"
                           name="faqs[{{ $key }}][id]"
                           value="{{ $faq['id'] ?? '' }}">

                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="faqs[{{ $key }}][question]"
                                   value="{{ $faq['question'] }}"
                                   placeholder="Question">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group text-center mt-2">
                            <label class="switch">
                                <input type="checkbox"
                                       name="faqs[{{ $key }}][status]"
                                       value="1"
                                       {{ !empty($faq['status']) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 text-end action-btns">

                        @if($loop->last)
                            <button type="button" class="btn btn-success add-faq">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endif

                        <button type="button"
                                class="btn btn-danger remove-faq {{ count(old('faqs')) == 1 ? 'd-none' : '' }}">
                            <i class="fa fa-minus"></i>
                        </button>

                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <textarea class="form-control"
                                      rows="4"
                                      name="faqs[{{ $key }}][answer]"
                                      placeholder="Answer">{{ $faq['answer'] }}</textarea>
                        </div>
                    </div>

                </div>

            @endforeach

        @else

            <div class="faq-item row mb-3" data-key="0">

                <input type="hidden"
                       name="faqs[0][id]"
                       value="">

                <div class="col-md-9">
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               name="faqs[0][question]"
                               placeholder="Question">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group text-center mt-2">
                        <label class="switch">
                            <input type="checkbox"
                                   name="faqs[0][status]"
                                   value="1"
                                   checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-2 text-end action-btns">

                    <button type="button" class="btn btn-success add-faq">
                        <i class="fa fa-plus"></i>
                    </button>

                    <button type="button"
                            class="btn btn-danger remove-faq d-none">
                        <i class="fa fa-minus"></i>
                    </button>

                </div>

                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <textarea class="form-control"
                                  rows="4"
                                  name="faqs[0][answer]"
                                  placeholder="Answer"></textarea>
                    </div>
                </div>

            </div>

        @endif

    </div>

</div>
                                        </div>

                                    </div>


                                    <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                          </div> -->
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


        function updateFaqButtons() {

            // Remove all + buttons
            $('#faq-container .faq-item .add-faq').remove();

            // Add + button only to last row if it doesn't exist
            let lastRow = $('#faq-container .faq-item:last .action-btns');

            if (lastRow.find('.add-faq').length === 0) {
                lastRow.prepend(`
            <button type="button" class="btn btn-success add-faq">
                <i class="fa fa-plus"></i>
            </button>
        `);
            }

            // Hide remove button if only one row
            if ($('#faq-container .faq-item').length == 1) {
                $('#faq-container .faq-item .remove-faq').hide();
            } else {
                $('#faq-container .faq-item .remove-faq').show();
            }
        }

        $(document).on('click', '.add-faq', function(e) {

            e.preventDefault();

            let key = $('#faq-container .faq-item').length;

            let html = `
    <div class="faq-item row mb-3" data-key="${key}">

        <div class="col-md-9">
            <input type="text"
                   class="form-control"
                   name="faqs[${key}][question]"
                   placeholder="Question">
        </div>

        <div class="col-md-1 text-center">
            <label class="switch">
                <input type="checkbox"
                       name="faqs[${key}][status]"
                       value="1"
                       checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="col-md-2 text-end action-btns">

            <button type="button" class="btn btn-success add-faq">
                <i class="fa fa-plus"></i>
            </button>

            <button type="button" class="btn btn-danger remove-faq">
                <i class="fa fa-minus"></i>
            </button>

        </div>

        <div class="col-md-12 mt-2">
            <textarea class="form-control"
                      rows="4"
                      name="faqs[${key}][answer]"
                      placeholder="Answer"></textarea>
        </div>
		<input type="hidden"
       name="faqs[0][id]"
       value="">

    </div>`;

            $('#faq-container').append(html);

            updateFaqButtons();

        });

        $(document).on('click', '.remove-faq', function(e) {

            e.preventDefault();

            $(this).closest('.faq-item').remove();

            updateFaqButtons();

        });
    </script>
@endpush
