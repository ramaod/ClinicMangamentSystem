<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Database\Seeders\RolesTableSeeder;
use App\Http\controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ServicController;


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


Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/index',[UserController::class,'index']);
Route::group(['middleware'=>['auth:sanctum']],
    function (){
        Route::get('/logout',[UserController::class,'logout']);
    });

Route::get('/show',[DoctorController::class,'show']);
Route::post('/add',[DoctorController::class,'store']);
Route::post('/update/{id}',[DoctorController::class,'update']);
Route::delete('/delete/{id}',[DoctorController::class,'destroy']);



Route::get('/view',[ServicController::class,'view']);
Route::post('/create',[ServicController::class,'create']);
Route::post('/change/{id}',[ServicController::class,'update']);
Route::delete('/destroy/{id}',[ServicController::class,'destroy']);
