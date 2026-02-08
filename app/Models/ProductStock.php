<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    // Specify the table name
    protected $table = 'product_stocks';

    // Mass assignable fields
    protected $fillable = [
        'product_id',   // related product ID
        'sku',          // product SKU or barcode
        'quantity',     // current stock quantity
        'last_synced_at' // timestamp when stock was last synced from API
    ];

    // Enable timestamps (created_at & updated_at)
    public $timestamps = true;
}
