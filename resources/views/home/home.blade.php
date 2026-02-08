@extends('layout.app')
@section('title', 'Home')
@section('content')

      @include('home.slider')
      <!-- ===== section start ===== -->
      
     @php
        $baseImagePath = env('ADMIN_BASE_URL') . '/storage/';
    @endphp
      
      @if($featureProduct)
         @php
            // Main → Sub → Child Path
            $parts = [
               optional($featureProduct->mainMenu)->name,
               optional($featureProduct->subMenu)->name,
               optional($featureProduct->childMenu)->name,
            ];

            // Non-empty values only, joined with " | "
            $categoryPath = collect($parts)->filter()->implode(' | ');

            // Category slug for "See More Products" link
            $categorySlug = optional($featureProduct->childMenu)->slug 
               ?? optional($featureProduct->subMenu)->slug 
               ?? optional($featureProduct->mainMenu)->slug;
         @endphp

         <div class="container topGap-1">
            <div class="row">
               {{-- ===== Left Side ===== --}}
               <div class="col-lg-5">
                  <div class="link-titel">
                     {{ $categoryPath ?: 'Uncategorized' }} | 
                     <a href="{{ route('product.details', $featureProduct->slug) }}">
                        {{ $featureProduct->name_en }}
                     </a>
                  </div>

                  <h2 class="product-title">
                     <a href="{{ route('product.details', $featureProduct->slug) }}" class="text-dark" style="text-decoration: none;">
                        {{ $featureProduct->name_en }}
                     </a>
                  </h2>

                  <h1 class="product-title-bangla">
                     <a href="{{ route('product.details', $featureProduct->slug) }}" class="text-dark" style="text-decoration: none;">
                        {{ $featureProduct->name_bn }}
                     </a>
                  </h1>

                  <p class="mt-5 details-text">
                     {!! $featureProduct->details !!}
                  </p>

                  <p class="mt-5 custom-link">
                     @if($categorySlug)
                        <a href="{{ route('category.list', $categorySlug) }}">See More Products</a>
                     @else
                        <a href="{{ route('shop.index') }}">See More Products</a>
                     @endif
                  </p>
               </div>

               {{-- ===== Right Side ===== --}}
             
               <div class="col-lg-7 right-content">
                  <a href="{{ route('product.details', $featureProduct->slug) }}">
                     <img 
                        src="{{  $baseImagePath . $featureProduct->main_image  }}" 
                        alt="{{ $featureProduct->name_en }}" 
                        class="img-fluid" 
                        style="float: right;"
                     >
                  </a>

                  <h3 class="price">BDT {{ number_format($featureProduct->price, 0) }}</h3>

                  <p class="mt-3 custom-link text-center">
                     @if($featureProduct->link_status === 'Add to Cart')
                        <a class="addToCart" href="#" 
                           data-id="{{ $featureProduct->id }}"
                           data-name="{{ $featureProduct->name_en }}"
                           data-price="{{ number_format($featureProduct->price, 0) }}"
                           data-img="{{  $baseImagePath . $featureProduct->main_image  }}"
                           data-product-barcode="{{ $featureProduct->product_barcode }}">
                           Add to Cart
                        </a>
                     @else
                        <a href="{{ route('product.details', $featureProduct->slug) }}">Select Options</a>
                     @endif
                  </p>
               </div>
            </div>
         </div>
      @endif
      <!-- ===== section end ===== -->


    <!-- ===== section start ===== -->
