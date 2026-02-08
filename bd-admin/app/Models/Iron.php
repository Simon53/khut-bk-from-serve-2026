<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iron extends Model{
    protected $table = 'irons';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = ['iron_name'];
}    
