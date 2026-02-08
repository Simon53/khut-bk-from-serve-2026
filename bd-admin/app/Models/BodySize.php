<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodySize extends Model{
    protected $table = 'body_sizes';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  
    protected $fillable = ['body_size'];  
}
