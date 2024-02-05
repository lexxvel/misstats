<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function getAllUsers(){
        return users::all();
    }

    public function loginAuth(Request $request){
        $login = $request->input('login');
        $password = $request->input('password');
        $isexist = users::where('User_Login', $login)
        ->where('User_Password', $password )
        ->count();
        $user = users::where('User_Login', $login) ->first();
        if ($isexist == 0) {
            return [
                "status" => false,
                "message" => "User not found"
            ];
        } elseif ($isexist == 1) {
            $user->remember_token = Str::random(60);
            $user->save();
            return [
                "status" => true,
                "message" => "Auth success",
                "remember_token" => $user->remember_token,
                "username" => $user->User_Name,
                "id" => $user->id,
                "User_Role_id" => $user->User_Role_id
            ];
        } else {
            return [
                "status" => false,
                "message" => "Error running auth method"
            ];
        }
    }


}
