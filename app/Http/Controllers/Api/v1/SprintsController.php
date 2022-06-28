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
                ->orderBy('Sprint_id','DESC')
                ->get()->reverse();
        } else {
            return sprints::select('sprints.*', 'users.User_Name')
                ->join('users', 'users.id', '=', 'sprints.Sprint_UserId')
                ->where('sprints.Sprint_UserId', $user_id)
                ->orderBy('Sprint_id','DESC')
                ->get()->reverse();
        }
    }

    public function addSprint(Request $request) {
        $user_id = $request->input('User_id');
        $Sprint_Name = $request->input('Sprint_Name');
        $Sprint_isActual = $request->input('Sprint_isActual');
        if ($user_id !== null && $Sprint_Name !== null && $Sprint_isActual !== null) {
            $isExist = sprints::where('Sprint_Name', $Sprint_Name)->get()->count();
            if ($isExist < 1) {
                if ($Sprint_isActual === "Да") {
                    sprints::where('Sprint_isActual', 1)
                        ->chunkById(100, function ($sprints) {
                            foreach ($sprints as $sprint) {
                                sprints::where('Sprint_id', $sprint->Sprint_id)
                                    ->update(['Sprint_isActual' => 0]);
                            }
                        });
                    
                    sprints::insert([
                        'Sprint_Name' => $Sprint_Name,
                        'Sprint_UserId' => $user_id,
                        'Sprint_isActual' => 1
                    ]);
                } else {
                    sprints::insert([
                        'Sprint_Name' => $Sprint_Name,
                        'Sprint_UserId' => $user_id
                    ]);
                }
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

    public function changeActualSprint(Request $request) {
        $user_id = $request->input('User_id');
        $Sprint_Name = $request->input('Sprint_Name');

        if ($user_id !== null && $Sprint_Name !== null) {
            $isExist = sprints::where('Sprint_Name', $Sprint_Name)->get()->count();
            if ($isExist === 1) {

                sprints::where('Sprint_isActual', 1)
                ->chunkById(100, function ($sprints) {
                    foreach ($sprints as $sprint) {
                        sprints::where('Sprint_id', $sprint->Sprint_id)
                            ->update(['Sprint_isActual' => 0]);
                    }
                });
                $Sprint_id = sprints::where('Sprint_Name', 'like', $Sprint_Name)->first()->Sprint_id;
                
                sprints::where('Sprint_id', $Sprint_id)->update(['Sprint_isActual' => 1]);
                
                return [
                    "status" => true,
                    "message" => 'Установлен актуальный спринт '.$Sprint_Name
                ];
            } else {
                return [
                    "status" => false,
                    "message" => 'Спринт не существует'
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => 'Необходимые параметры не переданы!'
            ];
        }


    }
}
