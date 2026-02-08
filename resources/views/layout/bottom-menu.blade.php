    <div class="bottom-nav-mobile">
          <a href="https://khut.shop/">
            <i class="fas fa-home"></i>
            <span>Home</span>
          </a>
          <a href="{{ route('shop.index') }}">
            <i class="fas fa-shopping-bag"></i>
            <span>Shop</span>
          </a>
          <a href="#" class="nav-item-with-badge">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount" class="badge-count cart-count" style="background-color: transparent; color: #333!important; font-size: 12px!important;">0</span>
            <span>Cart</span>
          </a>
          <a href="{{ route('wishlist.page') }}" class="nav-item-with-badge">
            <i class="fas fa-heart"></i>
            <span  id="wishlistCount" class="badge-count wishlist-count" style="background-color: transparent; color: #333!important; font-size: 12px!important;">0</span>
            <span>Wishlist</span>
          </a>
          <a href="{{ route('customer.login') }}">
            <i class="fas fa-user"></i>
            <span>Account</span>
          </a>
      </div>
      <!-- Bottom Menu -->
      <nav class="bottom-nav bottom-nav-desktop" id="bottomNav">
         <div class="d-flex flex-wrap justify-content-center bottomMenu">
            @foreach($mainMenus as $menu)
               <div>
                  @php
                     $displayName = $menu->name;
                     if ($menu->name === 'Hojoborolo') {
                        $displayName = 'Ho-Jo-Bo-Ro-Lo';
                     }
                  @endphp

                  @if(strtolower($menu->name) === 'patchwork')
                     <a href="{{ route('home.patchwork') }}">{{ $displayName }}</a>
                  @elseif(strtolower($menu->name) === 'new arrivals')
                     <a href="{{ route('home.new-arrivals') }}">{{ $displayName }}</a>
                  @else
                     <a href="{{ route('category.list', str_replace(' ', '-', $menu->name)) }}">{{ $displayName }}</a>
                  @endif
               </div>
            @endforeach
         </div>
      </nav>
      <!-- Slide-In Menu -->
      <div class="slide-menu" id="slideMenu" style="overflow-y: scroll;">
         <div class="d-flex  justify-content-center">
            <div class="p-2 bd-highlight">
               <img src="{{asset('/images/top-logo.png')}}" class="" alt="..." style="width:40px;">
            </div>
            <!--div class="p-2 bd-highlight">
               <img src="{{asset('/images/khut-text.png')}}" class=" m-1" alt="..." style="width:40px;">
            </div-->
         </div>
       <ul>
         @foreach($mainMenus as $menu)
            <li>
                  @if(strtolower($menu->name) === 'Patchwork')
                        <a href="{{ route('home.patchwork') }}">{{ $menu->name }}</a>
                   @elseif(strtolower($menu->name) === 'New Arrivals')
                      <a href="{{ route('home.new-arrivals') }}">{{ $menu->name }}</a>
                  @else
                        <a href="{{ route('category.list', str_replace(' ', '-', $menu->name)) }}">{{ $menu->name }}</a>
                  @endif
            </li>
         @endforeach
      </ul>
        
         
         <div class="p-2 bd-highlight joinUs justify-content-center for-mobile-socail" style="margin-left: 6%;">
            <h2 class="joinUs" >Join Us</h2>
            <a href="https://www.facebook.com/khut.art" target="_blank"><img src="{{asset('/images/facebook.png')}}" class="img-fluid p-1 mobile-media-icon" alt="..."></a>
            <a href="https://www.instagram.com/khut.art?igsh=MXR1azV1d24zNnk2NQ%3D%3D" target="_blank"><img src="{{asset('/images/istagram.png')}}" class="img-fluid p-1 mobile-media-icon" alt="..."></a>
            <!--a href="https://www.youtube.com/@khutart" target="_blank"><img src="{{asset('/images/youtube.png')}}" class="img-fluid p-1 mobile-media-icon" alt="..."></a-->
         </div>
         
      </div>
      <!-- Overlay -->
      <div class="overlay" id="overlay"></div>
      <!-- Cart Icon Button -->
      
      <div class="cart-icon-wrapper" id="openCart" style="cursor:pointer;">
            <i class="fas fa-shopping-cart fa-lg cart-icon" style="font-size: 1.5em!important; color:#790101!important; vertical-align: -.08em!important;"></i>
            <span id="cartCount" class="cart-count">0</span>
       </div>
      <!-- Cart Sidebar -->
     <div id="cartSidebar" class="cart-sidebar">
    <div class=" d-flex" >
        <!--button id="closeCart" class="close-btn">×</button-->
         <!--h3 class="justify-content-center">
            <img src="{{ asset('/images/mycart.png') }}" alt="Cart"-->
            
         </h3-->
    </div>

    <div class="cart-body custom-link text-center">
        <ul id="cartList"></ul>
        <p>Total Items: <span id="cartItems">0</span></p>
        <p>Total Price: BDT <span id="cartTotal">0</span></p>
        <a id="returnShop" href="{{ route('shop.index') }}" style="display:none; width:100%">Return to Shop</a>
    </div>

    <button id="checkoutBtn" class="btn btn-primary checkout-Btn w-100" data-url="{{ route('checkout.index') }}">
        Checkout 
    </button>
    
  
</div>

      <!-- Overlay -->
      <div id="cartOverlay" class="cart-overlay"></div>
      <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>