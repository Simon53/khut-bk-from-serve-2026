<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDryWash extends Model
{
    protected $table = 'product_dry_washes';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    
    protected $fillable = [
        'product_id', 
        'drywash_id'
    ];
}
