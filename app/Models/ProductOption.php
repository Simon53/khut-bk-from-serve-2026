<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'product_options';
    protected $fillable = [
        'thumbnail_id',
        'common_size_id',
        'body_size_id',
        'barcode'
    ];

    // Relation with Thumbnail
    public function thumbnail()
    {
        return $this->belongsTo(ProductThumbnail::class, 'thumbnail_id');
    }

    // Relation with CommonSize
    public function commonSize()
    {
        return $this->belongsTo(CommonSize::class, 'common_size_id');
    }

    // Relation with BodySize
    public function bodySize()
    {
        return $this->belongsTo(BodySize::class, 'body_size_id');
    }
}
