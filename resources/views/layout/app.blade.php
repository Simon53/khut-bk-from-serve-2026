<!DOCTYPE html>
<html lang="en">
  @include('layout.header')

   <body class="bodyBg">
      <!-- Header -->
       @include('layout.topheader')

      

      @yield('content')
      


      <!-- Footer -->
      @include('layout.footer')
      @include('layout.bottom-menu')
      
      @yield('script')


      <div id="cartToast" class="cart-toast">
        Product added to cart!
    </div>
   </body>
</html>



<!-- Empty Cart Modal -->
<div class="modal fade" id="emptyCartModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center p-4">

     
      <button type="button" class="close position-absolute" style="right:10px;top:10px;" onclick="closeEmptyCartModal()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

      <h5 class="mb-3 mt-3">Your cart is empty!</h5>
      <button type="button" class="btn btn-secondary" onclick="closeEmptyCartModal()">OK</button>
    </div>
  </div>
</div>

<script>
    fetch('/log-visitor'); // visitor database এ insert হবে
</script>


