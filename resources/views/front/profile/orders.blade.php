@extends('front.layouts.app')

@section('content')


<section class="my-account pt-6 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3">
                @include('front.profile.side')
            </div>
            <div class="col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">

                        <div class="recent-orders bg-white rounded py-5">
                            <h6 class="mb-4 px-4">Your Orders</h6>
                            @if(count($orders) > 0)
                                <div class="table-responsive">
                                    <table class="order-history-table table">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th style="width: 200px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>#{{$order->order_no}}</td>
                                                <td>{{$order->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                                                <td>{{$order->order_status}}</td>
                                                <td>{{$order->amountWithItems()}}</td>
                                                <td><a href="{{route('order',$order->order_unique_id)}}" class="btn btn-primary btn-sm">View</a><a target="_blank" href="{{route('order.invoice',$order->order_unique_id)}}" class="btn btn-secondary btn-sm ms-1">Invoice</a></td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>

                            @else
                                <p class="text-center my-3">No orders placed yet. </p>
                            @endif
                            
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