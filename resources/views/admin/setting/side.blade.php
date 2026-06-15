

<div class="nav flex-column nav-tabs h-100" role="tablist" aria-orientation="vertical">
    <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="{{route('admin.settings')}}">Home</a>
    <a class="nav-link {{ (request()->is('admin/settings/seo-list') || request()->is('admin/settings/seo') || request()->is('admin/settings/seo/*')) ? 'active' : '' }}" href="{{route('admin.settings.seo.list')}}">SEO Pages</a>
    <a class="nav-link {{ (request()->is('admin/settings/social')) ? 'active' : '' }}" href="{{route('admin.settings.social')}}">Social</a>
    <a class="nav-link {{ (request()->is('admin/settings/marketing-facebook')) ? 'active' : '' }}" href="{{route('admin.settings.marketing.facebook')}}">Facebook Marketing</a>
    <a class="nav-link {{ (request()->is('admin/settings/payments')) ? 'active' : '' }}" href="{{route('admin.settings.payments')}}">Payment Methods</a>
    <a class="nav-link {{ (request()->is('admin/settings/accounting')) ? 'active' : '' }}" href="{{route('admin.settings.accounting')}}">Accounting</a>

    
    <!-- <a class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}" href="{{route('admin.settings')}}">Settings</a> -->
</div>


<!-- <ul class="nav flex-column" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{route('profile')}}" ><i class="fi-rs-settings-sliders mr-10"></i>Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('change-password') ? 'active' : '' }}" href="{{route('change.password')}}" ><i class="fi-rs-key mr-10"></i>Change Password</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('orders') || request()->is('order') || request()->is('order/*')) ? 'active' : '' }}" href="{{route('orders')}}"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('addresses') || request()->is('address') || request()->is('address/*')) ? 'active' : '' }}" href="{{route('addresses')}}"><i class="fi-rs-marker mr-10"></i>My Addresses</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{route('logout')}}"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
    </li>
</ul>-->