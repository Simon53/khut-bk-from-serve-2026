<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductThumbnail extends Model
{
    protected $table = 'product_thumbnails';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  
    


    protected $fillable = [
        'product_id', 
        'image_path',
        'thumb_color',
        'thumb_size',
        'thumb_common_size',
        'thumb_barcode'

    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function color() {
        return $this->belongsTo(Color::class, 'thumb_color');
    }

    public function bodySize() {
        return $this->belongsTo(BodySize::class, 'thumb_size');
    }

    public function commonSize() {
        return $this->belongsTo(CommonSize::class, 'thumb_common_size');
    }

    public function options(){
        return $this->hasMany(ProductOption::class, 'thumbnail_id');
    }
}
