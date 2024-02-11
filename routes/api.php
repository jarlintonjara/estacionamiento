<?php

use App\Http\Controllers\EstacionamientoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\SettingController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');
Route::post('resetSimplePassword', [AuthController::class, 'resetPass']);
Route::get('sendResetLinkEmail/{email}', [AuthController::class, 'sendResetLinkEmail']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('getSession/{token}', [AuthController::class, 'getSession']);

//Route::resource('estacionamiento', EstacionamientoController::class)->only(['index']);
Route::get('dashboard', [HomeController::class, 'index']);
Route::post('change-sede', [HomeController::class, 'changeSede']);
Route::post('sendProgrammingLink', [EventController::class, 'sendProgrammingLink']);
Route::post('emailProgramacionSemanal', [HomeController::class, 'emailProgramacionSemanal']);
Route::resource('programacion', ProgramacionController::class);
Route::resource('estacionamiento', EstacionamientoController::class);
Route::resource('setting', SettingController::class);
Route::resource('usuario', UserController::class);
Route::match(['put', 'patch'], 'updateProfile/{usuario}', [UserController::class, 'updateProfile']);
Route::resource('rol', RoleController::class);
Route::resource('sede', SedeController::class);
