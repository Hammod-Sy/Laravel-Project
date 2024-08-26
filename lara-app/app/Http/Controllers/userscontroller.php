<?php

namespace App\Http\Controllers;

use App\Http\Requests\productRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash as FacadesHash;

class userscontroller extends Controller
{
    public function register(Request $request){
        $users = new User;
        if($request -> name){
            $users -> name = $request -> name;
        }
        if($request-> email){
            $users -> email = $request -> email;
        }
        if($request -> password){
            $users -> password = $request -> password;
        Hash::make($request -> password);
        }
        $users -> save();
        return response($users);
    }
    public function login(Request $request){
        $credentials = $request -> only('email' ,'password');
        if(!Auth::attempt($credentials)){
            return response('Invalid Credentials' ,401);
        }
        $token = $request->user()->createToken('token')->plainTextToken;
        $cookies = Cookie('jwt', $token, 60 * 24  ,'/', null, true, true, false,'None');
        return response('Logged In Successfully', 200)->withCookie($cookies);
        }


    public function getusers(){
        $users = User::all();
        if(!$users){
            return response('No Users' ,201);
        }
        return response($users ,200);
    }
    public function updateusers(Request $request , $id){
        $oldusers = User::find($id);
           $oldusers -> name = $request -> name;
         $oldusers -> email = $request -> email;
        $oldusers -> password = Hash::make( $request -> password);
       $oldusers -> save();
       return response("user Updated",200);
    }

    public function logout(){
        $cookies = Cookie::forget('jwt');
        return response('Logged Out' , 201)->withCookie($cookies);
    }

    public function delete($id){
        $users = User::destroy($id);
        return response('deleted' ,200);
    }

}
