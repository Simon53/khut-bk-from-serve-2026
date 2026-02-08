<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TinyMCEController extends Controller{
      public function upload(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/tinymce'), $filename);

            return response()->json(['location' => asset('uploads/tinymce/'.$filename)]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
