<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteMenu;
use App\Models\SitePage;
use Illuminate\Http\Request;

class SitePageController extends Controller{

    public function index(){
        $pages = SitePage::with('siteMenu')->latest()->get();
        $siteMenus = SiteMenu::all();  // add this line
        return view('site-pages.list', compact('pages', 'siteMenus'));
    }

    public function create(){
        $siteMenus = SiteMenu::all();
        return view('site-pages.site-pages', compact('siteMenus'));
    }

    public function store(Request $request){
        $request->validate([
            'page_title' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    if (SitePage::where('site_menu_id', $request->site_menu_id)
                        ->where('page_title', $value)
                        ->exists()) {
                        $fail('This Page Title has already been created for this Site Menu');
                    }
                }
            ],
            'site_menu_id' => 'required|exists:site_menus,id',
            'choose_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12048',
        ]);

        $imagePath = null;

        if ($request->hasFile('choose_image')) {
            $file = $request->file('choose_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

           // $imagePath = asset('uploads/' . $filename); 
            $imagePath = '/uploads/' . $filename;
        }

        SitePage::create([
            'page_title'   => $request->page_title,
            'details'      => $request->details,
            'image'        => $imagePath,
            'site_menu_id' => $request->site_menu_id,
        ]);

        return redirect()->back()->with('success', 'Page created successfully');
    }


    public function edit($id){
        $page = SitePage::findOrFail($id);
        $siteMenus = SiteMenu::all();
        return view('site-pages.edit', compact('page', 'siteMenus'));
    }

    public function update(Request $request, $id){
        $page = SitePage::findOrFail($id);

        $request->validate([
            'page_title' => [
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    if (SitePage::where('site_menu_id', $request->site_menu_id)
                        ->where('page_title', $value)
                        ->where('id', '!=', $id)->exists()) {
                        $fail('This page title already exists under the selected menu.');
                    }
                }
            ],
            'site_menu_id' => 'required|exists:site_menus,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12048',
            'details' => 'nullable|string', // CKEditor field
        ]);

        $page->page_title = $request->page_title;
        $page->site_menu_id = $request->site_menu_id;
        $page->details = $request->details;

        // Image Upload
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($page->image && file_exists(public_path(parse_url($page->image, PHP_URL_PATH)))) {
                unlink(public_path(parse_url($page->image, PHP_URL_PATH)));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            //$page->image = asset('uploads/' . $filename);
            $page->image = '/uploads/' . $filename;
        }

        $page->save();

        return response()->json(['success' => true]);
    }




    public function destroy($id){
        $page = SitePage::findOrFail($id);
        $page->delete();
        return redirect()->route('site-pages.list')->with('success', 'Page deleted successfully');
    }

}
