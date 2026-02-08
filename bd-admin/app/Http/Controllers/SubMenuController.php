<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;

class SubMenuController extends Controller{


    public function store(Request $request){
        $request->validate([
            'main_menu_id' => 'required|exists:main_menus,id',
            'name' => 'required|string|max:255',
        ]);

        SubMenu::create([
            'main_menu_id' => $request->main_menu_id,
            'name' => $request->name,
        ]);

        return response()->json(['success' => true]);
    }


    public function getByMainMenu($id){
        $subMenus = SubMenu::where('main_menu_id', $id)->get();
        return response()->json($subMenus);
    }


    
    public function edit($id){
        $submenu = SubMenu::findOrFail($id);
        return response()->json([
            'id' => $submenu->id,
            'name' => $submenu->name,
            'main_menu_id' => $submenu->main_menu_id,
        ]);
    }

    public function update(Request $request){
        $submenu = SubMenu::findOrFail($request->id);
        $submenu->name = $request->name;
        $submenu->main_menu_id = $request->main_menu_id;
        $submenu->save();

        return response()->json(['success' => true]);
    }

public function destroy($id)
{
    $submenu = SubMenu::findOrFail($id);
    $submenu->childMenus()->delete(); // delete children
    $submenu->delete();

    return response()->json(['message' => 'Sub menu deleted successfully']);
}

}
