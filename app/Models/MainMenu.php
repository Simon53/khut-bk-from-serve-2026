<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MainMenu extends Model{
    protected $fillable = ['name'];
    public function subMenus(){
        return $this->hasMany(SubMenu::class);
    }
    protected static function boot(){
        parent::boot();
        static::deleting(function ($mainMenu) {
            if (!$mainMenu->relationLoaded('subMenus')) {
                $mainMenu->load('subMenus.childMenus');
            }
            foreach ($mainMenu->subMenus as $subMenu) {
                $subMenu->childMenus()->delete();
            }
            $mainMenu->subMenus()->delete();
        });
    }
}