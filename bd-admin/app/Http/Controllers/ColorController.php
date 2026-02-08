<?php

namespace App\Http\Controllers;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function colorIndex(){
        $colors = Color::latest()->paginate(10); 
        return view('color.color', compact('colors'));
    }

    public function store(Request $request){
        $request->validate([
            'color_name' => 'required|string|max:255',
        ]);

        $color = new Color();
        $color->color_name = $request->color_name;
        $color->save();

        return response()->json(['message' => 'Color added successfully!']);
    }


   public function update(Request $request, $id){
        $request->validate([
            'color_name' => 'required|string|max:255',
        ]);

        $color = Color::findOrFail($id);
        $color->color_name = $request->color_name;
        $color->save();

        return response()->json(['message' => 'Color updated successfully']);
    }


    public function destroy($id){
        $color = Color::find($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found.'], 404);
        }

        $color->delete();

        return response()->json(['message' => 'Color deleted successfully.']);
    }

}
