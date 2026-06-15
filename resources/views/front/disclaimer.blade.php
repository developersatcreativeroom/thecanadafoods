@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Disclaimer</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page">Last updated on April 12, 2025</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->

<section class="">
    <div class="container my-5">
    <div class="bg-white p-4 rounded shadow-sm">
    <h2>WEBSITE DISCLAIMER</h2>
    <p>The information provided by Warrior Retail Inc., doing business as The Canada Foods ("we", "us", or "our") on 
      <a href="https://thecanadafoods.com" target="_blank">https://thecanadafoods.com</a> (the "Site") is for general informational purposes only. 
      All information on the Site is provided in good faith, however, we make no representation or warranty of any kind, express or implied, 
      regarding the accuracy, adequacy, validity, reliability, availability, or completeness of any information on the Site. 
      <strong>UNDER NO CIRCUMSTANCES SHALL WE HAVE ANY LIABILITY TO YOU FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF THE SITE 
      OR RELIANCE ON ANY INFORMATION PROVIDED ON THE SITE. YOUR USE OF THE SITE AND YOUR RELIANCE ON ANY INFORMATION ON THE SITE IS SOLELY AT YOUR OWN RISK.</strong>
    </p>

    <h2>EXTERNAL LINKS DISCLAIMER</h2>
    <p>The Site may contain (or you may be sent through the Site) links to other websites or content belonging to or originating from third parties or links to websites and features in banners or other advertising. 
      Such external links are not investigated, monitored, or checked for accuracy, adequacy, validity, reliability, availability, or completeness by us. 
      <strong>WE DO NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR THE ACCURACY OR RELIABILITY OF ANY INFORMATION OFFERED BY THIRD-PARTY WEBSITES 
      LINKED THROUGH THE SITE OR ANY WEBSITE OR FEATURE LINKED IN ANY BANNER OR OTHER ADVERTISING. WE WILL NOT BE A PARTY TO OR IN ANY WAY BE RESPONSIBLE FOR MONITORING 
      ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES.</strong>
    </p>

    <h2>TESTIMONIALS DISCLAIMER</h2>
    <p>The Site may contain testimonials by users of our products and/or services. These testimonials reflect the real-life experiences and opinions of such users. 
      However, the experiences are personal to those particular users, and may not necessarily be representative of all users of our products and/or services. 
      We do not claim, and you should not assume, that all users will have the same experiences. <strong>YOUR INDIVIDUAL RESULTS MAY VARY.</strong>
    </p>

    <p>The testimonials on the Site are submitted in various forms such as text, audio and/or video, and are reviewed by us before being posted. 
      They appear on the Site verbatim as given by the users, except for the correction of grammar or typing errors. 
      Some testimonials may have been shortened for the sake of brevity where the full testimonial contained extraneous information not relevant to the general public.
    </p>

    <p>The views and opinions contained in the testimonials belong solely to the individual user and do not reflect our views and opinions. 
      We are not affiliated with users who provide testimonials, and users are not paid or otherwise compensated for their testimonials.
    </p>
  </div>
  </div>
</section>


@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush