<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteMenu;
use Illuminate\Support\Str;

class SiteMenuController extends Controller{
  
    public function index()
    {
        $menus = SiteMenu::latest()->get();
        return view('site_menus.index', compact('menus'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:site_menus,name',
        ]);

        SiteMenu::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 1,
        ]);

        return response()->json(['success' => 'Menu created successfully!']);
    }

  public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $menu = SiteMenu::findOrFail($id);
        $menu->name = $request->name;
        $menu->save();

        return response()->json(['success' => 'Menu updated successfully']);
    }

    public function destroy($id){
        SiteMenu::findOrFail($id)->delete();
        return response()->json(['success' => 'Menu deleted successfully!']);
    }
}
