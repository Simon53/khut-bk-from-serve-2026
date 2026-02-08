<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ProductStock;
use Carbon\Carbon;

class SyncKhutStock extends Command
{
    protected $signature = 'app:sync-khut-stock';
    protected $description = 'Sync stock from KHUT API to local database';

    public function handle()
    {
        $secretKey = env('KHUT_API_SECRET');

        if (!$secretKey) {
            $this->error('KHUT_API_SECRET not found in .env');
            return;
        }

        // All SKU from product_stocks table
        $skus = ProductStock::pluck('sku')->toArray();

        if (empty($skus)) {
            $this->warn('No SKU found in product_stocks table');
            return;
        }

        foreach ($skus as $sku) {

            $response = Http::get('https://khut.bdsoft.us/api/get_stock.php', [
                'sku' => $sku,
                'secret_key' => $secretKey
            ]);

            if (!$response->successful()) {
                $this->error("API request failed for SKU: {$sku}");
                $this->error("HTTP Status: " . $response->status());
                continue;
            }

            $data = $response->json();

            // Debug: show full response for troubleshooting
            $this->info("Response for SKU {$sku}: " . json_encode($data));

            // Determine quantity key
            $quantity = $data['quantity'] ?? $data['stock'] ?? null;

            if ($quantity === null) {
                $this->error("Invalid response for SKU: {$sku}");
                continue;
            }

            ProductStock::updateOrCreate(
                ['sku' => $sku],
                [
                    'quantity' => (int)$quantity,
                    'last_synced_at' => Carbon::now()
                ]
            );

            $this->info("Synced SKU: {$sku} | Qty: {$quantity}");
        }

        $this->info('KHUT stock sync completed successfully.');
    }
}
