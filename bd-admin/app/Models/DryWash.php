<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DryWash extends Model
{
    protected $table = 'dry_washes';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = ['drywash_name'];
}
