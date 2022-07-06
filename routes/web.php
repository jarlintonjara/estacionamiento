<?php

use App\Http\Controllers\EventController;
use App\Mail\SchedulesForTomorrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserExportController;
use App\Models\SettingModel;
use Illuminate\Support\Facades\DB;
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

Route::get( 'test', function(){
    /* $correo = SettingModel::first();

    // $texto = "Hola";
    // Storage::append("archivo.txt",$texto);
    Storage::delete('schedule.xlsx');

    $s = new ScheduleExportController;
    $s->export();

    $email = new SchedulesForTomorrow;

    $correos = [];
    if ($correo->email1 != NULL or $correo->email1 != '') {
        array_push($correos, $correo->email1);
    }
    if ($correo->email2 != NULL or $correo->email2 != '') {
        array_push($correos, $correo->email2);
    }
    if ($correo->email3 != NULL or $correo->email3 != '') {
        array_push($correos, $correo->email3);
    }
    if ($correo->email4 != NULL or $correo->email4 != '') {
        array_push($correos, $correo->email4);
    }

    Mail::to($correo->email)
        ->cc($correos)
        ->send($email);
    return "Mensaje enviado"; */
});

Route::get('event/{event}/{user}', 'EventController@subscribe')
    ->name('event.subscribe');

Route::get('event/link-subscribe', [EventController::class, 'getLinkSubscribe'])
    ->name('event.getLinkSubscribe');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

 
