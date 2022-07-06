<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TasksController;
use App\Http\Controllers\Api\v1\LoginController;
use App\Http\Controllers\Api\v1\CausesController;
use App\Http\Controllers\Api\v1\PersonsController;
use App\Http\Controllers\Api\v1\SprintsController;
use App\Http\Controllers\Api\v1\SprintscauseslinkController;
use App\Http\Controllers\Api\v1\JiraController;
use App\Http\Controllers\Api\v1\PostsController;
use App\Http\Kernel;
use App\Http\Middleware\TokenValidation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users', [LoginController::class, 'getAllUsers']);
Route::post('login', [LoginController::class, 'loginAuth']);

Route::post('tasks', [TasksController::class, 'getAllTasks']);
Route::post('tasks/byCat', [TasksController::class, 'getTasksByCategory']);
Route::get('tasks/{id}', [TasksController::class, 'getTaskById']);
Route::post('tasks/add', [TasksController::class, 'addTaskV2']);
Route::post('tasks/edit', [TasksController::class, 'addTaskInfo']);

Route::get('causes', [CausesController::class, 'getAllCauses']);
Route::get('causes/{id}', [CausesController::class, 'getCauseById']);
Route::get('causes/top/topFiveFailCauses', [CausesController::class, 'getTopFiveFailCauses']);

Route::get('persons', [PersonsController::class, 'getAllPersons']);
Route::get('persons/{id}', [PersonsController::class, 'getPersonById']);
Route::post('persons/add', [PersonsController::class, 'addPerson']);
Route::post('person/edit', [PersonsController::class, 'editPerson']);
Route::get('persons/top/topFiveFailPersons', [PersonsController::class, 'getTopFiveFailPersons']);

Route::post('sprints', [SprintsController::class, 'getSprints']);
Route::post('sprints/add', [SprintsController::class, 'addSprint']);
Route::post('sprint/info', [SprintsController::class, 'getSprintStats']);
Route::post('sprints/changeActual', [SprintsController::class, 'changeActualSprint']);

Route::post('sprintCausesLink/bySprint', [SprintscauseslinkController::class, 'getTopFiveCausesBySprint']);

Route::post('jiraIssueInfo', [JiraController::class, 'getIssueInfo']);

Route::get('posts', [PostsController::class, 'getAllPosts']);
Route::post('postById', [PostsController::class, 'getPostById']);
