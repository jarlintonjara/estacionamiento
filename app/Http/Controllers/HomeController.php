<?php

namespace App\Http\Controllers;

use App\Mail\RequestParking;
use App\Mail\SchedulesForTomorrow;
use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\SettingModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $schedules = ProgramacionModel::where('status',1)->get();
        $users = User::all()->count();
        $parkings = EstacionamientoModel::where('status',1)->get()->count();

        date_default_timezone_set("America/Lima");
        $fecha = date('Y-m-d');
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        $nuevafechad = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechad = date ( 'Y-m-d' , $nuevafechad );

        $programacionManana = ProgramacionModel::where('status',1)->whereDate("fecha",$nuevafecha)->get()->count();
        $programacionma = ProgramacionModel::where('status',1)->whereDate("fecha",$nuevafecha)->get();
        $programacionhoy = ProgramacionModel::where('status',1)->whereDate("fecha",$fecha)->get();
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
            array_push($ids,$pml->estacionamiento_id);
            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
            $pml["propietario"] = $pml->propietario;
        }

        $estacionesma = User::select(
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



    function emailProgramacionSemanal(Request $request)
    {
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

            return ["success" => true, "message" => "Correo enviado", "error" => ""];

        } catch (Exception $ex) {
            return ["success" => false, "message" => "Error en el envio", "error" => $ex->getMessage()];
        }
    }
}
