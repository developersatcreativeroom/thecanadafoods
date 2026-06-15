@extends('front.layouts.app')

@section('content')

<!--my account section-->
<section class="my-account pt-6 pb-120">
    <div class="container">


        @php
        $config = App\Helper::getWebsiteConfig('is_email_verify');
        @endphp
        @if($config['is_email_verify'] && Auth::user()->email_verified_at == null)
        
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="alert alert-warning text-center mt-4" role="alert">
                        Your email is not verified, please click <a id="verify-email" href="#"><strong>here</strong></a>
                        to verify your email.
                    </div>
                </div>
            </div>
        
        @endif

        <div class="row g-4">
            <div class="col-xl-3">
                @include('front.profile.side')
            </div>
            <div class="col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="profile">
                        <div class="address-book bg-white rounded p-5">
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <div class="address-book-content pe-md-4 border-right position-relative">
                                        <div class="d-flex align-items-center gap-5 mb-4">
                                            <h6 class="mb-0">{{Auth::user()->first_name}} {{Auth::user()->last_name}}
                                            </h6>
                                        </div>

                                        <p class="text-uppercase fw-medium mb-3"><strong>Email:</strong>
                                            {{Auth::user()->email}}</p>
                                        <p class="text-uppercase fw-medium mb-3"><strong>Phone:</strong>
                                            +{{Auth::user()->country_code}}-{{Auth::user()->phone}}</p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>



@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush