<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\ChildMenu;

class MainMenuController extends Controller
{
    public function menuIndex(){
      
        $mainMenus = MainMenu::all();
        return view('menu.menu', compact('mainMenus'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        MainMenu::create(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id){
        $menu = MainMenu::find($id);
        $menu->update(['name' => $request->name]);      
        return response()->json(1);
    }

public function destroy($id)
{
    $mainMenu = MainMenu::with('subMenus.childMenus')->findOrFail($id); // 👈 eager load
    $mainMenu->delete();

    return response()->json(['message' => 'Main menu deleted successfully']);
}

}
