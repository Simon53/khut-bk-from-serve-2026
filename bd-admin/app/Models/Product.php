<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{

    protected $table = 'products';     
    protected $primaryKey = 'id';            
    public $incrementing = true;             
    protected $keyType = 'int';              
    public $timestamps = false;  

    protected $fillable = [
        'slug',
        'name_en', 
        'name_bn', 
        'details', 
        'main_image', 
        'price',
        'sale_price',
        'sale_from_dates',
        'Sale_to_dates',
        'tax_status',
        'tax_class',
        'stock_management',
        'stock_status',
        'sold_individually',
        'weight_kg',
        'length',
        'width',
        'height',
        'site_view_status',
        'published_site',
        'festive_collection',
        'new_arrivals',
        'patchwork',
        'feature',
        'highlight',
        'bottom_fastive',
        'product_serial',
        'product_barcode',
        'link_status',
        'main_menu_id', 
        'sub_menu_id', 
        'child_menu_id'
    ];  

    public function thumbnails() {
        return $this->hasMany(ProductThumbnail::class);
    }

    public function commonSizes() {
        return $this->belongsToMany(CommonSize::class, 'product_common_size');
    }

    public function bodySizes() {
        return $this->belongsToMany(BodySize::class, 'product_body_size');
    }

    public function colors() {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function statuses() {
        return $this->belongsToMany(Status::class, 'product_status');
    }

    public function irons(){
        return $this->belongsToMany(Iron::class, 'product_irons');
   }


    public function dryWashes(){
        return $this->belongsToMany( DryWash::class,        // Related model
            'product_dry_washes',  // Pivot table
            'product_id',          // Foreign key on pivot table for this model
            'drywash_id'           // Foreign key on pivot table for related model
        );
    }
   
    public function mainMenu(){
        return $this->belongsTo(MainMenu::class);
    }

    public function subMenu() {
        return $this->belongsTo(SubMenu::class);
    }

    public function childMenu() {
        return $this->belongsTo(ChildMenu::class);
    }
    
}
