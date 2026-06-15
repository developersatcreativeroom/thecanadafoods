@extends('front.layouts.app')

@section('content')


<!--contact us section start-->
<section class="contact-us-section position-relative overflow-hidden z-1 pt-80 pb-120">
    <img src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle" class="position-absolute frame z--1 d-none d-sm-block">
    <img src="{{ URL::asset('frontend/img/shapes/roll-2.png') }}" alt="roll" class="position-absolute roll-2 z--1">
    <img src="{{ URL::asset('frontend/img/shapes/pata-xs.svg') }}" alt="pata" class="position-absolute pata z--1">
    <img src="{{ URL::asset('frontend/img/shapes/garlic-white.png') }}" alt="garlic" class="position-absolute garlic z--1">
    <img src="{{ URL::asset('frontend/img/shapes/roll-1.png') }}" alt="roll" class="position-absolute roll-1 z--1">
    <img src="{{ URL::asset('frontend/img/shapes/leaf.svg') }}" alt="leaf" class="position-absolute leaf z--1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Get In Touch</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="contact-box rounded-2 bg-white overflow-hidden mt-8">
            <div class="row g-4">
                <div class="col-xl-5">
                    <div class="contact-left-box position-relative overflow-hidden z-1 bg-primary p-6 d-flex flex-column h-100" data-background="assets/img/shapes/circle-half-fill.png') }}">
                        <img src="{{ URL::asset('frontend/img/shapes/texture-overlay.png') }}" alt="texture" class="position-absolute w-100 h-100 start-0 top-0 z--1">
                        <h3 class="text-white mb-3">Contact Details</h3>
                       <p class="text-white">We're here to answer your questions, take your orders, and bring a taste of Canada right to your doorstep in the U.S. — reach out anytime!</p>
                        {{-- <p class="fs-sm text-white"><strong>Address:</strong> {!!$config['address']!!} </p> --}}
                        <span class="spacer my-5"></span>
                        <ul class="contact-list mb-5">
                            {{-- <li class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="icon d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0">
                                <i class="fa fa-phone text-primary"></i>
                            </span>
                                <div class="info">
                                    <span class="fw-medium text-white fs-xs">Phone</span>
                                    <a href="mailto:{{$config['phone']}}"><h5 class="mb-0 mt-1 text-white">{{$config['phone']}}</h5></a>
                                </div>
                            </li> --}}
                            <li class="d-flex align-items-center gap-3 flex-wrap mt-3">
                                <span class="icon d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0">
                                <i class="fa-regular fa-envelope text-primary"></i>
                            </span>
                                <div class="info">
                                    <span class="fw-medium text-white fs-xs ">Email</span>
                                    <a href="mailto:{{$config['email']}}"><p class="mb-0 mt-1 text-white fw-medium">{{$config['email']}}</p></a>
                                </div>
                            </li>
                        </ul>

                        @if(count($config['social']) > 0 && 
                            ($config['social']['facebook'] != "" && $config['social']['facebook'] != "#" ||
                            $config['social']['instagram'] != "" && $config['social']['instagram'] != "#" ||
                            $config['social']['twitter'] != "" && $config['social']['twitter'] != "#" ||
                            $config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#" ||
                            $config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                            )
                                <div class="mt-5">
                                    <span class="fw-bold text-white mb-3 d-block">Follow us on:</span>
                                    <div class="social-links d-flex align-items-center gap-2">

                                        @if($config['social']['facebook'] != "" && $config['social']['facebook'] != "#")
                                            <a target="_blank" href="{{$config['social']['facebook']}}"><i class="fab fa-facebook-f"></i></a>
                                        @endif

                                        @if($config['social']['instagram'] != "" && $config['social']['instagram'] != "#")
                                            <a target="_blank" href="{{$config['social']['instagram']}}"><i class="fab fa-instagram"></i></a>
                                        @endif

                                        @if($config['social']['twitter'] != "" && $config['social']['twitter'] != "#")
                                            <a target="_blank" href="{{$config['social']['twitter']}}"><i class="fab fa-twitter"></i></a>
                                        @endif

                                        @if($config['social']['pinterest'] != "" && $config['social']['pinterest'] != "#")
                                            <a target="_blank" href="{{$config['social']['pinterest']}}"><i class="fab fa-pinterest"></i></a>
                                        @endif

                                        @if($config['social']['youtube'] != "" && $config['social']['youtube'] != "#")
                                            <a target="_blank" href="{{$config['social']['youtube']}}"><i class="fab fa-youtube"></i></a>
                                        @endif

                                    </div>
                                </div>

                        @endif

                    </div>
                </div>
                <div class="col-xl-7">
                        <form class="contact-form ps-5 ps-xl-4 py-6 pe-6" method="POST" action="{{ route('contact') }}">
                        @csrf
                        <h3 class="mb-6">Get in Touch With The Canada Foods</h3>
                        
                        <div class="row g-4">

                            <div class="col-sm-6">
                                <div class="label-input-field">
                                    <label>Name</label>
                                    <input placeholder="Name" type="text" class="form-control {{$errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}" />
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback">
                                           {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="label-input-field">
                                    <label>Email</label>
                                    <input placeholder="Your Email" type="email" class="form-control {{$errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{old('email')}}" />
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback">
                                           {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="label-input-field">
                                    <label class="z-5">Phone</label>
                                    <div class="input-group">
                                    <span class="input-group-text" >+@if(!empty($config['country_code'])){{$config['country_code']}}@else{{config('constants.CONTACT.country_code')}}@endif</span>
                                    <input placeholder="Your Phone" type="text" class="form-control only-numbers {{$errors->has('phone') ? ' is-invalid' : '' }}" maxlength="10" name="phone" value="{{old('phone')}}" />
                                    @if($errors->has('phone'))
                                        <span class="invalid-feedback">
                                           {{ $errors->first('phone') }}
                                        </span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="label-input-field">
                                    <label>Subject</label>
                                    <input placeholder="Subject" type="text" class="form-control {{$errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{old('subject')}}" />
                                    @if($errors->has('subject'))
                                        <span class="invalid-feedback">
                                           {{ $errors->first('subject') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="label-input-field">
                                    <label>Message</label>
                                    <textarea placeholder="Message" class="form-control {{$errors->has('message') ? ' is-invalid' : '' }}" name="message" rows="6">{{old('message')}}</textarea>
                                    @if($errors->has('message'))
                                        <span class="invalid-feedback">
                                           {{ $errors->first('message') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary btn-md rounded-1 mt-6">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--contact us section end-->


@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush