<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CategoryBanner extends Model{
    use HasFactory;
    protected $fillable = [
        'main_menu_id',
        'banner_image',
        'title',
    ];
    public function mainMenu(){
        return $this->belongsTo(MainMenu::class);
    }
    
}
