<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\persons;
use App\Models\posts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    public function getAllPersons() {
        return persons::join('posts', 'posts.Post_id', '=', 'persons.Person_PostId')
        ->select('persons.*', 'posts.Post_Name')
        ->get();
    }

    public function getPersonById($id) {
        $person = persons::join('posts', 'posts.Post_id', '=', 'persons.Person_PostId')
            ->select('persons.*', 'posts.Post_Name')
            ->where('Person_id', $id)
            ->first();
        
        if ($person === null || !$person || $person === "") {
            return [
                "status" => false,
                "message" => "Person not found"
            ];
        } else {
            return $person;
        }
    }

    public function addPerson(Request $request) {
        $Person_Name = $request->input('Person_Name');
        $Person_Secname = $request->input('Person_Secname');
        $Person_Surname = $request->input('Person_Surname');
        $Person_Email = $request->input('Person_Email');
        $Person_TableId = $request->input('Person_TableId');
        $Person_PostName = $request->input('Person_PostName');

        $emailIsExist = persons::where('Person_Email', $Person_Email)
            ->count();
        if ($emailIsExist !== 0) {
            return [
                "status" => false,
                "message" => 'Пользователь с таким Email существует'
            ];
        } else {
            if ($Person_TableId !== "") {
                $tableIsExist = persons::where('Person_Email', $Person_Email)
            ->count();
                if ($tableIsExist >= 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь с таким табельным номером существует'
                    ];
                } else {
                    $postId = posts::where('Post_Name', 'like', $Person_PostName)->first()->Post_id;
                    persons::insert([
                        'Person_Name' => $Person_Name,
                        'Person_Secname' => $Person_Secname,
                        'Person_Surname' => $Person_Surname,
                        'Person_Fullname' => $Person_Surname . " " . $Person_Name . " " . $Person_Secname,
                        'Person_Email' => $Person_Email,
                        'Person_TableId' => $Person_TableId,
                        'Person_PostId' => $postId
                    ]);
                    return [
                        "status" => true,
                        "message" => 'Новый пользователь добавлен!'
                    ];
                }
            }
        }

    }

    public function editPerson(Request $request) {
        $method = $request->input('method');
        $Person_id = intval($request->input('Person_id'));
        switch ($method) {
            case "name":
                $Person_Name = $request->input('Person_Name');
                $personIsExist = persons::where('Person_id', $Person_id)->count();
                if ($personIsExist < 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь не найден!'
                    ];
                } else {
                    $person = persons::where('Person_id', $Person_id)->first();
                    $Person_Secname = $person->Person_Secname;
                    $Person_Surname = $person->Person_Surname;

                    $query = persons::where('Person_id', $Person_id)->first();
                    $query->Person_Name = $Person_Name;
                    $query->Person_Fullname = $Person_Surname . " " . $Person_Name . " " . $Person_Secname;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => 'Имя пользователя успешно изменено!'
                    ];
                }
                break;
            case "secName":
                $Person_Secname = $request->input('Person_Secname');
                $personIsExist = persons::where('Person_id', $Person_id)->count();
                if ($personIsExist < 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь не найден!'
                    ];
                } else {
                    $person = persons::where('Person_id', $Person_id)->first();
                    $Person_Name = $person->Person_Name;
                    $Person_Surname = $person->Person_Surname;

                    $query = persons::where('Person_id', $Person_id)->first();
                    $query->Person_Secname = $Person_Secname;
                    $query->Person_Fullname = $Person_Surname . " " . $Person_Name . " " . $Person_Secname;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => 'Отчество пользователя успешно изменено!'
                    ];
                }
                break;
            case "surName":
                $Person_Surname = $request->input('Person_Surname');
                $personIsExist = persons::where('Person_id', $Person_id)->count();
                if ($personIsExist < 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь не найден!'
                    ];
                } else {
                    $person = persons::where('Person_id', $Person_id)->first();
                    $Person_Name = $person->Person_Name;
                    $Person_Secname = $person->Person_Secname;

                    $query = persons::where('Person_id', $Person_id)->first();
                    $query->Person_Surname = $Person_Surname;
                    $query->Person_Fullname = $Person_Surname . " " . $Person_Name . " " . $Person_Secname;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => 'Фамилия пользователя успешно изменено!'
                    ];
                }
                break;
            case "eMail":
                $Person_Email = $request->input('Person_Email');
                $personIsExist = persons::where('Person_id', $Person_id)->count();
                if ($personIsExist < 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь не найден!'
                    ];
                } else {
                    $query = persons::where('Person_id', $Person_id)->first();
                    $query->Person_Email = $Person_Email;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => 'Email пользователя успешно изменён!'
                    ];
                }
                break;
            case "tableId":
                $Person_TableId = $request->input('Person_TableId');
                $personIsExist = persons::where('Person_id', $Person_id)->count();
                if ($personIsExist < 1) {
                    return [
                        "status" => false,
                        "message" => 'Пользователь не найден!'
                    ];
                } else {
                    $query = persons::where('Person_id', $Person_id)->first();
                    $query->Person_TableId = $Person_TableId;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => 'Табельный номер пользователя успешно изменён!'
                    ];
                }
                break;
        }
    }

    public function getTopFiveFailPersons() {
        $persons = persons::
        select("Person_id", "Person_Fullname", "Person_Failcount")
        ->orderBy('Person_Failcount', 'DESC')
        ->take(5)->get();
        return $persons;
    }

}