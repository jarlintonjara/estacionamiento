<?php

namespace App\Http\Controllers;
 
use App\Models\{Event, User, EstacionamientoModel, ProgramacionModel};
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    public function getLinkProgramming($user_id, $parking_id)
    {
        $user = User::find($user_id);
        $parking = EstacionamientoModel::find($parking_id);
        return URL::temporarySignedRoute(
            'event.programming',
            now()->addMinutes(1),
            ['user' => $user, 'estacionamiento' => $parking]
        );
    }

    public function programming(Request $request, User $user, EstacionamientoModel $parking)
    {
        if (!$request->hasValidSignature()) {
            return view('requestEmail', ['message' => 'Caduco el tiempo de solicitud', 'error' => true]);
        }

        date_default_timezone_set("America/Lima");
        $fecha = date('Y-m-d');
        
        $parking = EstacionamientoModel::find($request->estacionamiento);

        $payload["user_id"] = $user->id;
        $payload["estacionamiento_id"] = $parking->id;
        $payload["fecha"] = $fecha;
        $payload["hora_inicio"] = "07:00:00";
        $payload["hora_fin"] = "19:00:00";
        $payload["fecha"] = $fecha;
        $payload["created_by"] = 196;
        $payload["turno"] = "D";
        $payload["observacion"] = "Creado pòr solicitud";

        //Validacion por fecha y estacionamiento
        $register = ProgramacionModel::where("estacionamiento_id", $request->estacionamiento)
            ->whereDate("fecha", $payload["fecha"])
            ->first();

        if ($register) {
            if (($payload["turno"] == "M" || $payload["turno"] == "D") && $register->turno == "M") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación en la mañana', 'error' => true]);

            } else if (($payload["turno"] == "T" || $payload["turno"] == "D") && $register->turno == "T") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación en la tarde', 'error' => true]);
            
            } else if ($register->turno == "D") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación todo el día', 'error' => true]);
            }
        }

        //validacion por usuario y fecha
        $register2 = ProgramacionModel::where("user_id", $payload["user_id"])
        ->whereDate("fecha", $payload["fecha"])
            ->first();

        if ($register2) {
            if (($payload["turno"] == "M" || $payload["turno"] == "D") && $register2->turno == "M") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación en la mañana', 'error' => true]);

            } else if (($payload["turno"] == "T" || $payload["turno"] == "D") && $register2->turno == "T") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación en la tarde', 'error' => true]);

            } else if ($register2->turno == "D") {
                return view('requestEmail', ['message' => 'El usuario ya tiene una programación todo el día', 'error' => true]);
            }
        }

        ProgramacionModel::create($payload);
        return view('requestEmail', ['message' => 'Te has programado al estacionamiento ' . $parking->numero, 'error' => false]);
    }   
}
