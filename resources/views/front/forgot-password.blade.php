@extends('front.layouts.app')

@section('content')




<!--login section start-->
<section class="login-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow">
                <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100" action="{{ route('forgot.password') }}" method="post">
                    @csrf
                    <div class="text-center mb-7">
                        <a href="{{route('home')}}">
                            <img class="img-fluid logo-body" src="{{App\Helper::getLightLogo()}}" alt="logo">
                        </a>
                    </div>
                    <h4 class="mb-3">Forgot Password</h4>
                    <p class="fs-xs">Want to login? <a href="{{route('login')}}" class="text-secondary">Sign in</a></p>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="input-field">
                                <input type="email" class="theme-input form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email" value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <div>{{ $errors->first('email') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    <div class="row g-4 mt-2">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
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