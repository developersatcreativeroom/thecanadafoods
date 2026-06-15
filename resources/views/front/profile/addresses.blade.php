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

                    <div class="tab-pane fade show active" id="addresses">
                        <div class="address-book bg-white rounded p-5">
                            




                                @if(count($addresses) > 0)
                                    <div class="row g-5">
                                        @foreach($addresses as $address)

                                        <div class="col-md-6 align-self-end">
                                            <div class="address-book-content ps-md-4">
                                                <p class="text-uppercase fw-medium mb-3">
                                                    <a href="#" class="btn-small set-default-address" data-key="{{$address->id}}" data-is-default="{{$address->is_default}}" >{{$address->is_default ? 'Default' : 'Set Default'}}</a>
                                                </p>
                                                <a href="{{route('address.edit',$address->id)}}" class="btn-small">Edit</a>
                                                <div class="address">
                                                    @if($address->company_name != null)
                                                        <p class="mb-2"><span class="text-dark fw-bold mb-1">Company:</span> {{$address->company_name}}</p>
                                                    @else
                                                        <br>
                                                    @endif

                                                    <p class="text-dark fw-bold mb-1">{{$address->first_name}} {{$address->last_name}}</p>

                                                    <p class="mb-0"><span class="text-dark fw-bold mb-1">Email:</span> {{$address->email}}</p>

                                                    <p><span class="text-dark fw-bold mb-1">Phone:</span> +{{$address->country_code}}-{{$address->phone}}</p>

                                                    <p class="mb-0">
                                                        {{$address->address_line_1}} 
                                                        {{$address->address_line_2}} {{$address->street}}<br> 
                                                        {{$address->city}}, {{$address->state}}, {{$address->postal}}
                                                        <br>
                                                        {{$address->country}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @endforeach
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary mt-10" href="{{route('address')}}">Add Address</a>
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