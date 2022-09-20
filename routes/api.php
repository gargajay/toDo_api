<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToDoController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class,'me']);
    Route::get('/me', [ToDoController::class,'me']);

    Route::group(['prefix' => 'todo', 'as' => 'todo.'], function () {
        Route::post('add', [ToDoController::class,'add'])->name('add');
        Route::post('status-update', [ToDoController::class,'statusUpdate'])->name('status-update');
        Route::get('list', [ToDoController::class,'list'])->name('list');
        Route::post('delete', [ToDoController::class,'delete'])->name('delete');
         
      
    });


});


Route::post('/register',[AuthController::class,'register']);

Route::post('/login', [AuthController::class, 'login']);
