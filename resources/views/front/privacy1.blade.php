@extends('front.layouts.app')

@section('content')


<main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" rel="nofollow">Home</a>
                    <span></span> Terms and Conditions
                </div>
            </div>
        </div>
    
        <section class="pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 m-auto">
                        <div class="contact-from-area padding-20-row-col wow FadeInUp">
                            <h3 class="mb-10 text-center">Terms and Conditions</h3>
                            <p class="text-muted mb-30 text-center font-sm">Please read the terms and conditions carefully.</p>
                            
                                <div class="row">
                                    <div class="col">
                                    
                                    <p>
                                    This privacy policy sets out how {demowebsite.com} uses and protects any information that you give to {demowebsite.com} when you use this website.
                                    </p><p>
                                    While shopping with us you will be asked for certain information (such as your email address, name, address, and where you purchase a product, your payment details) to make sure that your order and delivery go smoothly. Any information you hand over reaches us fully encrypted through an SSL – a special security layer added to your account and checkout pages. You can see when you’re on a secure page, because the address in your browser will begin with https instead of http. You can be assured that it will only be used in accordance with this privacy statement.
                                    </p><p>
                                    How we will use your Information When your information reaches us, we store it securely and might use it for:
                                    </p>
                                    <ul>
                                    <li>
                                        <p>Helping to process your orders</p>
                                    </li>
                                    <li>
                                    <p>Providing admin support for your account</p>
                                    </li>
                                    <li>
                                    <p>Helping with your enquiries</p>
                                    </li>
                                    <li>
                                    <p>Crime and fraud prevention (when we might also share it with the police or other authorities if required by law)</p>
                                    </li>
                                    <li>
                                    <p>Marketing (subject to your account preferences, which you can change in My Account)</p>
                                    </li>
                                    <li>
                                    <p>Administering promotions or competitions (when we might also need to share the information with third parties in order to deliver you your prize!)</p>
                                    </li>
                                    <li>
                                    <p>Analysis of our customer base and profiling in order to decide which products or services you might prefer and so these are tailored to you Except as listed above, or to our other group companies who are involved in processing orders/administrative support, we don’t share your information with any third parties except our suppliers or processors who we’ve checked out first and who we appoint to work with us to provide services to you. These suppliers include the teams delivering products to you and our marketing agencies.</p>
                                    </li>
                                    <li>
                                    <p>Your information is kept with us as long as we need it for the purpose listed above. It is deleted securely when we don’t need it. Some of your information might be retained with us to ensure that your details are kept on our marketing suppression lists, even if you ask us to stop processing your information for marketing purposes.</p>
                                    </li>

                                    </ul>
                                    </p><p>
                                    If you would like to know what information is kept with us or have any queries about the security, please contact Customer Services.
                                    </p><p>
                                    How we use Cookies A cookie is a small file, which asks permission to be placed on your computer's hard drive. Once you agree, the file is added and the cookie helps analyze web traffic or lets us know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.
                                    </p><p>
                                    To identify which pages are being used we use traffic log cookies. This data is removed or deleted after our statistical analysis purpose is fulfilled. This data is only used to analyse the data about webpage traffic and improve our website for tailoring it to customer needs.
                                    </p><p>
                                    Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.
                                    </p>

                                    </div>
                                    
                                </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
      

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}


@endpush