@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Blog</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->




<!--blog section start-->
<section class="blog-section pb-120 position-relative overflow-hidden z-1">
    {{-- <img src="{{ URL::asset('frontend/img/shapes/dal.png') }}" alt="shape" class="position-absolute dal-shape z--1">
    <img src="{{ URL::asset('frontend/img/shapes/frame-circle.svg') }}" alt="frame circle" class="position-absolute frame-circle z--1 d-none d-md-block"> --}}
    <div class="container">
        <div class="row g-4 justify-content-center mt-3">

            @foreach($blogs as $blog)
            <div class="col-xl-4 col-md-6">
                <article class="blog-card rounded-2 overflow-hidden bg-white">
                    <div class="thumbnail overflow-hidden">
                        <a href="{{route('blog', $blog->slug)}}"><img src="{{ asset('storage/blogs/') }}/{{$blog->id}}/{{$blog->image}}" alt="blog thumb" class="img-fluid"></a>
                    </div>
                    <div class="blog-card-content">
                        <div class="blog-meta d-flex align-items-center gap-3 mb-1">
                            <span class="fs-xs fw-medium"><i class="fa-solid fa-tags me-1"></i>{{$blog->category_name}}</span>
                            <span class="fs-xs fw-medium"><i class="fa-regular fa-clock me-1"></i>{{$blog->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                        </div>
                        <a href="{{route('blog', $blog->slug)}}">
                            <h4 class="mb-3">{{$blog->title}}</h4>
                        </a>
                        <p class="mb-0 mb-5">{{$blog->short_description}}</p>
                        <a href="{{route('blog', $blog->slug)}}" class="btn btn-primary-light btn-md">Explore More<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                </article>
            </div>
            @endforeach
            
        </div>
    </div>
</section> <!--blog section end-->
        
@endsection