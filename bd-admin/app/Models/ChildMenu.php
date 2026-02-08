<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class ChildMenu extends Model
{
    protected $fillable = ['name', 'sub_menu_id'];

    

    public function subMenu() {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id');
    }

   
}
