<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorTable;

class VisitorController extends Controller{

    public function logVisitor(Request $request){
       $ip = $request->ip();

        VisitorTable::create([
            'ip_address' => $ip,
            'visit_time' => now()
        ]);
    }
}
