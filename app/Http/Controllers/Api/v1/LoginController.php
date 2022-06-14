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
        $email = $request->input('email');
        $password = $request->input('password');
        $isexist = users::where('User_Email', $email)
        ->where('User_Password', $password )
        ->count();
        $user = users::where('User_Email', $email) ->first();
        if ($isexist == 0) {
            return [
                "status" => false,
                "message" => "User not found"
            ];
        } elseif ($isexist == 1) {
            $user->api_token = Str::random(60);
            $user->save();
            return [
                "status" => true,
                "message" => "Auth success",
                "api_token" => $user->api_token,
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