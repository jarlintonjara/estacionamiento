<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProgramacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
//confirmacion de reserva
Route::get('event/{user}', [ProgramacionController::class, 'programming'])
    ->name('event.programming');
    
Route::get('event/link-programming/{user}', [EventController::class, 'getLinkProgramming'])
->name('event.getLinkProgramming');

//recuperación de contraseña
Route::get('reset-password/{user}', [AuthController::class, 'resetPassword'])
->name('event.resetPassword');

Route::get('event/link-programming/{user}', [EventController::class, 'getLinkPassword'])
    ->name('event.getLinkPassword'); 

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');



 
