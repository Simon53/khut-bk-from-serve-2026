<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;

class ChildMenuController extends Controller{
   
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'submenu_id' => 'required|exists:sub_menus,id'
        ]);

        $child = new ChildMenu();
        $child->name = $request->name;
        $child->sub_menu_id = $request->submenu_id;
        $child->save();

        return response()->json(['success' => true]);
    }



    public function getBySubmenu($id) {
        return ChildMenu::with('subMenu.mainMenu')
            ->where('sub_menu_id', $id)
            ->get();
    }




    public function getChildMenus($submenuId){
    $childMenus = ChildMenu::with('subMenu.mainMenu')
        ->where('sub_menu_id', $submenuId) 
        ->get();

    return response()->json($childMenus);
    }




    public function edit($id){
        $child = ChildMenu::with('subMenu.mainMenu')->findOrFail($id);

        $mainMenuId = null;
        if ($child->subMenu && $child->subMenu->mainMenu) {
            $mainMenuId = $child->subMenu->mainMenu->id;
        }

        $subMenus = $mainMenuId 
            ? SubMenu::where('main_menu_id', $mainMenuId)->get() 
            : collect();  // empty collection to avoid errors

        return response()->json([
            'child' => $child,
            'mainMenus' => MainMenu::all(),
            'subMenus' => $subMenus,
        ]);
    }

    public function list(){
        $childMenus = ChildMenu::with('subMenu.mainMenu')->get();
        return view('partials.child_menu_table', compact('childMenus'));
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required|exists:child_menus,id',
            'name' => 'required|string|max:255',
            'main_menu_id' => 'required|exists:main_menus,id',
            'sub_menu_id' => 'required|exists:sub_menus,id',
        ]);

        $child = ChildMenu::find($request->id);
        $child->name = $request->name;
        $child->sub_menu_id = $request->sub_menu_id;
        $child->save();

        return response()->json(['message' => 'Child menu updated successfully']);
    }


    public function destroy($id)
    {
        $child = ChildMenu::findOrFail($id);
        $child->delete();

        return response()->json(['message' => 'Child menu deleted successfully']);
    }
}
