<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryTable extends Model
{
    protected $table = 'gallery_tables';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;    

    protected $fillable = ['name', 'location'];
}
