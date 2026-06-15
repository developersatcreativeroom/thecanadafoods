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
                @if(count($gallery) > 0)
                    <div class="row g-3 shorting gallery-view pt-45">
                        @foreach($gallery as $gallerySingle)
                            <div class="col-lg-4 col-sm-6">
                                <div class="testimonial">
                                    <i class="fi-rs-quote-right"></i>
                                    <p>
                                        We loved our stay in your apartment. The stairs were a bit of a problem for my husband who had a bad
                                        knee, but he is going in for a knee replacement so next time will be even better! Your friendly
                                        service was excellent and you should be proud of yourselves. Our overseas friends were also very
                                        pleased.
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