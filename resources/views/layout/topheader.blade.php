<div class="header py-2 bodyBg">
   <div class="container">
      <div class="row">

         <!-- FULL FLEX WRAPPER -->
         <div class="d-flex align-items-center justify-content-between w-100">

            <!-- Desktop Logo -->
            <div class="col-lg-2 py-3 d-none d-lg-block">
               <a href="https://khut.shop/">
                  <img src="{{asset('/images/khut-text.png')}}" class="img-fluid" alt="khut text" style="width:120px">
               </a>
            </div>

            <!-- Mobile Logo -->
            <div class="col-auto d-lg-none">
               <a href="https://khut.shop/"> <img src="{{asset('/images/top-logo.png')}}" class="img-fluid" alt="logo" width="55px" style="    margin-bottom: 10px;"></a>
            </div>

            <div class="d-none d-lg-flex justify-content-center py-1 w-100">
               <a href="https://khut.shop/">
                  <img src="{{asset('/images/top-logo.png')}}" class="img-fluid" alt="khut text" style="width:80px; ">
               </a>
            </div>

            <!-- SEARCH + ICONS (RIGHT SIDE) -->
            <div class="col d-flex align-items-center justify-content-end search-box mt-4" id="searchBox">

               <!-- SEARCH ICON -->
               <button id="searchIcon" class="border-0 bg-transparent search-icon mr-1 hideIconSize">
                  <i class="fas fa-search fa-lg"></i>
               </button>

               <!-- CART -->
               <div class="position-relative me-2 hideIcon">
                  <button id="cartBtn" class="wish-btn btn p-0 border-0 bg-transparent">
                     <i class="fas fa-shopping-cart fa-lg"></i>
                  </button>
                  <span id="cartCount"
                     class="cart-count badge position-absolute top-0 start-100 translate-middle count-bg-none"
                     style="color:#333!important;">0</span>
               </div>

               <!-- WISHLIST -->
               <div class="position-relative me-2 hideIcon">
                  <a href="{{ route('wishlist.page') }}" class="">
                     <i class="far fa-heart fa-lg"></i>
                     <span class="wishlist-count position-absolute top-0 start-100 translate-middle badge count-bg-none">0</span>
                  </a>
                  <!--button class="wish-btn btn p-0 border-0 bg-transparent">
                     <i class="far fa-heart fa-lg"></i>
                  </button>
                  <span id="wishlistCount"
                     class="wishlist-count position-absolute top-0 start-100 translate-middle badge count-bg-none">0</span-->
               </div>

               <!-- LOGIN -->
               <a href="{{ route('customer.login') }}"
                  class="border-0 bg-transparent hideIcon search-icon mr-1 hideIconSize"
                  style="color:#212529">
                  <i class="fas fa-user" style="font-size: 22px;"></i>
               </a>

               <!-- MENU ICON -->
               <img id="openMenu" src="{{asset('/images/app.png')}}" class="menuIconBar ms-2" alt="menu">

               <!-- SEARCH INPUT -->
               <div class="ms-2">
                  <input type="text" class="search-input" id="searchInput" placeholder="Search..." style="display:none;">
               </div>

               <!-- SEARCH RESULTS -->
               <div id="searchResults"
                  style="display:none; position:absolute; background:#fff; border:1px solid #ddd; width:250px; max-height:300px; overflow-y:auto; z-index:9999;">
               </div>

            </div>
            <!-- END RIGHT SIDE -->

         </div>
         <!-- END FLEX -->

      </div>
   </div>
</div>

     
      <nav class="navbar navbar-expand-sm sticky-top navbar-light" style="margin-top: -7px; margin-bottom: -7px;">
          <div class="ribon d-flex justify-content-between align-items-center ribotTOP">
            <div class="clr"></div>
           
            <!-- Language Switch Button -->
            <!--div class="container">
                <div class="d-flex justify-content-end custom-menu">
                    <button class="btn btn-sm"  onclick="setLanguage('en')">EN</button>
                    <button class="btn btn-sm " onclick="switchLanguage('fr')">FR</button>
                </div>
            </div-->
          </div>
        </nav>
        
       

   




