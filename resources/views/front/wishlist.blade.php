@extends('front.layouts.app')

@section('content')


<!--breadcrumb section start-->
<div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50">
    @include('front.layouts.breadcrumb-image')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="mb-2 text-center">Wishlist</h2>
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item fw-bold" aria-current="page"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item fw-bold" aria-current="page">Wishlist</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!--breadcrumb section end-->


<!--wishlist section start-->
<section class="wishlist-section ptb-80">
    <div class="container">
        <div class="row">

            @if(count($wishlist) > 0)
                    
            <div class="col-12">
                <div class="wishlist-table bg-white">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>

                          
                        @foreach($wishlist as $wishlistSingle)

                            <tr>
                                <td class="text-center thumbnail">

                                    @if($wishlistSingle->is_variant && $wishlistSingle->attribute)
                                        <img class="img-fluid" src="{{ asset('storage/products/') }}/{{$wishlistSingle->product_id}}/{{$wishlistSingle->attribute->image}}" alt="{{$wishlistSingle->name}}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('storage/products/') }}/{{$wishlistSingle->product_id}}/{{$wishlistSingle->image}}" alt="{{$wishlistSingle->name}}">    
                                    @endif

                                </td>
                                <td class="text-center">
                                    {{-- <span class="fw-bold text-secondary fs-xs">Vegetable</span> --}}
                                    <a href="{{route('product', $wishlistSingle->slug)}}"><h6 class="mb-1 mt-1">{{$wishlistSingle->name}}</h6></a>

                                    @if($wishlistSingle->is_variant && $wishlistSingle->attribute)
                                        @if(isset($wishlistSingle->attribute->details))
                                            <p class="">
                                                @foreach($wishlistSingle->attribute->details as $detail)
                                                    <span class="badge text-dark ps-0 pe-1">{{$detail->attribute_name}}: {{$detail->attribute_option_name}}</span>
                                                @endforeach
                                            </p>
                                        @endif
                                    @endif

                                </td>
                                <td class="text-center">
                                    <span class="price fw-bold text-dark">{{$wishlistSingle->productPriceShow()}}</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-secondary btn-sm ms-5 rounded-1 add-cart" data-key="{{$wishlistSingle->slug}}" data-attribute="{{$wishlistSingle->product_attribute_id}}" data-page="wishlist">Add to Cart</a>
                                    
                                </td>
                                <td class="text-end">
                                    <a href="#" class="close-btn ms-3 remove-wishlist" data-key="{{$wishlistSingle->slug}}" data-attribute="{{$wishlistSingle->product_attribute_id}}"><i class="fas fa-close"></i></a>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <div class="col-12">
                    <p class="my-3 text-center"> Wishlist is Empty</p>
                </div>
            @endif
        </div>
    </div>
</section>
<!--wishlist section end-->

        
@endsection