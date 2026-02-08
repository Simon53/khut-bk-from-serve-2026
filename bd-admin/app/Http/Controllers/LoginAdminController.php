<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginAdmin;
use Illuminate\Support\Facades\Hash;

class LoginAdminController extends Controller{
    function loginAdmin(){
        return view('login.login');
    }

   
    public function onLogin(Request $request)
    {
        $user = $request->input('user');
        $pass = $request->input('pass');

        $admin = LoginAdmin::where('username', $user)
                    ->orWhere('email', $user)
                    ->first();

        if ($admin && Hash::check($pass, $admin->password)) {
            $request->session()->put('user', [
                'id' => $admin->id,
                'name' => $admin->name,
                'username' => $admin->username,
                'email' => $admin->email,
                'role' => $admin->role ?? 'editor'
            ]);
            return response()->json(1, 200);
        } else {
            return response()->json(0, 401);
        }
    }
       
    

    function onLogout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }


    public function index() {
        $users = LoginAdmin::orderBy('id', 'desc')->get();
        return view('user.index', compact('users'));
    }

    public function store(Request $request){
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:login_admin,username',
            'email'     => 'required|email|unique:login_admin,email',
            'password'  => 'required|min:6',
            'role'      => 'required|in:Administrator,Moderator'
        ]);

        $user = LoginAdmin::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'data'    => $user
        ]);
    }


    // Edit User
    public function edit($id){
        $user = LoginAdmin::findOrFail($id);
        return response()->json($user);
    }

    // Update User
    public function update(Request $request, $id){
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:login_admin,username,' . $id,
            'email'     => 'required|email|unique:login_admin,email,' . $id,
            'password'  => 'nullable|min:6',
            'role'      => 'required|in:Administrator,Moderator'
        ]);

        $user = LoginAdmin::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'data' => $user
        ]);
    }

    public function destroy($id){
        $user = LoginAdmin::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'User not found!'
        ], 404);
    }


}
