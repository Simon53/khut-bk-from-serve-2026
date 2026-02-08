<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorTable;

class VisitorController extends Controller
{
    public function visitorIndex(){
        $visitorData = VisitorTable::all(); 
        $visitorData = VisitorTable::orderBy('id', 'desc')->paginate(10);
        return view('visitor.visitor', ['visitors' => $visitorData]);
    }
}
