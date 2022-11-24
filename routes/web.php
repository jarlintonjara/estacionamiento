<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ScheduleExportController;
use App\Mail\SchedulesForTomorrow;
use App\Models\ProgramacionModel;
use App\Models\SettingModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
 
Route::get('test', function(){
    $class = new AuthController();
    return $class->sendResetLinkEmail('fredy.acp25@gmail.com');
    
});
 
Route::get('event/{user}/{estacionamiento}', [EventController::class, 'programming'])
    ->name('event.programming');

Route::get('event/link-programming/{user}/{estacionamiento}', [EventController::class, 'getLinkProgramming'])
    ->name('event.getLinkProgramming');

Route::get('event/{user}', [AuthController::class, 'resetPassword'])
->name('event.resetPassword');

Route::get('event/link-programming/{user}', [EventController::class, 'getLinkPassword'])
    ->name('event.getLinkPassword');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');



 
