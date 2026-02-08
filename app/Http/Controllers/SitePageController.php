<?php

namespace App\Http\Controllers;

use App\Models\SiteMenu;
use App\Models\SitePage;
use Illuminate\Http\Request;

class SitePageController extends Controller
{
    public function showPage($slug){
        $menu = SiteMenu::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $pages = SitePage::where('site_menu_id', $menu->id)->get();

        // Flat breadcrumb
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $menu->name, 'url' => route('site.page', $menu->slug)]
        ];
        return view('site.pages.index', compact('menu', 'pages', 'breadcrumbs'));
    }
}
