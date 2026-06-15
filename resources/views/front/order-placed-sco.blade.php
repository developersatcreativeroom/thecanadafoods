@extends('front.layouts.app')
@section('head')
<!-- Google tag (gtag.js) event -->
<script>
  gtag('event', 'conversion_event_purchase', {
    // <event_parameters>
  });
</script>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1024329659429409');
fbq('track', 'order-placed');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1024329659429409&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endsection
@section('content')



<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Products</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Order Success</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->


<section class="gshop-gshop-grid ptb-80 bg-white">
    <div class="container">         
        <div class="row">
            <div class="col text-center">
                <h6>Thanks!</h6>
                <h2 class="my-3 text-success">Your Order is Successful</h2>
                <p>We will keep you updated</p>
            </div>
        </div> 
    </div> 
</section>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush