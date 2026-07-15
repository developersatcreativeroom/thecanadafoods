@extends('front.layouts.app')

@section('content')



<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 justify-content-center">
                <div class="breadcrumb-content">
                    <h1 class="mb-2 text-center text-red">{{$blog->title}}</h1>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Blog Details</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->



<!--blog details start-->
<section class="blog-details pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="blog-details-content bg-white rounded-2 py-6 px-5">
                    <div class="thumbnail rounded-2 overflow-hidden text-center">
                        <img src="{{ asset('storage/blogs/') }}/{{$blog->id}}/{{$blog->image}}" alt="blog thumb" class="img-fluid">
                    </div>
                    <div class="blog-meta d-flex align-items-center gap-3 flex-wrap mt-5">
                        <span class="fs-xs fw-medium">By the {{config('constants.POSTED_BY')}}</span> • 
                        <span class="fs-xs fw-medium"> UPDATED {{$blog->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                       @if(!empty($blog->read_time))
                        • 
    <span class="fs-xs fw-medium">
        <i class="fa-regular fa-clock me-2"></i>
        {{ \Illuminate\Support\Str::contains(strtolower($blog->read_time), 'min') ? $blog->read_time : $blog->read_time . ' min' }} read
    </span>
@endif
                        {{-- <span class="fs-xs fw-medium"><i class="fa-regular fa-comments me-2"></i>Organic Vegetable</span> --}}
                    </div>
                    <span class="hr-line w-100 position-relative d-block my-4"></span>
                    <div class="blog-description" style="max-width: 1275px">{!!$blog->description!!}</div>
                    

                    {{-- <h4 class="mt-6">Comments(02)</h4>
                    <ul class="comments_list mt-6">
                        <li class="d-sm-flex">
                            <div class="thumbnail flex-shrink-0">
                                <img src="assets/img/authors/user-thumb-1.jpg" alt="user" class="img-fluid rounded-circle">
                            </div>
                            <span class="date text-danger">05.03.2021[11.00am]</span>
                            <div class="comments_content ms-sm-4 mt-4 mt-sm-0">
                                <h6 class="mb-3">Randy K. Melton</h6>
                                <p>Distinctively customize holistic information whereas multidisciplinary process improve. services. Dynamically predominate standardized. </p>
                                <a href="#" class="reply-btn"><span class="me-1"><i class="fa-solid fa-reply"></i></span>Reply</a>
                            </div>
                        </li>
                        <li class="d-sm-flex ms-5">
                            <div class="thumbnail flex-shrink-0">
                                <img src="assets/img/authors/user-thumb-2.jpg" alt="user" class="img-fluid rounded-circle">
                            </div>
                            <span class="date text-danger">05.03.2021[11.00am]</span>
                            <div class="comments_content ms-sm-4 mt-4 mt-sm-0">
                                <h6 class="mb-3">Randy K. Melton</h6>
                                <p>Distinctively customize holistic information whereas multidisciplinary process improve. services. Dynamically predominate standardized. </p>
                                <a href="#" class="reply-btn"><span class="me-1"><i class="fa-solid fa-reply"></i></span>Reply</a>
                            </div>
                        </li>
                    </ul>
                    <hr class="my-6">
                    <div class="comment_form_wrapper">
                        <h4>Leave a Comments</h4>
                        <p class="mb-5">Your email address will not be published. Required fields are marked*</p>
                        <form action="#" class="comment_form">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="input-field">
                                        <input type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-field">
                                        <input type="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-field">
                                        <input type="url" placeholder="Website">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-field">
                                        <textarea placeholder="Paste Here" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-30">Post Comment</button>
                        </form>
                    </div> --}}
                </div>
            </div>
            
        </div>

    </div>
</section>
<!--blog details end-->


<!--faq section start-->
@if (count($blog->faqs) > 0)
<section class="faq-section pb-120 position-relative overflow-hidden z-1">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-md-8">
                <div class="faq-right">
                    <h4 class="mb-4">Frequently Asked Questions</h4>
                    <p class="mb-5">Wondering how things work around here? Our FAQ has you covered.</p>
                    
                    <div class="accordion faq-accordion" id="faq-accordion">
                         
                        
                        @foreach($blog->faqs as $k=>$faq)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="#acc-{{$faq->id}}" data-bs-toggle="collapse" class="collapsed"> {{$k+1}}. {{$faq->question}}<i class="fas fa-angle-down float-end ms-1"></i></a>
                            </div>
                            <div class="accordion-collapse collapse" id="acc-{{$faq->id}}" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <p class="mb-0">{{$faq->answer}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach 

                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
@endif
<!--faq section end-->


@endsection