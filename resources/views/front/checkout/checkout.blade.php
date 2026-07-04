@extends('front.layouts.app')


@section('head')
    <script>
        gtag('event', 'conversion_event_begin_checkout_1', {
            // <event_parameters>
        });
    </script>

    <!-- Google tag (gtag.js) event - delayed navigation helper -->
    <script>
        // Helper function to delay opening a URL until a gtag event is sent.
        // Call it in response to an action that should navigate to a URL.
        function gtagSendEvent(url) {
            var callback = function() {
                if (typeof url === 'string') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion_event_begin_checkout_1', {
                'event_callback': callback,
                'event_timeout': 2000,
                // <event_parameters>
            });
            return false;
        }
    </script>

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1024329659429409');
        fbq('track', 'checkout-page');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1024329659429409&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
@endsection

@section('content')



    <!--breadcrumb section start-->
    <div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
        <img src="{{ URL::asset('frontend/img/shapes/bg-shape-6.png') }}" alt="bg-shape"
            class="position-absolute start-0 z--1 w-100 bg-shape">
        <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="pata"
            class="position-absolute pata-xs z--1 vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/onion.png') }}" alt="onion"
            class="position-absolute z--1 onion start-0 top-0 vector-shape bg-icon-1">
        <img src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle"
            class="position-absolute z--1 frame-circle vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/energy-drink.png') }}" alt="leaf"
            class="position-absolute z--1 leaf vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/garlic-white.png') }}" alt="garlic"
            class="position-absolute z--1 garlic vector-shape bg-icon-2">
        <img src="{{ URL::asset('frontend/img/shapes/roll-1.png') }}" alt="roll"
            class="position-absolute z--1 roll vector-shape bg-icon-3">
        <img src="{{ URL::asset('frontend/img/shapes/roll-2.png') }}" alt="roll"
            class="position-absolute z--1 roll-2 vector-shape bg-icon-4">
        <img src="{{ URL::asset('frontend/img/shapes/chocolate-bar.png') }}" alt="roll"
            class="position-absolute z--1 pata-xs-2 vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/white-bread.png') }}" alt="tomato"
            class="position-absolute z--1 tomato-half vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/cookie.png') }}" alt="tomato"
            class="position-absolute z--1 tomato-slice vector-shape">
        <img src="{{ URL::asset('frontend/img/shapes/cauliflower.png') }}" alt="tomato"
            class="position-absolute z--1 cauliflower vector-shape bg-icon-5">
        <img src="{{ URL::asset('frontend/img/shapes/leaf-gray.png') }}" alt="tomato"
            class="position-absolute z--1 leaf-gray vector-shape bg-icon-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="mb-2 text-center">Checkout</h2>
                        <nav>
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                                        href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item fw-bold" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb section end-->

    <!--checkout section start-->
    <div class="checkout-section ptb-80">
        <div class="container">
            <form action="{{ route('checkout.post') }}" class="card-checkout" method="post" enctype='multipart/form-data'>
                @csrf
                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="checkout-steps">

                            @guest
                                <h4 class="mb-5 mt-5">Shipping Details</h4>
                            @endguest

                            @auth('web')
                                <div id="address-section">
                                    @include('front.checkout.address-section')
                                </div>
                            @endauth

                            @guest

                                <div
                                    class="checkout-form mt-4 py-7 px-5 bg-white rounded-2 @if (!$checkout['is_min_amount']) disable-fields @endif">
                                    <div class="row g-4">
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>First Name</label>
                                                <input type="text" required=""
                                                    class="form-control {{ $errors->has('shipping.first_name') ? ' is-invalid' : '' }}"
                                                    placeholder="First name *" name="shipping[first_name]"
                                                    value="{{ old('shipping.first_name') }}">
                                                @if ($errors->has('shipping.first_name'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.first_name') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Last Name</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('shipping.last_name') ? ' is-invalid' : '' }}"
                                                    required="" placeholder="Last name *" name="shipping[last_name]"
                                                    value="{{ old('shipping.last_name') }}">
                                                @if ($errors->has('shipping.last_name'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.last_name') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Company Name</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('shipping.company_name') ? ' is-invalid' : '' }}"
                                                    placeholder="Company Name" name="shipping[company_name]"
                                                    value="{{ old('shipping.company_name') }}">
                                                @if ($errors->has('shipping.company_name'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.company_name') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Address line 1</label>
                                                <input type="text" required=""
                                                    class="form-control {{ $errors->has('shipping.address_line_1') ? ' is-invalid' : '' }}"
                                                    placeholder="Address Line 1 *" name="shipping[address_line_1]"
                                                    value="{{ old('shipping.address_line_1') }}">
                                                @if ($errors->has('shipping.address_line_1'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.address_line_1') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Address line 2</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('shipping.address_line_2') ? ' is-invalid' : '' }}"
                                                    placeholder="Address Line 2 " name="shipping[address_line_2]"
                                                    value="{{ old('shipping.address_line_2') }}">
                                                @if ($errors->has('shipping.address_line_2'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.address_line_2') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-none">
                                            <div class="label-input-field mt-0">
                                                <label>Street</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('shipping.street') ? ' is-invalid' : '' }}"
                                                    placeholder="Street" name="shipping[street]"
                                                    value="{{ old('shipping.street') }}">
                                                @if ($errors->has('shipping.street'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.street') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Country</label>
                                                <select
                                                    class="form-control select-active1 {{ $errors->has('shipping.country') ? ' is-invalid' : '' }}"
                                                    name="shipping[country]" id="country" required="">
                                                    {{-- <option value="">Select an option...</option> --}}
                                                    <!-- <option value="India" @if (old('shipping.country') != null && old('shipping.country') == 'India') selected @endif>India</option> -->
                                                    @foreach ($countries as $key => $country)
                                                        <option value="{{ $country->code }}"
                                                            @if (old('shipping.country') != null && old('shipping.country') == $country->code) selected
                                            @else selected @endif>
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('shipping.country'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.country') }}</div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>State</label>
                                                <select
                                                    class="form-control select-active1 get-shipping {{ $errors->has('shipping.state') ? ' is-invalid' : '' }}"
                                                    name="shipping[state]" id="state"
                                                    data-selected-state="@if (old('shipping.state') != null) {{ old('shipping.state') }} @endif"
                                                    required="">
                                                    <option value="">--Select country first--</option>
                                                </select>
                                                @if ($errors->has('shipping.state'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.state') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>City</label>
                                                <input required="" type="text"
                                                    class="form-control {{ $errors->has('shipping.city') ? ' is-invalid' : '' }}"
                                                    placeholder="City / Town *" name="shipping[city]"
                                                    value="{{ old('shipping.city') }}">
                                                @if ($errors->has('shipping.city'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.city') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Postal</label>
                                                <input required="" type="text"
                                                    class="form-control {{ $errors->has('shipping.postal') ? ' is-invalid' : '' }}"
                                                    placeholder="Postcode / ZIP *" name="shipping[postal]"
                                                    value="{{ old('shipping.postal') }}">
                                                @if ($errors->has('shipping.postal'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.postal') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label class="z-5">Phone</label>
                                                <div class="input-group">
                                                    @php
                                                        $config = App\Helper::getWebsiteConfig('country_code');
                                                    @endphp
                                                    <span class="input-group-text font-xs">+@if (!empty($config['country_code']))
                                                            {{ $config['country_code'] }}@else{{ config('constants.CONTACT.country_code') }}
                                                        @endif
                                                    </span>
                                                    <input required="" type="text"
                                                        class="form-control only-numbers {{ $errors->has('shipping.phone') ? ' is-invalid' : '' }}"
                                                        maxlength="10" placeholder="Phone *" name="shipping[phone]"
                                                        value="{{ old('shipping.phone') }}">
                                                    @if ($errors->has('shipping.phone'))
                                                        <div class="invalid-feedback">
                                                            <div>{{ $errors->first('shipping.phone') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="label-input-field mt-0">
                                                <label>Email</label>
                                                <input required="" type="email"
                                                    class="form-control {{ $errors->has('shipping.email') ? ' is-invalid' : '' }}"
                                                    placeholder="Email address *" name="shipping[email]"
                                                    value="{{ old('shipping.email') }}">
                                                @if ($errors->has('shipping.email'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('shipping.email') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ship_detail">

                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="custom-checkbox d-flex align-items-center">
                                                            <div class="theme-checkbox flex-shrink-0">
                                                                <input type="checkbox" id="differentaddress"
                                                                    name="billing_address" {{-- @if (old('billing_address') != null && old('billing_address') == 'on') checked @elseif(old('billing') !=null) checked @else checked @endif --}}
                                                                    @if (old('billing_address') != null && old('billing_address') == 'on') checked @elseif(!empty(old('billing')) && is_array(old('billing'))) checked @else checked @endif>
                                                                <span class="checkbox-field"><i
                                                                        class="fa-solid fa-check"></i></span>
                                                            </div>

                                                            <label class="ms-2" for="differentaddress">Shipping and billing
                                                                to be same</label>
                                                        </div>
                                                    </div>

                                                    <div id="collapseAddress" class="different_address mt-8">

                                                        <h5 class="mb-6 mt-1">Billing Details</h5>

                                                        <div class="row g-4">
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>First Name</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('billing.first_name') ? ' is-invalid' : '' }}"
                                                                        placeholder="First name *" name="billing[first_name]"
                                                                        value="{{ old('billing.first_name') }}">
                                                                    @if ($errors->has('billing.first_name'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.first_name') }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Last Name</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('billing.last_name') ? ' is-invalid' : '' }}"
                                                                        placeholder="Last name *" name="billing[last_name]"
                                                                        value="{{ old('billing.last_name') }}">
                                                                    @if ($errors->has('billing.last_name'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.last_name') }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Company Name</label>
                                                                    <input type="text"
                                                                        class="form-control optional {{ $errors->has('billing.company_name') ? ' is-invalid' : '' }}"
                                                                        placeholder="Company Name"
                                                                        name="billing[company_name]"
                                                                        value="{{ old('billing.company_name') }}">
                                                                    @if ($errors->has('billing.company_name'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.company_name') }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Address line 1</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('billing.address_line_1') ? ' is-invalid' : '' }}"
                                                                        placeholder="Address Line 1 *"
                                                                        name="billing[address_line_1]"
                                                                        value="{{ old('billing.address_line_1') }}">
                                                                    @if ($errors->has('billing.address_line_1'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.address_line_1') }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Address line 2</label>
                                                                    <input type="text"
                                                                        class="form-control optional {{ $errors->has('billing.address_line_2') ? ' is-invalid' : '' }}"
                                                                        placeholder="Address Line 2"
                                                                        name="billing[address_line_2]"
                                                                        value="{{ old('billing.address_line_2') }}">
                                                                    @if ($errors->has('billing.address_line_2'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.address_line_2') }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 d-none">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Street</label>
                                                                    <input type="text"
                                                                        class="form-control optional {{ $errors->has('billing.street') ? ' is-invalid' : '' }}"
                                                                        placeholder="Street" name="billing[street]"
                                                                        value="{{ old('billing.street') }}">
                                                                    @if ($errors->has('billing.street'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.street') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Country</label>
                                                                    <select
                                                                        class="form-control select-active1 {{ $errors->has('billing.country') ? ' is-invalid' : '' }}"
                                                                        name="billing[country]" id="country-billing">
                                                                        {{-- <option value="">Select an option...</option> --}}
                                                                        <!-- <option value="India" @if (old('billing.country') != null && old('billing.country') == 'India') selected @endif>India</option> -->
                                                                        @foreach ($countries as $key => $country)
                                                                            <option value="{{ $country->code }}"
                                                                                @if (old('billing.country') != null && old('billing.country') == $country->code) selected
                                                                @else
                                                                selected @endif>
                                                                                {{ $country->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('billing.country'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.country') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>State</label>
                                                                    {{-- <input  type="text"
                                                            class="form-control {{ $errors->has('billing.state') ? ' is-invalid' : '' }}"
                                                            placeholder="State *" name="billing[state]"
                                                            value="{{old('billing.state')}}"> --}}

                                                                    <select
                                                                        class="form-control select-active1 get-billing {{ $errors->has('billing.state') ? ' is-invalid' : '' }}"
                                                                        name="billing[state]" id="state-billing"
                                                                        data-selected-state="@if (old('billing.state') != null) {{ old('billing.state') }} @endif">
                                                                        <option value="">--Select country first--
                                                                        </option>
                                                                    </select>
                                                                    @if ($errors->has('billing.state'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.state') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>City</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('billing.city') ? ' is-invalid' : '' }}"
                                                                        placeholder="City / Town *" name="billing[city]"
                                                                        value="{{ old('billing.city') }}">
                                                                    @if ($errors->has('billing.city'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.city') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Postal</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('billing.postal') ? ' is-invalid' : '' }}"
                                                                        placeholder="Postcode / ZIP *" name="billing[postal]"
                                                                        value="{{ old('billing.postal') }}">
                                                                    @if ($errors->has('billing.postal'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.postal') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label class="z-5">Phone</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text font-xs">+@if (!empty($config['country_code']))
                                                                                {{ $config['country_code'] }}@else{{ config('constants.CONTACT.country_code') }}
                                                                            @endif
                                                                        </span>
                                                                        <input type="text"
                                                                            class="form-control only-numbers {{ $errors->has('billing.phone') ? ' is-invalid' : '' }}"
                                                                            maxlength="10" placeholder="Phone *"
                                                                            name="billing[phone]"
                                                                            value="{{ old('billing.phone') }}">
                                                                        @if ($errors->has('billing.phone'))
                                                                            <div class="invalid-feedback">
                                                                                <div>{{ $errors->first('billing.phone') }}
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="label-input-field mt-0">
                                                                    <label>Email</label>
                                                                    <input type="email"
                                                                        class="form-control {{ $errors->has('billing.email') ? ' is-invalid' : '' }}"
                                                                        placeholder="Email address *" name="billing[email]"
                                                                        value="{{ old('billing.email') }}">
                                                                    @if ($errors->has('billing.email'))
                                                                        <div class="invalid-feedback">
                                                                            <div>{{ $errors->first('billing.email') }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endguest







                            <h4 class="mt-8">Additional Information</h4>
                            <div
                                class="checkout-form mt-4 py-7 px-5 bg-white rounded-2 @if (!$checkout['is_min_amount']) disable-fields @endif">
                                <div class="row g-4">
                                    {{-- <div class="col-sm-6">
                                <div class="label-input-field mt-0">

                                    <label>Order Type</label>
                                    <select class="form-control {{ $errors->has('order_type') ? ' is-invalid' : '' }}"
                                        id="order-type" name="order_type">
                                        <option value="">Select Order Type *</option>
                                        @foreach (config('constants.ORDER_TYPE') as $key => $orderType)
                                        <option value="{{$orderType}}" @if (old('order_type') != null && old('order_type') == $orderType) selected @elseif(!empty($row) && $row->
                                            order_type==$orderType) selected
                                            @elseif($orderType==config('constants.ORDER_TYPE_SELECTED')) selected
                                            @endif>{{$orderType}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('order_type'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('order_type') }}
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="label-input-field mt-0 d-none">
                                    <label>Customer GST</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('customer_gst') ? ' is-invalid' : '' }}"
                                        placeholder="Customer GST (optional)" name="customer_gst" disabled
                                        value="{{old('customer_gst')}}">
                                    @if ($errors->has('customer_gst'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('customer_gst') }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div> --}}
                                    <div class="col-sm-6">
                                        <div class="label-input-field mt-0">
                                            <textarea rows="5" placeholder="Order notes"
                                                class="form-control {{ $errors->has('order_notes') ? ' is-invalid' : '' }}" name="order_notes">{{ old('order_notes') }}</textarea>
                                            @if ($errors->has('order_notes'))
                                                <div class="invalid-feedback">
                                                    <div>{{ $errors->first('order_notes') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>




                    <div class="col-xl-4">
                        <div class="checkout-sidebar">
                            <div class="sidebar-widget checkout-sidebar py-6 px-4 bg-white rounded-2">
                                <div class="widget-title d-flex">
                                    <h5 class="mb-0 flex-shrink-0">Order Summery</h5>
                                    <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                                </div>
                                <table class="sidebar-table w-100 mt-5">

                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $is_temp_sensitive = false;
                                    @endphp

                                    @foreach ($cart as $cartSingle)
                                        @php
                                            if ($cartSingle->temp_sensitive) {
                                                $is_temp_sensitive = true;
                                            }

                                        @endphp
                                        <tr>
                                            <td width="25%">
                                                <!-- <img src="{{ asset('storage/products/') }}/{{ $cartSingle->product_id }}/{{ $cartSingle->image }}" alt="#"> -->
                                                @if ($cartSingle->is_variant && $cartSingle->attribute)
                                                    <img class="img-thumbnail bg-white"
                                                        style="width: 100px;height:70; object-fit:contain"
                                                        src="{{ asset('storage/products/') }}/{{ $cartSingle->product_id }}/{{ $cartSingle->attribute->image }}"
                                                        alt="{{ $cartSingle->name }}">
                                                @else
                                                    <img class="img-thumbnail bg-white"
                                                        style="width: 100px;height:70px;object-fit:contain"
                                                        src="{{ asset('storage/products/') }}/{{ $cartSingle->product_id }}/{{ $cartSingle->image }}"
                                                        alt="{{ $cartSingle->name }}">
                                                @endif
                                            </td>
                                            <td>
                                                <h6><a class="text-dark"
                                                        href="{{ route('product', $cartSingle->slug) }}">{{ $cartSingle->name }}</a>
                                                </h6>
                                                <!-- <span class="product-qty">x 2</span> -->
                                                @if ($cartSingle->is_variant && $cartSingle->attribute)
                                                    @if (isset($cartSingle->attribute->details))
                                                        <p class="">
                                                            @foreach ($cartSingle->attribute->details as $detail)
                                                                <span
                                                                    class="badge text-dark ps-0 pe-1">{{ $detail->attribute_name }}:
                                                                    {{ $detail->attribute_option_name }}</span>
                                                            @endforeach
                                                        </p>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $cartSingle->quantity }}</td>
                                            <td>
                                                {{ $cartSingle->productQuantityPriceShow() }}
                                                @if ($cartSingle->is_tax_included)
                                                    <small class="font-xxs">({{ $cartSingle->tax }}% inc)</small>
                                                @endif
                                            </td>
                                        </tr>

                                        @php
                                            $config = App\Helper::getWebsiteConfig('product_services');
                                        @endphp

                                        @if ($config['product_services'])
                                            @if (!empty($cartSingle->productServices) && count($cartSingle->productServices) > 0)
                                                @foreach ($cartSingle->productServices as $service)
                                                    @php
                                                        $alreadyService = App\Helper::serviceAlreadyInCart(
                                                            $cartSingle->product_row_id,
                                                            $cartSingle->product_attribute_id,
                                                            $service,
                                                        );
                                                    @endphp

                                                    @if ($alreadyService)
                                                        <tr class="service-row">
                                                            <td colspan="4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="">
                                                                        <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted"
                                                                            style="width:80px"
                                                                            src="{{ asset('storage/product-services/') }}/{{ $service->id }}/{{ $service->image }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="pl-10">
                                                                        <h5 class="mb-5 fw-500">
                                                                            {{ $service->name }}
                                                                        </h5>
                                                                        <p>Price: {{ $service->getPrice() }}</p>
                                                                        <p class="font-sm text-grey-5">
                                                                            {{ $service->summary }}</p>
                                                                        <!-- <p class="text-grey-3">{{ $service->description }}</p> -->



                                                                    </div>

                                                                </div>
                                                            </td>


                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                    @if ($is_temp_sensitive)
                                        @foreach ($products as $item)
                                            @php
                                                $already = App\Helper::alreadyInCart($item);
                                            @endphp

                                            <tr class="ice-packs">
                                                <td width="25%">
                                                    @if ($item->is_variant && $item->attribute)
                                                        <img class="img-thumbnail bg-white"
                                                            style="width:100px;height:70px;object-fit:contain"
                                                            src="{{ asset('storage/products/' . $item->id . '/' . $item->attribute->image) }}"
                                                            alt="{{ $item->name }}">
                                                    @else
                                                        <img class="img-thumbnail bg-white"
                                                            style="width:100px;height:70px;object-fit:contain"
                                                            src="{{ asset('storage/products/' . $item->id . '/' . $item->image) }}"
                                                            alt="{{ $item->name }}">
                                                    @endif
                                                </td>

                                                <td>
                                                    <h6 class="mb-1">
                                                        <a class="text-dark" href="{{ route('product', $item->slug) }}">
                                                            {{ $item->name }}
                                                        </a>
                                                    </h6>

                                                    @if ($item->is_variant && $item->attribute && $item->attribute->details)
                                                        <p class="mb-0">
                                                            @foreach ($item->attribute->details as $detail)
                                                                <span class="badge text-dark ps-0 pe-1">
                                                                    {{ $detail->attribute_name }}:
                                                                    {{ $detail->attribute_option_name }}
                                                                </span>
                                                            @endforeach
                                                        </p>
                                                    @endif
                                                </td>

                                                <td>1</td>

                                                <td>
                                                    ${{ number_format($item->price, 2) }}

                                                    @if ($item->is_tax_included)
                                                        <small>({{ $item->tax }}% inc)</small>
                                                    @endif
                                                </td>

                                                <td width="5%" class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input ice-bag-checkbox"
                                                        data-key="{{ $item->slug }}"
                                                        data-price="{{ $item->price }}"
                                                        data-attribute="{{ $item->attribute_id ?? '' }}"
                                                        {{ $already ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="ice-packs">
                                            <td colspan="5">
                                                <small class="text-warning d-block">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Some products are temperature-sensitive. We recommend adding an ice bag
                                                    to help maintain product quality during shipping.
                                                </small>
                                            </td>
                                        </tr>
                                    @endif

                                </table>

                                <div id="pricing-section">
                                    @include('front.checkout.pricing-section')
                                </div>






                                @if (!$isEnquiryWebsite)
                                    @if ($couponEnabled['coupon'] == true)
                                        <span class="sidebar-spacer d-block my-4 opacity-50"></span>
                                        <div
                                            class="checkout-voucher-box mt-5 @if (!$checkout['is_min_amount']) disable-fields @endif">
                                            <div id="coupon-cont">
                                                @if ($coupon)
                                                    <div class="coupon-row">
                                                        <span class="copyCode text-primary"> {{ $coupon->code }} </span>
                                                        <span class="copyBtn bg-secondary text-white" id="remove-coupon"
                                                            data-code="{{ $coupon->code }}">Remove</span>
                                                    </div>
                                                @else
                                                    <h4 class="mb-3">Apply Coupon</h4>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" placeholder="Enter Your Coupon"
                                                            class="theme-input w-100" name="Coupon" id="coupon-code">
                                                        <button type="submit" class="btn btn-secondary flex-shrink-0"
                                                            id="apply-coupon">Apply Coupon</button>
                                                    </div>
                                                    <div id="coupon-message"></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif



                                @if (!$isEnquiryWebsite)
                                    @if (count($allowedPaymentMethods) > 0)
                                        {{-- <span class="sidebar-spacer d-block my-4 opacity-50"></span> --}}

                                        <div @if (!$checkout['is_min_amount']) class="disable-fields" @endif>


                                            <div class="d-flex align-items-end justify-content-between">
                                                <h4 class="mt-8 mb-0">Payment Details</h4>
                                                @auth('web')
                                                    {{-- @if (isset($paymentMethods) && count($paymentMethods) > 0)
                                                    <a class="btn btn-secondary btn-sm py-1 px-2 show-add-payment-method"><i class="fas fa-plus"></i> Card</a>
                                                @endif --}}
                                                @endauth
                                            </div>
                                            <div class="my-6 @if (array_key_exists('stripe_checkout', $allowedPaymentMethods)) d-none @endif">


                                                @foreach (config('constants.PAYMENT_METHODS') as $key => $paymentMethod)
                                                    @if (array_key_exists($key, $allowedPaymentMethods))
                                                        @if ($key != 'stripe_checkout')
                                                            <div
                                                                class="form-title d-flex align-items-center pb-5 @if ($key == 'stripe_express_checkout') position-relative mb-5 @endif">
                                                                <div class="theme-radio">
                                                                    <input type="radio" name="payment_method"
                                                                        id="{{ $key }}Radio"
                                                                        @if (old('payment_method') != null && old('payment_method') == $key) checked 
                                                                        @elseif (count($allowedPaymentMethods) == 1) 
                                                                        checked @endif
                                                                        value="{{ $key }}">
                                                                    <span class="custom-radio"></span>
                                                                </div>
                                                                <label
                                                                    class="h6 mb-0 ms-2 {{ $errors->has('payment_method') ? ' is-invalid' : '' }}"
                                                                    for="{{ $key }}Radio">{{ $paymentMethod }}
                                                                </label>

                                                                @if ($key == 'stripe_express_checkout')
                                                                    <small class="position-absolute fs-12"
                                                                        style="top:24px">After placing the order, you'll be
                                                                        redirected to Stripe to complete payment.</small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <input type="hidden" name="payment_method"
                                                                value="stripe_checkout">
                                                        @endif
                                                    @endif
                                                @endforeach


                                                @if ($errors->has('payment_method'))
                                                    <div class="invalid-feedback" style="display: inline;">
                                                        <div>{{ $errors->first('payment_method') }}</div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                @endif


                                <div id="place-order-section">
                                    @include('front.checkout.place-order-section')
                                </div>

                                <p class="mt-3 mb-0 fs-xs">By Placing your order your agree to our company
                                    <a target="_blank" href="{{ route('privacy') }}">Privacy Policy</a>
                                </p>

                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" />
                            </div>
                        </div>
                    </div>
                </div>



            </form>
        </div>
    </div>
    <!--checkout section end-->






@endsection


@push('scripts')
    {{-- page specific JS goes here --}}

    @if ($checkout['is_min_amount'])
        @if (array_key_exists('stripe_checkout', $allowedPaymentMethods))
            <script src="https://js.stripe.com/v3/"></script>

            {{-- @guest --}}
            @if (!(isset($paymentMethods) && count($paymentMethods) > 0))
                <script>
                    let stripe = Stripe("{{ env('STRIPE_KEY') }}");
                    let elements = stripe.elements()
                    // let style = {
                    //     base: {
                    //         color: '#32325d',
                    //         fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    //         fontSmoothing: 'antialiased',
                    //         fontSize: '16px',
                    //         '::placeholder': {
                    //             color: '#aab7c4'
                    //         }
                    //     },
                    //     invalid: {
                    //         color: '#fa755a',
                    //         iconColor: '#fa755a'
                    //     }
                    // };
                    //         let style = {
                    //             base: {
                    //     color: '#32325d',
                    //     fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    //     fontSize: '16px',
                    //     fontSmoothing: 'antialiased',
                    //     '::placeholder': {
                    //       color: '#aab7c4'
                    //     },
                    //     backgroundColor: '#ffffff',
                    //     border: '1px solid #e0e0e0',
                    //     padding: '10px 12px',
                    //     borderRadius: '4px',
                    //   },
                    //   invalid: {
                    //     color: '#fa755a',
                    //     iconColor: '#fa755a',
                    //     borderColor: '#fa755a',
                    //   }
                    //                     };

                    // let card = elements.create('card', { hidePostalCode: true, style: style})
                    let card = elements.create('card', {
                        hidePostalCode: true
                    })
                    card.mount('#card-element')
                    let paymentMethod = null
                    $('.card-checkout').on('submit', function(e) {
                        $('button.submit-btn').attr('disabled', true)
                        if (paymentMethod) {
                            return true
                        }
                        $('.loader').removeClass('d-none');
                        stripe.confirmCardSetup(
                            "{{ $intent->client_secret }}", {
                                payment_method: {
                                    card: card,
                                    billing_details: {
                                        name: $('.card_holder_name').val()
                                    }
                                }
                            }
                        ).then(function(result) {
                            console.log(result);
                            // $('.loader').addClass('d-none');
                            if (result.error) {
                                $('#card-errors').text(result.error.message)
                                $('button.submit-btn').removeAttr('disabled');
                                $('.loader').addClass('d-none');
                            } else {
                                paymentMethod = result.setupIntent.payment_method
                                $('.stripe-payment-method').val(paymentMethod)
                                $('.card-checkout').submit()
                            }
                        })
                        return false
                    })
                </script>
            @else
                <script>
                    $('.card-checkout').on('submit', function(e) {
                        $('button.submit-btn').attr('disabled', true);
                        $('.loader').removeClass('d-none');
                    });
                </script>
            @endif
            {{-- @endguest --}}

            @auth('web')
                <script>
                    // const stripePaymentMethod = Stripe("{{ env('STRIPE_KEY') }}");
                    // const {paymentMethod, error} = await stripePaymentMethod.createPaymentMethod({
                    //     type: 'card',
                    //     card: cardElement,
                    // });

                    // console.log(paymentMethod);
                    // console.log(error);

                    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
                    const elements = stripe.elements();
                    const cardElement = elements.create('card');
                    cardElement.mount('#card-element');

                    document.getElementById('payment-form').addEventListener('submit', async (e) => {
                        e.preventDefault();

                        const cardholderName = document.getElementById('cardholder-name').value;

                        const {
                            paymentMethod,
                            error
                        } = await stripe.createPaymentMethod({
                            type: 'card',
                            card: cardElement,
                            billing_details: {
                                name: cardholderName
                            },
                            //hidePostalCode: true
                        });

                        if (error) {
                            alert(error.message);
                        } else {
                            // send to backend
                            // const res = await fetch('/api/payment-methods', {
                            //     method: 'POST',
                            //     headers: {
                            //         'Content-Type': 'application/json',
                            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            //         'Authorization': 'Bearer YOUR_USER_TOKEN' // if using auth via token
                            //     },
                            //     body: JSON.stringify({
                            //         payment_method: paymentMethod.id
                            //     })
                            // });

                            // const data = await res.json();
                            // alert(data.message);

                            $('.loader').removeClass('d-none');

                            $.ajax({
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: site_url + "/save-payment-method",
                                data: {
                                    payment_method: paymentMethod.id
                                },
                                success: function(response) {
                                    console.log(response)
                                    if (response.result) {
                                        $('#addPaymentMethodModal').modal('hide');
                                        location.reload();
                                    } else {
                                        toastr.error(response.message, 'Error');
                                    }

                                    return false;

                                },
                                error: function(xhr, textStatus) {
                                    if (xhr.status == 422) {
                                        var responseText = $.parseJSON(xhr.responseText);
                                        validateAfterCall(responseText, modalBody);
                                    }
                                    return false;
                                },
                                complete: function(xhr, textStatus) {
                                    $('.loader').addClass('d-none');
                                    // console.log(response);

                                    that.prop("disabled", false);
                                    that.find('i').remove();

                                    if (xhr.status == 401) {
                                        window.location.href = site_url + "/login";
                                    }
                                }
                            });
                        }
                    });

                   
                </script>
            @endauth
        @endif
    @endif

    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                action: 'submit'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });

        $(document).on('change', '.ice-bag-checkbox', function() {

            let checkbox = $(this);
            let checked = checkbox.is(':checked');

            $.ajax({
                type: "POST",
                url: site_url + (checked ? "/add-cart" : "/delete-cart"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: checked ? {
                    key: checkbox.data('key'),
                    quantity: 1,
                    attribute: checkbox.data('attribute') || '',
                    page: 'checkout'
                } : {
                    key: checkbox.data('key'),
                    attribute: checkbox.data('attribute') || ''
                },

                beforeSend: function() {
                    $('.loader').removeClass('d-none');
                },

                success: function(response) {

                    if (!response.result) {
                        checkbox.prop('checked', !checked);
                        toastr.error(response.message, 'Error');
                        return;
                    }

                    let subtotal = parseFloat($('.subtotal-price').text().replace(/[^0-9.-]+/g, ''));
                    let price = parseFloat(checkbox.data('price'));

                    if (checked) {
                        subtotal += price;
                    } else {
                        subtotal -= price;
                         location.reload();
        return;
                    }

                    $('.subtotal-price').text('$' + subtotal.toFixed(2));

                    toastr.success(response.message, 'Success');
                },

                error: function(xhr) {

                    checkbox.prop('checked', !checked);

                    if (xhr.status === 401) {
                        window.location.href = site_url + "/login";
                    } else {
                        toastr.error('Something went wrong. Please try again.', 'Error');
                    }
                },

                complete: function() {
                    $('.loader').addClass('d-none');
                }

            });

        });
    </script>


@endpush
