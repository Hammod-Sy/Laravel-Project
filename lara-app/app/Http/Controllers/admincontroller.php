<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class admincontroller extends Controller
{
    public function admin(Request $request) {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response('Invalid Credentials', 401);
        }
        $token = $admin->createToken('admin-token')->plainTextToken;
        return response($token, 200);
    }
    public function add(Request $request){
        $admin = new Admin;
        $admin->email = $request -> email;
        $admin->password = $request -> password;
        $admin -> save();
        return response('adel' ,200);
    }
}

