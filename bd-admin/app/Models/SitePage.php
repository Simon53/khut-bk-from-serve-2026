<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    protected $fillable = ['page_title', 'details', 'image', 'site_menu_id'];

    public function menu(){
        return $this->belongsTo(SiteMenu::class, 'site_menu_id');
    }

    public function siteMenu(){
        return $this->belongsTo(SiteMenu::class);
    }
}
