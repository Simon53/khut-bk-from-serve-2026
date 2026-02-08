<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorTable;
use App\Models\Slider;
use App\Models\SitePage;
use App\Models\SiteMenu;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\MainMenu;
use App\Models\ChildMenu;
use App\Models\CategoryBanner;
use App\Models\KhutStory;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        VisitorTable::create([
            'ip_address' => $request->ip(),
            'visit_time' => now(),
        ]);

        return view('home.home'); 
    }

    public function homeIndex()
    {
        // ===== Sliders =====
        $sliders = Slider::where('is_active', 'Yes')->get();

        // $adminBaseUrl = env('ADMIN_BASE_URL');

        $adminBaseUrl = rtrim(env('ADMIN_BASE_URL'), '/');

        // Convert DB path (sliders/xxx.jpg) → full URL
        $sliders->transform(function ($item) use ($adminBaseUrl) {
            $item->full_image = $adminBaseUrl . '/storage/' . $item->slider_location;
            return $item;
        });

        // ===== Menus =====
        $cottonMenu = ChildMenu::where('name', 'Cotton')->first();
        $endiSilkMenu = ChildMenu::where('name', 'Endi-Silk')->first();
        $halfSilkMenu = ChildMenu::where('name', 'Half-Silk')->first();

        $mainMenus = MainMenu::with('subMenus')->get();

        // ===== Festive Products =====
        $festiveProducts = Product::whereIn('bottom_fastive', ['festive-left', 'festive-right'])
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->latest()
            ->take(2)
            ->get();

        $festiveLeft = $festiveProducts->firstWhere('bottom_fastive', 'festive-left');
        $festiveRight = $festiveProducts->firstWhere('bottom_fastive', 'festive-right');

   
        

        // ===== Pages =====
        $pages = SitePage::all()->map(function($page) {
            $cleanText = strip_tags($page->details);
            $page->first_paragraph = Str::limit($cleanText, 600);

            preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $page->details, $img_matches);
            $page->first_image = $img_matches[1] ?? '';
            $page->menu_slug = optional($page->menu)->slug ?? '';
            return $page;
        });

        // ===== Products =====
        $products = Product::where('new_arrivals', 'Y')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->latest()
            ->take(6)
            ->get();

        $featureProduct = Product::with(['childMenu', 'subMenu', 'mainMenu'])
            ->where('feature', 'Feature One')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->latest()
            ->first();

        $featureTwoProduct = Product::with(['childMenu', 'subMenu', 'mainMenu'])
            ->where('feature', 'Feature Two')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->latest()
            ->first();

        $highlightProducts = Product::where('site_view_status', 'Y')
            ->where('published_site', 'Y')
            ->whereIn('highlight', ['highlight-one', 'highlight-two', 'highlight-three', 'highlight-four'])
            ->get()
            ->keyBy('highlight');

        $ArtGellery = Product::where('bottom_fastive', 'art-gallery')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->take(10)
            ->get();

        $stories = KhutStory::where('is_active', 'Y')
            ->latest()
            ->take(4)
            ->get();

        $cottonProducts = $cottonMenu
            ? Product::where('child_menu_id', $cottonMenu->id)
                ->where('published_site', 'Y')
                ->where('site_view_status', 'Y')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $endiSilkProducts = $endiSilkMenu
            ? Product::where('child_menu_id', $endiSilkMenu->id)
                ->where('published_site', 'Y')
                ->where('site_view_status', 'Y')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $halfSilkProducts = $halfSilkMenu
            ? Product::where('child_menu_id', $halfSilkMenu->id)
                ->where('published_site', 'Y')
                ->where('site_view_status', 'Y')
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $patchworkProducts = Product::where('patchwork', 'Y')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->latest()
            ->take(10)
            ->get();
            
      // "Ho-jo-bo-ro-lo" মেইন ক্যাটাগরির ৪টা লেটেস্ট প্রোডাক্ট
       $mainMenu = MainMenu::whereRaw('LOWER(name) = ?', ['Hojoborolo'])->first();

        $HozoboroloProducts = collect(); // default empty collection
        
        if ($mainMenu) {
            $HozoboroloProducts = Product::where('main_menu_id', $mainMenu->id)
                ->where('published_site', 'Y')
                ->where('site_view_status', 'Y')
                ->latest()
                ->take(4)
                ->get();
        }

            
         

        $bottomContent = Product::where('bottom_fastive', 'bottom-image')
            ->where('published_site', 'Y')
            ->where('site_view_status', 'Y')
            ->select('details', 'main_image')
            ->first();

        $footerMenus = SiteMenu::where('status', 1)->get();
        $menuBanners = CategoryBanner::with('mainMenu')->get();

        return view('home.home', compact(
            'sliders',
            'products',
            'mainMenus',
            'featureProduct',
            'featureTwoProduct',
            'highlightProducts',
            'menuBanners',
            'pages',
            'stories',
            'footerMenus',
            'cottonProducts',
            'endiSilkProducts',
            'halfSilkProducts',
            'festiveLeft',
            'festiveRight',
            'patchworkProducts',
            'bottomContent',
            'HozoboroloProducts',
            'adminBaseUrl' 
        ));
    }
    
public function patchworkProducts()
{
    $products = \App\Models\Product::where('patchwork', 'Y')
        ->where('published_site', 'Y')
        ->where('site_view_status', 'Y')
        ->latest()
        ->paginate(12);

    $mainMenus = \App\Models\MainMenu::with('subMenus.childMenus')->get();

    // Category object
    $category = (object)[
        'name' => 'Patchwork',
        'title' => 'Patchwork'
    ];

    // Load banner
    $banner = \App\Models\CategoryBanner::first();

    if ($banner && !empty($banner->banner_image)) {
        $bannerImage = $banner->banner_image;

        // 1️⃣ Remove base URL if exists
        $bannerImage = preg_replace('#^https?://[^/]+/#', '', $bannerImage);

        // 2️⃣ Remove leading storage/ if exists
        $bannerImage = preg_replace('#^/?storage/#', '', $bannerImage);

        // 3️⃣ Final relative path
        $category->banner = '/storage/' . ltrim($bannerImage, '/');

    } else {
        // fallback relative path
        $category->banner = '/storage/category_banners/product_banner.jpg';
    }

    return view(
        'product-categories.patchwork',
        compact('products', 'mainMenus', 'category')
    );
}




       public function newArrivalsProducts()
            {
                $products = \App\Models\Product::where('new_arrivals', 'Y')
                    ->where('published_site', 'Y')
                    ->where('site_view_status', 'Y')
                    ->latest()
                    ->paginate(12);

                $mainMenus = \App\Models\MainMenu::with('subMenus.childMenus')->get();

                // Category object
                $category = (object)[
                    'name' => 'New Arrivals',
                    'title' => 'New Arrivals'
                ];

                // Load banner
                $banner = \App\Models\CategoryBanner::first();

                if ($banner && !empty($banner->banner_image)) {
                    $bannerImage = $banner->banner_image;

                    // Remove base URL if exists
                    $bannerImage = preg_replace('#^https?://[^/]+/#', '', $bannerImage);

                    // Remove leading storage/ if exists
                    $bannerImage = preg_replace('#^/?storage/#', '', $bannerImage);

                    // Final relative path
                    $category->banner = '/storage/' . ltrim($bannerImage, '/');

                } else {
                    $category->banner = '/storage/category_banners/product_banner.jpg';
                }

                return view(
                    'product-categories.new-arrivals',
                    compact('products', 'mainMenus', 'category')
                )->with('activeMenu', 'New Arrivals');
            }



}
