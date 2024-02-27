<?php

namespace App\Http\Controllers;

use App\Mail\RequestParking;
use App\Mail\SchedulesForTomorrow;
use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\SettingModel;
use App\Models\User;
use App\Models\Sede;
use Exception;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    private function getSchedulesToday($sedeId = null, $fecha) {
        $programacion = ProgramacionModel::select(
            'programacion.*',
            'e.sede_id'
        )
        ->join('estacionamiento as e', 'e.id', '=', 'programacion.estacionamiento_id')
        ->join('sedes as s', 's.id', '=', 'e.sede_id')
        ->where('s.id', '=', $sedeId)
        ->where('programacion.status', '=', 1)
        // ->where('estacionamiento.deleted_at', null)
        ->whereDate('programacion.fecha', '=', $fecha)
        ->get();

        $ids2= [];

        foreach ($programacion as $pml) {
            array_push($ids2,$pml->estacionamiento_id);
            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
            $pml["sede"] = $pml->parking->sede;
        }

        $estaciones = EstacionamientoModel::select(
            'estacionamiento.id',
            'estacionamiento.numero',
            's.id as sede_id',
            's.email as sede_email',
            's.name as sede_name'
        )
        ->join('sedes as s', 's.id', '=', 'estacionamiento.sede_id')
        ->where('s.id', '=', $sedeId)
        ->where('estacionamiento.deleted_at', null)
        ->whereNotIn('estacionamiento.id', $ids2)
        ->get();

        return (Object)[
            'estaciones' => $estaciones,
            'programacion' => $programacion
        ];
    }

    public function index(Request $request)
    {
        try {
            $user_session_id = $request->query('user_id');
            $curr_user = User::find($user_session_id);

            $q_sedeId = $request->query('sede_id');
            $schedules = DB::table('programacion as p')
            ->select('p.*', 's.name', 's.id as sedeId')
            ->join('estacionamiento as e', 'p.estacionamiento_id', '=', 'e.id')
            ->join('sedes as s', 'e.sede_id', '=', 's.id')
            ->where('s.id', '=', $q_sedeId)
            ->where('p.deleted_at', null)
            ->get();

            /* 
            ------------------
            DATA ADD 
            ------------------
            */
            date_default_timezone_set("America/Lima");
            $fecha = date('Y-m-d');
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
            $nuevafechad = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $nuevafechad = date ( 'Y-m-d' , $nuevafechad );
    
            $programacionManana = ProgramacionModel::where('status',1)->whereDate("fecha",$nuevafecha)->get()->count();
            

            if($curr_user->role_id ==  1) {
                if($request->query('filters')) {
                    $users = User::where('sede_id', $q_sedeId)->count();
                    $parkings = EstacionamientoModel::where('deleted_at', null)->where('sede_id', $q_sedeId)->get();
                    
                    /* Programaciones Hoy */
                    $schedulesToday = $this->getSchedulesToday($q_sedeId, $fecha);
                    
                    /* Programaciones para Mañana  */
                    $schedulesTomorrow = $this->getSchedulesToday($q_sedeId, $nuevafecha);                        
                } else {
                    $users = User::all()->count();
                    $parkings = EstacionamientoModel::where('deleted_at', null)->get();
                }

                $sedes = Sede::where('deleted_at', null)->get();
                
                return response()->json([
                    'sedes' => $sedes,
                    'total_users' => $users,
                    'total_parkings' => $parkings->count(),
                    'total_schedules' => $schedules->count(),
                    'schedules' => $schedules,

                    'programacionManana' => $programacionManana,
                    'programacionma' => $schedulesTomorrow->programacion,
                    'estacionesma' => $schedulesTomorrow->estaciones,
                    'programacionhoy' => $schedulesToday->programacion,
                    'estacioneshoy' => $schedulesToday->estaciones,
                    'test' => []
                ]);
            } else if($curr_user->role_id === 2 || $curr_user->role_id === 3) {
                $users = User::where('sede_id', $curr_user->sede_id)->get()->count();
                $parkings = EstacionamientoModel::where('deleted_at', null)->where('sede_id', $q_sedeId)->get();

                /* Programaciones Hoy */
                $schedulesToday = $this->getSchedulesToday($q_sedeId, $fecha);

                /* Programaciones para Mañana  */
                $schedulesTomorrow = $this->getSchedulesToday($q_sedeId, $nuevafecha);

                return response()->json([
                    'sedes' => [],
                    'total_users' => 0,
                    'total_parkings' => $parkings->count(),
                    'total_schedules' => $schedules->count(),
                    'schedules' => $schedules,

                    'programacionManana' => $programacionManana,
                    'programacionma' => $schedulesTomorrow->programacion,
                    'estacionesma' => $schedulesTomorrow->estaciones,
                    'programacionhoy' => $schedulesToday->programacion,
                    'estacioneshoy' => $schedulesToday->estaciones,
                    'test' => $schedulesTomorrow
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => $th->getMessage()
            ]);
        }
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

    public function changeSede(Request $request) {
        $sedeId = $request->curr_sede_id;
        $userId = $request->user;

        $userFound = User::find($userId);

        $userFound->curr_sede_id = $sedeId;
        $userFound->save();

        return response()->json($userFound);
    }
}
