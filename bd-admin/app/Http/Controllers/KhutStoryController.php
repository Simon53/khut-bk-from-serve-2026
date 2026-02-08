<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhutStory;

class KhutStoryController extends Controller{
    
    // List all stories
    public function index(){
    $stories = KhutStory::orderBy('id','desc')->paginate(10); // 10 per page

    return view('khut-stories.index', compact('stories'));
    }

    // Show Create Form
    public function create()
    {
        return view('khut-stories.create');
    }

    // Store Data
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'details' => 'required|string',
            'choose_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12048',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('choose_image')) {
            $file = $request->file('choose_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            //$imagePath = asset('uploads/' . $filename); 
            $imagePath = '/uploads/' . $filename;
        }

        KhutStory::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'details' => $request->details,
            'image'   => $imagePath,
            'is_active' => $request->has('is_active') ? 'Y' : 'N',
           
        ]);

        return redirect()->route('khut-stories.create')->with('success', 'Khut Story created successfully!');
    }

    // TinyMCE Image Upload
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('khut-stories', 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }


    



    public function update(Request $request, $id){
        $story = KhutStory::findOrFail($id);
        $story->title   = $request->title;
        $story->subject   = $request->subject;
        $story->details = $request->details;
        $story->is_active = $request->has('is_active') ? 'Y' : 'N';

        // ইমেজ আপলোড
        if ($request->hasFile('image')) {
            if ($story->image && file_exists(public_path(parse_url($story->image, PHP_URL_PATH)))) {
                unlink(public_path(parse_url($story->image, PHP_URL_PATH)));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
           // $story->image = asset('uploads/' . $filename);

            $story->image = '/uploads/' . $filename;
        }

        $story->save();

        return response()->json(['success' => true]);
    } 


          










    // Delete story
    public function destroy($id)
    {
        $story = KhutStory::findOrFail($id);
        $story->delete();

        return redirect()->route('khut-stories.index')->with('success', 'Story deleted successfully.');
    }
}
