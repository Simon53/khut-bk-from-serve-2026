<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CKEditorController extends Controller{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file     = $request->file('upload');
            $filename = time().'_'.$file->getClientOriginalName();
            $path     = $file->storeAs('uploads/ckeditor', $filename, 'public');

            return response()->json([
                'url' => asset('storage/'.$path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

}
