@extends('front.layouts.app')

@section('content')

<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
               
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-lg-6">
                        <button id="rzp-button1">Pay</button>
                    </div>
                </div>

            </div>
        </section>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
        "key": "{{config('services.razorpay.key')}}", // Enter the Key ID generated from the Dashboard
        "amount": "{{$payment->amount * 100}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "{{$currency}}",
        "name": "{{config('constants.BUSINESS.name')}}", //your business name
        "description": "Razorpay Online Payment",
        "image": "{{App\Helper::getLightLogo()}}",
        "order_id": "{{$razorOrderID}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        "callback_url": "{{route('razorpay.redirect')}}",
        "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
            "name": "{{$order->first_name}} {{$order->last_name}}", //your customer's name
            "email": "{{$order->email}}",
            "contact": "{{$order->phone}}" //Provide the customer's phone number for better conversion rates 
        },
        // "notes": {
        //     "address": "Razorpay Corporate Office"
        // },
        // "theme": {
        //     "color": "#3399cc"
        // }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
    </script>


@endpush