<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GalleryTable;
use App\Models\ProductThumbnail;
//use Illuminate\Support\Str;
//use Intervention\Image\Facades\Image;


class GalleryController extends Controller{

//===============insert base url==================
    // //Gallery page
// public function galleryIndex(){
//     return view('gallery.gallery');
// }

// //Load gallery 1st view
// public function galleryLoadJson(){
//    return GalleryTable::take(20)->get();
// }

// //Load gallery image more
// public function galleryLoadJsonById(Request $request){
//    $request->validate([
//     'id' => 'required|integer|min:0',
//     ]);

//     $firstId = $request->id;
//     $images = GalleryTable::where('id', '>', $firstId)
//                 ->orderBy('id', 'asc')
//                 ->limit(20)
//                 ->get();

//     return response()->json($images);
// }


// //Add gallery image
// public function uploadGallery(Request $request){
//     $request->validate([
//         'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
//     ]);

//     $path = $request->file('image')->store('gallery', 'public');
//     $imageName = explode('/', $path)[1];
//     $url = asset('storage/' . $path);

//     // DB Save
//     $id = GalleryTable::insertGetId([
//         'location' => $url,
//     ]);

//     return response()->json([
//         'status' => 'success',
//         'id' => $id,
//         'url' => $url,
//     ]);
// }


// public function uploadThumbnails(Request $request){
//     try {
//         $request->validate([
//             'product_id' => 'required|integer',
//             'images' => 'required|array',
//             'images.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
//         ]);
//         } catch (\Illuminate\Validation\ValidationException $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->errors(),
//             'line' => __LINE__
//         ], 422);
//     }

//     $thumbnails = [];

//     foreach ($request->file('images') as $image) {
//         $path = $image->store('product_thumbnails', 'public');
//         $url = asset('storage/' . $path);

//         ProductThumbnail::create([
//             'product_id' => $request->product_id,
//             'image_url' => $url,
//         ]);

//         $thumbnails[] = [
//             'url' => $url,
//         ];
//     }

//     return response()->json([
//         'status' => 'success',
//         'thumbnails' => $thumbnails,
//     ]);
// }


// //This code for add image from add-new-product page
// public function upload(Request $request) {
//     try {
//         $request->validate([
//             'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:20240',
//         ]);

//         $file = $request->file('image');
//         $path = $file->store('gallery', 'public');
//         $url = asset('storage/' . $path);

//         $id = GalleryTable::insertGetId([
//             'location' => $url,
//         ]);

//         return response()->json([
//             'status' => 'success',
//             'id' => $id,
//             'url' => $url
//         ]);
//     } catch (\Exception $e) {
//     \Log::error('Image Upload Error: ' . $e->getMessage());

//     return response()->json([
//         'status' => 'error',
//         'message' => $e->getMessage(),
//         'line' => $e->getLine()
//     ], 500);
//     }
// }


// //Delete gallery image
// public function deleteGalleryImg(Request $request){
//     $id = $request->input('id');
//     $url = $request->input('url');

//     try {
       
//         $filename = basename($url); 
//         $storagePath = 'gallery/' . $filename;
//         if (Storage::disk('public')->exists($storagePath)) {
//             Storage::disk('public')->delete($storagePath); 
//         }

//         GalleryTable::where('id', $id)->delete();

//         return response()->json(['status' => 'success']);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }





    //====================wiuthout base url===================

   
     // Show gallery page
     public function galleryIndex()
    {
        return view('gallery.gallery');
    }

    // Load gallery 1st view (return full URLs in JSON)
    public function galleryLoadJson()
    {
        $images = GalleryTable::take(20)->orderBy('id', 'desc')->get();

        $images->transform(function ($item) {
            $item->url = url('storage/' . $item->location);
            return $item;
        });

        return $images;
    }

    // Load gallery image more by id
    public function galleryLoadJsonById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:0',
        ]);

        $firstId = $request->id;
        $images = GalleryTable::where('id', '<', $firstId)
                    ->orderBy('id', 'desc')
                    ->limit(20)
                    ->get();

        $images->transform(function ($item) {
            $item->url = url('storage/' . $item->location);
            return $item;
        });

        return response()->json($images);
    }


    
    // Add gallery image (store relative path in DB)
   public function uploadGallery(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
    ]);

    // gallery images stored in storage/app/public/gallery
    $path = $request->file('image')->store('gallery', 'public');

    $id = GalleryTable::insertGetId([
        'location' => $path,
    ]);

    // public path adjustment for cPanel deploy
    // যদি public folder root -> /public_html/dev.khut.shop
    $url = url('storage/'.$path);

    return response()->json([
        'status' => 'success',
        'id' => $id,
        'url' => $url,
        'path' => $path,
    ]);
}

    // Upload multiple thumbnails for a product
    public function uploadThumbnails(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:20240',
        ]);

        $thumbnails = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('product_thumbnails', 'public');
            $url = url('storage/' . $path);

            ProductThumbnail::create([
                'product_id' => $request->product_id,
                'image_url' => $path,
            ]);

            $thumbnails[] = [
                'url' => $url,
                'path' => $path,
            ];
        }

        return response()->json([
            'status' => 'success',
            'thumbnails' => $thumbnails,
        ]);
    }

    // Add image from add-new-product page
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:20240',
        ]);

        $path = $request->file('image')->store('gallery', 'public');
        $id = GalleryTable::insertGetId([
            'location' => $path,
        ]);

        $url = url('storage/' . $path);

        return response()->json([
            'status' => 'success',
            'id' => $id,
            'url' => $url,
            'path' => $path
        ]);
    }

    // Delete gallery image
    public function deleteGalleryImg(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $id = $request->input('id');

        $image = GalleryTable::find($id);

        if (!$image) {
            return response()->json(['status' => 'error', 'message' => 'Image not found'], 404);
        }

        $storagePath = $image->location;

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }

        $image->delete();

        return response()->json(['status' => 'success']);
    }

}
