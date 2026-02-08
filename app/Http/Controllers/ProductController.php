<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainMenu;        
use App\Models\SubMenu;
use App\Models\ChildMenu;
use App\Models\CategoryBanner;   
use App\Models\Status;
use App\Models\Iron;
use App\Models\DryWash;

class ProductController extends Controller{


   
    
    public function list($name){
        $decodedName = str_replace('-', ' ', $name);
        $mainMenu = MainMenu::where('name', $decodedName)->firstOrFail();
        $products = Product::where('main_menu_id', $mainMenu->id)
            ->where('site_view_status', 'Y')
            ->orderBy('id', 'desc')
            ->paginate(50);
            $banner = CategoryBanner::where('main_menu_id', $mainMenu->id)->first();
            return view('product-categories.index', compact('products', 'mainMenu', 'banner'));
        }

        public function categoryProducts($id){
            $products = Product::with(['mainMenu', 'subMenu', 'childMenu'])
            ->where('main_menu_id', $id)
            ->orWhere('sub_menu_id', $id)
            ->orWhere('child_menu_id', $id)
            ->paginate(12);

            return view('product-categories.index', compact('products'));
        }

    
   

    // Product Details দেখাবে
   public function details($slug)
{
    $product = Product::with([
        'thumbnails.color',
        'thumbnails.bodySize',
        'thumbnails.commonSize',
        'thumbnails.options.commonSize',
        'thumbnails.options.bodySize',
        'mainMenu',
        'subMenu',
        'childMenu',
        'statuses',
        'irons',
        'dryWashes',
    ])->where('slug', $slug)->firstOrFail();

    $thumbnails = $product->thumbnails;
    $colors = $thumbnails->pluck('color')->filter()->unique('id');
    $bodySizes = $thumbnails->pluck('bodySize')->filter()->unique('id');
    $commonSizes = $thumbnails->pluck('commonSize')->filter()->unique('id');

    // ✅ Related products properly filtered by category hierarchy
    if ($product->child_menu_id) {
        $relatedProducts = Product::where('child_menu_id', $product->child_menu_id)
            ->where('id', '!=', $product->id)
            ->where('site_view_status', 'Y')
            ->limit(12)
            ->orderBy('id', 'desc')
            ->get();
    } elseif ($product->sub_menu_id) {
        $relatedProducts = Product::where('sub_menu_id', $product->sub_menu_id)
            ->where('id', '!=', $product->id)
            ->where('site_view_status', 'Y')
            ->limit(12)
            ->orderBy('id', 'desc')
            ->get();
    } else {
        $relatedProducts = Product::where('main_menu_id', $product->main_menu_id)
            ->where('id', '!=', $product->id)
            ->where('site_view_status', 'Y')
            ->limit(12)
            ->orderBy('id', 'desc')
            ->get();
    }

    return view('product-details.index', compact(
        'product',
        'thumbnails',
        'colors',
        'bodySizes',
        'commonSizes',
        'relatedProducts'
    ));
    
    

}



   



        public function allProductsList($type)
        {
            $decodedType = strtolower($type);
        
            // Column-based types
            $validColumns = ['new_arrivals', 'patchwork', 'festive_collection'];
        
            if (in_array($decodedType, $validColumns)) {
                $products = Product::where($decodedType, 'Y')
                    ->where('published_site', 'Y')
                    ->where('site_view_status', 'Y')
                    ->latest()
                    ->orderBy('id', 'desc')
                    ->paginate(12);
        
                $showBanner = false;
                $displayType = ucwords(str_replace('_', ' ', $decodedType));
        
                return view('all-products.all-products-list', compact('products', 'displayType', 'showBanner'));
            }
        
            // Category-based filter (MainMenu)
            $mainMenu = MainMenu::whereRaw('LOWER(name) = ?', [$decodedType])->first();
        
            if ($mainMenu) {
                $subIds = $mainMenu->subMenus->pluck('id')->toArray();
                $childIds = ChildMenu::whereIn('sub_menu_id', $subIds)->pluck('id')->toArray();
        
                $products = Product::where('published_site', 'Y')
                    ->where('site_view_status', 'Y')
                    ->where(function($q) use ($mainMenu, $subIds, $childIds) {
                        $q->where('main_menu_id', $mainMenu->id)
                          ->orWhereIn('sub_menu_id', $subIds)
                          ->orWhereIn('child_menu_id', $childIds);
                    })
                    ->latest()
                    ->orderBy('id', 'desc')
                    ->paginate(12);
        
                $showBanner = true;
                $displayType = $mainMenu->name;
        
                return view('all-products.all-products-list', compact('products', 'displayType', 'showBanner'));
            }
        
            // Column নেই + category নেই → empty collection
            $products = collect(); 
            $showBanner = false;
            $displayType = ucwords(str_replace('-', ' ', $type));
        
            return view('all-products.all-products-list', compact('products', 'displayType', 'showBanner'));
        }
        






}
