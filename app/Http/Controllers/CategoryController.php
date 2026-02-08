<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;
use App\Models\Product;
use App\Models\CategoryBanner;

class CategoryController extends Controller
{
   // Main Category Page
    
    
    

    // AJAX Filter for Main/Sub/Child Menus
    public function productsByMenu($type, $id)
    {
        $query = Product::where('site_view_status', 'Y');

        if ($type == 'main') {
            $query->where('main_menu_id', $id);
        } elseif ($type == 'sub') {
            $query->where('sub_menu_id', $id);
        } elseif ($type == 'child') {
            $query->where('child_menu_id', $id);
        }

     
        $products = $query->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
            ->latest()
            ->paginate(12);

        return view('product-categories.partials.products', compact('products'))->render();
    }

    // Mixed Category (Main/Sub/Child) View
    public function categoryProducts($id)
    {
        $products = Product::with(['mainMenu', 'subMenu', 'childMenu'])
            ->where(function ($q) use ($id) {
                $q->where('main_menu_id', $id)
                  ->orWhere('sub_menu_id', $id)
                  ->orWhere('child_menu_id', $id);
            })
            ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END") // sold out নিচে
            ->latest()
            ->paginate(12);

        return view('product-categories.index', compact('products'));
    }
    
    
     


 // ✅ MAIN CATEGORY (slug ভিত্তিক)
    public function listBySlug($slug)
    {
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();

        $normalizedSlug = strtolower($slug);

        $category = $mainMenus->first(function($menu) use ($normalizedSlug) {
            $menuSlug = strtolower(str_replace(' ', '-', $menu->name));
            return $menuSlug === $normalizedSlug;
        });

        if ($category) {
            $subIds = $category->subMenus->pluck('id')->toArray();
            $childIds = ChildMenu::whereIn('sub_menu_id', $subIds)->pluck('id')->toArray();

            $columnName = strtolower(str_replace(' ', '_', $category->name));

            $products = Product::where('published_site', 'Y')
                ->where(function($q) use ($category, $subIds, $childIds, $columnName) {
                    $q->where('main_menu_id', $category->id)
                      ->orWhereIn('sub_menu_id', $subIds)
                      ->orWhereIn('child_menu_id', $childIds);

                    if (\Schema::hasColumn('products', $columnName)) {
                        $q->orWhere($columnName, 'Y');
                    }
                })
                ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END") // Out of stock নিচে
                ->orderBy('id', 'DESC') // Latest products আগে
                ->paginate(12);

            $banner = CategoryBanner::where('main_menu_id', $category->id)->first();

            return view('product-categories.index', compact('mainMenus', 'products', 'category', 'banner'));
        }

        abort(404,'Category not found');
    }



    
    public function listById($id)
    {
        $mainMenus = MainMenu::with('subMenus.childMenus')->get();
        $products = [];
        $category = null;

        $routeName = request()->route()->getName();

        if ($routeName == 'subcategory.list') {
            $category = SubMenu::findOrFail($id);
            $childIds = $category->childMenus->pluck('id')->toArray();

            $products = Product::where('published_site', 'Y')
                ->where(function ($q) use ($id, $childIds) {
                    $q->where('sub_menu_id', $id)
                      ->orWhereIn('child_menu_id', $childIds);
                })
                ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END") // Out of stock নিচে
                ->orderBy('id', 'DESC') 
                ->paginate(12);

            $banner = CategoryBanner::where('main_menu_id', $category->main_menu_id)->first();
        } 


        elseif ($routeName == 'childcategory.list') {
            $childMenu = ChildMenu::findOrFail($id);

            $products = Product::where('child_menu_id', $id)
                ->where('site_view_status', 'Y')
                ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
                ->orderBy('id', 'DESC')
                ->paginate(12);

        
            $subMenu = $childMenu->subMenu;    // ChildMenu এর parent SubMenu
            $mainMenu = $subMenu ? $subMenu->mainMenu : null;  // SubMenu এর parent MainMenu

            // Banner assign
            $main = $mainMenu;
            if ($main) {
                $banner = CategoryBanner::where('main_menu_id', $main->id)->first();
            } else {
                $banner = (object)[
                    'banner_image' => asset('assets/images/product_banner.jpg'),
                    'title' => $childMenu->name
                ];
            }
        
            return view('product-categories.index', compact('mainMenus', 'products', 'childMenu', 'subMenu', 'mainMenu', 'banner'));
        }

        return view('product-categories.index', compact('mainMenus', 'products', 'category', 'banner'));
    }








    
    public function list($name)
    {
       
        $mainMenu = MainMenu::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
        if (!$mainMenu) {
            abort(404, 'Category not found');
        }
        $products = Product::where('main_menu_id', $mainMenu->id)
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->orderByRaw("CASE WHEN stock_status = 'N' THEN 1 ELSE 0 END")
            ->orderBy('id', 'DESC')
            ->paginate(12);

        return view('category.index', compact('products', 'mainMenu'));
    }

    

}
