<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = ['status'];
    
}
