<?php

namespace App\Http\Controllers;
use App\Models\CommonSize;
use Illuminate\Http\Request;

class CommonSizeController extends Controller
{
    public function CommonSizeIndex(){
       $commonSizes = CommonSize::orderBy('id', 'desc')->paginate(10);
       return view('common-size.common-size', compact('commonSizes'));
    
    }

    public function getAll(){
        $CommonSizes = CommonSize::latest()->paginate(10);
        return response()->json($CommonSizes);
    }

    public function store(Request $request) {
        CommonSize::create([
            'common_size' => $request->common_size
        ]);
        return response()->json(['message' => 'CommonSize added successfully!']);
    }

    public function update(Request $request){
        $CommonSize = CommonSize::findOrFail($request->id);
        $CommonSize->update(['common_size' => $request->common_size]);
        return response()->json(['message' => 'CommonSize updated successfully!']);
    }

    public function destroy($id){
        CommonSize::findOrFail($id)->delete();
        return response()->json(['message' => 'CommonSize deleted successfully!']);
    }
}
