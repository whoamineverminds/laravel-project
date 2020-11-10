<?php

use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Exceptions\CatchExceptionsController;
use App\Http\Controllers\to_do_list\ToDoListsController;
use App\Http\Controllers\to_do_list\ToDoPlansController;
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

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/user', [UsersController::class, 'get']);
        Route::post('/change', [UsersController::class, 'change']);
        Route::group(['prefix' => 'verify'], function() {
            Route::post('/{id}/{hash}', [UsersController::class, 'verify'])
                ->name('verification.verify');
            Route::post('/resend', [UsersController::class, 'verifyReSend']);
        });
    });
});

Route::group(['prefix' => 'to_do_list', 'middleware' => ['auth:sanctum', 'verified']], function() {
    Route::group(['prefix' => 'lists'], function() {
        Route::post('/create', [ToDoListsController::class, 'create']);
        Route::delete('/delete/{list}', [ToDoListsController::class, 'delete']);
        Route::post('/change/{list}', [ToDoListsController::class, 'change']);
        Route::get('/get', [ToDoListsController::class, 'get']);
        Route::get('/sort', [ToDoListsController::class, 'sort']);
        Route::get('/filter', [ToDoListsController::class, 'filter']);
    });
    Route::group(['prefix' => 'plans'], function() {
        Route::post('/create/{list}', [ToDoPlansController::class, 'create']);
        Route::delete('/delete/{plan}', [ToDoPlansController::class, 'delete']);
        Route::post('/change/{plan}/{newList?}', [ToDoPlansController::class, 'change']);
        Route::get('/get/{list}', [ToDoPlansController::class, 'get']);
        Route::post('/mark-complete/{plan}', [ToDoPlansController::class, 'markComplete']);
    });
});

Route::group(['prefix' => 'exceptions'], function() {
    Route::get('/UserIsNotAuthorized', [CatchExceptionsController::class, 'catchException'])
        ->name('login');
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/EmailIsNotVerificated', [CatchExceptionsController::class, 'catchException'])
            ->name('verification.notice');
    });
});
