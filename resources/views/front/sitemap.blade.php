@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Sitemap</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Sitemap</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<section class="pt-5 position-relative overflow-hidden bg-white">    
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-xl-10">
                <div class="faq-right">
                    <h4 class="mb-4">Pages</h4>                    
                    <ul class="wsp-pages-list">
                        @foreach (config('constants.SITEMAP_PAGES') as $route=>$page)
                            <li><a href="{{route($route)}}" target="_blank">{{$page}}</a></li>
                        @endforeach 
                    </ul>
                    <h4 class="mb-4 mt-5">Blogs</h4>                    
                    <ul class="wsp-pages-list">
                        @foreach ($blogs as $k=>$val)
                            <li><a href="{{route('blog', $val->slug)}}" target="_blank">{{$val->title}}</a></li>
                        @endforeach 
                    </ul>

                    <h4 class="mb-4 mt-5">Categories</h4>                    
                    <ul class="wsp-pages-list">
                        @foreach ($categories as $k=>$val)
                            <li><a href="{{route('category', $val->slug)}}" target="_blank">{{$val->name}}</a></li>
                        @endforeach 
                    </ul>

                    <h4 class="mb-4 mt-5">Products</h4>    
                    @php 
                        $boxCount = 2;
                        $boxes = array_fill(0, $boxCount, []);
                        foreach ($products as $index => $val) {
                            $boxIndex = $index % $boxCount;
                            $boxes[$boxIndex][] = $val;
                        }
                    @endphp  
                    <div class="row">
                    @foreach ($boxes as $box)                    
                        <div class="col-md-6">
                            <ul class="wsp-pages-list">
                                @foreach ($box as $k=>$val) 
                                    <li><a href="{{route('product', $val->slug)}}" target="_blank">{{$val->name}}</a></li>
                                     
                                @endforeach
                            </ul>
                        </div>
                    @endforeach  
                    </div>          
                    {{-- <ul class="wsp-pages-list">
                        @foreach ($products as $k=>$val)
                            <li><a href="{{route('product', $val->slug)}}" target="_blank">{{$val->name}}</a></li>
                        @endforeach 
                    </ul>  --}}
                    @if ($pages->count() > 0)                    
                        <h4 class="mb-4 mt-5">Dynamic Pages</h4>                    
                        <ul class="wsp-pages-list">
                            @foreach ($pages as $k=>$val)
                                <li><a href="{{route('page', $val->slug)}}" target="_blank">{{$val->title}}</a></li>
                            @endforeach 
                        </ul>
                    @endif                    
                </div>
            </div>
        </div>
    </div>
</section>
        
@endsection