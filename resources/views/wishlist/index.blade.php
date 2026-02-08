@extends('layout.app')
@section('title', 'My Wishlist')

@php
$baseImagePath = env('ADMIN_BASE_URL') . '/storage/';
$publicPath = env('APP_URL') . '/public'; // public path fix for links
@endphp

@section('content')

<div class="container my-4">
    <div class="row topGap-1">
        <!-- Left Menu -->
        <div class="col-lg-3 d-none d-lg-block">
            <ul class="nav flex-column nav-pills">
                @foreach($mainMenus as $main)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link main-menu-tab" href="{{ url('category/'.$main->name) }}">
                            {{ $main->name }}
                        </a>

                        @if($main->subMenus->count())
                            <ul class="nav flex-column ms-3 mt-1">
                                @foreach($main->subMenus as $sub)
                                    <li class="nav-item">
                                        <a class="nav-link sub-menu-tab" href="{{ url('subcategory/'.$sub->id) }}">
                                            {{ $sub->name }}
                                        </a>

                                        @if($sub->childMenus->count())
                                            <ul class="nav flex-column ms-3 mt-1">
                                                @foreach($sub->childMenus as $child)
                                                    <li class="nav-item">
                                                        <a class="nav-link child-menu-tab" href="{{ url('childcategory/'.$child->id) }}">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="row" id="product-list">
                <!-- Wishlist products injected via JS -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
const baseImagePath = "{{ $baseImagePath }}";
const publicPath = "{{ $publicPath }}";

function getWishlist() {
    return JSON.parse(localStorage.getItem("wishlist")) || [];
}

function setWishlist(data) {
    localStorage.setItem("wishlist", JSON.stringify(data));
    updateWishlistCount();
}

function updateWishlistCount() {
    const count = getWishlist().length;
    document.querySelectorAll(".wishlist-count").forEach(el => el.textContent = count);
}

function renderWishlist() {
    const wishlist = getWishlist();
    const container = document.getElementById("product-list");
    container.innerHTML = '';

    if (wishlist.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center">
                <h5>No wishlist product found</h5>
            </div>`;
        return;
    }

    wishlist.forEach(product => {
        // fallback values
        const slug = product.slug || '#';
        const name = product.name || 'Product';
        const price = product.price || 0;
        const salePrice = product.sale_price ? `<span>${product.sale_price}</span>` : '';
        const img = product.img ? product.img : '/assets/images/no-image.png';

        // full URL for image
        const imageUrl = img.startsWith('http') ? img : `${baseImagePath}${img}`;

        container.innerHTML += `
        <div class="col-lg-3 col-md-6 col-6 hozoboro-text productListName productportraitListDiv padding-custom-mobile product-card"
             data-price="${price}">
            <a href="${publicPath}/product-details/${slug}">
                <img src="${imageUrl}" class="img-fluid img-alllist-resize" alt="${name}">
                ${product.stock_status === 'N' ? '<div class="sold-out">Sold Out</div>' : ''}
            </a>

            <div class="nameProduct">
                <a href="${publicPath}/product-details/${slug}"><p>${name}</p></a>
                <h4>BDT ${price} ${salePrice}</h4>
            </div>

            <div class="custom-link d-flex align-items-center justify-content-between">
                <a href="${publicPath}/product-details/${slug}" style="padding:4px 18px">View Details</a>
                <button class="wish-btn" 
                    data-id="${product.id}" 
                    data-name="${name}" 
                    data-price="${price}" 
                    data-img="${img}" 
                    data-slug="${slug}">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>`;
    });

    attachEvents();
}

function attachEvents() {
    document.querySelectorAll(".wish-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            let wishlist = getWishlist();
            wishlist = wishlist.filter(p => p.id != id);
            setWishlist(wishlist);
            renderWishlist();
        });
    });
}

// Initial render
updateWishlistCount();
renderWishlist();
</script>
@endsection
