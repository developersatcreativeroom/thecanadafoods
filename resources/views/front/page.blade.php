@extends('front.layouts.app')

@section('content')


        <section class="pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 m-auto">
                        <div class="contact-from-area padding-20-row-col wow FadeInUp">
                            <h3 class="mb-10 text-center">{{$page->title}}</h3>
                            
                            <p class="mt-10">{!! $page->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection