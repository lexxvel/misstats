<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\sprints;
use App\Models\tasks;
use App\Models\users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SprintsController extends Controller
{
    public function getSprints(Request $request) {
        $user_id = $request->input('User_id');
        $role = users::where('id', $user_id)->first()->User_Role_id;
        if ($role > 1) {
            return sprints::select('sprints.*', 'users.User_Name')
                ->join('users', 'users.id', '=', 'sprints.Sprint_UserId')
                ->get();
        } else {
            return sprints::select('sprints.*', 'users.User_Name')
                ->join('users', 'users.id', '=', 'sprints.Sprint_UserId')
                ->where('sprints.Sprint_UserId', $user_id)
                ->get();
        }
    }

    public function addSprint(Request $request) {
        $user_id = $request->input('User_id');
        $Sprint_Name = $request->input('Sprint_Name');
        if ($user_id !== null && $Sprint_Name !== null) {
            $isExist = sprints::where('Sprint_Name', $Sprint_Name)->get()->count();
            if ($isExist < 1) {
                sprints::insert([
                    'Sprint_Name' => $Sprint_Name,
                    'Sprint_UserId' => $user_id
                ]);
                return [
                    "status" => true,
                    "message" => 'Спринт успешно добавлен'
                ];
            } else {
                return [
                    "status" => false,
                    "message" => 'Спринт с таким названием уже существует'
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => 'Необходимые параметры не переданы!'
            ];
        }
    }

    public function getSprintStats(Request $request) {
        $Sprint_id = $request->input('Sprint_id');
        $allTasksCount = tasks::where('Task_SprintId', $Sprint_id)->get()->count();
        $failedTasksCount = tasks::where('Task_SprintId', $Sprint_id)->whereNotIn('Task_Failcause', [101])->get()->count();
        $allSprintTasks = tasks::where('Task_SprintId', $Sprint_id)->get();
        
        return [
            'allTasksCount' => $allTasksCount,
            'failedTasksCount' => $failedTasksCount,
            'tasks' => $allSprintTasks
        ];
    }
}
