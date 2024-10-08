<?php

use App\Http\Controllers\NotasController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [PassportAuthController::class, 'logout']);



});

Route::get('/notas', [NotasController::class, 'index']); 
Route::get('/notas/{id}', [NotasController::class, 'show']); 
Route::post('/notas', [NotasController::class, 'store']); 
Route::put('/notas/{id}', [NotasController::class, 'update']); 
Route::delete('/notas/{id}', [NotasController::class, 'destroy']); 

Route::get('/notas', [NotasController::class, 'index']); 
Route::get('usuarios', [UserController::class, 'index']);