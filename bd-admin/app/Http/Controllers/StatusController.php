<?php

namespace App\Http\Controllers;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller{
    
    
    public function statusIndex(){
     
       $status = Status::latest()->paginate(10);
       return view('status-page.status-page', compact('status'));
    
    }

    public function getAll(){
        $status = status::latest()->paginate(10);
        return response()->json($status);	
    }

    public function store(Request $request) {
        status::create([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'status added successfully!']);
    }

    public function update(Request $request){
        $status = status::findOrFail($request->id);
        $status->update(['status' => $request->status]);
        return response()->json(['message' => 'status updated successfully!']);
    }

    public function destroy($id){
        status::findOrFail($id)->delete();
        return response()->json(['message' => 'status deleted successfully!']);
    }
}
