@extends('layout.app')
@section('title', $displayType . ' Products')
@section('content')

@php
    $baseImagePath = 'https://dev.khut.shop/khut-bd-admin/public/storage/';
@endphp

<style>
    .innerBanner h1 {
        display: none;
    }
    .bradcum-category {
        margin-top: -10px;
    }
    .product-card img {
        width: 190px;
        height: 190px;
        object-fit: cover;
        object-position: center;
        border-radius: 8px;
        background-color: #f8f8f8;
    }
</style>

<div class="container my-4">
    <!-- Filter Button (Mobile Only) -->
    <button class="d-lg-none mb-3 filterBtn" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasTabs"
            aria-controls="offcanvasTabs" style="color:#FFF">
        ☰ Filter
    </button>

    <div class="row topGap-1">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 d-none d-lg-block">
            <!-- Desktop Price Range -->
            <div class="mb-4">
                <!--h6 class="fw-bold mb-2">Price Range</h6-->
                <input type="range" class="form-range" min="60" max="25000" step="100" id="priceRangeDesktop">
                <div class="d-flex justify-content-between">
                    <small>৳60</small>
                    <small id="priceValueDesktop">৳10,000</small>
                    <small>৳25,000</small>
                </div>
            </div>

            <!--h2 class="product-title mb-3">Product Category</h2-->
            <ul class="nav flex-column nav-pills">
                @foreach($mainMenus as $main)
                    <li class="nav-item">
                        <a class="nav-link main-menu-tab" href="{{ url('category/' . str_replace(' ', '-', $main->name)) }}">
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
            <h1 class="mb-4" style="display:none;">{{ $displayType }} Products</h1>

            <div class="row" id="product-list">
               @foreach($products as $product)
                    <div class="col-lg-3 col-md-6 col-6 hozoboro-text productListName productportraitListDiv padding-custom-mobile product-card"
                        data-price="{{ $product->price }}">
                        <a href="{{ route('product.details', $product->slug) }}">
                            <img src="{{ $baseImagePath . $product->main_image }}" alt="{{ $product->name_en }}"
                                class="img-fluid img-alllist-resize">
                    
                            @if($product->stock_status == 'N')
                                <div class="sold-out">Sold Out</div>
                            @endif
                        </a>
                    
                        <div class="nameProduct">
                            <a href="{{ route('product.details', $product->slug) }}"><p>{{ $product->name_en }}</p></a>
                            <h4>BDT {{ $product->price }} .VAT &nbsp;&nbsp; <span>{{ $product->sale_price }}</span></h4>
                        </div>
                    
                        @if($product->stock_status != 'N')
                            <div class="custom-link d-flex align-items-center justify-content-between">
                                @if($product->link_status == 'Add to Cart')
                                    <a class="addToCart"
                                       data-id="{{ $product->id }}"
                                       data-name="{{ $product->name_en }}"
                                       data-price="{{ $product->price }}"
                                       data-img="{{ $baseImagePath . $product->main_image }}"
                                       data-product-barcode="{{ $product->product_barcode }}">
                                       Add to Cart
                                    </a>
                                @elseif($product->link_status == 'Read More')
                                    <a href="{{ route('product.details', $product->slug) }}">Select Option</a>
                                @endif
                                <button class="wish-btn">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Offcanvas (Mobile Filter) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasTabs">
        <div class="offcanvas-header">
            <h5 id="offcanvasTabsLabel">Filter</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-4">
                <h6 class="fw-bold mb-2">Price Range</h6>
                <input type="range" class="form-range" min="60" max="25000" step="100" id="priceRangeMobile">
                <div class="d-flex justify-content-between">
                    <small>৳60</small>
                    <small id="priceValueMobile">৳10,000</small>
                    <small>৳25,000</small>
                </div>
            </div>

            <h6 class="fw-bold mb-2">Product Category</h6>
            <ul class="nav flex-column nav-pills">
                @foreach($mainMenus as $main)
                    <li class="nav-item">
                        <a class="nav-link main-menu-tab" href="{{ url('category/' . str_replace(' ', '-', $main->name)) }}">
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
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('/js/jquery-3.6.0.min.js')}}" ></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/custom.js')}}"></script>

<script>
   /* ---------- Price Range Filter ---------- */
function priceFilter(rangeId, valueId, defaultValue = 10000) {
    const range = document.getElementById(rangeId);
    const value = document.getElementById(valueId);
    const grid = document.getElementById('product-list');
    if (!range || !value || !grid) return;

    range.value = defaultValue;
    value.textContent = '৳' + defaultValue.toLocaleString();

    range.addEventListener('input', function () {
        const maxPrice = parseInt(this.value);
        value.textContent = '৳' + maxPrice.toLocaleString();

        grid.querySelectorAll('.product-card').forEach(card => {
            const price = parseFloat(card.dataset.price);
            card.style.display = (price <= maxPrice) ? '' : 'none';
        });
    });
}
priceFilter('priceRangeDesktop', 'priceValueDesktop', 10000);
priceFilter('priceRangeMobile', 'priceValueMobile', 10000);

/* ---------- Category Filter (AJAX) ---------- */
$(document).on('click', '.main-menu-tab, .sub-menu-tab, .child-menu-tab', function () {
    let slug = $(this).data('slug');
    if (!slug) return;

    if ($(this).hasClass('main-menu-tab')) {
        window.location.href = '/category/' + slug;
    } else if ($(this).hasClass('sub-menu-tab')) {
        window.location.href = '/subcategory/' + slug;
    } else if ($(this).hasClass('child-menu-tab')) {
        window.location.href = '/childcategory/' + slug;
    }
});
</script>
@endsection
