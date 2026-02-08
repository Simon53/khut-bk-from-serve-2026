<?php

namespace App\Http\Controllers;
use App\Models\BodySize;
use Illuminate\Http\Request;

class BodySizeController extends Controller
{
    public function bodysizeIndex(){
       $bodySizes = BodySize::orderBy('id', 'desc')->paginate(10);
        return view('body-size.body-size', compact('bodySizes'));
    }

    public function getAll(){
        $bodySizes = BodySize::latest()->paginate(10);
        return response()->json($bodySizes);
    }

    public function store(Request $request) {
        BodySize::create([
            'body_size' => $request->body_size
        ]);
        return response()->json(['message' => 'BodySize added successfully!']);
    }

    public function update(Request $request){
        $bodySize = BodySize::findOrFail($request->id);
        $bodySize->update(['body_size' => $request->body_size]);
        return response()->json(['message' => 'BodySize updated successfully!']);
    }

    public function destroy($id){
        BodySize::findOrFail($id)->delete();
        return response()->json(['message' => 'BodySize deleted successfully!']);
    }
}
