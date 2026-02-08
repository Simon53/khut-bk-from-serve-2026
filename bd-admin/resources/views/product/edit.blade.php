@extends('layout.app')
@section('title', 'Khut::Protuct Edit')
@section('content')


<style>
   .ck-editor__editable_inline {
   background-color: #2a3038 !important;
   color: #ffffff !important;
   min-height: 200px;
   }
   #thumbnailPreview img {
   border: 1px solid #ccc;
   padding: 2px;
   background-color: #fff;
   }
   .thumbnail-wrapper {
   position: relative;
   display: inline-block;
   }
   .thumbnail-wrapper img {
   border: 1px solid #ccc;
   padding: 2px;
   background-color: #fff;
   width: 100%;
   }
   .remove-thumbnail {
   position: absolute;
   top: 5px;
   right: 5px;
   background: rgba(255, 0, 0, 0.85);
   color: #fff;
   border: none;
   padding: 2px 6px;
   font-size: 14px;
   line-height: 1;
   cursor: pointer;
   border-radius: 50%;
   z-index: 10;
   }
   .gallery-image.selected {
   border: 3px solid #28a745;
   opacity: 0.8;
   }
   /* For WebKit browsers (Chrome, Safari, Edge) */
   ::-webkit-scrollbar {
   width: 6px; /* Vertical scrollbar width */
   height: 6px; /* Horizontal scrollbar height */
   }
   ::-webkit-scrollbar-track {
   background: #f0f0f0; /* Scrollbar background */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb {
   background: #888; /* Scrollbar thumb color */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb:hover {
   background: #555; /* On hover */
   }
    .gallery-image.selected {
   border: 3px solid #007bff;
   opacity: 0.7;
   }
   .ck-editor__editable_inline {
   background-color: #2a3038 !important;
   color: #ffffff !important;
   min-height: 200px;
   }
   #thumbnailPreview img {
   border: 1px solid #ccc;
   padding: 2px;
   background-color: #fff;
   }
   .thumbnail-wrapper {
   position: relative;
   display: inline-block;
   }
   .thumbnail-wrapper img {
   border: 1px solid #ccc;
   padding: 2px;
   background-color: #fff;
   width: 100%;
   }
   .remove-thumbnail {
   position: absolute;
   top: 5px;
   right: 5px;
   background: rgba(255, 0, 0, 0.85);
   color: #fff;
   border: none;
   padding: 2px 6px;
   font-size: 14px;
   line-height: 1;
   cursor: pointer;
   border-radius: 50%;
   z-index: 10;
   }
   .gallery-image.selected {
   border: 3px solid #28a745;
   opacity: 0.8;
   }
   /* For WebKit browsers (Chrome, Safari, Edge) */
   ::-webkit-scrollbar {
   width: 6px; /* Vertical scrollbar width */
   height: 6px; /* Horizontal scrollbar height */
   }
   ::-webkit-scrollbar-track {
   background: #f0f0f0; /* Scrollbar background */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb {
   background: #888; /* Scrollbar thumb color */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb:hover {
   background: #555; /* On hover */
   }
   .ck-editor__editable {
   background-color: #ffffff !important; /
   color: #000000 
   min-height: 300px; 
   }
</style>

