<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
     protected $fillable = ['name', 'slug', 'status'];
    
     public function pages(){
          return $this->hasMany(SitePage::class);
     }
}
