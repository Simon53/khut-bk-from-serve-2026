@extends('layout.app')
@section('title', $category->name ?? 'New-Arrivals')
@section('content')

<style>
    .innerBanner h1 {
        display: none;
    }
    .bradcum-category {
        margin-top: -10px;
    }
</style>

@php
   $baseImagePath = env('ADMIN_BASE_URL') . '/storage/';
@endphp

<!-- ===== Banner Section Start ===== -->
<div class="innerBanner">
    
    <!--img src="{{ $category->banner }}" class="img-fluid img-resize-banner banner-animate"-->

   

    <img src="{{ env('ADMIN_BASE_URL') }}{{ $category->banner }}"
     class="img-fluid img-resize-banner banner-animate">

    <div class="banner-overlay"></div>

    <div class="d-flex justify-content-center">
        <h1>{{ $banner->title ?? $category->name }}</h1>
    </div>

    <div class="ribon"></div>

    <div class="container mt-2">
        <div class="bradcum-category">
            <a href="{{ url('/') }}">Home</a> /

            @if(!empty($mainMenu))
                <a href="{{ url('/category/'.str_replace(' ', '-', $mainMenu->name)) }}">
                    {{ $mainMenu->name }}
                </a> /
            @endif

            @if(!empty($subMenu))
                <a href="{{ url('/category/'.str_replace(' ', '-', $mainMenu->name).'/'.str_replace(' ', '-', $subMenu->name)) }}">
                    {{ $subMenu->name }}
                </a> /
            @endif

            @if(!empty($childMenu))
                <span>{{ $childMenu->name }}</span>
            @elseif(!empty($category))
                <span>{{ $category->name }}</span>
            @endif
        </div>
    </div>

</div>
<!-- ===== Banner Section End ===== -->

<div class="container my-4">
    <!-- Filter Button (Mobile Only) -->
    <button class="d-lg-none mb-3 filterBtn" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasTabs"
            aria-controls="offcanvasTabs" style="color:#FFF">
        ☰ Filter
    </button>

    <div class="row topGap-1">
        <!-- Sidebar -->
        <div class="col-lg-3 d-none d-lg-block">
            <!--h2 class="product-title mb-3">Product Category</h2-->
            <ul class="nav flex-column nav-pills">
                 @foreach($mainMenus as $main)
                    @php
                        // Default: menu name 그대로
                        $mainUrlName = $main->name;

                        // Special case: New Arrivals
                        if (strtolower($main->name) === 'new arrivals') {
                            $mainUrlName = 'New-Arrivals';
                        }
                    @endphp

                    <li class="nav-item" role="presentation">
                        <a class="nav-link main-menu-tab
                        {{ request()->is('category/'.$mainUrlName) ? 'active-menu' : '' }}"
                        href="{{ url('category/'.$mainUrlName) }}">
                            {{ $main->name }}
                        </a>

                        @if($main->subMenus->count())
                            <ul class="nav flex-column ms-3 mt-1">
                                @foreach($main->subMenus as $sub)
                                    <li class="nav-item">
                                        <a class="nav-link sub-menu-tab
                                        {{ request()->is('subcategory/'.$sub->id) ? 'active-menu' : '' }}"
                                        href="{{ url('subcategory/'.$sub->id) }}">
                                            {{ $sub->name }}
                                        </a>

                                        @if($sub->childMenus->count())
                                            <ul class="nav flex-column ms-3 mt-1">
                                                @foreach($sub->childMenus as $child)
                                                    <li class="nav-item">
                                                        <a class="nav-link child-menu-tab
                                                        {{ request()->is('childcategory/'.$child->id) ? 'active-menu' : '' }}"
                                                        href="{{ url('childcategory/'.$child->id) }}">
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
                @include('product-categories.partials.products-grid', [
                    'products' => $products,
                    'baseImagePath' => $baseImagePath
                ])
            </div>
        </div>
    </div>

   
     <!-- Offcanvas (Mobile Filter) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasTabs">
        <div class="offcanvas-header">
            <!--h5 id="offcanvasTabsLabel">Filter</h5-->
            <!--h6 class="fw-bold mb-2">Price Range</h6-->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-4">
                <input type="range" class="form-range" min="60" max="25000" step="100" id="priceRangeMobile">
                <div class="d-flex justify-content-between">
                    <small>৳60</small>
                    <small id="priceValueMobile">৳10,000</small>
                    <small>৳25,000</small>
                </div>
            </div>

            <!--h6 class="fw-bold mb-2">Product Category</h6-->
            <ul class="nav flex-column nav-pills">
                  @foreach($mainMenus as $main)
                    @php
                        // Default: menu name 그대로
                        $mainUrlName = $main->name;

                        // Special case: New Arrivals
                        if (strtolower($main->name) === 'new arrivals') {
                            $mainUrlName = 'New-Arrivals';
                        }
                    @endphp

                    <li class="nav-item" role="presentation">
                        <a class="nav-link main-menu-tab
                        {{ request()->is('category/'.$mainUrlName) ? 'active-menu' : '' }}"
                        href="{{ url('category/'.$mainUrlName) }}">
                            {{ $main->name }}
                        </a>

                        @if($main->subMenus->count())
                            <ul class="nav flex-column ms-3 mt-1">
                                @foreach($main->subMenus as $sub)
                                    <li class="nav-item">
                                        <a class="nav-link sub-menu-tab
                                        {{ request()->is('subcategory/'.$sub->id) ? 'active-menu' : '' }}"
                                        href="{{ url('subcategory/'.$sub->id) }}">
                                            {{ $sub->name }}
                                        </a>

                                        @if($sub->childMenus->count())
                                            <ul class="nav flex-column ms-3 mt-1">
                                                @foreach($sub->childMenus as $child)
                                                    <li class="nav-item">
                                                        <a class="nav-link child-menu-tab
                                                        {{ request()->is('childcategory/'.$child->id) ? 'active-menu' : '' }}"
                                                        href="{{ url('childcategory/'.$child->id) }}">
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
<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('/js/custom.js') }}"></script>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-card').forEach(card => {
        const sku = card.dataset.sku;
        if (!sku) return;

        fetch(`/stock/${sku}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success) return;

                const stockQty = parseInt(res.data.stock ?? 0);

                // SOLD OUT
                if (stockQty <= 0) {
                    card.querySelector('.sold-out')?.classList.remove('d-none');

                    // Remove Add to Cart
                    const btn = card.querySelector('.addToCart');
                    if (btn) btn.remove();
                }
            })
            .catch(err => console.error(err));
    });
});
</script>
@endsection





