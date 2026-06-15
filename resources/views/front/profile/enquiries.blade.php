@extends('front.layouts.app')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{route('home')}}" rel="nofollow">Home</a>
            <span></span> Pages
            <span></span> Account
        </div>
    </div>
</div>
<section class="pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-menu">
                            @include('front.profile.side')
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content dashboard-content">
                        
                            
                        <div class="tab-pane fade active show" id="enquiries" role="tabpanel" aria-labelledby="enquiries-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Your Enquiries</h5>
                                            </div>
                                            <div class="card-body">
                                                @if(count($enquiries) > 0)
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Enquiry #</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($enquiries as $enquiry)
                                                            <tr>
                                                                <td>#{{$enquiry->enquiry_no}}</td>
                                                                <td>{{$enquiry->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                                                                <td>{{$enquiry->enquiry_status}}</td>
                                                                <td>{{$enquiry->amountWithItems()}}</td>
                                                                <td><a href="{{route('enquiry',$enquiry->enquiry_unique_id)}}" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            @endforeach
                                                         
                                                        </tbody>
                                                    </table>
                                                </div>

                                                @else
                                                <p class="text-center my-3">No Enquiries placed yet. </p>
                                                @endif
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