<div class="container topGap-2">
   @php
      $order = ['highlight-one', 'highlight-two', 'highlight-three'];
   @endphp

   @if(isset($highlightProducts) && $highlightProducts->count())
   
      <div class="row">
            @foreach($order as $key)
               @php 
                  $product = $highlightProducts[$key] ?? null;

                  if ($product) {

                        // Detect correct category route
                        if ($product->childMenu) {
                           $categoryRoute = route('childcategory.list', $product->childMenu->id);
                           $categoryName  = $product->childMenu->name;
                        }
                        elseif ($product->subMenu) {
                           $categoryRoute = route('subcategory.list', $product->subMenu->id);
                           $categoryName  = $product->subMenu->name;
                        }
                        else {
                           $categoryRoute = route('category.list', strtolower(str_replace(' ', '-', $product->mainMenu->name)));
                           $categoryName  = $product->mainMenu->name;
                        }

                  }
               @endphp
               
               @if($product)
                  {{-- ===== Left Side: highlight-one ===== --}}
                  @if($loop->first)
                        <div class="col-lg-6 col-md-12 col-sm-12 topLink mb-2 padding-r">
                           <div class="image-hover-wrapper">
                              <a href="{{ route('product.details', $product->slug) }}">
                                    <img src="{{ $baseImagePath . $product->main_image }}" class="img-resize-2 img-fluid" alt="{{ $product->name_en }}">
                              </a>

                              <div class="image-hover-content-topLink">
                                    <a href="{{ $categoryRoute }}">
                                       {{ $categoryName }}
                                    </a>

                                    <p class="custom-link">
                                          @if($product->link_status === 'Add to Cart')
                                             <a href="#" class="addToCart"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name_en }}"
                                                data-price="{{ $product->price }}"
                                                data-img="{{ $baseImagePath . $product->main_image }}"
                                                data-product-barcode="{{ $product->product_barcode }}">
                                                Add to Cart
                                             </a>
                                          @else
                                             <a href="{{ route('product.details', $product->slug) }}">Select Options</a>
                                          @endif
                                    </p>

                              </div>
                           </div>
                        </div>
                  @else
                        {{-- ===== Right Side: highlight-two & highlight-three ===== --}}
                        @if($loop->iteration == 2)
                           <div class="col-lg-6 col-md-12 col-sm-12 r-top-1 padding-l">
                        @endif

                        <div class="image-hover-wrapper mb-2" @if($loop->last) style="margin-top: -16px;" @endif>
                           <a href="{{ route('product.details', $product->slug) }}">
                              <img src="{{ $baseImagePath . $product->main_image }}" class="img-resize-1 img-fluid" alt="{{ $product->name_en }}">
                           </a>

                           <div class="image-hover-content-cottonSareeLink">
                              <a href="{{ $categoryRoute }}">
                                    {{ $categoryName }}
                              </a>

                              <p class="custom-link">
                                 @if($product->link_status === 'Add to Cart')
                                    <a href="#" class="addToCart"
                                       data-id="{{ $product->id }}"
                                       data-name="{{ $product->name_en }}"
                                       data-price="{{ $product->price }}"
                                       data-img="{{ $baseImagePath . $product->main_image }}"
                                       data-product-barcode="{{ $product->product_barcode }}">
                                       Add to Cart
                                    </a>
                                 @else
                                    <a href="{{ route('product.details', $product->slug) }}">Select Options</a>
                                 @endif
                              </p>

                           </div>
                        </div>

                        @if($loop->last)
                           </div>
                        @endif
                  @endif
               @endif
            @endforeach
      </div>
   @endif

   {{-- ===== Highlight Four: নিচের ডিভ ===== --}}
   @php
      $highlightFour = $highlightProducts['highlight-four'] ?? null;

      if ($highlightFour) {
            if ($highlightFour->childMenu) {
               $categoryRoute = route('childcategory.list', $highlightFour->childMenu->id);
               $categoryName  = $highlightFour->childMenu->name;
            }
            elseif ($highlightFour->subMenu) {
               $categoryRoute = route('subcategory.list', $highlightFour->subMenu->id);
               $categoryName  = $highlightFour->subMenu->name;
            }
            else {
               $categoryRoute = route('category.list', strtolower(str_replace(' ', '-', $highlightFour->mainMenu->name)));
               $categoryName  = $highlightFour->mainMenu->name;
            }
      }
   @endphp

   @if($highlightFour)
      <div class="image-hover-wrapper woodDiv">
            <a href="{{ route('product.details', $highlightFour->slug) }}">
               <img src="{{ $baseImagePath . $highlightFour->main_image }}" class="img-resize-1" alt="{{ $highlightFour->name_en }}" style="height:310px">
            </a>
            <div class="image-hover-content-cottonSareeLink image-hover-content-cottonSareeLink-to-xtra">
               <a href="{{ $categoryRoute }}">
                  {{ $categoryName }}
               </a>
               
            <p class="custom-link">
                  @if($highlightFour->link_status === 'Add to Cart')
                     <a href="#" class="addToCart"
                        data-id="{{ $highlightFour->id }}"
                        data-name="{{ $highlightFour->name_en }}"
                        data-price="{{ $highlightFour->price }}"
                        data-img="{{ $baseImagePath . $highlightFour->main_image }}"
                        data-product-barcode="{{ $highlightFour->product_barcode }}">
                        Add to Cart
                     </a>
                  @else
                        <a href="{{ route('product.details', $highlightFour->slug) }}">Shop More</a>
                  @endif
               </p>
            </div>
      </div>
   @endif
