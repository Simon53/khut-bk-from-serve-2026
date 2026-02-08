<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBodySize extends Model
{
    protected $table = 'product_body_size';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = [
        'product_id', 
        'body_size_id'
    ];
    
}
