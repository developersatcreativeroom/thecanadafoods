@extends('front.layouts.app')

@section('content')


<!--login section start-->
<section class="login-section py-5">
    <div class="container">
        {{-- <div class="row justify-content-center">
            <div class="col">
                <div class="text-center mb-7">
                    <a href="{{route('home')}}">
                        <img class="img-fluid logo-body" src="{{App\Helper::getLightLogo()}}" alt="logo">
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="row justify-content-center">
            {{-- <div class="col-lg-5 col-12 tt-login-img" data-background="{{ URL::asset('frontend/img/banner/login-banner.jpg') }}"></div> --}}
            <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow mb-10">
                <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100" action="{{ route('login') }}" method="post">
                        @csrf
                    <h2 class="mb-3 h3">Login</h2>
                    <p class="fs-xs">if registered, login here</p>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="input-field">
                                <label class="fw-bold text-dark fs-sm mb-1">Email</label>
                                <input type="text" class="theme-input form-control {{ (old('login') != null && $errors->has('email')) ? ' is-invalid' : '' }}" name="email" placeholder="Enter your email" value="{{old('email')}}">
                                @if(old('login') != null && $errors->has('email'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('email') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field check-password">
                                <label class="fw-bold text-dark fs-sm mb-1">Password</label>
                                <div class="check-password">
                                    <input class="theme-input form-control {{ (old('login') != null && $errors->has('password')) ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Password">
                                    @if(old('login') != null && $errors->has('password'))
                                        <div class="invalid-feedback">
                                            <div>{{ $errors->first('password') }}</div>
                                        </div>
                                    @endif
                                    
                                    <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                    <span class="eye eye-slash"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <div class="checkbox d-inline-flex align-items-center gap-2">
                            <div class="theme-checkbox flex-shrink-0">
                                <input type="checkbox" id="remember" name="remember" @if(old('remember') != null && old('remember')) checked @endif>
                                <span class="checkbox-field">
                                    <i class="fa-solid fa-check"></i>
                                    </span>
                            </div>
                            <label class="save-password fs-sm" for="remember">Remember me</label>
                            
                        </div>
                        <a href="{{route('forgot.password')}}" class="fs-sm">Forgot Password</a>
                    </div>
                    <div class="row g-4 mt-4">
                        <div class="col-sm-6">
                            <button type="submit" name="login" value="login" class="btn btn-secondary w-100">Sign In</button>
                        </div>
                        {{-- <div class="col-sm-6">
                            <a href="#" class="btn btn-outline google-btn w-100">
                                <img src="{{ URL::asset('frontend/img/brands/google.png') }}" alt="google" class="me-2">Sign with Google </a>
                        </div> --}}
                    </div>
                    {{-- <p class="mb-0 fs-xs mt-4">Don't have an Account? <a href="{{route('register')}}">Sign Up</a> --}}
                    </p>

                    <div class="d-block d-sm-none text-center">
                        <hr>
                        <h6 class="text-muted">OR</h6>
                        <a href="#register-section">Create an Account</a>
                    </div>

                </form>

                

            </div>
            <div class="col-lg-1 col-12">
            </div>
            <div class="col-lg-6 col-12 bg-white d-flex p-0 tt-login-col shadow" id="register-section">
                <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100" action="{{ route('register') }}" method="post">
                    @csrf
                  
                    <h4 class="mb-3">Create an Account</h4>
                    <p class="fs-xs">If you don't have an account, register here</p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="input-field">
                                <input type="text" class="theme-input form-control {{ ($errors->has('first_name')) ? ' is-invalid' : '' }}" name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                @if($errors->has('first_name'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('first_name') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-field">
                                <input type="text" class="theme-input form-control {{ (old('register') != null && $errors->has('last_name')) ? ' is-invalid' : '' }}" name="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                                @if(old('register') != null && $errors->has('last_name'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('last_name') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field">
                                <input type="email" class="theme-input form-control {{ (old('register') != null && $errors->has('email')) ? ' is-invalid' : '' }}" name="email" placeholder="Email" value="{{old('email')}}">
                                @if(old('register') != null && $errors->has('email'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('email') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-group">
                                @php 
                                    $config = App\Helper::getWebsiteConfig('country_code');
                                @endphp
                                <span class="input-group-text" >+@if(!empty($config['country_code'])){{$config['country_code']}}@else{{config('constants.CONTACT.country_code')}}@endif</span>
                                <input type="text" class="theme-input form-control only-numbers {{ (old('register') != null && $errors->has('phone')) ? ' is-invalid' : '' }}" maxlength="10" name="phone" placeholder="Phone" value="{{old('phone')}}">
                                @if(old('register') != null && $errors->has('phone'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('phone') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field check-password">
                                <input type="password" class="theme-input form-control {{ (old('register') != null && $errors->has('password')) ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                                @if(old('register') != null && $errors->has('password'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('password') }}</div>
                                    </div>
                                @endif
                                <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                <span class="eye eye-slash"><i class="fa-solid fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field check-password">
                                <input type="password" class="theme-input form-control {{ (old('register') != null && $errors->has('confirm_password')) ? ' is-invalid' : '' }}" name="confirm_password" placeholder="Confirm password">
                                @if(old('register') != null && $errors->has('confirm_password'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('confirm_password') }}</div>
                                    </div>
                                @endif
                                <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                <span class="eye eye-slash"><i class="fa-solid fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-checkbox d-flex align-items-center {{ (old('register') != null && $errors->has('privacy')) ? ' text-danger' : '' }}">
                                <div class="theme-checkbox flex-shrink-0">
                                    <input type="checkbox" class="form-check-input" name="privacy" id="privacy" @if(old('privacy')) checked @endif>
                                    <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <label class="ms-2" for="privacy">
                                    <p class="mb-0 fs-xxs text-center">I agree to <a href="{{route('terms')}}" class="text-dark">Terms of Use and Privacy Policy</a></p>
                                </label>
                            </div>
                            @if(old('register') != null && $errors->has('privacy'))
                                <div class="invalid-feedback d-block">
                                    <div>{{ $errors->first('privacy') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row g-4 mt-2">
                        <div class="col-sm-6">
                            <button type="submit" name="register" value="register" class="btn btn-primary w-100">Create account</button>
                        </div>
                        {{-- <div class="col-sm-6">
                            <a href="#" class="btn btn-outline google-btn w-100">
                                <img src="{{ URL::asset('frontend/img/brands/google.png') }}" alt="google" class="me-2">Sign with Google </a>
                        </div>  --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--login section end-->

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush