<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;
use App\Models\Product;
use App\Models\ProductThumbnail;
use App\Models\CommonSize;
use App\Models\BodySize;
use App\Models\Color;
use App\Models\Status;
use App\Models\Iron;
use App\Models\DryWash;
use App\Models\GalleryTable;
use App\Models\ProductColor;
use App\Models\ProductStatus;
use App\Models\ProductCommonSize;
use App\Models\ProductBodySize;
use App\Models\ProductDryWash;
use App\Models\ProductIron;
use App\Models\ProductOption;


class ProductController extends Controller{

 


public function productIndex(){
         $mainMenus = MainMenu::with('subMenus.childMenus')->get(); 
         $commonSizes = CommonSize::all();
         $bodSyizes = BodySize::all();
         $color = Color::all();
         $status = Status::all();
         $iron = Iron::all();
         $dryWash = DryWash::all(); 
         $galleries = GalleryTable::all();
         return view('product.add-new-product', compact('mainMenus', 'commonSizes', 'bodSyizes', 'color', 'status', 'iron', 'dryWash', 'galleries'));
    }

    public function upload(Request $request)
        {
        if ($request->hasFile('images')) {
            $saved = [];
    
            foreach ($request->file('images') as $imageFile) {
                $image = \Image::make($imageFile);
                $image->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
    
                $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = storage_path('app/public/gallery/' . $filename);
                $image->save($path, 75);
    
                // ✅ Database এ শুধু relative path save করো
                $relativePath = 'gallery/' . $filename;
    
                \App\Models\GalleryTable::create([
                    'location' => $relativePath
                ]);
    
                $saved[] = $relativePath;
            }
    
            return response()->json([
                'success' => true,
                'urls' => $saved
            ]);
        }

    return response()->json(['success' => false, 'message' => 'No image uploaded']);
}



   
 
    
 
  

    public function store(Request $request){
        try {
            // Step 1: Validate input
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_bn' => 'required|string|max:255',
                'price' => 'nullable|numeric',
                'details' => 'nullable|string',
                'main_image' => 'required|string',
                'thumbnail_images' => 'nullable|string',
                'main_menu_id' => 'required|integer',
                'sub_menu_id' => 'nullable|integer',
                'child_menu_id' => 'nullable|integer',
                'common_sizes' => 'nullable|array',
                'body_sizes' => 'nullable|array',
                'colors' => 'nullable|array',
                'dry_washes' => 'nullable|array',
                'irons' => 'nullable|array',
                'statuses' => 'nullable|array',
                'sale_price' => 'nullable|numeric',
                'product_serial' => 'nullable|string',
                'product_barcode' => 'nullable|string',
                'sale_from_dates' => 'nullable|date',
                'Sale_to_dates' => 'nullable|date',
                'tax_status' => 'nullable|string|max:50',
                'tax_class' => 'nullable|string|max:50',
                'stock_management' => 'nullable|boolean',
                'stock_status' => 'nullable|string',
                'link_status' => 'required|string',
                'sold_individually' => 'nullable|boolean',
                'weight_kg' => 'nullable|numeric',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'site_view_status' => 'nullable|string|max:1',
                'published_site' => 'nullable|string|max:1',
                'festive_collection' => 'nullable|string|max:20',
                'new_arrivals' => 'nullable|string|max:1',
                'patchwork' => 'nullable|string|max:1',
                'feature' => 'nullable|string',
                'highlight' => 'nullable|string',
                'bottom_fastive' => 'nullable|string',
                'thumbnail_images' => 'nullable|array',
                'thumbnail_images.*.image_path' => 'nullable|string',
                'thumbnail_images.*.thumb_color' => 'nullable|string',
                'thumbnail_images.*.thumb_size' => 'nullable|string',
                'thumbnail_images.*.thumb_common_size' => 'nullable|string',
                'thumbnail_images.*.thumb_barcode' => 'nullable|string',

            ],[
                'name_en.required' => 'Name is Empty.',
                'name_bn.required' => 'Name Bangla is Empty.',
                'link_status.required' => 'Please select a link status.',
                'main_image.required' => 'Please select a choose image',
                'main_menu_id.required' => 'Menu is required',
            ]);


           // $mainImage = $request->main_image;
           // $mainImage = ltrim(str_replace('storage/', '', $mainImage), '/'); 
           
           

        $mainImage = $request->main_image;

        // Clean the path: remove any domain/public prefix
        $mainImage = str_replace([
            //'/khut-bd-admin/public/',
            '/storage/',
            'storage/',
        ], '', $mainImage);
        
        // Ensure no leading slash
        $mainImage = ltrim($mainImage, '/');
        
        $mainImage = ltrim($mainImage, '/'); // Ensure no leading slash

            // Step 2: Create Product
            $product = Product::create([
                'slug' => Str::slug($request->name_en),
                'name_en' => $request->name_en,
                'name_bn' => $request->name_bn,
                'details' => $request->details,
                'main_image' => $mainImage, 
                'price' => $request->price,
                'main_menu_id' => $request->main_menu_id,
                'sub_menu_id' => $request->sub_menu_id,
                'child_menu_id' => $request->child_menu_id,
                'sale_price' => $request->sale_price,
                'product_serial' => $request->product_serial,
                'product_barcode' => $request->product_barcode,
                'sale_from_dates' => $request->sale_from_dates,
                'Sale_to_dates' => $request->Sale_to_dates,
                'tax_status' => $request->tax_status,
                'tax_class' => $request->tax_class,
                'stock_management' => $request->stock_management ? 1 : 0,
                'stock_status' => $request->stock_status,
                'link_status' => $request->link_status,
                'sold_individually' => $request->sold_individually ? 1 : 0,
                'weight_kg' => $request->weight_kg,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'site_view_status' => $request->site_view_status === 'Y' ? 'Y' : 'N',
                'published_site' => $request->published_site === 'Y' ? 'Y' : 'N',
                'festive_collection' => $request->festive_collection === 'fastive-collection' ? 'fastive-collection' : 'N',
                'new_arrivals' => $request->new_arrivals === 'Y' ? 'Y' : 'N',
                'patchwork' => $request->patchwork === 'Y' ? 'Y' : 'N',
                'feature' => $request->feature,
                'highlight' => $request->highlight,
                'bottom_fastive' => $request->bottom_fastive,
            ]);



          
       

           /* if ($request->filled('thumbnail_images')) {
                foreach ($request->thumbnail_images as $thumb) {
                    $imagePath = $thumb['image_path'] ?? '';
                    $imagePath = ltrim(str_replace('storage/', '', $imagePath), '/');
                    if ($imagePath) {
                        ProductThumbnail::create([
                            'product_id' => $product->id,
                            'image_path' => $imagePath, 
                            'thumb_color' => $thumb['thumb_color'] ?? null,
                            'thumb_size' => $thumb['thumb_size'] ?? null,
                            'thumb_common_size' => $thumb['thumb_common_size'] ?? null,
                            'thumb_barcode' => $thumb['thumb_barcode'] ?? null,
                        ]);
                    }
                }
            }*/
            
            
        if ($request->filled('thumbnail_images')) {
                foreach ($request->thumbnail_images as $thumb) {
                    $imagePath = $thumb['image_path'] ?? '';
                    if ($imagePath) {
                        ProductThumbnail::create([
                            'product_id' => $product->id,
                            'image_path' => $imagePath, // gallery/filename.jpg
                            'thumb_color' => $thumb['thumb_color'] ?? null,
                            'thumb_size' => $thumb['thumb_size'] ?? null,
                            'thumb_common_size' => $thumb['thumb_common_size'] ?? null,
                            'thumb_barcode' => $thumb['thumb_barcode'] ?? null,
                        ]);
                    }
                }
            }


            // Step 4: Common Sizes
            foreach ((array)$request->common_sizes as $commonSize) {
                ProductCommonSize::create([
                    'product_id' => $product->id,
                    'common_size_id' => $commonSize,
                ]);
            }

            // Step 5: Body Sizes
            foreach ((array)$request->body_sizes as $bodySize) {
                ProductBodySize::create([
                    'product_id' => $product->id,
                    'body_size_id' => $bodySize,
                ]);
            }

