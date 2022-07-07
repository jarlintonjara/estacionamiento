<?php

namespace App\Http\Controllers;

use App\Mail\RequestParking;
use App\Mail\SchedulesForTomorrow;
use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $schedules = ProgramacionModel::all();
        $users = User::all()->count();
        $parkings = EstacionamientoModel::all()->count();

        date_default_timezone_set("America/Lima");
        $fecha = date('Y-m-d');
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        $nuevafechad = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechad = date ( 'Y-m-d' , $nuevafechad );

        $programacionManana = ProgramacionModel::whereDate("fecha",$nuevafecha)->get()->count();
        $programacionma = ProgramacionModel::whereDate("fecha",$nuevafecha)->get();
        $programacionhoy = ProgramacionModel::whereDate("fecha",$fecha)->get();
        $ids2= [];
        foreach ($programacionhoy as $pml) {
            array_push($ids2,$pml->estacionamiento_id);
            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
            $pml["propietario"] = $pml->propietario;
        }
        $estacioneshoy = User::select(
                            'users.id as user_id',
                            'estacionamiento.id',
                            'estacionamiento.numero',
                            'users.nombre',
                            'users.apellido',
                            'users.telefono',
                            'users.email',
                            'estacionamiento.sede',
                            'estacionamiento.ubicacion')
                ->rightJoin('estacionamiento', 'users.parking_id', '=', 'estacionamiento.id')
                ->whereNotIn('estacionamiento.id', $ids2)
                ->get();

        $ids = [];
        foreach ($programacionma as $pml) {
            array_push($ids,$pml->id);
            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
            $pml["propietario"] = $pml->propietario;
        }
        $event = new EventController();
        foreach ($estacioneshoy as $row) {
            $row["link"] = $event->getLinkProgramming(143, $row["id"]);
        }
        $estacionesma = User::select(
                            'estacionamiento.id',
                            'estacionamiento.numero',
                            'users.nombre',
                            'users.apellido',
                            'users.telefono',
                            'users.email',
                            'estacionamiento.sede',
                            'estacionamiento.ubicacion')
        ->rightJoin('estacionamiento', 'users.parking_id', '=', 'estacionamiento.id')
        ->whereNotIn('estacionamiento.id', $ids)
        ->get();

        foreach ($schedules as $schedule) {
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }

        foreach ($schedules as $schedule) {
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }

        return response()->json([
            "parkingsTotal" => $parkings,
            "usersTotal" => $users,
            "schedulesTotal" => count($schedules),
            "schedules" => $schedules,
            "programacionManana" => $programacionManana,
            
            "programacionma" => $programacionma,
            "estacionesma" => $estacionesma,
            "programacionhoy" => $programacionhoy,
            "estacioneshoy" => $estacioneshoy
        ]);
    }

    function sendEmail(Request $request){

        $page = new RequestParking($request->name, $request->link);

        Mail::to("fredy.acp25@gmail.com")
            ->send($page);

        /* Mail::send('mail.schedulesTomorrow', [], function ($message) {
            $message->to($email)->subject('Prueba !');
        });  */
        return response()->json(["message" => "exitoso"]);
    }
}
