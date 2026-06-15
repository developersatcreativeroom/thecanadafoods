@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Shipping Policy</h2>
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
    <div class="row">
    <div class="col">
      
        <p>At <strong>The Canada Foods</strong>, we understand that receiving your order in a timely and secure manner is crucial. Our Shipping Policy is designed to provide you with clear and comprehensive information regarding the shipping and delivery of your orders from our website, <a href="https://thecanadafoods.com" target="_blank">https://thecanadafoods.com</a>. This policy applies to all purchases made through our online platform and aims to ensure a smooth, efficient, and hassle-free delivery experience.</p>
      
        <h4 class="mt-4">1. Order Processing and Shipping</h4>
        <ul>
          <li><strong>Processing:</strong> Our order processing time is 2–3 business days.</li>
        </ul>
        <p>
          <em>Processing refers to the entire process from the moment an order is placed until it is prepared and handed over to the shipping carrier. It includes receiving the order, processing it, packaging the items, and ensuring they are ready for shipment. Processing time is distinct from shipping time, which is the duration it takes for the shipped items to be delivered to the customer's address after leaving the fulfillment center.</em>
        </p>
      
        <ul>
          <li><strong>Tracking Your Order:</strong> Once your order is dispatched, we will provide a tracking number. This enables you to monitor the delivery status and estimated arrival of your purchase.</li>
          <li><strong>Shipping Charges:</strong> Shipping costs are calculated based on the weight of the order and the delivery location. All applicable shipping charges will be clearly displayed at checkout before you confirm your purchase.</li>
          <li><strong>Serviceable Countries:</strong> We currently provide shipping services exclusively to customers located in the United States of America (USA).</li>
        </ul>
      
        <p><em>Orders placed with shipping addresses outside these countries will not be processed. We reserve the right to cancel such orders at our sole discretion. If an order is inadvertently placed for an unserviceable location, a full refund will be issued for the purchase amount.</em></p>
      
        <ul>
          <li><strong>Shipping Requirements:</strong>
            <ul>
              <li>Accurate Address: The shipping address must be provided accurately and exclusively in Latin characters. It is the customer's responsibility to ensure that the address is correct.</li>
            </ul>
          </li>
        </ul>
      
        <h5 class="mt-4">What Happens If My Order Is Delayed?</h5>
        <p>If delivery is delayed for any reason, we will let you know as soon as possible and will advise you of a revised estimated date for delivery.</p>
      
        <h5 class="mt-4">I entered the wrong address at the time of checkout. Can I change it?</h5>
        <p>If the order is still in the processing phase, then we can still change it. Please contact us at <a href="mailto:support@thecanadafoods.com">support@thecanadafoods.com</a> as soon as possible. However, if the order is already shipped, then we can’t do anything in that case.</p>
      
        <h5 class="mt-4">My order should be here by now, but I still don't have it. What should I do?</h5>
        <p>Before getting in touch with us, please help us out by doing the following:</p>
        <ul>
          <li>Check your shipping confirmation email for any mistakes in the delivery address.</li>
          <li>Ask your local post office if they have your package.</li>
          <li>Stop by your neighbors in case the courier left the package with them.</li>
        </ul>
        <p>If the shipping address was correct, and the package wasn't left at the post office or at your neighbor’s, get in touch with us at <a href="mailto:support@thecanadafoods.com">support@thecanadafoods.com</a> with your order number.</p>
        <p>If you did find a mistake in your delivery address, we can send you a replacement order, but shipping will be at your own cost.</p>
      
        <p><strong>Please note:</strong></p>
        <ul>
          <li>Any unclaimed package will be returned back to us. And, you will be liable for the cost of a reshipment.</li>
          <li>It is recommended that customers provide a secure delivery address, such as their home or place of employment, to prevent lost or stolen parcels.</li>
        </ul>
      
        <h5 class="mt-4">How do I track my order?</h5>
        <p>You’ll receive a tracking link via email when your order ships out. If you have any questions about your tracking or shipment, drop us a line at <a href="mailto:support@thecanadafoods.com">support@thecanadafoods.com</a>.</p>
      
        <h4 class="mt-5">2. Disclaimer</h4>
        <ul>
          <li>We reserve the right to exercise discretion and may choose not to process or ship any order.</li>
          <li>We do not offer shipping to multiple locations per order.</li>
          <li>All orders are processed and shipped on business days, excluding weekends and holidays.</li>
          <li>For security reasons, we do not deliver to incomplete recipient information or unidentifiable addresses.</li>
          <li>The Canada Foods is not liable for shipping or delivery delays caused by natural or uncontrollable events.</li>
          <li>We are not responsible for courier-related delays, such as customs clearance, as they are beyond our control.</li>
          <li>Transit time does not include Saturdays, Sundays, or holidays.</li>
        </ul>
      
        <h4 class="mt-5">3. Questions</h4>
        <p>If you have any questions concerning our shipping policy, please contact us at: <a href="mailto:support@thecanadafoods.com">support@thecanadafoods.com</a>.</p>
      </div>
      </div>
      </div>
      </div>
</section>


@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush