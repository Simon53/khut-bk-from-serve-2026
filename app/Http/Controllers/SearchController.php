<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainMenu;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $q = $request->q;

    if (!$q) {
        return response()->json([]);
    }

    $product = Product::where('name_en', 'like', "%{$q}%")
        ->orWhere('name_bn', 'like', "%{$q}%")
        ->select('slug', 'name_en')
        ->first();

    if (!$product) {
        return response()->json([]);
    }

    return response()->json([
        'slug' => $product->slug
    ]);
}
}
