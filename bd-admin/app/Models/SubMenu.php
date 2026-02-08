<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class SubMenu extends Model
{
    protected $fillable = ['name', 'main_menu_id'];


    public function childMenus()
    {
        return $this->hasMany(ChildMenu::class);
    }

    public function mainMenu()
    {
        return $this->belongsTo(MainMenu::class, 'main_menu_id');
    }

  
 

}


