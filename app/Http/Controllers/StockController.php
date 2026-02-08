<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class StockController extends Controller
{
  /* public function getStock($sku)
{
    $secretKey = env('KHUT_API_SECRET');
    $sku = trim((string) $sku);

    if (!$sku || !$secretKey) {
        return response()->json([
            'success' => false,
            'message' => 'Missing SKU or Secret Key'
        ], 400);
    }

    try {
        $response = Http::timeout(15)->get(
            'https://khut.bdsoft.us/api/get_stock.php',
            [
                'sku' => $sku,
                'secret_key' => $secretKey
            ]
        );

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'success' => false,
            'message' => $response->json()['error'] ?? 'Stock API error'
        ], $response->status());

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Stock API request failed: ' . $e->getMessage()
        ], 500);
    }
}*/



      public function getStock($sku)
        {
            $secretKey = env('KHUT_API_SECRET');

            if (!$sku || !$secretKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing SKU or Secret Key'
                ], 400);
            }

            // API URL
            $apiUrl = "https://khut.bdsoft.us/api/get_stock.php";

            // GET request with query parameters
            $response = Http::get($apiUrl, [
                'sku' => $sku,
                'secret_key' => $secretKey
            ]);

            // Check if response is successful
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json()
                ]);
            }

            // Error handling
            return response()->json([
                'success' => false,
                'message' => $response->body()
            ], $response->status());
        }



/*public function getStock($sku)
{
    $product = \App\Models\Product::where('product_barcode', $sku)->first();

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'stock' => (int) $product->stock  // cast to integer
        ]
    ]);
}*/





          
}
