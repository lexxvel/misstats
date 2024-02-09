<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class users extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'User_Name', 'User_Login', 'User_Password', 'remember_token'];

    public function isUserExists($User_Login)
    {
        $count = DB::table('users')->where('User_Login', '=', $User_Login)->count();
        switch ($count) {
            case 0:
                return false;
            case 1:
                return true;
            default:
                return null;
        }
    }

    public function createUser($User_Login, $User_Name, string $bcrypt, $User_Role_id)
    {
        $result = DB::table('users')
            ->insert([
                'User_Login' => $User_Login,
                'User_Name' => $User_Name,
                'User_Password' => $bcrypt,
                'User_Role_id' => $User_Role_id,
                'created_at' => Carbon::now()
            ]);
        if ($result == 1) {
            return [
                'success' => true,
                'msg' => 'Пользователь создан'
            ];
        } else {
            return [
                'success' => true,
                'error_msg' => 'Пользователь не создан. Произошла ошибка!'
            ];
        }
    }
}
