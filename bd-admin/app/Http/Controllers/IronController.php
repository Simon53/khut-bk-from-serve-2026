<?php

namespace App\Http\Controllers;
use App\Models\Iron;
use Illuminate\Http\Request;

class IronController extends Controller{
    
    public function ironIndex(){
        $iron = Iron::orderBy('id', 'DESC')->paginate(10); 
        return view('iron.iron', compact('iron'));
    }

    public function store(Request $request){
        $request->validate([
            'iron_name' => 'required|string|max:255',
        ]);

        $iron = new Iron();
        $iron->iron_name = $request->iron_name;
        $iron->save();

        return response()->json(['message' => 'Iron name added successfully!']);
    }


   public function update(Request $request, $id){
        $request->validate([
            'iron_name' => 'required|string|max:255',
        ]);

        $iron = Iron::findOrFail($id);
        $iron->iron_name = $request->iron_name;
        $iron->save();

        return response()->json(['message' => 'Iron Name updated successfully']);
    }


    public function destroy($id){
       $iron = Iron::find($id);

        if (!$iron) {
            return response()->json(['message' => 'Iron name not found.'], 404);
        }

        $iron->delete();

        return response()->json(['message' => 'Iron name deleted successfully.']);
    }
}