<div class="container-fluid mt-4">
   <div class="page-header">
      <h3 class="page-title">Edit Product</h3>
   </div>
   <input type="hidden" id="productId" value="{{ $product->id }}">
   <div class="row">
      <div class="col-md-8 grid-margin stretch-card" >
         <div class="card" style="max-height: 600px; overflow-y: auto; overflow-x: hidden;">
            <div class="card-body row">
               <div id="productAccordion" class="accordion" style="width: 100%;">
                  <!-- Product Details -->
                  <div class="card">
                     <div class="card-header" id="headingDetails">
                        <h5 class="mb-0">
                           <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseDetails" aria-expanded="true" aria-controls="collapseDetails">
                           Product Details
                           </button>
                        </h5>
                     </div>
                     <div id="collapseDetails" class="collapse show" aria-labelledby="headingDetails" data-parent="#productAccordion">
                        <div class="card-body row">
                           <div class="form-group col-md-12">
                              <label for="exampleInputUsername1">Product Name(Eng)</label>
                              <input type="text" class="form-control" id="nameEn" name="name_en" value="{{ $product->name_en }}" placeholder="Product Name(Eng)">
                           </div>
                           <div class="form-group col-md-12">
                              <label for="exampleInputEmail1">Product Name(Bn)</label>
                              <input type="text" class="form-control" id="nameBn" name="name_bn" name="name_en" value="{{ $product->name_bn }}"  placeholder="Product Name(Bn)">
                           </div>
                           <div class="form-group col-md-12">
                              <label >About Details</label>
                              <textarea class="form-control" id="productDetailsEditor" name="details" rows="5" placeholder="Enter details...">{{ old('details', $product->details) }}</textarea>
                           </div>
                           <div class="col-md-12 mt-3">
                              <label for="exampleInputUsername1">Link Options</label>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="radio" class="form-check-input" name="link_status" value="Add to Cart"
                                 {{ $product->link_status == 'Add to Cart' ? 'checked' : '' }}> Add to Cart <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="radio" class="form-check-input" name="link_status" value="Read More"
                                 {{ $product->link_status == 'Read More' ? 'checked' : '' }}> Read More <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-12 mt-3">
                              <label for="exampleInputUsername1">Site View Options</label>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="checkbox"  class="form-check-input"  name="site_view_status"  id="site_view_status" value="Y" {{ $product->site_view_status == 'Y' ? 'checked' : '' }}> Show Home  <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input  type="checkbox"  class="form-check-input"  name="published_site"   id="published_site"  value="Y" {{ $product->published_site == 'Y' ? 'checked' : '' }}> Published <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input  type="checkbox"  class="form-check-input"  name="festive_collection"   id="festive_collection"  value="fastive-collection" {{ $product->festive_collection == 'fastive-collection' ? 'checked' : '' }}> Festive Collection <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input  type="checkbox"  class="form-check-input"  name="new_arrivals"   id="new_arrivals"  value="Y" {{ $product->new_arrivals == 'Y' ? 'checked' : '' }}> New Arrivals <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input  type="checkbox"  class="form-check-input"  name="patchwork"   id="patchwork"  value="Y" {{ $product->patchwork == 'Y' ? 'checked' : '' }}>Patchwork <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="row p-2" id="homeViewOptions" style="display:none">
                              <div class="col-md-12 mt-3">
                                 <label for="exampleInputUsername1">Feature Options</label>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="feature" value="Feature One"
                                    {{ $product->feature == 'Feature One' ? 'checked' : '' }}> Feature One <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="feature" value="Feature Two"
                                    {{ $product->feature == 'Feature Two' ? 'checked' : '' }}> Feature Two <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-md-12 mt-3">
                                 <label for="exampleInputUsername1">Highlight</label>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="highlight" value="highlight-one"
                                    {{ $product->highlight == 'highlight-one' ? 'checked' : '' }}> Highlight One <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="highlight" value="highlight-two"
                                    {{ $product->highlight == 'highlight-two' ? 'checked' : '' }}> Highlight Two <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="highlight" value="highlight-three"
                                    {{ $product->highlight == 'highlight-three' ? 'checked' : '' }}> Highlight Three <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="highlight" value="highlight-four"
                                    {{ $product->highlight == 'highlight-four' ? 'checked' : '' }}> Highlight Four <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              
                              <div class="col-sm-12 mt-3">
                                 <label for="exampleInputUsername1">Options Bottom/Fastive Collection</label>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottom_fastive" value="festive-left"
                                    {{ $product->bottom_fastive == 'festive-left' ? 'checked' : '' }}> Fastive Left <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottom_fastive" value="festive-right"
                                    {{ $product->bottom_fastive == 'festive-right' ? 'checked' : '' }}>Fastive Right <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottom_fastive" value="bottom-image"
                                    {{ $product->bottom_fastive == 'bottom-image' ? 'checked' : '' }}>Bottom Image <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group col-md-6 mt-2">
                              <label for="exampleInputUsername1">Product Barcode</label>
                              <input type="text" class="form-control col-md-12" id="product_barcode" name="product_barcode"  value="{{ $product->product_barcode }}" placeholder="Product Barcode">
                           </div>

                           <div class="form-group col-md-6">
                              <label for="exampleInputUsername1">Product Serial</label>
                              <input type="text" class="form-control col-md-12" id="product_serial" name="product_serial" value="{{ $product->product_serial }}" placeholder="product_serial">
                           </div>
                           <div class="form-group col-md-12 text-center">
                              <a href="#" class="btn btn-info openImageModal" data-target="#mainImage">+ Choose Image</a>
                           </div>
                           
                           <div class="form-group col-md-12 text-center p-2">
                                <div id="mainImagePreview" class="d-flex justify-content-center mt-2">
                                    @if($product->main_image)
                                        @php
                                            $baseUrl = url('storage') . '/';
                                            $mainImagePath = ltrim($product->main_image, '/');
                                            $previewUrl = $baseUrl . $mainImagePath;
                                        @endphp
                                        <img src="{{ $previewUrl }}" style="max-width: 300px;">
                                    @endif
                                </div>
                                <input type="hidden" id="mainImage" value="{{ $product->main_image }}">
                            </div>
                            
                            <div class="col-lg-12 mt-2">
                                <input type="hidden" name="main_image" id="mainImage" value="{{ $product->main_image }}">
                                <div id="mainImagePreview" class="d-flex justify-content-center mt-2"></div>
                            </div>


                          <div class="col-md-12"> <h3 style="color:#333"> About Pricing</h3></div>

                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Regular Price</label>
                              <input type="text" class="form-control" id="price" name="price"  value="{{ $product->price }}" placeholder="Price">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale Price</label>
                              <input type="text" class="form-control" id="sale_price" value="{{ $product->sale_price }}" name="sale_price" placeholder="Price">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale Price From Date</label>
                              <input type="text" class="form-control" id="sale_from_dates"  value="{{ $product->sale_from_dates }}" name="sale_from_dates" placeholder="From Date">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale PriceTo Date</label>
                              <input type="text" class="form-control" id="Sale_to_dates" name="Sale_to_dates"  value="{{ $product->Sale_to_dates }}" placeholder="To Date">
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <!-- Tax content -->
                  <div class="card">
                     <div class="card-header" id="headingPricing">
                        <h5 class="mb-0">
                           <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseTax" aria-expanded="true" aria-controls="collapseTax">
                           About Tax
                           </button>
                        </h5>
                     </div>
                     <div id="collapseTax" class="collapse" aria-labelledby="headingPricing" data-parent="#productAccordion">
                        <div class="card-body row" style="width: 720px;">
                           <div class="form-group col-md-6">
                              <label class="col-form-label">Tax Status</label>
                              <div class="">
                                 <select class="form-control" id="tax_status" name="tax_status">
                                    <option value="">Select Option</option>
                                    <option value="Standrnd" {{ $product->tax_status == 'Standrnd' ? 'selected' : '' }}>Standrnd</option>
                                    <option value="Cloths" {{ $product->tax_status == 'Cloths' ? 'selected' : '' }}>Cloths</option>
                                    <option value="Misc" {{ $product->tax_status == 'Misc' ? 'selected' : '' }}>Misc</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label class="col-form-label">Tax Class</label>
                              <div class="">
                                 <select class="form-control" id="tax_class" name="tax_class">
                                    <option value="">Select Option</option>
                                    <option value="Taxable" {{ $product->tax_class == 'Taxable' ? 'selected' : '' }}>Taxable</option>
                                    <option value="Shipping only" {{ $product->tax_class == 'Shipping only' ? 'selected' : '' }}>Shipping only</option>
                                    <option value="None" {{ $product->tax_class == 'None' ? 'selected' : '' }}>None</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Shipping -->
                  <div class="card">
                     <div class="card-header" id="headingShipping">
                        <h5 class="mb-0">
                           <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseShipping" aria-expanded="true" aria-controls="collapseShipping">
                           Shipping
                           </button>
                        </h5>
                     </div>
                     <div id="collapseShipping" class="collapse" aria-labelledby="headingShipping" data-parent="#productAccordion">
                        <div class="card-body row">
                           <!-- Shipping content -->
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="length"  value="{{ $product->length }}" name="length" placeholder="Length">
                           </div>
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="width" value="{{ $product->width }}" name="width" placeholder="Width">
                           </div>
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="height" value="{{ $product->height }}" name="height" placeholder="Height">
                           </div>
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Weight (kg)</label>
                              <input type="text" class="form-control" id="weight_kg" name="weight_kg" value="{{ $product->weight_kg }}" placeholder="Weight">
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Inventory -->
                  <div class="card">
                     <div class="card-header" id="headingInventory">
                        <h5 class="mb-0">
                           <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseInventory" aria-expanded="true" aria-controls="collapseInventory">
                           Inventory
                           </button>
                        </h5>
                     </div>
                     <div id="collapseInventory" class="collapse" aria-labelledby="headingInventory" data-parent="#productAccordion">
                        <div class="card-body row">
                           <!-- Inventory content -->
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Stock Management</label>
                              <div class="form-check form-check-flat form-check-primary col-md-12">
                                 <label class="form-check-label">
                                 <input 
                                 type="checkbox" 
                                 class="form-check-input" 
                                 name="stock_management" 
                                 id="stock_management" 
                                 value="Y"
                                 {{ $product->stock_management == '1' ? 'checked' : '' }}>
                                 Track stock quantity for this product
                                 <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Sold Individually</label>
                              <div class="form-check form-check-flat form-check-primary col-md-12">
                                 <label class="form-check-label">
                                 <label class="form-check-label">
                                 <input 
                                 type="checkbox" 
                                 class="form-check-input" 
                                 name="sold_individually" 
                                 id="sold_individually" 
                                 value="Y"
                                 {{ $product->stock_management == '1' ? 'checked' : '' }}>
                                 Limit purchases to 1 item per order
                                 <i class="input-helper"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group row">
                                 <label class="col-sm-12 col-form-label">Stock status</label>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" value="Y"
                                       {{ $product->stock_status == 'Y' ? 'checked' : '' }}> In stock <i class="input-helper"></i>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" value="N"
                                       {{ $product->stock_status == 'N' ? 'checked' : '' }}> Out of stock <i class="input-helper"></i>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" value="On backorder"
                                       {{ $product->stock_status == 'On backorder' ? 'checked' : '' }}> On backorder <i class="input-helper"></i>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
         <div class="card" style="max-height: 600px; overflow-y: auto;">
            <div class="card-body">
               <h4 class="card-title">Select Options</h4>
               <div class="accordion" id="accordionOptions">
                  <div class="card">
                     <div class="card-header p-2" id="headingCategory">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseCategory">
                           Select Category
                           </button>
                        </h6>
                     </div>
                     <div id="collapseCategory" class="collapse show" data-parent="#accordionOptions">
                        <div class="card-body">
                           <div class="form-group">
                              <label>Main Menu</label>
                              <select name="main_menu_id" id="mainMenuSelect" class="form-control" required>
                                 <option value="">Select Main Menu</option>
                                 @foreach($mainMenus as $main)
                                 <option value="{{ $main->id }}" {{ $product->main_menu_id == $main->id ? 'selected' : '' }}>{{ $main->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group">
                              <label>Sub Menu</label>
                              <select name="sub_menu_id" id="subMenuSelect" class="form-control">
                                 <option value="">Select Sub Menu</option>
                                 @foreach($subMenus as $sub)
                                 <option value="{{ $sub->id }}" {{ $product->sub_menu_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group">
                              <label>Child Menu</label>
                              <select name="child_menu_id" id="childMenuSelect" class="form-control">
                                 <option value="">Select Child Menu</option>
                                 @foreach($childMenus as $child)
                                 <option value="{{ $child->id }}" {{ $product->child_menu_id == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                    
                  <div class="card">
                     <div class="card-header p-2" id="headingColor">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseThumbnail">
                           Select Thumbnail Images
                           </button>
                        </h6>
                     </div>
                     <div id="collapseThumbnail" class="collapse" data-parent="#accordionOptions">
                        <div class="form-group">
                           <div id="fileUploadContainer">                              
                             <div class="row">
                                 {{-- Hidden input to store thumbnails JSON --}}
                                 <input type="hidden" id="thumbnailImages" name="thumbnail_images" value="[]">
                                 {{-- Thumbnail preview container --}}
                                 <div id="thumbnailPreview" class="col-md-12">
                                    @foreach($product->thumbnails as $thumb)
                                          <div class="col-12 mb-4 thumbnail-wrapper position-relative p-4 shadow rounded bg-light" data-id="{{ $thumb->id }}">
                                             {{-- Thumbnail Image --}}
                                             <!--img src="/bd-admin/public/storage/{{ $thumb->image_path }}" 
                                                   alt="thumbnail" 
                                                   class="img-thumbnail d-block mx-auto mb-4"
                                                   style="height:auto; width:300px; object-fit:contain; border-radius:12px;"--->
                                                   <img src="{{ asset('storage/'.$thumb->image_path) }}"
                                                   alt="thumbnail" 
                                                   class="img-thumbnail d-block mx-auto mb-4"
                                                   style="height:auto; width:300px; object-fit:contain; border-radius:12px;">

                                             {{-- Remove Button --}}
                                             <button type="button" 
                                                      class="btn btn-sm btn-danger remove-thumbnail"
                                                      data-src="{{ $thumb->image_path }}"
                                                      style="position: absolute; top: 10px; right: 10px; border-radius:50%;">
                                                &times;
                                             </button>

                                             <div class="row">
                                                {{-- Color Select --}}
                                                <div class="col-md-12 mb-3">
                                                      <label class="form-label col-md-12 fw-bold">Color</label>
                                                      <select class="form-select form-control-sm col-md-12 color-select">
                                                         <option value="">-- Select Color --</option>
                                                         @foreach($allColors as $color)
                                                            <option value="{{ $color->id }}" 
                                                                  {{ $thumb->thumb_color == $color->id ? 'selected' : '' }}>
                                                                  {{ $color->color_name }}
                                                            </option>
                                                         @endforeach
                                                      </select>
                                                </div>

                                                {{-- Body Size --}}
                                                <div class="col-md-12 mb-3">
                                                      <label class="form-label col-md-12 fw-bold">Body Size</label>
                                                      <select class="form-select form-control-sm col-md-12 body-size-select">
                                                         <option value="">-- Select Body Size --</option>
                                                         @foreach($allBodySizes as $size)
                                                            <option value="{{ $size->id }}" 
                                                                  {{ $thumb->thumb_size == $size->id ? 'selected' : '' }}>
                                                                  {{ $size->body_size }}
                                                            </option>
                                                         @endforeach
                                                      </select>
                                                </div>

                                                {{-- Common Size --}}
                                                <div class="col-md-12 mb-3">
                                                      <label class="form-label col-md-12 fw-bold">Common Size</label>
                                                      <select class="form-select form-control-sm col-md-12 common-size-select">
                                                         <option value="">-- Select Common Size --</option>
                                                         @foreach($allCommonSizes as $common)
                                                            <option value="{{ $common->id }}" 
                                                                  {{ $thumb->thumb_common_size == $common->id ? 'selected' : '' }}>
                                                                  {{ $common->common_size }}
                                                            </option>
                                                         @endforeach
                                                      </select>
                                                </div>
                                             </div>

                                             {{-- Barcode --}}
                                             <div class="mb-3 col-md-12">
                                                <label class="form-label col-md-12 fw-bold">Barcode</label>
                                                <input type="text" class="form-control form-control-sm col-md-12  barcode-input" 
                                                         value="{{ $thumb->thumb_barcode }}">
                                             </div>

                                             <!-- Add Option button -->
                                             <div class="thumbnail-wrapper" data-id="{{ $thumb->id }}" 
                                                data-options='@json($thumb->options->map(function($o){ return [
                                                      "common_size_id"=>$o->common_size_id,
                                                      "body_size_id"=>$o->body_size_id,
                                                      "barcode"=>$o->barcode
                                                ]; }))'>
                                                <img style="display:none" src="{{ $thumb->image_path }}" class="img-thumbnail" style="width:150px;">
                                                <button type="button" class="btn btn-sm btn-info add-thumb-option">Add/View/Edit Options</button>
                                             </div>
                                          </div>
                                    @endforeach
                                 </div>
                              </div>
                              <div class="input-group p-2">
                                 <!--a href="#" class="btn btn-info btn-block openImageModal" data-target="#thumbnailImages">+ Add Thumbnail Images</a-->
                                 <input type="file" id="localThumbnailInput" class="d-none" multiple accept="image/*">
                                 <input type="hidden" id="product_id" value="{{ $product->id ?? 1 }}">
                                 <a href="#" style="background-color: green !important;" class="btn  btn-block btn-lg  openImageModal openThumbnailOption" data-target="#thumbnailImages">+ Add Thumbnail Images</a>
                              </div>
                           </div>
                           
                           
                           
                        </div>
                     </div>
                  </div>
                  <!-- Common Size Accordion -->
                  <div class="card"  style="display:none">
                     <div class="card-header p-2" id="headingSize">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseSize">
                           Select Common Size
                           </button>
                        </h6>
                     </div>
                     <div id="collapseSize" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                           @foreach($commonSizes as $commonsize)
                           <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox"
                                       name="common_sizes[]"
                                       value="{{ $commonsize->id }}"
                                       class="form-check-input"
                                       {{ in_array($commonsize->id, $selectedSizes) ? 'checked' : '' }}>
                                 {{ $commonsize->common_size }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <!-- Body Size Accordion -->
                  <div class="card"  style="display:none">
                     <div class="card-header p-2" id="headingBody">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseBody">
                           Select Body Size
                           </button>
                        </h6>
                     </div>
                     <div id="collapseBody" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                          @foreach($bodySizes as $bodysize)
                           <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox"
                                       name="body_sizes[]"
                                       value="{{ $bodysize->id }}"
                                       class="form-check-input"
                                       {{ in_array($bodysize->id, $selectedBodySizes) ? 'checked' : '' }}>
                                 {{ $bodysize->body_size }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <!-- Color Accordion -->
                  <div class="card" style="display:none">
                     <div class="card-header p-2" id="headingColor" >
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseColor">
                           Select Color
                           </button>
                        </h6>
                     </div>
                     <div id="collapseColor" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                          @foreach($dressColor as $dresscolor)
                           <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox"
                                       name="colors[]"
                                       value="{{ $dresscolor->id }}"
                                       class="form-check-input"
                                       {{ in_array($dresscolor->id, $selectedColor) ? 'checked' : '' }}>
                                 {{ $dresscolor->color_name }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header p-2" id="headingColor">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseStatus">
                           Select Wash
                           </button>
                        </h6>
                     </div>
                     <div id="collapseStatus" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                          @foreach($washStatus as $washstatus)
                           <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox"
                                       name="statuses[]"
                                       value="{{ $washstatus->id }}"
                                       class="form-check-input"
                                       {{ in_array($washstatus->id, $selectedWashStatus) ? 'checked' : '' }}>
                                 {{ $washstatus->status }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <!-- Dry Status -->
                  <div class="card">
                     <div class="card-header p-2" id="headingDry">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseDryStatus">
                           Dry Wash
                           </button>
                        </h6>
                     </div>
                     <div id="collapseDryStatus" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                         @foreach($dryWash as $productdrywash)
                           <div class="form-check">
                                 <label class="form-check-label">
                                    <input type="checkbox" 
                                          name="dry_washes[]" 
                                          value="{{ $productdrywash->id }}" 
                                          class="form-check-input"
                                          {{ in_array($productdrywash->id, $selectedDryWashes) ? 'checked' : '' }}>
                                    {{ $productdrywash->drywash_name }}
                                 </label>
                              </div>
                           @endforeach
                      </div>
                  </div>
                  <!-- Iron Status -->
                  <div class="card">
                     <div class="card-header p-2" id="headingIron">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseIronStatus">
                           Iron Status
                           </button>
                        </h6>
                     </div>
                     <div id="collapseIronStatus" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                          @foreach($iron as $productiron)
                           <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox" 
                                 name="irons[]" 
                                 value="{{ $productiron->id }}" 
                                 class="form-check-input"
                                 {{ $product->irons->contains($productiron->id) ? 'checked' : '' }}>
                                 {{ $productiron->iron_name }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                 
               </div>
            </div>
         </div>
      </div>
     </div>
   </div>
   <div class="col-md-12 text-center">
         <button type="button" class="btn btn-primary" id="submitUpdateProductBtn">Update Product</button>
         <!--button id="updateProductBtn" class="btn btn-success">Update Product</button-->
         <a href="{{ route('product.list') }}" class="btn btn-secondary">Back</a>
      </div>
</div>
<!-- Image Selection Modal -->
<div class="modal fade" id="imageSelectModal" tabindex="-1" role="dialog" aria-labelledby="imageSelectModalLabel" aria-hidden="true" style="max-height: 500px; overflow-y: auto;">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Select Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <div class="modal-footer">
               <button type="button" id="useSelectedImages" class="btn btn-primary">Use Selected Images</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           </div>                                   
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="imageTab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" id="upload-tab" data-toggle="tab" href="#uploadImage" role="tab">Upload</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#galleryImage" role="tab">Gallery</a>
               </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content p-3 border">
               <!-- Upload Tab -->
               <div class="tab-pane fade show active" id="uploadImage" role="tabpanel">
                  <form id="imageUploadForm" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="file" name="image" id="imageFileInput" class="form-control">
                     <input type="file" id="localThumbnailInput" class="d-none" multiple accept="image/*">
                     <button type="submit" class="btn btn-primary mt-2">Save</button>
                  </form>
               </div>
               <!-- Gallery Tab -->
               <div class="tab-pane fade" id="galleryImage" role="tabpanel">
                  <div class="row">
                    @foreach($galleries as $gallery)
                           <div class="col-md-1 mb-2">
                              <img src="{{ asset('storage/' . $gallery->location) }}" 
                                    class="img-thumbnail gallery-image selectable-img" 
                                    data-location="{{ $gallery->location }}" 
                                    style="cursor: pointer; width:100px; height:100px; ofject-fit:cover">
                           </div>
                      @endforeach
                  </div>
               </div>
            </div>
            <input type="hidden" id="selectedImageTarget" value="">
         </div>
        
      </div>
   </div>
</div>
<div class="modal fade" id="thumbnailUploadOptionModal" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-4">
         <h5>Select image source</h5>
         <button class="btn btn-success btn-block my-2" id="selectFromLocal">Upload from Device</button>
         <button class="btn btn-info btn-block my-2 " id="selectFromGallery">Select from Gallery</button>
      </div>
   </div>
</div>

<!-- Thumbnail Option Modal -->
<div class="modal fade" id="thumbOptionModal" tabindex="-1" role="dialog" aria-labelledby="thumbOptionModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header py-2">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
         <div class="d-flex align-items-center mb-3">
            <img id="thumbOptionPreview" src="" alt="preview" class="img-thumbnail mr-3" style="height:60px;width:auto;">
            <div class="small text-muted">
            Add  Multiple Size And Barcode
            </div>
         </div>

         <!-- Rows container -->
         <div id="thumbOptionRows"></div>

         <!-- Add Row button -->
         <div class="mt-3">
            <button type="button" class="btn btn-outline-success btn-sm" id="addThumbOptionRow">
               + Add Row
            </button>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Colse</button>
        <button type="button" class="btn btn-primary" id="saveThumbOptionsBtn" disabled>Save</button>
      </div>
    </div>
  </div>
</div>


@endsection  
@section('script')

<!-- jQuery & jQuery UI JS -->
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
   // ========== Global Declarations ==========
let productDetailsEditor;
let selectedTarget = '';
let selectedType = '';
let thumbnailArray = [];
let activeThumbEl = null;
let allColors = @json($allColors);
let allBodySizes = @json($allBodySizes);
let allCommonSizes = @json($allCommonSizes);
let hiddenInput = $('#thumbnailImages'); 
const menus = @json($mainMenus);
//const baseUrl = '/storage/';

const baseUrl = "{{ url('storage') }}/"



// Gallery বা local upload থেকে image select হলে
function setMainImage(path) {
    if (!path) return;

    // full URL থাকলে শুধু relative path বানাও
    path = path.replace(/^https?:\/\/[^/]+\/bd-admin\/public\/storage\//, '');

    // hidden input এ শুধু relative path রাখো
    $('#mainImage').val(path);

    // preview তে দেখাও root থেকে শুরু হওয়া path
    const fullUrl = baseUrl + path;
    $('#mainImagePreview').html('<img src="' + fullUrl + '" style="max-width:300px;">');
}

// Edit page load হলে preview show করো
$(document).ready(function() {
    const currentPath = $('#mainImage').val();
    if (currentPath) {
        const fullUrl = baseUrl + currentPath.replace(/^https?:\/\/[^/]+\/bd-admin\/public\/storage\//, '');
        $('#mainImagePreview').html('<img src="' + fullUrl + '" style="max-width:300px;">');
    }
});

// ===== Normalize path for preview =====





   tinymce.init({
        selector: '#productDetailsEditor',
        license_key: 'gpl',
        height: 500,
        plugins: 'advlist autolink lists link image charmap preview anchor code fullscreen table',
        toolbar: 'undo redo | styleselect | bold italic underline strikethrough | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertMapBtn | code fullscreen table',
        menubar: false,

        // Iframe allow
        extended_valid_elements: 'iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen]',

        // Fonts
        fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt',
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; Georgia=georgia,palatino; Tahoma=tahoma,arial,helvetica,sans-serif; Times New Roman=times new roman,times; Verdana=verdana,geneva;',

        // Image Upload
        automatic_uploads: true,
        images_upload_url: "{{ route('tinymce.upload') }}",
        relative_urls: false,
        remove_script_host: false,
        document_base_url: "{{ url('/') }}/",

        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype === 'image') {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var formData = new FormData();
                    formData.append('file', file);

                    fetch("{{ route('tinymce.upload') }}", {
                        method: "POST",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => callback(data.location))
                    .catch(() => alert('Image upload failed'));
                };
                input.click();
            }
        },

        // Custom Button for Google Map
        setup: function(editor) {
            editor.ui.registry.addButton('insertMapBtn', {
                text: '📍 Map',
                onAction: function() {
                    let mapIframe = `<iframe src="https://www.google.com/maps?q=House+no,+2/9+Block+D,+Lalmatia-Mohammadpur,+Dhaka&output=embed"
                                       width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>`;
                    editor.insertContent(mapIframe);
                }
            });
        }
    });








      $(document).ready(function () {
         $('input[type="radio"]').click(function () {
            let $this = $(this);
            if ($this.data('waschecked') == true) {
                  $this.prop('checked', false);
                  $this.data('waschecked', false);
            } else {
                  $('input[name="' + $this.attr('name') + '"]').data('waschecked', false);
                  $this.data('waschecked', true);
            }
         });
      });

   
   

     // Open modal & load existing options
    /*  $(document).on('click', '.add-thumb-option', function () {
         activeThumbEl = $(this).closest('.thumbnail-wrapper');

         // Clear modal rows
         $('#thumbOptionRows').html('');

         // Load existing options
         const existingOptions = activeThumbEl.data('options') || [];
         existingOptions.forEach(opt => {
            $('#thumbOptionRows').append(generateOptionRow(allCommonSizes, allBodySizes, opt));
         });

         $('#thumbOptionModal').modal('show');
      });*/
      
      
    $(document).on('click', '.add-thumb-option', function () {
        activeThumbEl = $(this).closest('.thumbnail-wrapper');
    
        $('#thumbOptionRows').html('');
    
        // ✅ থাম্বনেইল ইমেজ ধরো
        let imgSrc = activeThumbEl.find('img').attr('src') || '';
    
        // যদি image path শুধু filename বা gallery/... হয়
        if (imgSrc && !imgSrc.startsWith('/storage/')) {
            imgSrc = '/storage/' + imgSrc;
        }
    
        console.log('Preview path:', imgSrc);
    
        // ✅ প্রিভিউ তে দাও
        $('#thumbOptionPreview').attr('src', imgSrc);
    
        // Load existing options
        const existingOptions = activeThumbEl.data('options') || [];
        existingOptions.forEach(opt => {
            $('#thumbOptionRows').append(generateOptionRow(allCommonSizes, allBodySizes, opt));
        });
    
        $('#saveThumbOptionsBtn').prop('disabled', false);
        $('#thumbOptionModal').modal('show');
    });


      
      
      

     // Save modal options
    $(document).on('click', '#saveThumbOptionsBtn', function () {
        if (!activeThumbEl) return;
    
        let options = [];
        $('#thumbOptionRows .thumb-option-row').each(function () {
            options.push({
                id: $(this).data('id') || null,
                common_size_id: $(this).find('.common-size-select').val() || null,
                body_size_id: $(this).find('.body-size-select').val() || null,
                barcode: $(this).find('.barcode-input').val() || null
            });
        });
    
        // Save in thumbnail wrapper's data
        activeThumbEl.data('options', options);
    
        // Update hidden input for AJAX submit
        updateThumbnailInput();
    
        $('#thumbOptionModal').modal('hide');
        toastr.success('Options saved for this thumbnail!');
    });





   //  Row generator
   function generateOptionRow(commonSizes, bodySizes, data = {}) {
      let commonSizeOptions = '<option value="">-- Select Common Size --</option>';
      commonSizes.forEach(s => {
         commonSizeOptions += `<option value="${s.id}" ${s.id == data.common_size_id ? 'selected' : ''}>${s.common_size}</option>`;
      });

      let bodySizeOptions = '<option value="">-- Select Body Size --</option>';
      bodySizes.forEach(s => {
         bodySizeOptions += `<option value="${s.id}" ${s.id == data.body_size_id ? 'selected' : ''}>${s.body_size}</option>`;
      });

      let barcode = data.barcode ?? '';

      return `
         <div class="row align-items-end mb-2 thumb-option-row border p-2 rounded">
            <div class="col-md-4">
               <label class="small fw-bold">Common Size</label>
               <select class="form-control form-control-sm common-size-select">
                  ${commonSizeOptions}
               </select>
            </div>
            <div class="col-md-4">
               <label class="small fw-bold">Body Size</label>
               <select class="form-control form-control-sm body-size-select">
                  ${bodySizeOptions}
               </select>
            </div>
            <div class="col-md-3">
               <label class="small fw-bold">Barcode</label>
               <input type="text" class="form-control form-control-sm barcode-input" value="${barcode}">
            </div>
            <div class="col-md-1 text-right">
               <button type="button" class="btn btn-sm btn-danger remove-option-row">&times;</button>
            </div>
         </div>
      `;
   }


   // + Add Row
   $('#addThumbOptionRow').on('click', function () {
      $('#thumbOptionRows').append(generateOptionRow(allCommonSizes, allBodySizes));
      $('#saveThumbOptionsBtn').prop('disabled', false);
   });

   // Remove row
   $(document).on('click', '.remove-option-row', function () {
      $(this).closest('.thumb-option-row').remove();
      if ($('#thumbOptionRows .thumb-option-row').length === 0) {
         $('#saveThumbOptionsBtn').prop('disabled', true);
      }
   });

   


   //============end add option script===============
   
   
   $(document).ready(function () {
   const initial = $('#thumbnailImages').val();
   if (initial) {
       thumbnailArray = initial.split(',');
   }
   });
   
   // ========== Document Ready ==========
   document.addEventListener("DOMContentLoaded", function () {
   
   $(document).ready(function () {
       // Home View Toggle
       $('#site_view_status').on('change', function () {
           if ($(this).is(':checked')) {
               $('#homeViewOptions').slideDown();
           } else {
               $('#homeViewOptions').slideUp();
           }
       });
       if ($('#site_view_status').is(':checked')) {
           $('#homeViewOptions').show();
       }
   });
   
  

    // Menu Cascading
   $('#mainMenuSelect').on('change', function () {
       const mainId = $(this).val();
       const subMenuSelect = $('#subMenuSelect').empty().append('<option value="">Select Sub Menu</option>');
       const childMenuSelect = $('#childMenuSelect').empty().append('<option value="">Select Child Menu</option>').prop('disabled', true);
   
       const selectedMain = menus.find(m => m.id == mainId);
       if (selectedMain?.sub_menus.length) {
           subMenuSelect.prop('disabled', false);
           selectedMain.sub_menus.forEach(sub => subMenuSelect.append(`<option value="${sub.id}">${sub.name}</option>`));
       } else {
           subMenuSelect.prop('disabled', true);
       }
   });
   
   $('#subMenuSelect').on('change', function () {
       const mainId = $('#mainMenuSelect').val();
       const subId = $(this).val();
       const childMenuSelect = $('#childMenuSelect').empty().append('<option value="">Select Child Menu</option>');
   
       const selectedMain = menus.find(m => m.id == mainId);
       const selectedSub = selectedMain?.sub_menus.find(s => s.id == subId);
   
       if (selectedSub?.child_menus.length) {
           childMenuSelect.prop('disabled', false);
           selectedSub.child_menus.forEach(child => childMenuSelect.append(`<option value="${child.id}">${child.name}</option>`));
       } else {
           childMenuSelect.prop('disabled', true);
       }
   });    
   
   
   
   

// ✅ Thumbnail append function

 // ================= Thumbnail Append Function =================
function appendImageToPreview(container, hiddenInput, imgSrc, data = {}) {
    let id = data.id ?? '';
    let color = data.thumb_color ?? '';
    let bodySize = data.thumb_size ?? '';
    let commonSize = data.thumb_common_size ?? '';
    let barcode = data.thumb_barcode ?? '';
    let options = data.options ?? [];

    let imagePath = data.image_path ?? imgSrc;
    let previewUrl = '';

    // ====================================================
    // ✅ FIX PART: local device file support
    // ====================================================
    if (imagePath instanceof File) {
        // local file → blob preview
        previewUrl = URL.createObjectURL(imagePath);

    } else {
        // ====================================================
        // existing gallery / stored image logic
        // ====================================================

        // === Step 1: full URL হলে relative path বের করা ===
        if (typeof imagePath === 'string' && imagePath.startsWith('http')) {
            try {
                const url = new URL(imagePath);
                const match = url.pathname.match(/storage\/(.+)$/);
                if (match) imagePath = match[1];
            } catch (e) {
                console.warn('Invalid URL:', imagePath);
            }
        } else if (typeof imagePath === 'string') {
            imagePath = imagePath
                .replace(/^\/?bd-admin\/public\/storage\//, '')
                .replace(/^\/?storage\//, '');
        }

        // === Step 2: Preview URL (server image) ===
        previewUrl = "{{ url('storage') }}/" + imagePath;
    }

    // ====================================================
    // === Step 3: Append HTML (unchanged)
    // ====================================================
    container.append(`
        <div class="col-12 mb-4 thumbnail-wrapper position-relative p-4 shadow rounded bg-light" data-id="${id}">
            <img src="${previewUrl}" class="img-thumbnail d-block mx-auto mb-4" 
                 style="width:300px; object-fit:contain; border-radius:12px;">
            <button type="button" class="btn btn-sm btn-danger remove-thumbnail" 
                    data-src="${previewUrl}" style="position:absolute; top:10px; right:10px; border-radius:50%;">&times;</button>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Color</label>
                    <select class="form-select form-control-sm color-select">${generateOptions(allColors, color)}</select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Body Size</label>
                    <select class="form-select form-control-sm body-size-select">${generateOptions(allBodySizes, bodySize)}</select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Common Size</label>
                    <select class="form-select form-control-sm common-size-select">${generateOptions(allCommonSizes, commonSize)}</select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Barcode</label>
                <input type="text" class="form-control form-control-sm barcode-input" value="${barcode}">
            </div>

            <div class="mb-2">
                <button type="button" class="btn btn-outline-primary btn-sm add-thumb-option">
                    Add/View/Edit Option
                </button>
            </div>
        </div>
    `);

    updateThumbnailInput();
}


// ================= Update Hidden Input =================
// Update hidden input
function updateThumbnailInput() {
    let thumbnails = [];
    $('#thumbnailPreview .thumbnail-wrapper').each(function() {
        let imgSrc = $(this).find('img').attr('src') || '';

        // hidden input-এ শুধু relative path রাখার জন্য
        if(imgSrc.includes('/storage/')){
            imgSrc = imgSrc.replace('/storage/', '');
        }
        if(imgSrc.startsWith('/')){
            imgSrc = imgSrc.slice(1);
        }

        thumbnails.push({
            id: $(this).data('id') ?? null,
            image_path: imgSrc, // শুধু relative path
            thumb_color: $(this).find('.color-select').val() || null,
            thumb_size: $(this).find('.body-size-select').val() || null,
            thumb_common_size: $(this).find('.common-size-select').val() || null,
            thumb_barcode: $(this).find('.barcode-input').val() || null,
            options: $(this).data('options') || []
        });
    });

    $('#thumbnailImages').val(JSON.stringify(thumbnails));
}



// ================= Remove Thumbnail Button =================
$(document).on('click', '.remove-thumbnail', function() {
    $(this).closest('.thumbnail-wrapper').remove();
    updateThumbnailInput();
});







   function generateOptions(list, selectedId) {
      let html = `<option value="">-- Select --</option>`;
      list.forEach(item => {
         let val = item.id;
         let name = item.color_name ?? item.body_size ?? item.common_size;
         html += `<option value="${val}" ${val == selectedId ? 'selected' : ''}>${name}</option>`;
      });
      return html;
   }




/*function updateThumbnailInput() {
    let thumbnails = [];
    $('#thumbnailPreview .thumbnail-wrapper').each(function () {
        thumbnails.push({
            id: $(this).data('id') ?? null,
            image_path: $(this).find('img').attr('src'),
            thumb_color: $(this).find('.color-select').val() || null,
            thumb_size: $(this).find('.body-size-select').val() || null,
            thumb_common_size: $(this).find('.common-size-select').val() || null,
            thumb_barcode: $(this).find('.barcode-input').val() || null,
            options: $(this).data('options') || []
            
        });
    });

    $('#thumbnailImages').val(JSON.stringify(thumbnails));
}




// Remove thumbnail
$(document).on('click', '.remove-thumbnail', function() {
    $(this).closest('.thumbnail-wrapper').remove();
    updateThumbnailInput();
});*/

// Update hidden input on change
$(document).on('change', '.color-select, .body-size-select, .common-size-select, .barcode-input', function() {
    updateThumbnailInput();
});

// On page load, make sure hidden input matches preview
$(document).ready(function () {
    updateThumbnailInput();
});



   // Edit page load
      const val = hiddenInput.val();
      if (val) {
         let thumbnails = [];
         try {
            thumbnails = JSON.parse(val);
         } catch(e) {
            console.warn("Invalid JSON in #thumbnailImages, defaulting to empty array");
            thumbnails = [];
         }
         thumbnails.forEach(thumb => {
            appendImageToPreview(container, hiddenInput, thumb.image_path, thumb);
         });
      }


      
   // Modal Image Selection
   $(document).on('click', '.openImageModal', function (e) {
       e.preventDefault();
       selectedTarget = $(this).data('target');
       $('#selectedImageTarget').val(selectedTarget);
       $('#imageSelectModal').modal('show');
   });
   
   $(document).on('click', '.gallery-image', function () {

    const baseUrl = "{{ url('/') }}";
    const rawPath = $(this).attr('data-location').replace(/^\/+/, '');

    const cleanPath = rawPath.startsWith('gallery/')
        ? rawPath
        : 'gallery/' + rawPath.replace(/^storage\/gallery\//, '');

    const fullUrl = baseUrl + "/storage/" + cleanPath;

    if (selectedTarget === '#mainImage') {

        // DB → only relative path
        $('#mainImage').val(cleanPath);

        // Preview → correct absolute URL
        $('#mainImagePreview').html(
            `<img src="${fullUrl}" alt="Main Image" style="max-width:300px;">`
        );

        $('#imageSelectModal').modal('hide');

    } else if (selectedTarget === '#thumbnailImages') {
        $(this).toggleClass('selected');
    }
});


$('#useSelectedImages, #confirmGallerySelection').on('click', function () {
    const baseUrl = window.location.origin + '/';
    const selectedImages = $('.gallery-image.selected, #galleryImages input[type="checkbox"]:checked')
        .map(function () {
            const rawPath = $(this).attr('data-location').replace(/^\/+/, '');
            const cleanPath = rawPath.startsWith('gallery/') ? rawPath : 'gallery/' + rawPath.replace(/^storage\/gallery\//, '');
            return cleanPath;
        }).get();

    const hiddenInput = $(selectedTarget);
    selectedImages.forEach(path => {
        const fullUrl = baseUrl + '/storage/' + path;
        appendImageToPreview($('#thumbnailPreview'), hiddenInput, fullUrl, { image_path: path });
    });
    $('#imageSelectModal').modal('hide');
    toastr.success("Gallery images added!");
});imageUploadForm
   
   // Local Upload
   $(document).on('click', '.openThumbnailOption', function () {
       selectedTarget = $(this).data('target');
       selectedType = $(this).data('type');
       $('#thumbnailUploadOptionModal').modal('show');
   });
   
   $('#selectFromLocal').on('click', function () {
       $('#thumbnailUploadOptionModal').modal('hide');
       $('#imageSelectModal').modal('hide');
       $('#localThumbnailInput').click();
   });
   
   $('#selectFromGallery').on('click', function () {
       $('#thumbnailUploadOptionModal').modal('hide');
   });
   
  $('#localThumbnailInput').on('change', function () {
    const files = this.files;
    if (!files.length) return;
    let formData = new FormData();
    formData.append('product_id', $('#product_id').val());
    Array.from(files).forEach((file, i) => formData.append(`images[${i}]`, file));

    $.ajax({
        url: "{{ route('upload.thumbnails') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.status === 'success') {
                const baseUrl = window.location.origin + '/';
                res.thumbnails.forEach(item => {
                    const relativePath = item.url.split('/storage/')[1]; // gallery/filename.jpg
                    const fullUrl = baseUrl + '/storage/' + relativePath;
                    appendImageToPreview($('#thumbnailPreview'), $('#thumbnailImages'), fullUrl, { image_path: relativePath });
                });
                toastr.success("Images Saved!");
            } else {
                toastr.warning("Upload failed: " + res.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            toastr.error('Upload failed!');
        }
    });
});


   // ========== Main Image Upload local divice ==========
  /* $('#imageUploadForm').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('upload.gallery.image') }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.url) {
                // res.url = full URL (e.g. https://dev.khut.shop/bd-admin/public/storage/gallery/abc.jpg)
                const relativePath = res.url.split('/storage/')[1]; // gallery/abc.jpg
                const fullUrl = window.location.origin + '/storage/' + relativePath;

                $('#mainImage').val(relativePath);
                $('#mainImagePreview').html(`<img src="${fullUrl}" alt="Preview" class="img-fluid" style="max-height: 200px;">`);

                $('#imageSelectModal').modal('hide');
                toastr.success('Image Saved!');
            } else {
                toastr.error('Invalid response!');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            toastr.error('Image upload failed.');
        }
    });
});*/


const appUrl = "{{ url('') }}"; // https://khut.shop/bd-admin/public

// ======= Local file preview =======
$('#mainImageInput').on('change', function(e) {
    const file = this.files[0];
    if (!file) return;

    // Show preview immediately
    const reader = new FileReader();
    reader.onload = function(e) {
        $('#mainImagePreview').html(
            `<img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">`
        );
    };
    reader.readAsDataURL(file);
});

// ======= AJAX upload form =======
$('#imageUploadForm').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('upload.gallery.image') }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.url) {
                // res.url = full URL returned by server
                // extract relative path after /storage/
                const relativePath = res.url.split('/storage/')[1]; // gallery/abc.jpg

                // Correct full URL using APP_URL
                const fullUrl = appUrl + '/storage/' + relativePath;

                // Update hidden input
                $('#mainImage').val(relativePath);

                // Show preview
                $('#mainImagePreview').html(
                    `<img src="${fullUrl}" class="img-fluid" style="max-height: 200px;">`
                );

                // Hide modal
                $('#imageSelectModal').modal('hide');

                toastr.success('Image Saved!');
            } else {
                toastr.error('Invalid response!');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            toastr.error('Image upload failed.');
        }
    });
});
   
   
   
 

   
   // Datepicker
   $('#sale_from_dates, #Sale_to_dates').datepicker({ dateFormat: 'yy-mm-dd' });
   
   // Submit Update
   $.ajaxSetup({
       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
   });
   
$('#submitUpdateProductBtn').on('click', function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append('id', $('#productId').val());
    formData.append('name_en', $('#nameEn').val());
    formData.append('name_bn', $('#nameBn').val());
    formData.append('price', $('#price').val());
    formData.append('details', tinymce.get('productDetailsEditor').getContent());
     
    formData.append('main_image', $('#mainImage').val());

    formData.append('main_menu_id', $('#mainMenuSelect').val());
    formData.append('sub_menu_id', $('#subMenuSelect').val());
    formData.append('child_menu_id', $('#childMenuSelect').val());

    formData.append('sale_price', $('#sale_price').val());
    formData.append('sale_from_dates', $('#sale_from_dates').val());
    formData.append('Sale_to_dates', $('#Sale_to_dates').val());
    formData.append('tax_status', $('#tax_status').val());
    formData.append('tax_class', $('#tax_class').val());
    formData.append('weight_kg', $('#weight_kg').val());
    formData.append('length', $('#length').val());
    formData.append('width', $('#width').val());
    formData.append('height', $('#height').val());
    formData.append('product_serial', $('#product_serial').val());
    formData.append('product_barcode', $('#product_barcode').val());

    formData.append('stock_status', $('input[name="stock_status"]:checked').val());
    formData.append('link_status', $('input[name="link_status"]:checked').val());
    formData.append('stock_management', $('#stock_management').is(':checked') ? 1 : 0);
    formData.append('sold_individually', $('#sold_individually').is(':checked') ? 1 : 0);
    formData.append('site_view_status', $('#site_view_status').is(':checked') ? 'Y' : 'N');
    formData.append('published_site', $('#published_site').is(':checked') ? 'Y' : 'N');
    formData.append('festive_collection', $('#festive_collection').is(':checked') ? 'Y' : 'N');
    formData.append('new_arrivals', $('#new_arrivals').is(':checked') ? 'Y' : 'N');
    formData.append('patchwork', $('#patchwork').is(':checked') ? 'Y' : 'N');
    formData.append('feature', $('input[name="feature"]:checked').val());
    formData.append('highlight', $('input[name="highlight"]:checked').val());
    formData.append('bottom_fastive', $('input[name="bottom_fastive"]:checked').val());

    $('input[name="common_sizes[]"]:checked').each(function () {
        formData.append('common_sizes[]', this.value);
    });
    $('input[name="body_sizes[]"]:checked').each(function () {
        formData.append('body_sizes[]', this.value);
    });
    $('input[name="colors[]"]:checked').each(function () {
        formData.append('colors[]', this.value);
    });
    $('input[name="statuses[]"]:checked').each(function () {
        formData.append('statuses[]', this.value);
    });
    $('input[name="irons[]"]:checked').each(function () {
        formData.append('irons[]', this.value);
    });
    $('input[name="dry_washes[]"]:checked').each(function () {
        formData.append('dry_washes[]', this.value);
    });

    // ✅ Collect thumbnails and send as JSON
    let thumbnails = [];
      $('#thumbnailPreview .thumbnail-wrapper').each(function () {
         thumbnails.push({
            id: $(this).data('id') ?? null,
            image_path: $(this).find('img').attr('src'),
            thumb_color: $(this).find('.color-select').val() || null,
            thumb_size: $(this).find('.body-size-select').val() || null,
            thumb_common_size: $(this).find('.common-size-select').val() || null,
            thumb_barcode: $(this).find('.barcode-input').val() || null,
            options: $(this).data('options') || []  // ✅ add this
         });
      });
    formData.append('thumbnail_images', JSON.stringify(thumbnails));

    $.ajax({
        type: "POST",
        url: "{{ url('product/update') }}/" + $('#productId').val(),
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            toastr.success("Product updated successfully!");
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    errors[field].forEach(function (msg) {
                        toastr.error(msg);
                    });
                });
                return;
            }
            if (xhr.status === 419) {
                toastr.error("Session expired. Please refresh the page.");
                return;
            }
            if (xhr.responseJSON && xhr.responseJSON.message) {
                toastr.error(xhr.responseJSON.message);
            } else {
                toastr.error("Something went wrong!");
            }
            console.error(xhr.responseText);
        }
    });
});


});
     
</script>
@endsection