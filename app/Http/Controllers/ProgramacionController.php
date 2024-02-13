<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationParkingMail;
use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\User;
use App\Mail\ProgramacionMail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ProgramacionController extends Controller
{
    protected const DAYS = [
        '',
        'Lunes',
        'Martes',
        'Miercoles',
        'Jueves',
        'Viernes',
        'Sabado',
        'Domingo'
    ];

    protected const MONTHS = [
        '',
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Setiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $currUser = User::find($request->query('user_id'));
        $users = User::where('status', 1)->get();
        $parkings = EstacionamientoModel::where('deleted_at', null)->get();
        $schedules = ProgramacionModel::select('programacion.*')
            ->join('estacionamiento as e', 'programacion.estacionamiento_id', '=' , 'e.id')
            ->where('status',1)
            ->where('user_id', '=', $currUser->id)
            ->where('e.sede_id', '=', $currUser->curr_sede_id)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->fecha)->format('W');
            });

        //Programaciones de la semana actual
        $week = Carbon::now()->weekOfYear;
        $schedulesFilter = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)])? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [] ;

        $test = [];

        foreach ($schedulesFilter as $schedule) {
                $newDate = Carbon::parse($schedule->fecha);
                $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso]." ". $newDate->day." de ". self::MONTHS[$newDate->month];
                $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
                $schedule["user"] = $schedule->user;
                $schedule["parking"] = $schedule->parking;
                $schedule["sede"] = $schedule->parking->sede;
        }

        //Programaciones de la semana siguiente
        $week = Carbon::now()->weekOfYear + 1;
        $nextSchedules = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)]) ? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [];

        foreach ($nextSchedules as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
            $schedule["sede"] = $schedule->parking->sede;
        }

        return response()->json([
            "parkings" => $parkings,
            "users" => $users,
            "schedules" => $schedulesFilter,
            "nextSchedules" => $nextSchedules,
            "schedulesW" => $schedules,
            "test" => $test
        ]);
    }

    public function create()
    {
        //
    }
    public function validateSchedule($request)
    {
        $register = ProgramacionModel::where("user_id", $request->user_id)
            ->where('status',1)
            ->whereDate("fecha", $request->fecha)->first();
        if ($register) {
            switch ($register->turno) {
                case "D":
                    $message = "El usuario ya tiene una programación todo el día";
                    break;
                case "M":
                    $message = "El usuario ya tiene una programación en la mañana";
                    break;
                case "T":
                    $message = "El usuario ya tiene una programación en la tarde";
                    break;
                default:
                    $message = "El usuario ya tiene una programación";
            }
            return response()->json([
                "message" => $message,
                "isSuccess" => false
            ]);
        }
    }

    private function getQualify($type) {
        if($type == "M" || $type == "T") {
            return 0.5;
        } else if ($type == "D") {
            return 1;
        }
    }

    public function store(Request $request)
    {
        $start_date = Carbon::parse(date('Y-m-d', strtotime($request->fecha_inicio)));
        $end_date = Carbon::parse(date('Y-m-d', strtotime($request->fecha_fin)));

        $request['fecha'] = date('Y-m-d', strtotime($request->fecha));

        $period = new CarbonPeriod($start_date, '1 day', $end_date);

        /* 
            --------------------------------------------------
            Validacion de 1 reserva de estacionmiento por dia
            --------------------------------------------------
        */

        // Rango fecha semana actual
        $date = Carbon::parse($request->fecha_inicio);

        $start_curr_week = $date->startOfWeek()->toDateString();
        $end_curr_week = $date->endOfWeek()->toDateString();

        /* 
            -------------------------
            Validacion de las 3 reservas diarias por semana
            -------------------------
        */
        $schedules_week = ProgramacionModel::where('fecha', '>=', $start_curr_week)
        ->where('fecha', '<=', $end_curr_week)->where('user_id','=', $request->user_id)->where('status', '=' ,1)->get();

        $total_db_sum_week = 0;
        $total_curr_sum_week = 0;

        foreach($schedules_week as $sw) {
            $total_db_sum_week += $this->getQualify($sw->turno);
        }

        $total_curr_sum_week = $total_db_sum_week + $this->getQualify($request->turno);

        if($total_curr_sum_week > 3) {
            return response()->json([
                'isSuccess' => false,
                'message' => "Superaste las 3 en la semana",
                'total_schedules_week_db' => $total_db_sum_week,
                'schedules' => $schedules_week,
                'total_schedules_week_curr' => $total_curr_sum_week,
                'request' => $end_curr_week
            ]);
        }

        //Validacion por fecha y estacionamiento
        foreach ($period as $dt) {
            $newDate = $dt->format("Y-m-d");
            $day = "";

            $register = ProgramacionModel::where("estacionamiento_id", $request->estacionamiento_id)
            ->where('status',1)
            ->whereDate("fecha", $newDate)
            ->first();

            if($request->turno == "M") $day = "Mañana";
            else if ($request->turno == "T") $day = "Tarde";

            if ($register) {
                if (($request->turno == "M" || $request->turno == "D") && $register->turno == "M") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate . " en el turno "  . $day,
                        "isSuccess" => false
                    ]);
                } else if (($request->turno == "T" || $request->turno == "D") && $register->turno == "T") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate . " en el turno " . $day,
                        "isSuccess" => false
                    ]);
                } else if ($register->turno == "D") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate . " en el turno " . $day,
                        "isSuccess" => false
                    ]);
                }
            }
        }

        // return response()->json($request->all());

        //validacion por usuario y fecha
        foreach ($period as $dt) {
            $newDate = $dt->format("Y-m-d");

            $register2 = ProgramacionModel::where("user_id", $request->user_id)
            ->where('status',1)
            ->whereDate("fecha", $newDate)
            ->first();

            if ($register2) {
                if (($request->turno == "M" || $request->turno == "D") && $register2->turno == "M") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia ". $newDate,
                        "isSuccess" => false
                    ]);
                } else if (($request->turno == "T" || $request->turno == "D") && $register2->turno == "T") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia ". $newDate,
                        "isSuccess" => false
                    ]);
                } else if ($register2->turno == "D") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia ". $newDate,
                        "isSuccess" => false
                    ]);
                }
            }
        }

        //crear programación
        $payload = $request->except(['fecha_inicio', 'fecha_fin']);
        foreach ($period as $dt) {
            $payload["fecha"] = $dt->format("Y-m-d");
            $schedule = ProgramacionModel::create($payload);
        }
        $schedules = ProgramacionModel::select('*')
            ->where('status',1)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->fecha)->format('W');
            });
        //Programaciones de la semana actual
        $week = Carbon::now()->weekOfYear;
        $schedulesFilter = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)]) ? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [];

        foreach ($schedulesFilter as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }
        //Programaciones de la semana siguiente
        $week = Carbon::now()->weekOfYear + 1;
        $nextSchedules = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)]) ? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [];

        foreach ($nextSchedules as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }

        // Enviar correo
        $user = User::find($request->user_id);
        $this->sendEmail($user->email, $schedule);

        return response()->json([
            "isSuccess" => true,
            "schedules" => $schedulesFilter,
            "nextSchedules" => $nextSchedules
        ]);
    }

    public function update(Request $request, $id)
    {
        $register = ProgramacionModel::where("user_id", $request->user_id)
            ->where("id", "!=", $id)
            ->where('status',1)
            ->where("estacionamiento_id", $request->estacionamiento_id)
            ->whereDate("fecha", $request->fecha)->first();

        if ($register) {
            switch ($register->turno) {
                case "D":
                    $message = "Estacionamiento ocupado";
                    break;
                case "M":
                    $message = "Estacionamiento ocupado";
                    break;
                case "T":
                    $message = "Estacionamiento ocupado";
                    break;
                default:
                    $message = "Estacionamiento ocupado";
            }
            return response()->json([
                "message" => $message,
                "isSuccess" => false,
                "regis" => $register
            ]);
        }
        $updateSchedule = ProgramacionModel::findOrFail($id);
        $updateSchedule->update($request->all());
        $schedules = ProgramacionModel::select('*')
            ->where('status',1)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->fecha)->format('W');
            });
        //Programaciones de la semana actual
        $week = Carbon::now()->weekOfYear;
        $schedulesFilter = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)]) ? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [];

        foreach ($schedulesFilter as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }
        //Programaciones de la semana siguiente
        $week = Carbon::now()->weekOfYear + 1;
        $nextSchedules = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)]) ? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [];

        foreach ($nextSchedules as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso] . " " . $newDate->day . " de " . self::MONTHS[$newDate->month];
            $schedule["user"] = $schedule->user;
            $schedule["parking"] = $schedule->parking;
        }
        return response()->json([
            "isSuccess" => true,
            "schedules" => $schedulesFilter,
            "nextSchedules" => $nextSchedules
        ]);
    }

    public function destroy($id)
    {
        $estacionamiento = ProgramacionModel::findOrFail($id);
        $estacionamiento->status = 0;
        $estacionamiento->save();
        // $estacionamiento->delete();
        return response()->json($estacionamiento);
    }

    public function programming(Request $request, User $user)
    {
        if (!$request->hasValidSignature()) {
            return view('requestEmail', ['message' => 'Caduco el tiempo de solicitud', 'error' => true]);
        }

        date_default_timezone_set("America/Lima");
        $fecha = Carbon::parse($request->programacion["fecha"]);
        $parking = EstacionamientoModel::findOrFail($request->programacion["estacionamiento_id"]);
        $payload["user_id"] = $user->id;
        $payload["estacionamiento_id"] = $parking->id;
        $payload["fecha"] = $fecha->format('Y-m-d');
        $payload["hora_inicio"] = $request->programacion["hora_inicio"];
        $payload["hora_fin"] = $request->programacion["hora_fin"];
        $payload["created_by"] = 196;
        $payload["turno"] = $request->programacion["turno"];
        $payload["observacion"] = "Creado pòr solicitud";

        //Validacion por fecha y estacionamiento
        $register = ProgramacionModel::where("estacionamiento_id", $request->estacionamiento)
            ->where('status',1)
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
        ->where('status',1)
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
        $page = new ConfirmationParkingMail($user["nombre"], $parking["numero"]);
        Mail::to($user["email"])
            ->send($page);
        return view('requestEmail', ['message' => 'Se confirmo el estacionamiento numero '.$parking["numero"].' para el dia '.$fecha->format('d/m/Y').' de '.$payload["hora_inicio"].' a '.$payload["hora_fin"], 'error' => false]);
    }

    public function getSedesByUser(Request $request) {
        $userId = $request->user_id;
        $user = User::find($userId);
        $user['multisedes'] = $user->multisedes;
    
        foreach($user->multisedes as $multisede) {
            $multisede['sede_name'] = $multisede->sede->name;
        }
    
        return response()->json([
            'request' => $request->all(),
            'user' => $user
        ]);
    }

    public function getParkingByDate(Request $request) {
        $sedeId = $request->sede_id;
        $date = date('Y-m-d', strtotime($request->fecha));

        $available_parkings = [];

        $available_parkings = DB::table('estacionamiento')
            ->select('estacionamiento.numero', 'estacionamiento.id', 'estacionamiento.sede_id')
            ->where('estacionamiento.sede_id', $sedeId)
            ->whereNotIn('estacionamiento.id', function($query) use ($date) {
                $query->select('programacion.estacionamiento_id')
                    ->from('programacion')
                    ->join('estacionamiento', 'programacion.estacionamiento_id', '=', 'estacionamiento.id')
                    ->where('programacion.fecha', $date)
                    ->where('programacion.turno', '=', 'D');
            })
        ->get();

        return response()->json([
            'sede_id' => $sedeId,
            'cantidad' => count($available_parkings),
            'date' => $date,
            'schedules' => [],
            'available_parkings' => $available_parkings
        ]);
    }

    public function sendEmail($email, $data) {        
        $settings = [
            'subject' => "Inchcape",
            'programacion' => $data
        ];

        // Mail::to($email)->send(new ProgramacionMail($settings));
    }

    public function getTurnosParking(Request $request) {
        $date = date('Y-m-d', strtotime($request->fecha));
        $sedeId = $request->sede_id;
        $parkingId = $request->estacionamiento_id;

        $curr_parking = DB::table('programacion as p')
        ->join('estacionamiento', 'estacionamiento.id', '=', 'p.estacionamiento_id')
        ->where('p.fecha', '=', $date)
        ->where('estacionamiento.sede_id', '=', $sedeId)
        ->where('estacionamiento.id', '=', $parkingId)
        ->first();

        return response()->json([
            'result' => $curr_parking
        ]);
    } 
}
