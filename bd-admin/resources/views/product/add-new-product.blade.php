@extends('layout.app')
@section('title', 'Khut::Add New Product')
@section('content')
<div class="container-fluid">
   <div class="page-header">
      <h3 class="page-title">Add New Product</h3>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col-md-8 grid-margin stretch-card" >
         <div class="card" style="max-height: 600px; overflow-y: auto; overflow-x: hidden;">
            <div class="card-body row">
               <div id="productAccordion" class="accordion" style="width: 100%;">
                  <!-- Product Details -->
                  <div class="card">
                     <div class="card-header" id="headingDetails">
                       
                           <button class="btn btn-link" data-toggle="collapse" data-target="#collapseDetails" aria-expanded="true" aria-controls="collapseDetails">
                             Product Details
                           </button>
                       
                     </div>
                     <div id="collapseDetails" class="collapse show" aria-labelledby="headingDetails" data-parent="#productAccordion">
                        <div class="card-body row">
                           <div class="form-group col-md-12">
                              <label for="exampleInputUsername1">Product Name(Eng)</label>
                              <input type="text" class="form-control" id="nameEn" name="name_en" placeholder="Product Name(Eng)">
                           </div>
                           <div class="form-group col-md-12">
                              <label for="exampleInputEmail1">Product Name(Bn)</label>
                              <input type="text" class="form-control" id="nameBn" name="name_bn" placeholder="Product Name(Bn)">
                           </div>
                           <div class="form-group col-md-12">
                              <label >About Details</label>
                              <textarea class="form-control editorDetails" id="productDetailsEditor" name="details" rows="5" placeholder="Enter details..."></textarea>
                           </div>
                           
                           <div class="col-md-12 mt-3">
                              <label for="exampleInputUsername1">Link Options</label>
                           </div>   
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="radio" class="form-check-input" name="link_status" id="link_status" value="Add to Cart" > Add to Cart <i class="input-helper"></i></label>
                              </div>
                           </div>                           
                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="radio" class="form-check-input" name="link_status" id="link_status" value="Read More"> Read More <i class="input-helper"></i></label>
                              </div>
                           </div>

                           <div class="col-sm-12 mt-3">
                               <label for="exampleInputUsername1">Site View Status</label>
                           </div>  
                             
                           <div class="col-sm-3">
                              <div class="form-check">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input" name="site_view_status" id="site_view_status" value="Y"> Show Home <i class="input-helper"></i></label>
                              </div>
                           </div>
                           <div class="col-sm-3">
                              <div class="form-check">
                                 <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="published_site" id="published_site" value="Y"> Published <i class="input-helper"></i></label>
                               </div>
                           </div>
                           <div class="col-sm-3">
                              <div class="form-check">
                                 <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="festive_collection" id="festive_collection" value="fastive-collection"> Festive Collection <i class="input-helper"></i></label>
                               </div>
                           </div>

                           <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="new_arrivals" id="new_arrivals" value="Y"> New Arrivals <i class="input-helper"></i></label>
                               </div>
                           </div>

                            <div class="col-sm-6">
                              <div class="form-check">
                                 <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="patchwork" id="patchwork" value="Y"> Patchwork <i class="input-helper"></i></label>
                               </div>
                           </div>

                           <div class="row p-2" id="homeViewOptions" style="display:none">
                              <div class="col-sm-12 mt-3">
                                 <label for="exampleInputUsername1">Feature Options</label>
                              </div>   
                              <div class="col-sm-6 ">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="feature" id="feature" value="Feature One"> Feature One <i class="input-helper"></i></label>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="feature" id="feature" value="Feature Two"> Feature Two <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-12 mt-3">
                                 <label for="exampleInputUsername1">Hiligth</label>
                              </div>   
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="highlight" id="highlight" value="highlight-one" > Hiligth One <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="highlight" id="highlight" value="highlight-two" > Hiligth Two <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="highlight" id="highlight" value="highlight-three" > Hiligth three <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="highlight" id="highlight" value="highlight-four" > Hiligth Four <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-12 mt-3">
                                 <label for="exampleInputUsername1">Options Bottom/Fastive Collection</label>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="bottom_fastive" id="bottom_fastive" value="festive-left" > Festive Left <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="bottom_fastive" id="bottom_fastive" value="festive-right" > Festive Right <i class="input-helper"></i>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="bottom_fastive" id="bottom_fastive" value="bottom-image">Bottom Image<i class="input-helper"></i>
                                    <i class="input-helper"></i></label>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group col-md-6 mt-2">
                              <label for="exampleInputUsername1">Product Barcode</label>
                              <input type="text" class="form-control col-md-12" id="product_barcode" name="product_barcode" placeholder="Product Barcode">
                           </div>

                           <div class="form-group col-md-6 mt-2">
                              <label for="exampleInputUsername1">Product Serial</label>
                              <input type="text" class="form-control col-md-12" id="product_serial" name="product_serial" placeholder="Product Serial">
                           </div>

                           

                           <div class=" col-md-12 text-center">
                              <a href="#" class="btn btn-info openImageModal" data-target="#mainImage">+ Choose Image</a>
                           </div>
                           <div class="col-lg-12 mt-2">
                              <input type="hidden" name="main_image" id="mainImage">
                              <div id="mainImagePreview" class="d-flex justify-content-center mt-2"></div>
                           </div>

                            <div class="col-md-12"> <h3 style="color:#333"> About Pricing</h3></div>

                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Regular Price</label>
                              <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale Price</label>
                              <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="Price">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale Price From Date</label>
                              <input type="text" class="form-control" id="sale_from_dates" name="sale_from_dates" placeholder="From Date">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">Sale PriceTo Date</label>
                              <input type="text" class="form-control" id="Sale_to_dates" name="Sale_to_dates" placeholder="To Date">
                           </div>
                        </div>
                     </div>
                  </div>
                  
                
                  <div class="card">
                     <div class="card-header" id="headingPricing">
                       
                           <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTax" aria-expanded="false" aria-controls="collapsePricing">
                              About Tax
                           </button>
                        
                     </div>
                     <div id="collapseTax" class="collapse" aria-labelledby="headingPricing" data-parent="#productAccordion">
                        <div class="card-body row" style="width: 720px;">
                           <!-- Tax content -->
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Tax Status</label>
                              <div class="">
                                 <select class="form-control"  id="tax_status" name="tax_status">
                                    <option value="Standrnd">Standrnd</option>
                                    <option value="Cloths">Cloths</option>
                                    <option value="Misc">Misc</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group col-md-6"  >
                              <label class=" col-form-label">Tax Class</label>
                              <div class="">
                                 <select class="form-control" id="tax_class" name="tax_class">
                                    <option value="Taxable">Taxable</option>
                                    <option value="Shipping only">Shipping only</option>
                                    <option value="Shipping only">None</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Shipping -->
                  <div class="card">
                     <div class="card-header" id="headingShipping">
                           <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseShipping" aria-expanded="false" aria-controls="collapseShipping">
                             Shipping
                           </button>
                     </div>
                     <div id="collapseShipping" class="collapse" aria-labelledby="headingShipping" data-parent="#productAccordion">
                        <div class="card-body row">
                           <!-- Shipping content -->
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="length" name="length" placeholder="Length">
                           </div>
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="width" name="width" placeholder="Width">
                           </div>
                           <div class="form-group col-md-2">
                              <label class=" col-form-label">Dim (in)</label>
                              <input type="text" class="form-control" id="height" name="height" placeholder="Height">
                           </div>
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Weight (kg)</label>
                              <input type="text" class="form-control" id="weight_kg" name="weight_kg" placeholder="Weight">
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Inventory -->
                  <div class="card">
                     <div class="card-header" id="headingInventory">
                           <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseInventory" aria-expanded="false" aria-controls="collapseInventory">
                              Inventory
                           </button>
                     </div>
                     <div id="collapseInventory" class="collapse" aria-labelledby="headingInventory" data-parent="#productAccordion">
                        <div class="card-body row">
                           <!-- Inventory content -->
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Stock Management</label>
                              <div class="form-check form-check-flat form-check-primary col-md-12">
                                 <label class="form-check-label">
                                 <input type="checkbox" id="stock_management" name="stock_management" class="form-check-input"> Track stock quantity for this product</label>
                              </div>
                           </div>
                           <div class="form-group col-md-6">
                              <label class=" col-form-label">Sold Individually</label>
                              <div class="form-check form-check-flat form-check-primary col-md-12">
                                 <label class="form-check-label">
                                 <input type="checkbox" id="sold_individually" name="sold_individually" class="form-check-input"> Limit purchases to 1 item per order</label>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group row">
                                 <label class="col-sm-12 col-form-label">Stock status</label>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" id="stock_status" value="Y" > In stock <i class="input-helper"></i></label>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" id="stock_status" value="N"> Out of stock <i class="input-helper"></i></label>
                                    </div>
                                 </div>
                                 <div class="col-sm-4">
                                    <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="stock_status" id="stock_status" value="On-backorder"> On backorder <i class="input-helper"></i></label>
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
                  <!-- Category Accordion -->
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
                           {{-- Main Menu --}}
                           <div class="form-group">
                              <label>Select Main Menu</label>
                              <select class="form-control" id="mainMenuSelect">
                                 <option value="">Select Main Menu</option>
                                 @foreach($mainMenus as $main)
                                 <option value="{{ $main->id }}">{{ $main->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           {{-- Sub Menu --}}
                           <div class="form-group">
                              <label>Select Sub Menu</label>
                              <select class="form-control" id="subMenuSelect" disabled>
                                 <option value="">Select Sub Menu</option>
                              </select>
                           </div>
                           {{-- Child Menu --}}
                           <div class="form-group">
                              <label>Select Child Menu</label>
                              <select class="form-control" id="childMenuSelect" disabled>
                                 <option value="">Select Child Menu</option>
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
                                 <input type="hidden" name="thumbnail_images" id="thumbnailImages">
                                 <div id="thumbnailPreview" class="row mt-2 p-3" style="margin:auto"></div>
                              </div>
                              <div class="input-group p-2">
                                 <input type="file" id="localThumbnailInput" class="d-none" multiple accept="image/*">
                                 <input type="hidden" id="product_id" value="{{ $product->id ?? 1 }}">
                                 <a href="#" style="background-color: green !important;" class="btn  btn-block btn-lg  openImageModal openThumbnailOption" data-target="#thumbnailImages">+ Add Thumbnail Images</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Common Size Accordion -->
                  <div class="card" style="display:none">
                     <div class="card-header p-2" id="headingSize">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseSize">
                           Select Common Size
                           </button>
                        </h6>
                     </div>
                     <div id="collapseSize" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body" >
                           @foreach($commonSizes as $commonsize)
                           <div class="form-check">
                              <label class="form-check-label">
                              <input type="checkbox"  name="common_sizes[]" value="{{ $commonsize->id }}" class="form-check-input">
                              {{ $commonsize->common_size }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <!-- Body Size Accordion -->
                  <div class="card">
                     <div class="card-header p-2" id="headingBody" style="display:none">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseBody">
                           Select Body Size
                           </button>
                        </h6>
                     </div>
                     <div id="collapseBody" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                           @foreach($bodSyizes as $size)
                           <div class="form-check">
                              <label class="form-check-label">
                              <input type="checkbox" name="body_sizes[]" value="{{ $size->id }}" class="form-check-input">
                              {{ $size->body_size }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <!-- Color Accordion -->
                  <div class="card">
                     <div class="card-header p-2" id="headingColor" style="display:none">
                        <h6 class="mb-0">
                           <button class="btn btn-info collapsed newTabButtonStyle" type="button" data-toggle="collapse" data-target="#collapseColor">
                           Select Color
                           </button>
                        </h6>
                     </div>
                     <div id="collapseColor" class="collapse" data-parent="#accordionOptions">
                        <div class="card-body">
                           @foreach($color as $productcolor)
                           <div class="form-check">
                              <label class="form-check-label">
                              <input type="checkbox" name="colors[]" value="{{ $productcolor->id }}" class="form-check-input">
                              {{ $productcolor->color_name }}
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
                           @foreach($status as $productstatus)
                           <div class="form-check">
                              <label class="form-check-label">
                              <input type="checkbox" name="statuses[]" value="{{ $productstatus->id }}" class="form-check-input">
                              {{ $productstatus->status }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header p-2" id="headingColor">
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
                                 <input type="checkbox" name="dry_washes[]" value="{{ $productdrywash->id }}" class="form-check-input">
                                 {{ $productdrywash->drywash_name }}
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header p-2" id="headingColor">
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
                                 <input type="checkbox" name="irons[]" value="{{ $productiron->id }}" class="form-check-input">
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
      <div class="col-md-12 text-center">
         <button type="button" class="btn btn-primary btn-lg" id="submitProductBtn">Submit</button>
      </div>
   </div>
</div>


<style>
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
   
   ::-webkit-scrollbar {
   width: 6px; 
   height: 6px; 
   }
   ::-webkit-scrollbar-track {
   background: #f0f0f0; 
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb {
   background: #888; 
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb:hover {
   background: #555; 
   }
      .ck-editor__editable {
        background-color: #ffffff 
        color: #000000 !important; 
        min-height: 300px;
    }
   .ck-editor__editable {
   background-color: #ffffff !important; 
   color: #000000!important; 
   min-height: 300px; 
   }

   .img-resize-gallery {
    width: 100%;
    height: auto;
    max-height: 150px;
    object-fit: cover;
}
</style>
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
@endsection  
@section('script')

<!-- jQuery & jQuery UI JS -->
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let productDetailsEditor;
    let selectedTarget = '';
    let selectedType = '';
    const menus = @json($mainMenus);
    const colors = @json($color);
    const bodySizes = @json($bodSyizes);
    const commonSizes = @json($commonSizes);  
    const basePath = '/bd-admin/public';
    
   
    
    // тЬЕ TinyMCE init
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
                text: 'ЁЯУН Map',
                onAction: function() {
                    let mapIframe = `<iframe src="https://www.google.com/maps?q=House+no,+2/9+Block+D,+Lalmatia-Mohammadpur,+Dhaka&output=embed"
                                       width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>`;
                    editor.insertContent(mapIframe);
                }
            });
        }
    });

    $(document).ready(function () {
      // рж╕ржм radio button-ржПрж░ ржЬржирзНржп ржХрж╛ржЬ ржХрж░ржмрзЗ
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

     // ========== Menu Cascading ==========
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



    //chexk box shoe hide  
    $(document).ready(function () {
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

   


function appendImageToPreview(previewContainer, hiddenInput, imageUrl) {
    // 1️⃣ filename extract
    let fileName = imageUrl.split('/').pop(); 
    let relativePath =  'gallery/' + fileName; // DB-এ save হবে শুধু এটা

    // 2️⃣ preview জন্য full path
    let previewPath = basePath + '/storage/' + relativePath;

    // 3️⃣ Dropdown options
    let colorOptions = '<option value="">Select Color</option>';
    colors.forEach(c => { colorOptions += `<option value="${c.id}">${c.color_name}</option>`; });

    let bodySizeOptions = '<option value="">Select Size</option>';
    bodySizes.forEach(s => { bodySizeOptions += `<option value="${s.id}">${s.body_size}</option>`; });

    let commonSizeOptions = '<option value="">Select Common Size</option>';
    commonSizes.forEach(cs => { commonSizeOptions += `<option value="${cs.id}">${cs.common_size}</option>`; });

    // 4️⃣ wrapper
    const imgWrapper = $(`
        <div class="thumbnail-wrapper" style="position: relative; display: inline-block; margin: 10px; width: 220px; vertical-align: top;">
            <img src="${previewPath}" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;">
            <span class="remove-thumbnail" data-src="${relativePath}" 
                  style="position: absolute; top: 5px; right: 10px; font-size: 22px; color: red; cursor: pointer;">&times;</span>
            <div class="form-group mt-2">
                <label>Color</label>
                <select class="form-control form-control-sm color-select" name="colors[]">
                    ${colorOptions}
                </select>
            </div>
            <div class="form-group mt-2">
                <label>Size</label>
                <select class="form-control form-control-sm size-select" name="body_sizes[]">
                    ${bodySizeOptions}
                </select>
            </div>
            <div class="form-group mt-2">
                <label>Common Size</label>
                <select class="form-control form-control-sm common-size-select" name="common_sizes[]">
                    ${commonSizeOptions}
                </select>
            </div>
            <div class="form-group mt-2">
                <label>Barcode</label>
                <input type="text" class="form-control form-control-sm barcode-input" name="barcodes[]" placeholder="Enter Barcode">
            </div>
        </div>
    `);

    // 5️⃣ add to preview
    previewContainer.append(imgWrapper);

    // 6️⃣ save relative path to hidden input (DB-ready)
    let currentVal = hiddenInput.val();
    let images = currentVal ? currentVal.split(',') : [];
    if (!images.includes(relativePath)) {
        images.push(relativePath);
        hiddenInput.val(images.join(',')); // DB-তে যাবে শুধুই gallery/filename.jpg
    }
}



   // ========== Modal Image Selection ==========
   $(document).on('click', '.openImageModal', function (e) {
      e.preventDefault();
      selectedTarget = $(this).data('target');
      $('#selectedImageTarget').val(selectedTarget);
      $('#imageSelectModal').modal('show');
   });



   
   
   //main image selection from gallery
  $(document).on('click', '.gallery-image', function () {
    const imgSrc = $(this).attr('data-location'); 
    let fixedPath = imgSrc;
    if (!/^https?:\/\//i.test(imgSrc)) {
        fixedPath = basePath + '/storage' + (imgSrc.startsWith('/') ? '' : '/') + imgSrc;
    }

    if (selectedTarget === '#mainImage') {
        $('#mainImage').val(imgSrc); // hidden input-এ relative path
        $('#mainImagePreview').html(`<img src="${fixedPath}" style="max-width: 300px;">`);
        $('#imageSelectModal').modal('hide');
    } else if (selectedTarget === '#thumbnailImages') {
        $(this).toggleClass('selected');
    }
});





   // ========== Local Upload (thumbnail) ==========
   $(document).on('click', '.openThumbnailOption', function () {
      selectedTarget = $(this).data('target');
      selectedType = $(this).data('type');
      $('#thumbnailUploadOptionModal').modal('show');
   });

   document.querySelectorAll('input[type="radio"][name="feature"]').forEach(radio => {
      radio.addEventListener('click', function() {
         if (this.wasChecked) {
               this.checked = false;   // deselect
         }
         this.wasChecked = this.checked;
      });
   });

   document.querySelectorAll('input[type="radio"][name="highlight"]').forEach(radio => {
      radio.addEventListener('click', function() {
         if (this.wasChecked) {
               this.checked = false;   // deselect
         }
         this.wasChecked = this.checked;
      });
   });

     document.querySelectorAll('input[type="radio"][name="bottom_fastive"]').forEach(radio => {
      radio.addEventListener('click', function() {
         if (this.wasChecked) {
               this.checked = false;   // deselect
         }
         this.wasChecked = this.checked;
      });
   });




   $('#selectFromLocal').on('click', function () {
      $('#thumbnailUploadOptionModal').modal('hide');
      $('#imageSelectModal').modal('hide');
      $('#localThumbnailInput').click();
   });

   $('#selectFromGallery').on('click', function () {
      $('#thumbnailUploadOptionModal').modal('hide');
   });

 

//================thambnail select from gallery============
$('#useSelectedImages, #confirmGallerySelection').on('click', function () {
    const selectedImages = $('.gallery-image.selected, #galleryImages input[type="checkbox"]:checked').map(function () {
        return $(this).attr('data-location'); // data-location = gallery/filename.jpg
    }).get();

    const hiddenInput = $(selectedTarget); // যেই hidden input-এ save হবে
    selectedImages.forEach(src => appendImageToPreview($('#thumbnailPreview'), hiddenInput, src));
    $('#imageSelectModal').modal('hide');
    toastr.success("Gallery images added11111!");
});



  
   
   
   
   
   //=======================thamneil select from local device================
   $('#localThumbnailInput').on('change', function () {
    const files = this.files;
    if (!files.length) return;
    let formData = new FormData();
    formData.append('product_id', $('#product_id').val());
    Array.from(files).forEach((file, i) => formData.append(`images[${i}]`, file));

    $.ajax({
        url:  "{{ route('upload.thumbnails') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.status === 'success') {
                res.thumbnails.forEach(item => {
                    appendImageToPreview($('#thumbnailPreview'), $('#thumbnailImages'), item.url);
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
              
               let relativePath = res.url.replace(window.location.origin + '/', ''); 
               let imgName = res.path; 
                 //console.log(res)    
               $('#mainImage').val(imgName);

              $('#mainImagePreview').html(`<img src="/${relativePath}" alt="Preview" class="img-fluid" style="max-height: 200px;">`);

               $('#imageSelectModal').modal('hide');
               toastr.success('Image Saved!');
         },
         error: function (xhr) {
               console.error(xhr.responseText);
               toastr.error('Image upload failed.');
         }
      });
   });


   



    // ========== Remove Image ==========
    $(document).on('click', '.remove-thumbnail', function () {
      const imageUrl = $(this).data('src');
      $(this).parent().remove();
      const hiddenInput = $('#thumbnailImages');
      let images = hiddenInput.val().split(',');
      images = images.filter(img => img !== imageUrl);
      hiddenInput.val(images.join(','));
   });

    // ========== Datepicker ==========
    $('#sale_from_dates, #Sale_to_dates').datepicker({ dateFormat: 'yy-mm-dd' });

    // ========== Submit Product ==========
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

   $('#submitProductBtn').on('click', function (e) {
    e.preventDefault();

    // ржкрзНрж░рзЛржбрж╛ржХрзНржЯ ржбрзЗржЯрж╛ ржЕржмржЬрзЗржХрзНржЯ рждрзИрж░рж┐
    let formData = {
        name_en: $('#nameEn').val(),
        name_bn: $('#nameBn').val(),
        price: $('#price').val(),
        //details: productEditor.getData(),
        details: tinymce.get('productDetailsEditor').getContent(), 
        main_image: $('#mainImage').val(), 
        main_menu_id: $('#mainMenuSelect').val(),
        sub_menu_id: $('#subMenuSelect').val(),
        child_menu_id: $('#childMenuSelect').val(),
        sale_price: $('#sale_price').val(),
        sale_from_dates: $('#sale_from_dates').val(),
        Sale_to_dates: $('#Sale_to_dates').val(),
        tax_status: $('#tax_status').val(),
        tax_class: $('#tax_class').val(),
        weight_kg: $('#weight_kg').val(),
        length: $('#length').val(),
        width: $('#width').val(),
        height: $('#height').val(),
        product_serial: $('#product_serial').val(),
        product_barcode: $('#product_barcode').val(),
        stock_status: $('input[name="stock_status"]:checked').val(),
        link_status: $('input[name="link_status"]:checked').val(),
        stock_management: $('#stock_management').is(':checked') ? 1 : 0,
        sold_individually: $('#sold_individually').is(':checked') ? 1 : 0,
        site_view_status: $('#site_view_status').is(':checked') ? 'Y' : 'N',
        published_site: $('#published_site').is(':checked') ? 'Y' : 'N',
        festive_collection: $('#festive_collection').is(':checked') ? 'Y' : 'N',
        new_arrivals: $('#new_arrivals').is(':checked') ? 'Y' : 'N',
        patchwork: $('#patchwork').is(':checked') ? 'Y' : 'N',
        feature: $('input[name="feature"]:checked').val(),
        highlight: $('input[name="highlight"]:checked').val(),
        bottom_fastive: $('input[name="bottom_fastive"]:checked').val(),
        common_sizes: $('input[name="common_sizes[]"]:checked').map(function () { return this.value; }).get(),
        body_sizes: $('input[name="body_sizes[]"]:checked').map(function () { return this.value; }).get(),
        colors: $('input[name="colors[]"]:checked').map(function () { return this.value; }).get(),
        statuses: $('input[name="statuses[]"]:checked').map(function () { return this.value; }).get(),
        dry_washes: $('input[name="dry_washes[]"]:checked').map(function () { return this.value;}).get(),
        irons: $('input[name="irons[]"]:checked').map(function () {return this.value;}).get()
    };

   
    let thumbnails = [];
    $('#thumbnailPreview .thumbnail-wrapper').each(function () {
        let fullPath = $(this).find('img').attr('src');
        let fileName = fullPath.split('/').pop(); // শুধু filename.jpg
        let relativePath =  'gallery/' + fileName; // gallery/filename.jpg
    
        thumbnails.push({
            image_path: relativePath,
            thumb_color: $(this).find('.color-select').val(),
            thumb_size: $(this).find('.size-select').val(),
            thumb_common_size: $(this).find('.common-size-select').val(),
            thumb_barcode: $(this).find('.barcode-input').val(),
        });
    });

   
    formData.thumbnail_images = thumbnails;

    
    $.ajax({
         type: "POST",
         url:  "/bd-admin/public/product/store",
         contentType: "application/json; charset=utf-8",
         dataType: "json",
         headers: {
               "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
               "Accept": "application/json",
               "X-Requested-With": "XMLHttpRequest"
         },
         data: JSON.stringify(formData),
         success: function () {
               toastr.success("Product added successfully!");
               setTimeout(() => location.reload(), 1500);
         },
         error: function (xhr) {
               if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                  const errors = xhr.responseJSON.errors;
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
         }
      });
   });

});



</script>


@endsection