<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhutStory; // 

class KhutStoryController extends Controller{
   public function index()
    {
        $stories = KhutStory::orderBy('created_at', 'desc')->paginate(12);
        return view('khut-stories.index', compact('stories'));
    }

    public function show($id)
    {
        $story = KhutStory::findOrFail($id);
        return view('khut-stories.show', compact('story'));
    }

    public function details($id){
        
        $story = KhutStory::find($id);

        if (!$story) {
            
            return redirect()->route('khut-stories.index')->with('error', 'Story not found');
        }

        return view('khut-stories.details', compact('story'));
    }
}
