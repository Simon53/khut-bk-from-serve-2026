<?php

namespace App\Http\Controllers;
use App\Models\DryWash;
use Illuminate\Http\Request;

class DryWashController extends Controller{

    public function drywashIndex(){
       $dry_washes = DryWash::orderBy('id', 'DESC')->paginate(10); 
       return view('drywash.dry-wash-page', compact('dry_washes'));
    }

    public function store(Request $request){
        $request->validate([
            'drywash_name' => 'required|string|max:255',
        ]);

        $dry_washes = new DryWash();
        $dry_washes->drywash_name = $request->drywash_name;
        $dry_washes->save();

        return response()->json(['message' => 'Drywash name added successfully!']);
    }


   public function update(Request $request, $id){
        $request->validate([
            'drywash_name' => 'required|string|max:255',
        ]);

        $dry_washes = DryWash::findOrFail($id);
        $dry_washes->drywash_name = $request->drywash_name;
        $dry_washes->save();

        return response()->json(['message' => 'Drywash Name updated successfully']);
    }


    public function destroy($id){
        $dry_washes = DryWash::find($id);

        if (!$dry_washes) {
            return response()->json(['message' => 'Dry Washe not found.'], 404);
        }

        $dry_washes->delete();

        return response()->json(['message' => 'Dry Washe deleted successfully.']);
    }
    
}
