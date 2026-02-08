<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CategoryBanner;
use App\Models\MainMenu;
class CategoryBannerController extends Controller{
    public function categorrybannerIndex(){
        $mainMenus = MainMenu::all();
        $categoryBanners = CategoryBanner::with('mainMenu')->orderBy('id', 'desc')->get();
        return view('category-banner.category-banner', compact('mainMenus','categoryBanners'));
    }

    public function store(Request $request){
        $request->validate([
            'main_menu_id' => 'required|exists:main_menus,id',
            'title' => 'nullable|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:12048',
        ]);
        $imageUrl = null;
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('category_banners', 'public');
           // $imageUrl = asset('storage/' . $path);
            $imageUrl = '/storage/' . $path;
        }
        $banner = CategoryBanner::create([
            'main_menu_id' => $request->main_menu_id,
            'title'        => $request->title,
            'banner_image' => $imageUrl, 
        ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'Category Banner Added Successfully!',
            'data'    => $banner
        ]);
    }



    public function edit($id){
        $banner = CategoryBanner::findOrFail($id);
        return response()->json([
            'id' => $banner->id,
            'main_menu_id' => $banner->main_menu_id,
            'title' => $banner->title,
            'banner_image' => asset($banner->banner_image)
        ]);
    }


   public function update(Request $request){
    $banner = CategoryBanner::findOrFail($request->id);

    $request->validate([
        'main_menu_id' => 'required|exists:main_menus,id',
        'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12048',
    ]);

    $banner->main_menu_id = $request->main_menu_id;
    $banner->title = $request->title;
    if($request->hasFile('banner_image')){
        $file = $request->file('banner_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('category_banners', $filename, 'public');
       // $banner->banner_image = url('storage/'.$path);
        $banner->banner_image = '/storage/' . $path;
    }
    $banner->save();
    return response()->json([
        'status' => 'success',
        'message' => 'Category Banner Updated Successfully!'
    ]);
}


    
    public function destroy($id){
        $banner = CategoryBanner::findOrFail($id);
        if($banner->banner_image && file_exists(public_path($banner->banner_image))){
            unlink(public_path($banner->banner_image));
        }
        $banner->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category Banner Deleted Successfully!'
        ]);
    }



}
