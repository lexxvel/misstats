<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UsersController extends Controller
{
    function createUser(Request $request)
    {
        $User_Login = $request->input("User_Login");
        $User_Name = $request->input("User_Name");
        Crypt::encryptString($request->input("User_Password"));
        $User_Password = $request->input("User_Password");
        $User_Role_id = $request->input("User_Role_id");

        if (!$User_Login || !$User_Name || !$User_Password || !$User_Role_id)
        {
            return [
                "status" => "false",
                "msg" => "Не переданы обязательные параметры"
            ];
        }

        $isExist = (new users())->isUserExists($User_Login);

        if ($isExist) {
            return [
                "status" => "false",
                "msg" => "Пользователь не создан, имя использовано ранее"
            ];
        } else if (!$isExist) {
            return (new users)->createUser($User_Login, $User_Name, bcrypt($User_Password), $User_Role_id);
        } else {
            return [
                "status" => "false",
                "msg" => "Пользователь не создан. Произошла ошибка"
            ];
        }
    }

    function delUser(Request $request)
    {
        $id = $request->input("id");
        if (!$id) {
            return [
                "status" => "false",
                "msg" => "Не передан обязательный параметр"
            ];
        }

        return(new users)->delUser($id);
    }

    function updateUser(Request $request)
    {
        $id = $request->input("id");
        $User_Login = $request->input("User_Login");
        $User_Name = $request->input("User_Name");
        Crypt::encryptString($request->input("User_Password"));
        $User_Password = $request->input("User_Password");
        $User_Role_id = $request->input("User_Role_id");

        if (!$id || !$User_Login || !$User_Name || !$User_Password || !$User_Role_id)
        {
            return [
                "status" => "false",
                "msg" => "Не переданы обязательные параметры"
            ];
        }

        return (new users)->updateUser($id, $User_Login, $User_Name, $User_Password, $User_Role_id);
    }
}
