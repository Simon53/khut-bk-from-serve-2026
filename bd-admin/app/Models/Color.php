<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = ['color_name'];
    
}
