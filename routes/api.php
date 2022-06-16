<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TasksController;
use App\Http\Controllers\Api\v1\LoginController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\BasketController;
use App\Http\Controllers\Api\v1\OrdersController;
use App\Http\Controllers\Api\v1\CausesController;
use App\Http\Controllers\Api\v1\PersonsController;
use App\Http\Controllers\Api\v1\SprintsController;
use App\Http\Controllers\Api\v1\SprintscauseslinkController;
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

Route::get('basket', [BasketController::class, 'getUserBasket'])->middleware('tokenValidation');
Route::post('basket/add', [BasketController::class, 'addToBasket'])->middleware('tokenValidation');
Route::post('basket/control', [BasketController::class, 'controlBasketItems'])->middleware('tokenValidation');
Route::get('basket/getOrderCost/{userid}', [OrdersController::class, 'getOrderSum']);

Route::get('orders', [OrdersController::class, 'getOrdersListByUserID'])->middleware('tokenValidation');
Route::get('orders/all', [OrdersController::class, 'getAllOrders']);
Route::get('orders/items', [OrdersController::class, 'getOrderByID']);
Route::post('orders/make', [OrdersController::class, 'makeOrder'])->middleware('tokenValidation');

Route::get('tasks', [TasksController::class, 'getAllTasks']);
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

Route::post('sprintCausesLink/bySprint', [SprintscauseslinkController::class, 'getTopFiveCausesBySprint']);