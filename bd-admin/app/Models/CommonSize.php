<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonSize extends Model{
    protected $table = 'common_sizes';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  
    protected $fillable = ['common_size'];
}