</div>
<!-- ===== section end ===== -->




      <!-- ===== Feature Two Section ===== -->
      @if(isset($featureTwoProduct) && $featureTwoProduct)
    
         <div class="container topGap-2">
            <div class="row">
                  <div class="col-lg-5">
                     <div class="link-titel">
                        {{ optional($featureTwoProduct->mainMenu)->name 
                              ?? optional($featureTwoProduct->subMenu)->name 
                              ?? optional($featureTwoProduct->childMenu)->name 
                              ?? 'New Arrival' }} | 
                        <a href="{{ route('product.details', $featureTwoProduct->slug) }}">
                              {{ $featureTwoProduct->name_en }}
                        </a>
                     </div>

                     <h2 class="product-title">
                        <a href="{{ route('product.details', $featureTwoProduct->slug) }}" class="text-dark" style="text-decoration: none;">
                              {{ $featureTwoProduct->name_en }}
                        </a>
                     </h2>

                     <h1 class="product-title-bangla">
                        <a href="{{ route('product.details', $featureTwoProduct->slug) }}" class="text-dark" style="text-decoration: none;">
                              {{ $featureTwoProduct->name_bn }}
                        </a>
                     </h1>

                     <p class="mt-5 details-text">
                        {!! $featureTwoProduct->details !!}
                     </p>

                     <p class="mt-5 custom-link">
                         <a href="{{ route('shop.index') }}">See More Products</a>
                     </p>
                  </div>

                  <div class="col-lg-7 right-content">
                     <a href="{{ route('product.details', $featureTwoProduct->slug) }}">
                        <img src="{{ $baseImagePath . $featureTwoProduct->main_image  }}" class="img-fluid img-resize-2" style="float: right;" alt="{{ $featureTwoProduct->name_en }}">
                     </a>

                     <h3 class="price">BDT {{ number_format($featureTwoProduct->price, 0) }}</h3>

                     <p class="mt-3 custom-link text-center">
                       @if($featureTwoProduct->link_status === 'Add to Cart')
                    +      <a href="#" class="addToCart"
                               data-id="{{ $featureTwoProduct->id }}"
                               data-name="{{ $featureTwoProduct->name_en }}"
                               data-price="{{ $featureTwoProduct->price }}"
                               data-img="{{ $baseImagePath . $featureTwoProduct->main_image }}"
                               data-product-barcode="{{ $featureTwoProduct->product_barcode }}">
                               Add to Cart
                            </a>
                       @else
                            <a href="{{ route('product.details', $featureTwoProduct->slug) }}">Shop More</a>
                       @endif
                    </p>
                  </div>
            </div>
         </div>
      @endif



 

