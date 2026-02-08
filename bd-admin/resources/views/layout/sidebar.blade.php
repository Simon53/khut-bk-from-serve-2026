 <nav class="sidebar sidebar-offcanvas" id="sidebar">
    
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <img src="{{ asset('images/logo.png') }}" alt="Logo" width="60">
        </div>
       @php
          $user = session('user');
          $role = $user['role'] ?? '';
      @endphp

        <ul class="nav">
        
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('/')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('orders.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-format-line-spacing"></i>
              </span>
              <span class="menu-title">Orders</span>
            </a>
          </li>
          @if($role == 'Administrator')
           <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('user.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Create User</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('/visitor')}}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Visitor</span>
            </a>
          </li>
         <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('customer.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Customer List</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-pages" aria-expanded="false" aria-controls="ui-pages">
              <span class="menu-icon">
                <i class="mdi mdi-book-open-page-variant"></i>
              </span>
              <span class="menu-title">General Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-pages">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="{{ route('site.menus.index') }}"><i class="mdi mdi-comment-plus-outline"></i> &nbsp; Create Menu</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{ route('site-pages.create') }}"> <i class="mdi mdi-comment-plus-outline"></i> &nbsp; Create Page</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{ route('site-pages.list') }}"> <i class="mdi mdi-comment-plus-outline"></i> &nbsp; Page List </a></li>
                </ul>
            </div>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('khut-stories.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Khut Story</span>
            </a>
          </li>
          
           @endif
           @if(in_array($role, ['Administrator', 'Moderator']))
           <li class="nav-item menu-items">
            <a class="nav-link" href="{{url('/slider')}}">
              <span class="menu-icon">
                <i class="mdi mdi-file-image"></i>
              </span>
              <span class="menu-title">Slider</span>
            </a>
          </li>
           <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
              </span>
              <span class="menu-title">Settiings</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{url('/media-gallery')}}"><i class="mdi mdi-file-image"></i> &nbsp; Gallery</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/menu')}}"> <i class="mdi mdi-menu"></i> &nbsp;Set Category Menu</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/category-banner')}}"> <i class="mdi mdi-format-color-fill"></i> &nbsp; Set Category Banner</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/color')}}"> <i class="mdi mdi-format-color-fill"></i> &nbsp; Set Color</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/body-size')}}"> <i class="mdi mdi-scale"></i> &nbsp;Set Bosy Size</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/common-size')}}"> <i class="mdi mdi-relative-scale"></i> &nbsp;Set Common Size</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/status-page')}}"> <i class="mdi mdi-fan"></i> &nbsp;Set Wash</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/dry-wash-page')}}"> <i class="mdi mdi-fan"></i> &nbsp;Set Dry Wash</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/iron')}}"> <i class="mdi mdi-fan"></i> &nbsp;Set Iron</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-product" aria-expanded="false" aria-controls="ui-product">
              <span class="menu-icon">
                <i class="mdi mdi-package-variant"></i>
              </span>
              <span class="menu-title">Product</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-product">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{url('/add-new-product')}}"><i class="mdi mdi-message-plus"></i> &nbsp; Add New Product</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{url('/product-list')}}"> <i class="mdi mdi-view-list"></i> &nbsp; Product List</a></li>
              </ul>
            </div>
          </li>
           @endif
        </ul>
    </nav>