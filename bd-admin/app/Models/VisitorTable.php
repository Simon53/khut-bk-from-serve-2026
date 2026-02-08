<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorTable extends Model
{
    protected $table = 'visitor_tables';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;    
}
