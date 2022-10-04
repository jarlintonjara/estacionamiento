<?php

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
/* 
Route::get('test', function(){
    
    try {
        $correo = SettingModel::first();

        Storage::delete('schedule.xlsx');

        $s = new ScheduleExportController;
        $s->export();

        $email = new SchedulesForTomorrow;

        $correos = [];
        if ($correo->email1 != NULL OR $correo->email1 != '') {
            array_push($correos,$correo->email1);
        } 
        if ($correo->email2 != NULL OR $correo->email2 != '') {
            array_push($correos,$correo->email2);
        } 
        if ($correo->email3 != NULL OR $correo->email3 != '') {
            array_push($correos,$correo->email3);
        } 
        if ($correo->email4 != NULL OR $correo->email4 != '') {
            array_push($correos,$correo->email4);
        }    
        
        Mail::to($correo->email)
        ->cc($correos)
        ->send($email);

        return ["message" => "Correo enviado", "error" => ""];
        
    } catch (Exception $ex) {
        return ["message" => "Error en el envio", "error" => $ex->getMessage()];
    }
    
});
 */
Route::get('event/{user}/{estacionamiento}', [EventController::class, 'programming'])
    ->name('event.programming');

Route::get('event/link-programming/{user}/{estacionamiento}', [EventController::class, 'getLinkProgramming'])
    ->name('event.getLinkProgramming');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

 
