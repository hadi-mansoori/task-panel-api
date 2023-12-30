<?php

use App\Http\Controllers\Api\V1\TaskPanelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1/task')->middleware('auth:api')->group(function (){
    Route::post('/',[TaskPanelController::class,'store']);

});