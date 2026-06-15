@extends('admin.layouts.app')

@section('content')
                              
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
              <li class="breadcrumb-item active">Country</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="card card-primary card-outline">
          <!-- <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Vertical Tabs Examples
            </h3>
          </div> -->
          <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-3">
                  @include('admin.setting.side')
                </div>
                <div class="col-7 col-sm-9">

                  <div class="tab-content">
                    <div class="tab-pane text-left fade show active">

                    <div class="card-header1 d-flex justify-content-between p-0">
                      <h3 class="card-title py-3">Seo details</h3>
                    </div>
                    
                    <form action="{{ route('admin.settings') }}" method="post" enctype='multipart/form-data'>
                      @csrf
                        <div class="card-body1">
                          <div class="row">
                            <div class="col-md-6">

                              <div class="form-group">
                                <label for="country">Country <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" id="country" name="country">
                                  <option value="">--Select--</option>
                                  @foreach($countries as $key => $country)
                                    <option value="{{$country->code}}" @if(old('country')!=null && old('country')==$country->code) selected @elseif(!empty($countryDB) && $countryDB==$country->code) selected @endif>{{$country->name}}</option>
                                  @endforeach
                                </select>
                                @if($errors->has('country'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="shipping">Shipping <span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('shipping') ? ' is-invalid' : '' }}" id="shipping" placeholder="Enter Shipping Price" name="shipping" value="@if(old('shipping')!=null){{old('shipping')}}@elseif(!empty($shippingDB)){{$shippingDB}}@endif">
                                @if($errors->has('shipping'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('shipping') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="reviews">Reviews show? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('reviews') ? ' is-invalid' : '' }}" id="reviews" name="reviews">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('reviews')!=null && old('reviews')=='true') selected @elseif(!empty($reviewsDB) && $reviewsDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('reviews')!=null && old('reviews')=='false') selected @elseif(!empty($reviewsDB) && $reviewsDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('reviews'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('reviews') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="product_services">Enable Product Services System? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('product_services') ? ' is-invalid' : '' }}" id="product_services" name="product_services">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('product_services')!=null && old('product_services')=='true') selected @elseif(!empty($productServicesDB) && $productServicesDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('product_services')!=null && old('product_services')=='false') selected @elseif(!empty($productServicesDB) && $productServicesDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('product_services'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('product_services') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="product_addon">Enable Product Addon System? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('product_addon') ? ' is-invalid' : '' }}" id="product_addon" name="product_addon">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('product_addon')!=null && old('product_addon')=='true') selected @elseif(!empty($productAddonDB) && $productAddonDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('product_addon')!=null && old('product_addon')=='false') selected @elseif(!empty($productAddonDB) && $productAddonDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('product_addon'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('product_addon') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="coupon">Enable Coupon System? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('coupon') ? ' is-invalid' : '' }}" id="coupon" name="coupon">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('coupon')!=null && old('coupon')=='true') selected @elseif(!empty($couponDB) && $couponDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('coupon')!=null && old('coupon')=='false') selected @elseif(!empty($couponDB) && $couponDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('coupon'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('coupon') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="local_pickup">Enable Local Pickup? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('local_pickup') ? ' is-invalid' : '' }}" id="local_pickup" name="local_pickup">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('local_pickup')!=null && old('local_pickup')=='true') selected @elseif(!empty($localPickupDB) && $localPickupDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('local_pickup')!=null && old('local_pickup')=='false') selected @elseif(!empty($localPickupDB) && $localPickupDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('local_pickup'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('local_pickup') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="is_enquiry_website">Enable Enquiry Website? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('is_enquiry_website') ? ' is-invalid' : '' }}" id="is_enquiry_website" name="is_enquiry_website">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('is_enquiry_website')!=null && old('is_enquiry_website')=='true') selected @elseif(!empty($isEnquiryWebsiteDB) && $isEnquiryWebsiteDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('is_enquiry_website')!=null && old('is_enquiry_website')=='false') selected @elseif(!empty($isEnquiryWebsiteDB) && $isEnquiryWebsiteDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('is_enquiry_website'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('is_enquiry_website') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" placeholder="Enter Contact Address" name="address">@if(old('address')!=null){{old('address')}}@elseif(!empty($addressDB)){{$addressDB}}@endif</textarea>
                                @if($errors->has('address'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="country_code">Country Code<span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">+</span>
                                  </div>
                                  <input type="text" class="form-control only-numbers {{ $errors->has('country_code') ? ' is-invalid' : '' }}" id="country_code" placeholder="Enter Country Code without 00 or + (Example: 91)" name="country_code" value="@if(old('country_code')!=null){{old('country_code')}}@elseif(!empty($countryCodeDB)){{$countryCodeDB}}@endif">
                                </div>
                                
                                @if($errors->has('country_code'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('country_code') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="phone">Phone<span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">+@if(!empty($countryCodeDB)){{$countryCodeDB}}@else{{config('constants.CONTACT.country_code')}}@endif</span>
                                  </div>
                                  <input type="text" class="form-control only-numbers {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" maxlength="10" placeholder="Enter Contact Phone" name="phone" value="@if(old('phone')!=null){{old('phone')}}@elseif(!empty($phoneDB)){{$phoneDB}}@endif">
                                </div>
                                @if($errors->has('phone'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="whatsapp">WhatsApp<span class="text-danger">*</span></label>
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">+@if(!empty($countryCodeDB)){{$countryCodeDB}}@else{{config('constants.CONTACT.country_code')}}@endif</span>
                                    </div>
                                    <input type="text" class="form-control only-numbers {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" id="whatsapp" maxlength="10" placeholder="Enter Whatsapp number" name="whatsapp" value="@if(old('whatsapp')!=null){{old('whatsapp')}}@elseif(!empty($whatsappDB)){{$whatsappDB}}@endif">
                                  </div>
                                @if($errors->has('whatsapp'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('whatsapp') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="hours_week">Hours Weekdays<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('hours_week') ? ' is-invalid' : '' }}" id="hours_week" placeholder="Enter Contact Weekly Hours" name="hours_week" value="@if(old('hours_week')!=null){{old('hours_week')}}@elseif(!empty($hoursWeekDB)){{$hoursWeekDB}}@endif">
                                @if($errors->has('hours_week'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('hours_week') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="hours_week_end">Hours Weekend<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('hours_week_end') ? ' is-invalid' : '' }}" id="hours_week_end" placeholder="Enter Contact Weekend Hours" name="hours_week_end" value="@if(old('hours_week_end')!=null){{old('hours_week_end')}}@elseif(!empty($hoursWeekEndDB)){{$hoursWeekEndDB}}@endif">
                                @if($errors->has('hours_week_end'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('hours_week_end') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter Contact Email" name="email" value="@if(old('email')!=null){{old('email')}}@elseif(!empty($emailDB)){{$emailDB}}@endif">
                                @if($errors->has('email'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="map">Map Link<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('map') ? ' is-invalid' : '' }}" id="map" placeholder="Enter Map Link" name="map" value="@if(old('map')!=null){{old('map')}}@elseif(!empty($mapDB)){{$mapDB}}@endif">
                                @if($errors->has('map'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('map') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="currency_sign">Currency Sign<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('currency_sign') ? ' is-invalid' : '' }}" id="currency_sign" placeholder="Enter Currency Sign" name="currency_sign" value="@if(old('currency_sign')!=null){{old('currency_sign')}}@elseif(!empty($currencySignDB)){{$currencySignDB}}@endif">
                                @if($errors->has('currency_sign'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('currency_sign') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="currency_iso_code">Currency ISO Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('currency_iso_code') ? ' is-invalid' : '' }}" id="currency_iso_code" placeholder="Enter Currency ISO Code" name="currency_iso_code" value="@if(old('currency_iso_code')!=null){{old('currency_iso_code')}}@elseif(!empty($currencyIsoCodeDB)){{$currencyIsoCodeDB}}@endif">
                                @if($errors->has('currency_iso_code'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('currency_iso_code') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="is_email_verify">Enable Email Verify? <span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('is_email_verify') ? ' is-invalid' : '' }}" id="is_email_verify" name="is_email_verify">
                                    <option value="">--Select--</option>
                                    <option value="true" @if(old('is_email_verify')!=null && old('is_email_verify')=='true') selected @elseif(!empty($isEmailVerifyDB) && $isEmailVerifyDB=='true') selected @endif>Yes</option>
                                    <option value="false" @if(old('is_email_verify')!=null && old('is_email_verify')=='false') selected @elseif(!empty($isEmailVerifyDB) && $isEmailVerifyDB=='false') selected @endif>No</option>
                                </select>
                                @if($errors->has('is_email_verify'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('is_email_verify') }}
                                  </span>
                                @endif
                              </div>

                              

                              <div class="form-group">
                                <label for="light_logo">Light Background Logo<span class="text-danger">*</span></label>
                                <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('light_logo') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($lightLogoDB) && ($lightLogoDB != null || $lightLogoDB != '')) ? asset('storage/logo/').'/'.$lightLogoDB : '' }}" id="light_logo" name="light_logo">
                                @if($errors->has('light_logo'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('light_logo') }}
                                  </span>
                                @endif
                              </div>

                              {{-- @if(!empty($lightLogoDB) && ($lightLogoDB != null || $lightLogoDB != ''))
                              <div class="form-group">
                                <img class="img-thumbnail mb-4" src="{{ asset('storage/logo/') }}/{{$lightLogoDB}}" />
                              </div>
                              @endif --}}

                              <div class="form-group">
                                <label for="dark_logo">Dark Background Logo<span class="text-danger">*</span></label>
                                <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('dark_logo') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($darkLogoDB) && ($darkLogoDB != null || $darkLogoDB != '')) ? asset('storage/logo/').'/'.$darkLogoDB : '' }}" id="dark_logo" name="dark_logo">
                                @if($errors->has('dark_logo'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('dark_logo') }}
                                  </span>
                                @endif
                              </div>

                              {{-- @if(!empty($darkLogoDB) && ($darkLogoDB != null || $darkLogoDB != ''))
                              <div class="form-group">
                                <img class="img-thumbnail mb-4" src="{{ asset('storage/logo/') }}/{{$darkLogoDB}}" />
                              </div>
                              @endif --}}

                              <div class="form-group">
                                <label for="favicon">Favicon<span class="text-danger">*</span></label>
                                <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" class="form-control dropify {{ $errors->has('favicon') ? ' is-invalid' : '' }}" data-default-file="{{ (!empty($faviconDB) && ($faviconDB != null || $faviconDB != '')) ? asset('storage/favicon/').'/'.$faviconDB : '' }}" id="favicon" name="favicon">
                                @if($errors->has('favicon'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('favicon') }}
                                  </span>
                                @endif
                              </div>

                              {{-- @if(!empty($faviconDB) && ($faviconDB != null || $faviconDB != ''))
                              <div class="form-group">
                                <div style="max-width: 40px">
                                  <object data="{{ asset('storage/favicon/') }}/{{$faviconDB}}" type="image/svg+xml">
                                  </object>
                                </div>
                              </div>
                              @endif --}}

                              <div class="form-group">
                                <label for="page">Seo Title <span class="text-danger">*</span></label>
                                <input type="seo_title" class="form-control count-characters {{ $errors->has('seo_title') ? ' is-invalid' : '' }}" id="seo_title" placeholder="Enter Seo Page Title" name="seo_title" value="@if(old('seo_title')!=null){{old('seo_title')}}@elseif(!empty($seoTitleDB)){{$seoTitleDB}}@endif">
                                <small><strong>Note: </strong> Add 45 to 80 characters for optimal results</small>
                                @if($errors->has('seo_title'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('seo_title') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="seo_description">SEO Description <span class="text-danger">*</span></label>
                                <textarea class="form-control count-characters {{ $errors->has('seo_description') ? ' is-invalid' : '' }}" id="seo_description" rows="4" placeholder="Enter Description" name="seo_description">@if(old('seo_description')!=null){{old('seo_description')}}@elseif(!empty($seoDescriptionDB)){{$seoDescriptionDB}}@endif</textarea>
                                <small><strong>Note: </strong> Add 90 to 180 characters for optimal results</small>
                                @if($errors->has('seo_description'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('seo_description') }}
                                  </span>
                                @endif
                              </div>

                              <div class="form-group">
                                <label for="seo_keywords">SEO Keywords <span class="text-danger">*</span></label>
                                <textarea class="form-control {{ $errors->has('seo_keywords') ? ' is-invalid' : '' }}" id="seo_keywords" rows="4" placeholder="Enter Keywords" name="seo_keywords">@if(old('seo_keywords')!=null){{old('seo_keywords')}}@elseif(!empty($seoKeywordsDB)){{$seoKeywordsDB}}@endif</textarea>
                                <small>Example: Comma separated values like <strong>Keyword1, Keyword2, Keyword3</strong></small>
                                @if($errors->has('seo_keywords'))
                                  <span class="invalid-feedback">
                                    {{ $errors->first('seo_keywords') }}
                                  </span>
                                @endif
                              </div>

                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        <!-- <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div> -->
                      </form>
                    
                    </div>
                  </div>

                </div>
              </div>
          <!-- /.row -->
          </div>
          <!-- /.card -->
        </div>

        
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



