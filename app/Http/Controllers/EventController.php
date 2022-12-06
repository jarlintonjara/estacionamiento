<?php

namespace App\Http\Controllers;

use App\Mail\RequestParking;
use App\Models\EstacionamientoModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    function sendProgrammingLink(Request $request)
    {
        $user = User::find($request->user["id"]);
        $estacionamiento = EstacionamientoModel::find($request->programacion["estacionamiento_id"]);
        $propietario = User::where('parking_id', $request->programacion["estacionamiento_id"])->first();
        $event = new EventController();
        $fecha = Carbon::parse($request->programacion["fecha"]);
        $fecha = $fecha->format('d-m-Y');
        $link = $event->getLinkProgramming($user, $request->programacion);
        $page = new RequestParking($user["nombre"].' '.$user["apellido"], $estacionamiento["numero"], $propietario["nombre"], $link, $fecha);
        
        Mail::to($propietario["email"])
            ->send($page);
        return response()->json(["message" => "exitoso", "isSuccess" => true, 'link' => $link]);
    }
    
    public function getLinkProgramming($user, $programacion)
    {
        return URL::temporarySignedRoute(
            'event.programming',
            now()->addHours(8),
            ['user' => $user, 'programacion' => $programacion]
        );
    }
    
    public function getLinkPassword($user)
    {
        return URL::temporarySignedRoute(
            'event.resetPassword',
            now()->addMinutes(15),
            ['user' => $user]
        );
    }
}
