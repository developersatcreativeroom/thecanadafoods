@extends('front.layouts.app')

@section('content')



<section class="my-account pt-6 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3">
                @include('front.profile.side')
            </div>
            <div class="col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">

                        <div class="change-password bg-white py-5 px-4 mt-4 rounded">
                            <h6 class="mb-4">Add/Edit Address</h6>
                            <form action="{{ route('address') }}" method="post" enctype='multipart/form-data'>
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>First Name <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                                name="first_name" type="text"
                                                value="@if(old('first_name')!=null){{old('first_name')}}@elseif(!empty($address->first_name)){{$address->first_name}}@endif">
                                            @if($errors->has('first_name'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('first_name') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                                name="last_name" type="text"
                                                value="@if(old('last_name')!=null){{old('last_name')}}@elseif(!empty($address->last_name)){{$address->last_name}}@endif">
                                            @if($errors->has('last_name'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('last_name') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="label-input-field">
                                            <label>Company Name </label>
                                            <input
                                                class="form-control square {{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                                name="company_name" type="text"
                                                value="@if(old('company_name')!=null){{old('company_name')}}@elseif(!empty($address->company_name)){{$address->company_name}}@endif">
                                            @if($errors->has('company_name'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('company_name') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="label-input-field">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email" type="email"
                                                value="@if(old('email')!=null){{old('email')}}@elseif(!empty($address->email)){{$address->email}}@endif">
                                            @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('email') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="label-input-field">
                                            <label class="z-5">Phone <span class="required">*</span></label>
                                            @php
                                            $config = App\Helper::getWebsiteConfig('country_code');
                                            @endphp
                                            <div class="input-group mb-3">
                                                <span
                                                    class="input-group-text font-xs">+@if(!empty($config['country_code'])){{$config['country_code']}}@else{{config('constants.CONTACT.country_code')}}@endif</span>
                                                <input
                                                    class="form-control square {{ $errors->has('phone') ? ' is-invalid' : '' }} only-numbers"
                                                    name="phone" type="text" maxlength="10"
                                                    value="@if(old('phone')!=null){{old('phone')}}@elseif(!empty($address->phone)){{$address->phone}}@endif">
                                                @if($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    <div>{{ $errors->first('phone') }}</div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Address Line 1 <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('address_line_1') ? ' is-invalid' : '' }}"
                                                name="address_line_1" type="text"
                                                value="@if(old('address_line_1')!=null){{old('address_line_1')}}@elseif(!empty($address->address_line_1)){{$address->address_line_1}}@endif">
                                            @if($errors->has('address_line_1'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('address_line_1') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Address Line 2 <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('address_line_2') ? ' is-invalid' : '' }}"
                                                name="address_line_2" type="text"
                                                value="@if(old('address_line_2')!=null){{old('address_line_2')}}@elseif(!empty($address->address_line_2)){{$address->address_line_2}}@endif">
                                            @if($errors->has('address_line_2'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('address_line_2') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Street </label>
                                            <input
                                                class="form-control square {{ $errors->has('street') ? ' is-invalid' : '' }}"
                                                name="street" type="text"
                                                value="@if(old('street')!=null){{old('street')}}@elseif(!empty($address->street)){{$address->street}}@endif">
                                            @if($errors->has('street'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('street') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Country <span class="required">*</span></label>
                                            <select class="form-control square {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" id="country">
                                                {{-- <option value="">Select an option...</option> --}}
                                                @foreach($countries as $key => $country)
                                                <option value="{{$country->code}}" @if(old('country')!=null &&
                                                    old('country')==$country->code) selected
                                                    @elseif(!empty($address->country) && $address->country == $country->code) selected @else selected @endif>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('country'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('country') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>State <span class="required">*</span></label>
                                            <select class="form-control square {{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="state" data-selected-state="@if(old('state')!=null){{old('state')}}@elseif(!empty($address->state)){{$address->state}}@endif">
                                                <option value="">--Select country first--</option>
                                            </select>
                                            @if($errors->has('state'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('state') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>City <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('city') ? ' is-invalid' : '' }}"
                                                name="city" type="text"
                                                value="@if(old('city')!=null){{old('city')}}@elseif(!empty($address->city)){{$address->city}}@endif">
                                            @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('city') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="label-input-field">
                                            <label>Postal <span class="required">*</span></label>
                                            <input
                                                class="form-control square {{ $errors->has('postal') ? ' is-invalid' : '' }} only-numbers"
                                                name="postal" type="text"
                                                value="@if(old('postal')!=null){{old('postal')}}@elseif(!empty($address->postal)){{$address->postal}}@endif">
                                            @if($errors->has('postal'))
                                            <div class="invalid-feedback">
                                                <div>{{ $errors->first('postal') }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="id"
                                        value="@if(!empty($address->id)){{$address->id}}@endif">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary mt-6">
                                            Save
                                        </button>
                                        <a class="btn btn-secondary mt-6" href="{{route('addresses')}}">List</a>
                                    </div>
                                </div>
                            </form>
                        </div>




                    </div>


                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush