<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\tasks;
use App\Models\causes;
use App\Models\persons;
use App\Models\sprints;
use App\Models\users;
use App\Models\sprintscauseslink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function getAllTasks(Request $request) {
        $user_id = $request->input('User_id');
        $role = users::where('id', $user_id)->first()->User_Role_id;
        if ($role > 1) {
            return tasks::join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
            ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
            ->join('sprints', 'sprints.Sprint_id', '=', 'tasks.Task_SprintId')
            ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname', 'sprints.Sprint_id', 'sprints.Sprint_Name')
            ->orderBy('Task_id', 'DESC')
            ->get()
            ->reverse();
        } else if ($role == 1) {
            return tasks::join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
            ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
            ->join('sprints', 'sprints.Sprint_id', '=', 'tasks.Task_SprintId')
            ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname', 'sprints.Sprint_id', 'sprints.Sprint_Name')
            ->where('sprints.Sprint_UserId', $user_id)
            ->orderBy('Task_id', 'DESC')
            ->get()
            ->reverse();
        }
    }


    public function getTasksByCategory(Request $request) {
        $user_id = $request->input('User_id');
        $role = users::where('id', $user_id)->first()->User_Role_id;
        $category = $request->input('category');
        if ($category === 0) {
            getAllTasks();
        } else if ($category === 1) {
            return tasks::join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
            ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
            ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname')
            ->whereNull('Task_Facttime')
            ->orderBy('Task_id', 'DESC')
            ->get()
            ->reverse();
        } else if ($category === 2) {
            //проблемные задачи
        } else if ($category === 3) {
            //Не проблемные задачи
        } else if ($category === 4) {
            if ($role > 1) {
                return tasks::join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
                ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
                ->join('sprints', 'tasks.Task_SprintId', '=', 'sprints.Sprint_id')
                ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname', 'sprints.Sprint_id', 'sprints.Sprint_Name')
                ->where('sprints.Sprint_isActual', 1)
                ->orderBy('Task_id', 'DESC')
                ->get()
                ->reverse();
            } else if ($role == 1) {
                return tasks::join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
                ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
                ->join('sprints', 'tasks.Task_SprintId', '=', 'sprints.Sprint_id')
                ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname', 'sprints.Sprint_id', 'sprints.Sprint_Name')
                ->where('sprints.Sprint_isActual', 1)
                ->where('sprints.Sprint_UserId', $user_id)
                ->orderBy('Task_id', 'DESC')
                ->get()
                ->reverse();
            }
        } else {
            return [
                "status" => false,
                "message" => 'Запрос построен неправильно'
            ];
        }

    }

    public function getTaskById($id) {
        $task = tasks::where('Task_id', $id)
            ->join('causes', 'tasks.Task_Failcause', '=', 'causes.Cause_id')
            ->join('persons', 'tasks.Task_Failperson', '=', 'persons.Person_id')
            ->join('sprints', 'sprints.Sprint_id', '=', 'tasks.Task_SprintId')
            ->select('tasks.*', 'causes.Cause_Name', 'persons.Person_Fullname', 'sprints.Sprint_Name')
            ->first();
        
        if ($task === null || !$task || $task === "") {
            return [
                "status" => false,
                "message" => "Task not found"
            ];
        } else {
            return $task;
        }
    }

    public function addTask(Request $request) {
        $Task_Number = $request->input('Task_Number'); //получение номера задачи
        $Task_Plantime = floatval($request->input("Task_Plantime")); //получение запланированного времени
        $Task_Facttime = floatval($request->input("Task_Facttime")); //получение фактических трудозатрат
        $Task_Failcause = $request->input("Task_Failcause");
        $Task_Failperson = $request->input("Task_Failperson");
        $Sprint_Name = $request->input("Task_SprintName");
        $isExist = tasks::where("Task_Number", $Task_Number)->count();

        if ($isExist >= 1) {
            return [
                "status" => false,
                "message" => 'Задача уже добавлена ранее'
            ];
        } else {
            if ($Task_Facttime == NULL || $Task_Facttime == "") {
                tasks::insert([
                    'Task_Number' => $Task_Number,
                    'Task_Plantime' => $Task_Plantime,
                    'Task_Failcause' => 101,
                    'Task_Failperson' => 101
                ]);
            } else if ($Task_Failcause == "" || $Task_Failcause == NULL) {
                if ($Task_Failperson !== "") {
                    $person = persons::where('Person_Fullname', 'like', $Task_Failperson)->first();
                    $person->Person_Failcount += 1;
                    $person->save();

                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;
                    
                    tasks::insert([
                        'Task_Number' => $Task_Number,
                        'Task_Plantime' => $Task_Plantime,
                        'Task_Facttime' => $Task_Facttime,
                        'Task_Failcause' => 101,
                        'Task_Failperson' => $personId
                    ]);
                } else {
                    tasks::insert([
                        'Task_Number' => $Task_Number,
                        'Task_Plantime' => $Task_Plantime,
                        'Task_Facttime' => $Task_Facttime,
                        'Task_Failcause' => 101,
                        'Task_Failperson' => 101
                    ]);
                }
            } else {
                $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;
                $person = persons::where('Person_Fullname', 'like', $Task_Failperson)->first();
                $person->Person_Failcount += 1;
                $person->save();

                $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;
                tasks::insert([
                    'Task_Number' => $Task_Number,
                    'Task_Plantime' => $Task_Plantime,
                    'Task_Facttime' => $Task_Facttime,
                    'Task_Failcause' => $causeId,
                    'Task_Failperson' => $personId
                ]);
                
                $cause = causes::where('Cause_id', $causeId)->first();
                $cause->Cause_Failcount += 1;
                $cause->save();

            }
            return [
                "status" => true,
                "message" => 'Задача успешно добавлена'
            ];
        }
    }

    public function addTaskV2 (Request $request) {
        $Task_Number = $request->input('Task_Number'); //получение номера задачи
        $Task_Plantime = floatval($request->input("Task_Plantime")); //получение запланированного времени
        $Sprint_Name = $request->input("Task_SprintName");
        if ($Task_Number === "" || $Task_Plantime === "" || $Sprint_Name === "") {
            return [
                "status" => false,
                "message" => 'Номер задачи, плановое время или спринт не указаны!'
            ];
        } else {
            $isExist = tasks::where("Task_Number", $Task_Number)->count();
            if ($isExist >= 1) {
                return [
                    "status" => false,
                    "message" => 'Задача уже добавлена ранее'
                ];
            } else {
                $sprintId = sprints::where('Sprint_Name', 'like', $Sprint_Name)->first()->Sprint_id;
                tasks::insert([
                    'Task_Number' => $Task_Number,
                    'Task_Plantime' => $Task_Plantime,
                    'Task_SprintId' => $sprintId,
                    'Task_Failcause' => 101,
                    'Task_Failperson' => 101
                ]);
                $NewTaskId = $this->getCreatedTaskId();

                $Task_Facttime = $request->input("Task_Facttime");
                $Task_Failcause = $request->input("Task_Failcause");
                $Task_Failperson = $request->input("Task_Failperson");

                if ($Task_Facttime !== NULL && $Task_Failcause !== NULL && $Task_Failperson !== NULL) {
                    $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;
                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;

                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Facttime = floatval($Task_Facttime);
                    $query->Task_Failcause = $causeId;
                    $query->Task_Failperson = $personId;
                    $query->save();

                    $cause = causes::where('Cause_id', $causeId)->first();
                    $cause->Cause_Failcount += 1;
                    $cause->save();
                    $person = persons::where('Person_id', $personId)->first();
                    $person->Person_Failcount += 1;
                    $person->save();

                    $sprintId = tasks::where('Task_id', $NewTaskId)->first()->Task_SprintId;
                    $linkIsExist = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->get()->count();
                    if ($causeId !== 101) {
                        if ($linkIsExist < 1) {
                            sprintscauseslink::insert([
                                'Sprint_id' => $sprintId,
                                'Cause_id' => $causeId,
                                'Cause_Failcount' => 1
                            ]);
                        } else {
                                $linkQuery = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->first();
                                $linkQuery->Cause_Failcount += 1;
                                $linkQuery->save();
                        }
                    }
                } else if ($Task_Facttime === NULL && $Task_Failcause !== NULL && $Task_Failperson !== NULL) {
                    $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;
                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;

                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Failcause = $causeId;
                    $query->Task_Failperson = $personId;
                    $query->save();

                    $cause = causes::where('Cause_id', $causeId)->first();
                    $cause->Cause_Failcount += 1;
                    $cause->save();
                    $person = persons::where('Person_id', $personId)->first();
                    $person->Person_Failcount += 1;
                    $person->save();

                    $sprintId = tasks::where('Task_id', $NewTaskId)->first()->Task_SprintId;
                    $linkIsExist = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->get()->count();
                    if ($causeId !== 101) {
                        if ($linkIsExist < 1) {
                            sprintscauseslink::insert([
                                'Sprint_id' => $sprintId,
                                'Cause_id' => $causeId,
                                'Cause_Failcount' => 1
                            ]);
                        } else {
                                $linkQuery = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->first();
                                $linkQuery->Cause_Failcount += 1;
                                $linkQuery->save();
                        }
                    }
                } else if ($Task_Facttime !== NULL && $Task_Failcause === NULL && $Task_Failperson !== NULL) {
                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;

                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Facttime = floatval($Task_Facttime);
                    $query->Task_Failperson = $personId;
                    $query->save();

                    $person = persons::where('Person_id', $personId)->first();
                    $person->Person_Failcount += 1;
                    $person->save();
                } else if ($Task_Facttime !== NULL && $Task_Failcause !== NULL && $Task_Failperson === NULL) {
                    $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;

                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Facttime = floatval($Task_Facttime);
                    $query->Task_Failcause = $causeId;
                    $query->save();

                    $cause = causes::where('Cause_id', $causeId)->first();
                    $cause->Cause_Failcount += 1;
                    $cause->save();

                    $sprintId = tasks::where('Task_id', $NewTaskId)->first()->Task_SprintId;
                    $linkIsExist = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->get()->count();
                    if ($causeId !== 101) {
                        if ($linkIsExist < 1) {
                            sprintscauseslink::insert([
                                'Sprint_id' => $sprintId,
                                'Cause_id' => $causeId,
                                'Cause_Failcount' => 1
                            ]);
                        } else {
                            $linkQuery = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->first();
                            $linkQuery->Cause_Failcount += 1;
                            $linkQuery->save();
                        }
                    }
                } else if ($Task_Facttime === NULL && $Task_Failcause === NULL && $Task_Failperson !== NULL) {
                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;
                    
                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Failperson = $personId;
                    $query->save();

                    $person = persons::where('Person_id', $personId)->first();
                    $person->Person_Failcount += 1;
                    $person->save();
                } else if ($Task_Facttime !== NULL && $Task_Failcause === NULL && $Task_Failperson === NULL) {
                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Facttime = floatval($Task_Facttime);
                    $query->save();
                } else if ($Task_Facttime === NULL && $Task_Failcause !== NULL && $Task_Failperson === NULL) {
                    $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;

                    $query = tasks::where("Task_id", $NewTaskId)->first();
                    $query->Task_Failcause = $causeId;
                    $query->save();

                    $cause = causes::where('Cause_id', $causeId)->first();
                    $cause->Cause_Failcount += 1;
                    $cause->save();

                    $sprintId = tasks::where('Task_id', $NewTaskId)->first()->Task_SprintId;
                    $linkIsExist = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->get()->count();
                    if ($causeId !== 101) {
                        if ($linkIsExist < 1) {
                            sprintscauseslink::insert([
                                'Sprint_id' => $sprintId,
                                'Cause_id' => $causeId,
                                'Cause_Failcount' => 1
                            ]);
                        } else {
                            $linkQuery = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->first();
                            $linkQuery->Cause_Failcount += 1;
                            $linkQuery->save();
                        }
                    }
                } else if ($Task_Facttime === NULL && $Task_Failcause === NULL && $Task_Failperson === NULL) {
                    //
                } else {
                    //
                }
                return [
                    "status" => true,
                    "message" => 'Задача успешно добавлена'
                ];
            }
        }
    }

    public function addTaskInfo(Request $request) {
        $method = $request->input('method');
        $Task_id = intval($request->input('Task_id'));
        switch ($method){
            case "Facttime":
                $Task_Facttime = floatval($request->input('Task_Facttime'));
                $query = tasks::where("Task_id", $Task_id)->first();
                if ($query === null) {
                    return [
                        "status" => false,
                        "message" => "Задачи не существует! Не удалось установить фактические трудозатраты!"
                    ];
                } else {
                    $query->Task_Facttime = $Task_Facttime;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => "Фактические трудозатраты добавлены!"
                    ];
                }
                break;
            case "Failcause":
                $Task_Failcause = $request->input('Task_Failcause');
                $query = tasks::where("Task_id", $Task_id)->first();
                if ($query === null) {
                    return [
                        "status" => false,
                        "message" => "Задачи не существует! Не удалось установить причину задержки!"
                    ];
                } else {
                    $causeId = causes::where('Cause_Name', 'like', $Task_Failcause)->first()->Cause_id;
                    $query->Task_Failcause = $causeId;
                    $query->save();
                    $cause = causes::where('Cause_id', $causeId)->first();
                    $cause->Cause_Failcount += 1;
                    $cause->save();

                    $sprintId = tasks::where('Task_id', $Task_id)->first()->Task_SprintId;
                    $linkIsExist = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->get()->count();
                    if ($causeId !== 101) {
                        if ($linkIsExist < 1) {
                            sprintscauseslink::insert([
                                'Sprint_id' => $sprintId,
                                'Cause_id' => $causeId,
                                'Cause_Failcount' => 1
                            ]);
                        } else {
                            $linkQuery = sprintscauseslink::where('Sprint_id', $sprintId)->where('Cause_id', $causeId)->first();
                            $linkQuery->Cause_Failcount += 1;
                            $linkQuery->save();
                        }
                    }

                    return [
                        "status" => true,
                        "message" => "Причина задержки установлена!"
                    ];
                }
                break;
            case "Failperson":
                $Task_Failperson = $request->input('Task_Failperson');
                $query = tasks::where("Task_id", $Task_id)->first();
                if ($query === null) {
                    return [
                        "status" => false,
                        "message" => "Задачи не существует! Не удалось установить виновного!"
                    ];
                } else {
                    $personId = persons::where('Person_Fullname', 'like', $Task_Failperson)->first()->Person_id;
                    $query->Task_Failperson = $personId;
                    $query->save();
                    
                    $person = persons::where('Person_id', $personId)->first();
                    $person->Person_Failcount += 1;
                    $person->save();

                    return [
                        "status" => true,
                        "message" => "Виновный установлен!"
                    ];
                }
                break;
        }
    }

    //получение id созданной задачи
    private function getCreatedTaskId() {
        return tasks::orderBy('Task_id', 'DESC')->first()->Task_id;
    }
}
