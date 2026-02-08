<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginAdmin;

class AdminLoginController extends Controller{
    public function login(Request $request)
    {
        $user = LoginAdmin::where('username', $request->user)->orWhere('email', $request->user)->first();

        if($user && Hash::check($request->pass, $user->password)){
            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ]
            ]);
            return response()->json(1); 
        } else {
            return response()->json(0); 
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}
