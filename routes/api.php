<?php

use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\to_do_list\ToDoListsController;
use App\Http\Controllers\to_do_list\ToDoPlansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'to_do_list', 'middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'lists'], function() {
        Route::post('/create', [ToDoListsController::class, 'create']);
        Route::delete('/delete/{list}', [ToDoListsController::class, 'delete']);
        Route::post('/change/{list}', [ToDoListsController::class, 'change']);
        Route::get('/get', [ToDoListsController::class, 'get']);
        Route::get('/sort', [ToDoListsController::class, 'sort']);
        Route::get('/filter', [ToDoListsController::class, 'filter']);
        Route::get('/get_plans/{list}', [ToDoListsController::class, 'plans']);
    });
    Route::group(['prefix' => 'plans'], function() {
        Route::post('/create/{list}', [ToDoPlansController::class, 'create']);
        Route::delete('/delete/{plan}', [ToDoPlansController::class, 'delete']);
        Route::post('/change/{plan}/{newList?}', [ToDoPlansController::class, 'change']);
        Route::post('mark-complete/{plan}', [ToDoPlansController::class, 'markComplete']);
    });
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/change', [UsersController::class, 'change']);
    });
});
