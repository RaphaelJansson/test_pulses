<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DimensionsController;
use App\Http\Controllers\QuestionsController;
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

Route::get('/dimensions', [DimensionsController::class, 'index']);
Route::get('/dimensions/{id}', [DimensionsController::class, 'show']);
Route::get('/questions', [QuestionsController::class, 'index']);
Route::get('/question/{id}', [QuestionsController::class, 'show']);
Route::post('/create_dimension', [DimensionsController::class, 'store']);
Route::post('/create_question', [QuestionsController::class, 'store']);
Route::put('/put_dimension/{id}', [DimensionsController::class, 'update']);
Route::put('/put_question/{id}', [QuestionsController::class, 'update']);
Route::delete('/delete_dimension/{id}', [DimensionsController::class, 'destroy']);
Route::delete('/delete_question/{id}', [QuestionsController::class, 'destroy']);