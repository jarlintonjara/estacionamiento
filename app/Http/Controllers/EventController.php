<?php

namespace App\Http\Controllers;

use App\Mail\RequestParking;
use App\Models\EstacionamientoModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    function sendProgrammingLink(Request $request)
    {
        $user = User::find($request->user["id"]);
        $estacionamiento = EstacionamientoModel::find($request->programacion["estacionamiento_id"]);
        $propietario = User::where('id', $estacionamiento["id_usuario"])->first();
        $event = new EventController();
       
        $link = $event->getLinkProgramming($user, $request->programacion);
        /* $page = new RequestParking($request->user["nombre"], $estacionamiento["numero"], $propietario["nombre"], $link);
        
        Mail::to($propietario["email"])
            ->send($page); */
        return $propietario;
        return response()->json(["message" => "exitoso", "isSuccess" => true, 'link' => $link, "email" => $propietario["email"] ]);
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
            now()->addHours(8),
            ['user' => $user]
        );
    }
}
