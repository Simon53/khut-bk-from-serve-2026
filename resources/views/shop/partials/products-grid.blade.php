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
                   data-product-barcode="{{ $product->product_barcode }}"
                   style="padding:4px 18px">
                   Add to Cart
                </a>
            @elseif($product->link_status == 'Read More')
                <a href="{{ route('product.details', $product->slug) }}"  style="padding:4px 18px">Select Option</a>
            @endif
            <button class="wish-btn" data-id="{{ $product->id }}"
                            data-name="{{ $product->name_en }}"
                            data-price="{{ $product->price }}"
                            data-img="{{ $baseImagePath . $product->main_image }}"
                            data-slug="{{ $product->slug }}">
                <i class="far fa-heart"></i>
            </button>
        </div>
    @endif
</div>
@endforeach

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
