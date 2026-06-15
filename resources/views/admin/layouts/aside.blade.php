
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin')}}" class="brand-link text-center p-0">
      <img src="{{App\Helper::getDarkLogo()}}" alt="Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::guard('admin')->user()->image != '' ? asset('storage/admin/profile/').'/'.Auth::guard('admin')->user()->image : asset('backend/img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      @php
        $admin = Auth::guard('admin')->user();
        if($admin->level == 1 && $admin->role->permission != 'null'){
          //$section = json_decode(Auth::guard('admin')->user()->role->permission,true);
          $section = unserialize(Auth::guard('admin')->user()->role->permission);
        }else{
          $section = [];
        }
        
        // print '<pre>'; print_r($admin->role->toArray()); die;
        // print '<pre>'; print_r($section); die;

        $config = App\Helper::getWebsiteConfig();

      @endphp

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <!-- <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a> -->
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                  <i class="fas fa-home nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              @if ((is_array($section) && in_array('users',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.users')}}" class="nav-link {{ (request()->is('admin/users')) ? 'active' : '' }}">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('attributes',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.attributes')}}" class="nav-link {{ (request()->is('admin/attributes')  || request()->is('admin/attribute') || request()->is('admin/attribute/*')) ? 'active' : '' }}">
                  <i class="fa fa-anchor nav-icon"></i>
                  <p>Attributes</p>
                </a>
              </li>
              @endif 
              @if ((is_array($section) && in_array('products',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.categories')}}" class="nav-link {{ (request()->is('admin/categories') || request()->is('admin/category') || request()->is('admin/category/*')) ? 'active' : '' }}">
                  <i class="fa fa-list-alt nav-icon"></i>
                  <p>Product Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.products')}}" class="nav-link {{ (request()->is('admin/products') || request()->is('admin/product') || request()->is('admin/product/*')) ? 'active' : '' }}">
                  <i class="fas fa-tag nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              
                {{-- @if($config['product_services'])
                <li class="nav-item">
                  <a href="{{route('admin.product.services')}}" class="nav-link {{ (request()->is('admin/services') || request()->is('admin/service') || request()->is('admin/service/*')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product Services</p>
                  </a>
                </li>
                @endif --}}
              @endif

              {{-- <li class="nav-item">
                <a href="{{route('admin.product.addons')}}" class="nav-link {{ (request()->is('admin/addons') || request()->is('admin/addon') || request()->is('admin/addon/*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Addons</p>
                </a>
              </li> --}}
             
              <li class="nav-item">
                <a href="{{route('admin.ratings')}}" class="nav-link {{ (request()->is('admin/ratings') || request()->is('admin/rating') || request()->is('admin/rating/*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product ratings</p>
                </a>
              </li>
              
              {{-- @if ((is_array($section) && in_array('colors',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.colors')}}" class="nav-link {{ (request()->is('admin/colors') || request()->is('admin/color') || request()->is('admin/color/*')) ? 'active' : '' }}">
                  <i class="fas fa-paint-brush nav-icon"></i>
                  <p>Colors</p>
                </a>
              </li>
              @endif --}}
              @if ((is_array($section) && in_array('brands',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.brands')}}" class="nav-link {{ (request()->is('admin/brands') || request()->is('admin/brand') || request()->is('admin/brand/*')) ? 'active' : '' }}">
                  <i class="far fa-copyright nav-icon"></i>
                  <p>Brands</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('taxes',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.taxes')}}" class="nav-link {{ (request()->is('admin/taxes') || request()->is('admin/tax') || request()->is('admin/tax/*')) ? 'active' : '' }}">
                  <i class="fas fa-file-invoice-dollar nav-icon"></i>
                  <p>Taxes</p>
                </a>
              </li>
              @endif
              @if(!$config['is_enquiry_website'])
               @if($config['coupon'])
                  @if ((is_array($section) && in_array('coupons',$section)) || $admin->level == 0)
                  <li class="nav-item">
                    <a href="{{route('admin.coupons')}}" class="nav-link {{ (request()->is('admin/coupons') || request()->is('admin/coupon') || request()->is('admin/coupon/*')) ? 'active' : '' }}">
                      <i class="fa fa-gift nav-icon"></i>
                      <p>Coupons</p>
                    </a>
                  </li>
                  @endif
                @endif
             
                @if ((is_array($section) && in_array('orders',$section)) || $admin->level == 0)
                <li class="nav-item">
                  <a href="{{route('admin.orders')}}" class="nav-link {{ (request()->is('admin/orders') || request()->is('admin/order') || request()->is('admin/order/*')) ? 'active' : '' }}">
                    <i class="fas fa-cart-arrow-down nav-icon"></i>
                    <p>Orders</p>
                  </a>
                </li>
                @endif
                @if ((is_array($section) && in_array('payments',$section)) || $admin->level == 0)
                <li class="nav-item">
                  <a href="{{route('admin.payments')}}" class="nav-link {{ (request()->is('admin/payments') || request()->is('admin/payment') || request()->is('admin/payment/*')) ? 'active' : '' }}">
                    <i class="fas fa-money-bill-alt nav-icon"></i>
                    <p>Payments</p>
                  </a>
                </li>
                @endif
              @else
                @if ((is_array($section) && in_array('enquiries',$section)) || $admin->level == 0)
                  <li class="nav-item">
                    <a href="{{route('admin.enquiries')}}" class="nav-link {{ (request()->is('admin/enquiries') || request()->is('admin/enquiry') || request()->is('admin/enquiry/*')) ? 'active' : '' }}">
                      <i class="fas fa-question-circle nav-icon"></i>
                      <p>Enquiries</p>
                    </a>
                  </li>
                @endif
              @endif 
              @if ((is_array($section) && in_array('inventory',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.inventory')}}" class="nav-link {{ (request()->is('admin/inventory') ) ? 'active' : '' }}">
                  <i class="fas fa-calculator nav-icon"></i>
                  <p>Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.inventory.add')}}" class="nav-link {{ (request()->is('admin/inventory-add') ) ? 'active' : '' }}">
                  <i class="far fa-plus-square nav-icon"></i>
                  <p>Inventory Add</p>
                </a>
              </li>
              @endif

              <li class="nav-item">
                <a href="{{route('admin.config')}}" class="nav-link {{ (request()->is('admin/config') ) ? 'active' : '' }}">
                  <i class="fas fa-wrench nav-icon"></i>
                  <p>Configuration</p>
                </a>
              </li>
              @if ((is_array($section) && in_array('banners',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.banners')}}" class="nav-link {{ (request()->is('admin/banners') || request()->is('admin/banner') || request()->is('admin/banner/*')) ? 'active' : '' }}">
                  <i class="fas fa-image nav-icon"></i>
                  <p>Banners</p>
                </a>
              </li>
              @endif
              
              @if ((is_array($section) && in_array('blog',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.blog.categories')}}" class="nav-link {{ (request()->is('admin/blog-categories') || request()->is('admin/blog-category') || request()->is('admin/blog-category/*')) ? 'active' : '' }}">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Blog Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.blogs')}}" class="nav-link {{ (request()->is('admin/blogs') || request()->is('admin/blog') || request()->is('admin/blog/*')) ? 'active' : '' }}">
                  <i class="fas fa-blog nav-icon"></i>
                  <p>Blogs</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('faq',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.faqs')}}" class="nav-link {{ (request()->is('admin/faqs') || request()->is('admin/faq') || request()->is('admin/faq/*')) ? 'active' : '' }}">
                  <i class="fas fa-question nav-icon"></i>
                  <p>FAQs</p>
                </a>
              </li>
              @endif
              {{--
              @if ((is_array($section) && in_array('videos',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.videos')}}" class="nav-link {{ (request()->is('admin/videos') || request()->is('admin/video') || request()->is('admin/videos/*')) ? 'active' : '' }}">
                  <i class="fas fa-video nav-icon"></i>
                  <p>Videos</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('pages',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.pages')}}" class="nav-link {{ (request()->is('admin/pages') || request()->is('admin/page') || request()->is('admin/page/*')) ? 'active' : '' }}">
                  <i class="fas fa-book nav-icon "></i>
                  <p>Pages</p>
                </a>
              </li>
              @endif --}}
              {{-- <li class="nav-item">
                <a href="{{route('admin.sales')}}" class="nav-link {{ (request()->is('admin/sales')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales</p>
                </a>
              </li> --}}
              {{-- @if ((is_array($section) && in_array('testimonials',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.testimonials')}}" class="nav-link {{ (request()->is('admin/testimonials') || request()->is('admin/testimonial') || request()->is('admin/testimonial/*')) ? 'active' : '' }}">
                  <i class="fas fa-quote-left nav-icon"></i>
                  <p>Testimonials</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('gallery',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.gallery')}}" class="nav-link {{ (request()->is('admin/gallery') || request()->is('admin/gallery-single') || request()->is('admin/gallery-single/*')) ? 'active' : '' }}">
                  <i class="fas fa-image nav-icon"></i>
                  <p>Gallery</p>
                </a>
              </li>
              @endif

              @if ($admin->level == 0)
                <li class="nav-item">
                  <a href="{{route('admin.sub.users')}}" class="nav-link {{ (request()->is('admin/admin-sub-users') || request()->is('admin/admin-sub-user') || request()->is('admin/admin-sub-user/*')) ? 'active' : '' }}">
                    <i class="fas fa-user-circle nav-icon"></i>
                    <p>Sub Admin Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.permissions')}}" class="nav-link {{ (request()->is('admin/permissions') || request()->is('admin/permission') || request()->is('admin/permission/*')) ? 'active' : '' }}">
                    <i class="fas fa-lock nav-icon"></i>
                    <p>Permissions</p>
                  </a>
                </li>
              @endif
               --}}
              @if ((is_array($section) && in_array('contact_requests',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.contacts')}}" class="nav-link {{ (request()->is('admin/contacts')) ? 'active' : '' }}">
                  <i class="fas fa-phone-square nav-icon"></i>
                  <p>Contact Requests</p>
                </a>
              </li>
              @endif
              @if ((is_array($section) && in_array('subscription',$section)) || $admin->level == 0)
              <li class="nav-item">
                <a href="{{route('admin.subscriptions')}}" class="nav-link {{ (request()->is('admin/subscriptions')) ? 'active' : '' }}">
                  <i class="far fa-bell nav-icon"></i>
                  <p>Subscriptions</p>
                </a>
              </li>
              @endif
              
            </ul>
          </li>
          

          <li class="nav-item">
            <a href="{{route('admin.logout')}}" class="nav-link">
              <i class="fas fa-sign-out-alt nav-icon text-info"></i>
              <p>Logout</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>