<!-- ===== section start ===== -->
<div class="container">
   <div class="row mb-3 flex-wrap">
      <!-- Left side: Title & Description -->
      <div class="col-lg-7">
            <h1 class="mb-2 product-title">Find The perfect Saree</h1>
            <p class="mb-0 col-lg-8">
               Discover sarees that seamlessly blend tradition and modern style, perfect for any occasion and every unique moment.
            </p>
      </div>

      <!-- Right side: Tabs -->
      <div class="col-lg-5 topGap-3 padding-r">
            <ul class="nav nav-tabs d-flex flex-row justify-content-end" id="myTab" role="tablist">
               @php
                  $tabs = [
                        'Cotton' => $cottonProducts,
                        'Endi-Silk' => $endiSilkProducts,
                        'Half-Silck' => $halfSilkProducts,
                  ];
                  $first = true;
               @endphp

               @foreach($tabs as $tabName => $products)
                  <li class="tab-custom-btn" role="presentation">
                        <a class="{{ $first ? 'active' : '' }}" 
                           id="{{ Str::slug($tabName) }}-tab" 
                           data-bs-toggle="tab" 
                           data-bs-target="#{{ Str::slug($tabName) }}" 
                           type="button">
                           {{ $tabName }}
                        </a>
                  </li>
                  @php $first = false; @endphp
               @endforeach
            </ul>
      </div>
   </div>

   <!-- Tab Content -->
   <div class="tab-content mt-4" id="myTabContent">
      @php $first = true; @endphp
      @foreach($tabs as $tabName => $products)
            <div class="tab-pane fade {{ $first ? 'show active' : '' }}" id="{{ Str::slug($tabName) }}">
               <div class="swiper mySwiperShoes">
                  <div class="swiper-wrapper">
                        @forelse($products as $product)
                           <div class="swiper-slide slide-item">
                              <a href="{{ route('product.details', $product->slug) }}">
                                    {{-- ✅ Use fixed base path for image --}}
                                    <img 
                                       src="{{ $baseImagePath . $product->main_image }}" 
                                       class="slide-img" 
                                       alt="{{ $product->name_en }}"
                                    >
                                    <div class="overlaysSlider price">
                                       {{ $product->name_en }} <br> 
                                       BDT {{ number_format($product->price, 0) }}
                                    </div>
                              </a>
                           </div>
                        @empty
                           <p>No products found in {{ $tabName }} category.</p>
                        @endforelse
                  </div>
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>
               </div>
            </div>
            @php $first = false; @endphp
      @endforeach
   </div>
</div>
<!-- ===== section end ===== -->



  


<!-- ===== Festive Section ===== -->
<div class="container topGap-1" style="padding-left: 0;">
   <div class="row align-items-center justify-content-center">

      <!-- Left Text -->
      <div class="fastive-text text-center fastive-text-div col-lg-6 col-md-6">
            @if($festiveLeft)
               <h1>{{ $festiveLeft->name_en }}</h1>
               <p>{!! $festiveLeft->details ?? '' !!}</p>
            @endif
            <p class="mt-4 custom-link">
               <a href="{{ route('all.products.list', 'fastive-collection') }}">See All Products</a>
            </p>
      </div>

      <!-- Right Images -->
      <div class="d-flex justify-content-center">
         
         <div data-aos="fade-right" style="margin-left: 10px;">
            @if($festiveLeft)
               <img src="{{ $baseImagePath . $festiveLeft->main_image }}" class="img-fluid" alt="Festive Left"">
            @endif
         </div>

         <div data-aos="fade-left" style="padding:0px">
            @if($festiveRight)
               <img src="{{ $baseImagePath . $festiveRight->main_image }}" class="img-fluid" alt="Festive Right"">
            @endif
         </div>

      </div>
   </div>