            // Step 6: Colors
            foreach ((array)$request->colors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                ]);
            }

            // Step 7: Statuses
            foreach ((array)$request->statuses as $status) {
                ProductStatus::create([
                    'product_id' => $product->id,
                    'status_id' => $status,
                ]);
            }


          foreach ((array)$request->irons as $iron) {
            ProductIron::create([
                'product_id' => $product->id,
                'iron_id' => $iron,
            ]);
        }

        // Dry Wash insert
        foreach ((array)$request->dry_washes as $dry_wash) {
            ProductDryWash::create([
                'product_id' => $product->id,
                'drywash_id' => $dry_wash,
            ]);
        }


            // Step 8: Return success
            return response()->json(['success' => true]);

        } catch (ValidationException $e) {
        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
}




   public function uploadThumbnails(Request $request){
        $urls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('gallery', $name, 'public'); 
                $relativePath = $path; // gallery/filename.jpg
                // Gallery table-এ save
                $gallery = GalleryTable::create([
                    'location' => $relativePath
                ]);
                $urls[] = [
                    'id' => $gallery->id,
                    'url' => asset('storage/' . $relativePath) // /storage/gallery/filename.jpg
                ];
            }
            return response()->json([
                'status' => 'success',
                'thumbnails' => $urls,
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'No files found.',
        ]);
    }


   




    public function productlistIndex(Request $request){
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();
        $query = Product::query()->with(['mainMenu', 'subMenu', 'childMenu']);

            if ($request->filled('main_menu_id')) {
                $query->where('main_menu_id', $request->main_menu_id);
            }

            if ($request->filled('sub_menu_id')) {
                $query->where('sub_menu_id', $request->sub_menu_id);
            }

            if ($request->filled('child_menu_id')) {
                $query->where('child_menu_id', $request->child_menu_id);
            }

            if ($request->filled('title')) {
                $search = $request->title;
                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'LIKE', "%{$search}%")
                    ->orWhere('product_barcode', 'LIKE', "%{$search}%");
                });
            }

            $products = $query->orderBy('id', 'desc')->paginate(10);
            return view('product.product-list', compact('mainMenus', 'products'));
        
        }


        // Return sub menus based on main menu
            public function getSubMenus($mainId)
            {
                $subMenus = SubMenu::where('main_menu_id', $mainId)->get(['id', 'name']);
                return response()->json($subMenus);
            }

            // Return child menus based on sub menu
            public function getChildMenus($subId)
            {
                $childMenus = ChildMenu::where('sub_menu_id', $subId)->get(['id', 'name']);
                return response()->json($childMenus);
            }


    public function edit($id){
        $product = Product::with(['commonSizes', 'bodySizes', 'colors', 'statuses', 'irons', 'dryWashes', 'thumbnails', 'thumbnails.color', 'thumbnails.bodySize', 'thumbnails.commonSize'])->findOrFail($id); 
        $thumbnails = $product->thumbnails;
        $galleries = GalleryTable::all(); 
        $mainMenus = MainMenu::all();
        $subMenus = SubMenu::all();
        $childMenus = ChildMenu::all();
        $commonSizes = CommonSize::all();
        $selectedSizes = $product->commonSizes->pluck('id')->toArray();
        $bodySizes = BodySize::all();
        $selectedBodySizes = $product->bodySizes->pluck('id')->toArray();
        $dressColor = Color::all();
        $selectedColor = $product->colors->pluck('id')->toArray();
        $washStatus = Status::all();
        $selectedWashStatus = $product->statuses->pluck('id')->toArray();
        $iron = Iron::all();
        $selectedIrons = $product->irons->pluck('id')->toArray();
        $dryWash = DryWash::all();
        $selectedDryWashes = $product->dryWashes->pluck('id')->toArray();
        $allColors = Color::all();
        $allBodySizes = BodySize::all();
        $allCommonSizes = CommonSize::all();

        return view('product.edit', compact(
            'product',
            'mainMenus',
            'subMenus',
            'childMenus',
            'commonSizes',
            'selectedSizes',
            'bodySizes',
            'selectedBodySizes',
            'dressColor',
            'selectedColor',
            'selectedWashStatus',
            'iron',
            'selectedIrons',
            'dryWash',
            'selectedDryWashes',
            'washStatus',
            'selectedWashStatus',
            'galleries',
            'thumbnails',
            'allColors',
            'allBodySizes',
            'allCommonSizes'
        ));
    }


 



   public function update(Request $request, $id){
   
    $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'details' => 'nullable|string',
            'main_image' => 'nullable|string',
            'thumbnail_images' => 'nullable|string',
            'main_menu_id' => 'nullable|integer',
            'sub_menu_id' => 'nullable|integer',
            'child_menu_id' => 'nullable|integer',
            'common_sizes' => 'nullable|array',
            'body_sizes' => 'nullable|array',
            'colors' => 'nullable|array',
            'statuses' => 'nullable|array',
            'sale_price' => 'nullable|numeric',
            'product_serial' => 'nullable|string',
            'product_barcode' => 'nullable|string',
            'sale_from_dates' => 'nullable|date',
            'Sale_to_dates' => 'nullable|date',
            'tax_status' => 'nullable|string|max:50',
            'tax_class' => 'nullable|string|max:50',
            'stock_management' => 'nullable|boolean',
            'stock_status' => 'nullable|string',
            'link_status' => 'required|string',
            'sold_individually' => 'nullable|boolean',
            'weight_kg' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'site_view_status' => 'nullable|string|max:1',
            'published_site' => 'nullable|string|max:1',
            'festive_collection' => 'nullable|string|max:20',
            'new_arrivals' => 'nullable|string|max:1',
            'patchwork' => 'nullable|string|max:1',
            'feature' => 'nullable|string',
            'highlight' => 'nullable|string',
            'bottom_fastive' => 'nullable|string',
        ],[
            'name_en.required' => 'Name is Empty.',
            'name_bn.required' => 'Name Bangla is Empty.',
            'link_status.required' => 'Please select a link status.',
        ]);

    try {
        
        $product = Product::findOrFail($id);

        $mainImage = $request->main_image ? ltrim(str_replace('storage/', '', $request->main_image), '/') : $product->main_image;

        $product->fill([
            //'slug' => Str::slug($request->name_en) . '-' . $product->id, // slug আপডেট
            'slug' => Str::slug($request->name_en),
            'name_en' => $request->input('name_en', $product->name_en),
            'name_bn' => $request->name_bn ?? $product->name_bn,
            'details' => $request->details ?? $product->details,
           // 'main_image' => $request->main_image ?? $product->main_image,
            'main_image' => $mainImage,
            'price' => $request->price ?? $product->price,
            'main_menu_id' => $request->main_menu_id ?? $product->main_menu_id,
            'sub_menu_id' => $request->sub_menu_id ?? $product->sub_menu_id,
            'child_menu_id' => $request->child_menu_id ?? $product->child_menu_id,
            'sale_price' => $request->sale_price ?? $product->sale_price,
            'product_serial' => $request->product_serial ?? $product->product_serial,
            'product_barcode' => $request->product_barcode,
            'sale_from_dates' => $request->sale_from_dates ?? $product->sale_from_dates,
            'Sale_to_dates' => $request->Sale_to_dates ?? $product->Sale_to_dates,
            'tax_status' => $request->tax_status ?? $product->tax_status,
            'tax_class' => $request->tax_class ?? $product->tax_class,
            'stock_management' => $request->stock_management !== null ? ($request->stock_management ? 1 : 0) : $product->stock_management,
            'stock_status' => $request->stock_status ?? $product->stock_status,
            'link_status' => $request->link_status ?? $product->link_status,
            'sold_individually' => $request->sold_individually !== null ? ($request->sold_individually ? 1 : 0) : $product->sold_individually,
            'weight_kg' => $request->weight_kg ?? $product->weight_kg,
            'length' => $request->length ?? $product->length,
            'width' => $request->width ?? $product->width,
            'height' => $request->height ?? $product->height,
            'site_view_status' => $request->site_view_status ?? $product->site_view_status,
            'published_site' => $request->published_site ?? $product->published_site,
            'festive_collection' => $request->festive_collection ?? $product->festive_collection,
            'new_arrivals' => $request->new_arrivals ?? $product->new_arrivals,
            'patchwork' => $request->patchwork ?? $product->patchwork,
            'feature' => $request->feature ?? $product->feature,
            'highlight' => $request->highlight ?? $product->highlight,
            'bottom_fastive' => $request->bottom_fastive ?? $product->bottom_fastive,
        ]);
        $product->save();



   // ✅ Handle thumbnails and options
  /*  $thumbnails = $request->filled('thumbnail_images') 
        ? json_decode($request->thumbnail_images, true) 
        : [];

    if (!is_array($thumbnails)) $thumbnails = [];

    $existingIds = ProductThumbnail::where('product_id', $product->id)->pluck('id')->toArray();
    $updatedIds = [];

    foreach ($thumbnails as $thumbData) {
        if (!is_array($thumbData)) continue;

        $thumbImagePath = isset($thumbData['image_path'])
            ? ltrim(str_replace('storage/', '', $thumbData['image_path']), '/')
            : null;

        if (!empty($thumbData['id'])) {
            $thumbnail = ProductThumbnail::find($thumbData['id']);
            if ($thumbnail) {
                $thumbnail->update([
                    'image_path' => $thumbImagePath ?? $thumbnail->image_path,
                    'thumb_color' => $thumbData['thumb_color'] ?? $thumbnail->thumb_color,
                    'thumb_size' => $thumbData['thumb_size'] ?? $thumbnail->thumb_size,
                    'thumb_common_size' => $thumbData['thumb_common_size'] ?? $thumbnail->thumb_common_size,
                    'thumb_barcode' => $thumbData['thumb_barcode'] ?? $thumbnail->thumb_barcode,
                ]);
            }
        } else {
            $thumbnail = ProductThumbnail::create([
                'product_id' => $product->id,
                'image_path' => $thumbImagePath,
                'thumb_color' => $thumbData['thumb_color'] ?? null,
                'thumb_size' => $thumbData['thumb_size'] ?? null,
                'thumb_common_size' => $thumbData['thumb_common_size'] ?? null,
                'thumb_barcode' => $thumbData['thumb_barcode'] ?? null,
            ]);
        }

        $updatedIds[] = $thumbnail->id;*/
        
        
        // ✅ Handle thumbnails and options
$thumbnails = $request->filled('thumbnail_images') 
    ? json_decode($request->thumbnail_images, true) 
    : [];

if (!is_array($thumbnails)) $thumbnails = [];

$existingIds = ProductThumbnail::where('product_id', $product->id)->pluck('id')->toArray();
$updatedIds = [];

foreach ($thumbnails as $thumbData) {
    if (!is_array($thumbData)) continue;

    // === Fix image path to keep only gallery/... ===
    $thumbImagePath = null;
    if (!empty($thumbData['image_path'])) {
        $path = $thumbData['image_path'];

        // /khut-bd-admin/public/storage/gallery/filename.jpg -> gallery/filename.jpg
        if (str_contains($path, '/storage/')) {
            $parts = explode('/storage/', $path);
            $thumbImagePath = $parts[1] ?? null;
        }
        // storage/gallery/... -> gallery/...
        elseif (str_starts_with($path, 'storage/')) {
            $thumbImagePath = substr($path, strlen('storage/'));
        }
        // gallery/... -> 그대로
        elseif (str_starts_with($path, 'gallery/')) {
            $thumbImagePath = $path;
        }

        // leading slash remove
        if ($thumbImagePath) {
            $thumbImagePath = ltrim($thumbImagePath, '/');
        }
    }

    if (!empty($thumbData['id'])) {
        $thumbnail = ProductThumbnail::find($thumbData['id']);
        if ($thumbnail) {
            $thumbnail->update([
                'image_path' => $thumbImagePath ?? $thumbnail->image_path,
                'thumb_color' => $thumbData['thumb_color'] ?? $thumbnail->thumb_color,
                'thumb_size' => $thumbData['thumb_size'] ?? $thumbnail->thumb_size,
                'thumb_common_size' => $thumbData['thumb_common_size'] ?? $thumbnail->thumb_common_size,
                'thumb_barcode' => $thumbData['thumb_barcode'] ?? $thumbnail->thumb_barcode,
            ]);
        }
    } else {
        $thumbnail = ProductThumbnail::create([
            'product_id' => $product->id,
            'image_path' => $thumbImagePath,
            'thumb_color' => $thumbData['thumb_color'] ?? null,
            'thumb_size' => $thumbData['thumb_size'] ?? null,
            'thumb_common_size' => $thumbData['thumb_common_size'] ?? null,
            'thumb_barcode' => $thumbData['thumb_barcode'] ?? null,
        ]);
    }

    $updatedIds[] = $thumbnail->id;


    // ✅ Handle product options under this thumbnail
        $optionIds = [];
        if (!empty($thumbData['options']) && is_array($thumbData['options'])) {
            foreach ($thumbData['options'] as $opt) {
                if (!is_array($opt)) continue;

                if (!empty($opt['id'])) {
                    $option = \App\Models\ProductOption::find($opt['id']);
                    if ($option) {
                        $option->update([
                            'thumbnail_id' => $thumbnail->id,
                            'common_size_id' => $opt['common_size_id'] ?? null,
                            'body_size_id' => $opt['body_size_id'] ?? null,
                            'barcode' => $opt['barcode'] ?? null,
                        ]);
                        $optionIds[] = $option->id;
                    }
                } else {
                    $option = \App\Models\ProductOption::create([
                        'thumbnail_id' => $thumbnail->id,
                        'common_size_id' => $opt['common_size_id'] ?? null,
                        'body_size_id' => $opt['body_size_id'] ?? null,
                        'barcode' => $opt['barcode'] ?? null,
                    ]);
                    $optionIds[] = $option->id;
                }
            }

            // Delete old options that are not in request
            \App\Models\ProductOption::where('thumbnail_id', $thumbnail->id)
                ->whereNotIn('id', $optionIds)
                ->delete();
        }
    }

    // Delete old thumbnails not in updated list
    $toDelete = array_diff($existingIds, $updatedIds);
    if (!empty($toDelete)) {
        ProductThumbnail::whereIn('id', $toDelete)->delete();
    }




       if ($request->has('colors')) {
            ProductColor::where('product_id', $product->id)->delete();
            foreach ($request->colors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                ]);
            }
        }

        // Statuses Update
        if ($request->has('statuses')) {
            ProductStatus::where('product_id', $product->id)->delete();
            foreach ($request->statuses as $status) {
                ProductStatus::create([
                    'product_id' => $product->id,
                    'status_id' => $status,
                ]);
            }
        }

        // Common Sizes Update
        if ($request->has('common_sizes')) {
            ProductCommonSize::where('product_id', $product->id)->delete();
            foreach ($request->common_sizes as $size) {
                ProductCommonSize::create([
                    'product_id' => $product->id,
                    'common_size_id' => $size,
                ]);
            }
        }

        // Body Sizes Update
        if ($request->has('body_sizes')) {
            ProductBodySize::where('product_id', $product->id)->delete();
            foreach ($request->body_sizes as $size) {
                ProductBodySize::create([
                    'product_id' => $product->id,
                    'body_size_id' => $size,
                ]);
            }
        }


       // Irons Update
        if ($request->has('irons')) {
            ProductIron::where('product_id', $product->id)->delete();
            foreach ($request->irons as $iron) {
                ProductIron::create([
                    'product_id' => $product->id,
                    'iron_id' => $iron,
                ]);
            }
        }

        // Dry Wash Update
        if ($request->has('dry_washes')) {
            ProductDryWash::where('product_id', $product->id)->delete();
            foreach ($request->dry_washes as $dry_wash) {
                ProductDryWash::create([
                    'product_id' => $product->id,
                    'drywash_id' => $dry_wash,
                ]);
            }
        }

        

        $product->commonSizes()->sync($request->common_sizes ?? []);
        $product->bodySizes()->sync($request->body_sizes ?? []);
        $product->colors()->sync($request->colors ?? []);
        $product->statuses()->sync($request->statuses ?? []);
        $product->irons()->sync($request->irons ?? []);
        $product->dryWashes()->sync($request->dry_washes ?? []);

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        \Log::error('Product update error: '.$e->getMessage(), [
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}



    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['success' => true]);
    }
    
}





