@extends('front.layouts.app')

@section('content')

<main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" rel="nofollow">Home</a>
                    <span></span> Videos
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container custom">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-header mb-50">
                            <h1 class="font-xxl text-brand">Our Videos</h1>
                            <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                <span class="post-on has-dot">{{$count}} {{$count > 1 ? 'Videos' : 'Video'}}</span>
                            </div>
                        </div>
                        <div class="row">
                            
                            @foreach($videos as $video)
                                <div class="col-md-4 my-2">
                                    <iframe height="280px" width="100%" src="https://www.youtube.com/embed/{{$video->video}}"></iframe>  
                                </div>
                            @endforeach

                        </div>
                        <!--post-grid-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            {!! $videos->withQueryString()->links() !!}
                        </div>

                    </div>
               
                </div>
            </div>
        </section>
    </main>

        
@endsection