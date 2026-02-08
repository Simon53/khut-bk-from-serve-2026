<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCommonSize extends Model{
    protected $table = 'product_common_size';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  
    protected $fillable = [
        'product_id', 
        'common_size_id'

    ];
}
