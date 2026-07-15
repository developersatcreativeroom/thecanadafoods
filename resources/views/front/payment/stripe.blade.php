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
                        <form method="POST" action="{{ route('stripe.checkout', ['order_id' => $order->order_unique_id]) }}" class="card-form mt-3 mb-3">
                            @csrf
                            <input type="hidden" name="payment_method" class="payment-method">
                            <input class="StripeElement mb-4 form-control" name="card_holder_name" placeholder="Card holder name" required>
                            <div class="row">
                                <div class="col-12">
                                    <div id="card-element"></div>
                                </div>
                            </div>
                            <div class="text-danger" id="card-errors" role="alert"></div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary pay">Purchase</button>
                            </div>
                            <input type="hidden" name="order_id" value="{{$order->order_unique_id}}" />
                        </form>
                    </div>
                </div>

            </div>
        </section>

@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    let stripe = Stripe("{{ config('services.stripe.key') }}")
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
    let card = elements.create('card', { hidePostalCode: true, style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('.card-form').on('submit', function (e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)
                $('.card-form').submit()
            }
        })
        return false
    })
</script>


@endpush