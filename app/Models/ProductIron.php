<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIron extends Model
{
    protected $table = 'product_irons';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    
    protected $fillable = [
        'product_id', 
        'iron_id'
    ];
}