</div>
<!-- ===== Festive Section End ===== -->





      <!-- ===== Patchwork Section Start ===== -->
      <div class="container topGap-2">
         <div class="row align-items-center">
            <!-- Left side: Title -->
            <div class="col-lg-7">
               <h1 class="mb-2 product-title">
                  Exceptional Patchwork Outfits
               </h1>
            </div>

            <!-- Right side: Link -->
            <div class="col-lg-5 d-flex justify-content-end custom-link">
               <a class="m-1" href="/category/Patchwork">
                  All Patchwork 
               </a>
            </div>
         </div>

         <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active">
               <div class="swiper mySwiperShoes">
                  <div class="swiper-wrapper">
                     @forelse($patchworkProducts as $product)
                        <div class="swiper-slide slide-item">
                           <a href="{{ route('product.details', $product->slug) }}">
                              <img src="{{ $baseImagePath . $product->main_image  }}" class="slide-img" alt="{{ $product->name_en }}">
                              <div class="overlaysSlider price">
                                 {{ $product->name_en }} <br>
                                 BDT {{ number_format($product->price, 0) }}
                              </div>
                           </a>
                        </div>
                     @empty
                        <div class="text-center p-5">
                           <p>No Patchwork products found.</p>
                        </div>
                     @endforelse
                  </div>
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- ===== Patchwork Section End ===== -->




        <!-- ===== Ho-jo-bo-ro-lo Section Start ===== -->
         <div class="container topGap-2">
            <div class="row mb-3 flex-wrap">
               <!-- Left side: Title & Description -->
              <div class="col-lg-8">
               <h1 class="mb-2 product-title">Beautiful Ho-Jo-Bo-Ro-Lo Collection</h1>
               <p class="mb-0 col-lg-12">
                 Together lets create a colorful space with<br/>
                  Ho-Jo-Bo-Ro-Lo and inspire recycling | local artisan | handmade goods.
               </p>
            </div>

             <!-- Right side: Link -->
              <div class="col-lg-4 d-flex justify-content-end align-items-center custom-link">
                  <a class="m-1" href="/category/Hojoborolo">All Products</a>
               </div>
            </div>
            
          <div class="row bd-highlight mb-3">
            @forelse($HozoboroloProducts as $product)
               <div class="col-lg-3 col-md-6 col-6 hozoboro-text text-center mb-4">
                  <a href="{{ route('product.details', $product->slug) }}">  
                     <img src="{{ $baseImagePath . $product->main_image }}" class="home-hozoborolo-size" alt="{{ $product->name_en }}" />
                     <h3 class="mt-2">{{ $product->name_en }}</h3>
                  </a> 
               </div>
            @empty
               <div class="col-12 text-center py-5">
                  <p>No Ho-jo-bo-ro-lo products found.</p>
               </div>
            @endforelse
         </div>
         </div>
      <!-- ===== Ho-jo-bo-ro-lo Section End ===== -->


      <hr class="devider-container">
       <!-- ===== section start ===== -->
 


     <div class="container topGap-2">
        @if($bottomContent)
         <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-12 mt-2 hozoboro-text">
                <img src="{{ $baseImagePath . $bottomContent->main_image }}"
                           class="home-hozoborolo-big"
                           alt="Bottom Image" />
            </div>
            <div class="col-lg-7 col-md-8 col-sm-12 mt-2 hozoboro-text-2" >
               {!! $bottomContent->details !!}
            </div>
         </div>
          @endif
      </div>

         <!-- ===== bottom section end ===== -->

      <!-- ===== section end ===== -->                 
                        


      <!-- ===== section start ===== -->
      <div class="container topGap-1" style="display:none;">
         <div class="row align-items-center">
            <div class="col-lg-7">
                  <h1 class="mb-2 product-title">Why Khut is Unique</h1>
            </div>
            <div class="col-lg-5 d-flex justify-content-end custom-link">
                 <a class="m-1" href="{{ route('khut-stories.index') }}">All History</a>
            </div>
         </div>

         <div class="tab-content mt-4">
            <div class="tab-pane fade show active">
                  <div class="mySwiperShoes">
                     <div class="swiper-wrapper">
                        @foreach($stories as $story)
                              <div class="swiper-slide p-2">
                                   <a href="{{ route('khut-stories.details', $story->id) }}">
                                    <div class="col-md-12 slide-item slide-item-hozoborolo">
                                          <img src="{{ $adminBaseUrl . $story->image }}" class="slide-img-new" alt="{{ $story->title }}">
                                    </div>
                                 </a>
                                 <div class="wiper-slide-info-unique p-4">
                                    <h4 class="product-title">{{ $story->title }}</h4>
                                    <p>{{ Str::limit(strip_tags($story->details), 60) }}</p>
                                    <a href="{{ route('khut-stories.details', $story->id) }}">Read More >></a>
                                 </div>
                              </div>
                        @endforeach
                     </div>
                  </div>
            </div>
         </div>
      </div>
      <!-- ===== section end ===== -->
@endsection

@section('script')


<script src="{{asset('/js/jquery-3.6.0.min.js')}}" ></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('/js/aos.js')}}"></script>
<script src="{{asset('/js/custom.js')}}"></script>

<script>
       AOS.init({
        duration: 1000, // animation speed (in ms)
        once: true,     // only animate once
        offset: 100,    // trigger point (in px)
    });
</script>
@endsection