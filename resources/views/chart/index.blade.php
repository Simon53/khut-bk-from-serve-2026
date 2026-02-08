@extends('layout.app')

@section('title', 'My Cart')
@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Cart List -->
        <div class="col-lg-8">
            <div id="orderSummary"></div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div id="total"></div>
        </div>
    </div>
</div>

<style>
   .table-light tr th {
    padding: 10px;
    background-color: #adacacff!important;
    font-weight: 600;
    color:#282626ff;
    font-size:16px!important;
}
 .card{
    background-color: #b7afaf!important;
 }
</style>
@endsection


@section('script')
<script src="{{asset('/js/jquery-3.6.0.min.js')}}" ></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('/js/owl-carousel.js')}}"></script>
<script src="{{asset('/js/custom.js')}}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    loadOrderSummary();
});

function loadOrderSummary() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let subtotal = 0;
    let totalTax = 0;

    const orderDiv = document.getElementById("orderSummary");
    const totalDiv = document.getElementById("total");

    if(cart.length === 0){
        orderDiv.innerHTML = `<div class="alert alert-info">Your cart is empty.</div>`;
        totalDiv.innerHTML = ``;
        return;
    }

    let html = `<div class="table-responsive">
        <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Size</th>
                <th>Color</th>
                <th>Barcode</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>`;

    cart.forEach(item => {
        let price = parseFloat(item.price) || 0;
        let qty = parseInt(item.qty) || 1;
        let productSubtotal = price * qty;

        // Tax
        let taxRate = (item.tax_status == 'Standard') ? 0.10 : 0.075;
        let taxAmount = productSubtotal * taxRate;

        subtotal += productSubtotal;
        totalTax += taxAmount;

        html += `<tr>
            <td><img src="${item.img || '/images/no-image.png'}" width="60"></td>
            <td>${item.name}</td>
            <td>${item.size || '-'}</td>
            <td>${item.color || '-'}</td>
            <td>${item.barcode || 'NO_BARCODE'}</td>
            <td><input type="number" class="form-control form-control-sm updateQty" data-id="${item.id}" value="${qty}" min="1"></td>
            <td>${productSubtotal.toLocaleString()} BDT</td>
            <td><button class="btn btn-sm btn-danger removeItem" data-id="${item.id}">×</button></td>
        </tr>`;
    });

    html += `</tbody></table></div>`;
    orderDiv.innerHTML = html;

    let delivery = 80;
    let grandTotal = subtotal + totalTax + delivery;

    totalDiv.innerHTML = `<div class="card p-3 shadow-sm custom-link">
        <h5>Order Summary</h5>
        <p>Subtotal: ${subtotal.toLocaleString()} BDT</p>
        <p>Delivery: ${delivery.toLocaleString()} BDT</p>
        <hr>
        <h5>Total (incl. VAT): ${grandTotal.toLocaleString()} BDT</h5>
        <small class="text-muted">Includes VAT: ${totalTax.toLocaleString()} BDT</small>
        <!--a href="/checkout" class="btn  mt-2">Proceed to checkout</a-->
       
        <button id="checkoutBtn" class="btn btn-primary checkout-Btn w-100" data-url="{{ route('checkout.index') }}">
            Checkout 
        </button>
    </div>`;

    // Remove item
    document.querySelectorAll(".removeItem").forEach(btn => {
        btn.addEventListener("click", function(){
            const id = this.dataset.id;
            cart = cart.filter(i => i.id != id);
            localStorage.setItem("cart", JSON.stringify(cart));
            loadOrderSummary();
        });
    });

    // Update quantity
    document.querySelectorAll(".updateQty").forEach(input => {
        input.addEventListener("change", function(){
            const id = this.dataset.id;
            let qty = parseInt(this.value);
            if(qty < 1) qty = 1;
            cart = cart.map(i => { if(i.id == id) i.qty = qty; return i; });
            localStorage.setItem("cart", JSON.stringify(cart));
            loadOrderSummary();
        });
    });
}



document.addEventListener("DOMContentLoaded", function () {
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (!checkoutBtn) return;

    checkoutBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const url = this.dataset.url;

        if (cart.length === 0) {
            showEmptyCartModal();
        } else {
            window.location.href = url;
        }
    });
});

</script>
@endsection
