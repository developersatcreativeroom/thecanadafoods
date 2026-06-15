<div class="account-nav bg-white rounded py-5">
    <h6 class="mb-4 px-4">Manage My Account</h6>
    <ul class="nav nav-tabs border-0 d-block account-nav-menu">
        <li>
            <a class="{{ request()->is('profile') ? 'active' : '' }}" href="{{route('profile')}}">
                <span class="me-2">
                    <i class="fa-solid fa-user"></i>
                </span>
                Profile
            </a>
        </li>

        <li>
            <a class="{{ request()->is('change-password') ? 'active' : '' }}"
                href="{{route('change.password')}}">
                <span class="me-2">
                    <i class="fa-solid fa-lock"></i>
                </span>
                Change Password
            </a>
        </li>
    
        @php
        $isEnquiryWebsite = App\Helper::getWebsiteConfig('is_enquiry_website');
        @endphp
        @if($isEnquiryWebsite['is_enquiry_website'])

            <li>
                <a class="{{ (request()->is('enquiries') || request()->is('enquiry') || request()->is('enquiry/*')) ? 'active' : '' }}"
                    href="{{route('enquiries')}}">
                    <span class="me-2">
                        <i class="fa-solid fa-question-circle"></i>
                    </span>
                    Enquiries
                </a>
            </li>

        @else
        
            <li>
                <a class="{{ (request()->is('orders') || request()->is('order') || request()->is('order/*')) ? 'active' : '' }}"
                    href="{{route('orders')}}">
                    <span class="me-2">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                    </span>
                    Orders
                </a>
            </li>
        @endif

        <li>
            <a class="{{ (request()->is('addresses') || request()->is('address') || request()->is('address/*')) ? 'active' : '' }}"
                href="{{route('addresses')}}">
                <span class="me-2">
                    <i class="fa-solid fa-map-marker-alt"></i>
                </span>
                My Addresses
            </a>
        </li>

        <li>
            <a href="{{route('logout')}}">
                <span class="me-2">
                    <i class="fa-solid fa-sign-out"></i>
                </span>
                Logout
            </a>
        </li>

    </ul>
</div>
