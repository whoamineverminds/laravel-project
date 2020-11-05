<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListsController;
use App\Http\Controllers\PlansController;

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

Route::post('/CreateList', [ListsController::class, 'createList']);
Route::delete('/DeleteList/{list}', [ListsController::class, 'deleteList']);
Route::post('/ChangeList/{list}', [ListsController::class, 'changeList']);
Route::get('/SortLists', [ListsController::class, 'sortLists']);
Route::get('/FilterLists', [ListsController::class, 'filterLists']);
Route::get('/GetLists', [ListsController::class, 'getLists']);
Route::get('/GetPlans/{list}', [ListsController::class, 'getPlans']);

Route::post('/CreatePlan/{list}', [PlansController::class, 'createPlan']);
Route::delete('/DeletePlan/{plan}', [PlansController::class, 'deletePlan']);
Route::post('/ChangePlan/{plan}/{newList?}', [PlansController::class, 'changePlan']);
Route::post('MarkPlanComplete/{plan}', [PlansController::class, 'markPlanComplete']);
