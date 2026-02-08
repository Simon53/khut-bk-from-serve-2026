<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();

        // We will pass empty products, as wishlist products are from localStorage
        $products = [];

        return view('wishlist.index', compact('mainMenus', 'products'));
    }
}
