<div class="row">
    @foreach($products as $product)
                    <div class="col-lg-3 col-md-6 col-6 hozoboro-text productListName productportraitListDiv padding-custom-mobile product-card"
                        data-price="{{ $product->price }}">
                        <a href="{{ route('product.details', $product->slug) }}">
                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->name_en }}"
                                class="img-fluid img-alllist-resize">

                            {{-- Sold-out overlay --}}
                            @if($product->stock_status == 'N')
                                <div class="sold-out">
                                    Sold Out
                                </div>
                            @endif
                        </a>

                        <div class="nameProduct">
                            <p>{{ $product->name_en }}</p>
                            <h4>BDT {{ $product->price }} .VAT &nbsp;&nbsp; <span>{{ $product->sale_price }}</span></h4>
                        </div>

                        <div class="custom-link d-flex align-items-center justify-content-between">
                            {{-- Add to Cart / Select Option --}}
                            @if($product->link_status == 'Add to Cart')
                                <a class="addToCart" data-id="{{ $product->id }}" data-name="{{ $product->name_en }}"
                                    data-price="{{ $product->price }}" data-img="{{ asset($product->main_image) }}">
                                    Add to Cart
                                </a>
                            @elseif($product->link_status == 'Read More')
                                <a href="{{ route('product.details', $product->slug) }}">
                                    Select Option
                                </a>
                            @endif

                            {{-- Wishlist button --}}
                            <button class="wish-btn" data-id="{{ $product->id }}"
                            data-name="{{ $product->name_en }}"
                            data-price="{{ $product->price }}"
                            data-img="{{ $baseImagePath . $product->main_image }}"
                            data-slug="{{ $product->slug }}">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
