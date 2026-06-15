@extends('front.layouts.app')

@section('content')

<main class="main single-page">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" rel="nofollow">Home</a>
                    <span></span> Gallery Images
                </div>
            </div>
        </div>
        <section class="section-padding">
            <div class="bg-square"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h3 class="section-title mb-20"><span>Gallery</span> Images</h3>
                    </div>
                </div>
                @if(count($testimonials) > 0)
                    <div class="row g-4 shorting gallery-view pt-45">
                        @foreach($testimonials as $testimonial)
                            <div class="col-md-6">
                                <div class="testimonial mb-0">
                                    <i class="fi-rs-quote-right"></i>
                                    <p>
                                        {{$testimonial->description}}
                                    </p>
                                    <ul>
                                        <li @if($testimonial->image) class="custom-padding-left" @endif>
                                            @if($testimonial->image)
                                                <img src="{{ asset('storage/testimonials/'.$testimonial->id.'/'.$testimonial->image) }}" />
                                                @endif
                                            <h3>{{$testimonial->name}}</h3>
                                            @if($testimonial->designation)
                                                <span>{{$testimonial->designation}}</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                <div class="row">
                    <div class="col text-center">
                        <p class="my-5"> No Record Found</p>
                    </div>
                </div>
                @endif

            </div>
        </section>
     
    </main>
        
@endsection