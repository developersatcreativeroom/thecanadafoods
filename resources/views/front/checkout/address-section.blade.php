{{-- <div class="d-flex justify-content-between">
    
    <a href="#" data-bs-toggle="modal" data-bs-target="#addAddressModal" class="fw-semibold"><i
            class="fas fa-plus me-1"></i> Add Address</a>
</div> --}}

                    <!--add address modal start-->
            <!-- Modal -->
            <div class="modal fade" id="addAddressModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>

                            <div class="gstore-product-quick-view bg-white rounded-3 py-6 px-4">
                                <h2 class="modal-title fs-5 mb-3">Add New Address</h2>
                                <div class="row align-items-center g-4 mt-3">
                                    <form action="#">
                                        <div class="row g-4">
                                            <div class="col-sm-6">
                                                <div class="label-input-field">
                                                    <label>First Name</label>
                                                    <input type="text" placeholder="Saiful">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="label-input-field">
                                                    <label>Last Name</label>
                                                    <input type="text" placeholder="Talukdar">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="label-input-field">
                                                    <label>Street Address</label>
                                                    <input type="text"
                                                        placeholder="Mountain View, California, United States">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="label-input-field">
                                                    <label>Mobile</label>
                                                    <input type="tel" placeholder="Phone Number">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="label-input-field">
                                                    <label>Email</label>
                                                    <input type="email" placeholder="Your Email">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="label-input-field">
                                                    <label>Apt Number</label>
                                                    <input type="text" placeholder="Apart Number">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="label-input-field">
                                                    <label>State</label>
                                                    <input type="text" placeholder="Dhaka">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="label-input-field">
                                                    <label>Zip Code</label>
                                                    <input type="text" placeholder="Dhaka-1230">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 d-flex">
                                            <button type="submit" class="btn btn-secondary btn-md me-3">Use this
                                                Address</button>
                                            <button type="submit"
                                                class="btn btn-outline-secondary border-secondary btn-md">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--add address modal end-->




            




@if(count($addresses) > 0)
                            
    @if(count((array)$addressBilling) > 0)
        
        <div class="row">
        
            <div class="col-lg-6">
                <div class="mb-10">
                    <h4 class="mb-5 mt-5">Billing Details</h4>
                </div>


                <div class="tt-address-content">
                    <div class="tt-address-info bg-white rounded p-5 position-relative">
                        <strong>{{$addressBilling->first_name}} {{$addressBilling->last_name}} </strong>

                        @if($addressBilling->company_name != null)
                            <p class="mb-2"><span class="fw-bold mb-1">Company:</span> {{$addressBilling->company_name}}</p>
                        @else
                            <br>
                            <br>
                        @endif

                        <p class="mb-0"><span class="fw-bold mb-1">Email:</span> {{$addressBilling->email}}</p>

                        <p><span class="fw-bold mb-1">Phone:</span> +{{$addressBilling->country_code}}-{{$addressBilling->phone}}</p>
                        
                        <address class="fs-sm mb-0">
                            {{$addressBilling->address_line_1}} {{$addressBilling->address_line_2}} {{$addressBilling->street}}<br> 
                            {{$addressBilling->city}}, {{$addressBilling->state}}, {{$addressBilling->postal}}
                            <br>
                            {{$addressBilling->country}}
                        </address>
                        <a href="#" class="tt-edit-address checkout-radio-link position-absolute change-address" data-type="billing">Change Billing</a>

                    </div>
                </div>



                
            </div>

            <div class="col-lg-6">

                <div id="shipping-user-address">

                    @if(count((array)$addressShipping) > 0)
                        <div class="mb-10">
                            <h4 class="mb-5 mt-5">Shipping Details</h4>
                        </div>
                    @endif


                    <div class="tt-address-content">
                        <div class="tt-address-info bg-white rounded p-5 position-relative">
                            <strong>{{$addressShipping->first_name}} {{$addressShipping->last_name}} </strong>
    
                            @if($addressShipping->company_name != null)
                                <p class="mb-2"><span class="fw-bold mb-1">Company:</span> {{$addressShipping->company_name}}</p>
                            @else
                                <br>
                                <br>
                            @endif
    
                            <p class="mb-0"><span class="fw-bold mb-1">Email:</span> {{$addressShipping->email}}</p>
    
                            <p><span class="fw-bold mb-1">Phone:</span> +{{$addressShipping->country_code}}-{{$addressShipping->phone}}</p>
                            
                            <address class="fs-sm mb-0">
                                {{$addressShipping->address_line_1}} {{$addressShipping->address_line_2}} {{$addressShipping->street}}<br> 
                                {{$addressShipping->city}}, {{$addressShipping->state}}, {{$addressShipping->postal}}
                                <br>
                                {{$addressShipping->country}}
                            </address>
                            <a href="#" class="tt-edit-address checkout-radio-link position-absolute change-address" data-type="shipping">Change Shipping</a>
    
                        </div>
                    </div>
                    
                </div>
                
            </div>
        
        </div>
    @endif

@else
<div class="my-10">
    
    <a href="#" class="btn btn-sm btn-primary fw-semibold" id="add-address-modal"><i class="fas fa-plus me-1"></i> Add Address</a>

    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#addAddressModal" class="fw-semibold"><i
        class="fas fa-plus me-1"></i> Add Address</a> --}}

</div>
@endif