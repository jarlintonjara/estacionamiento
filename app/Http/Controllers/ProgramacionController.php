<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationParkingMail;
use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    public function index()
    {
        $users = User::all();
        $parkings = EstacionamientoModel::all();
        $schedules = ProgramacionModel::select('*')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->fecha)->format('W');
            });

        //Programaciones de la semana actual
        $week = Carbon::now()->weekOfYear;
        $schedulesFilter = isset($schedules[str_pad($week,2,"0",STR_PAD_LEFT)])? $schedules[str_pad($week,2,"0",STR_PAD_LEFT)] : [] ;


        foreach ($schedulesFilter as $schedule) {
            $newDate = Carbon::parse($schedule->fecha);
            $schedule["dia"] = self::DAYS[$newDate->dayOfWeekIso]." ". $newDate->day." de ". self::MONTHS[$newDate->month];
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
            "parkings" => $parkings,
            "users" => $users,
            "schedules" => $schedulesFilter,
            "nextSchedules" => $nextSchedules,
            "schedulesW" => $schedules
        ]);
    }

    public function create()
    {
        //
    }
    public function validateSchedule($request)
    {
        $register = ProgramacionModel::where("user_id", $request->user_id)
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
    public function store(Request $request)
    {
        $start_date = Carbon::parse($request->fecha_inicio);
        $end_date = Carbon::parse($request->fecha_fin);

        $period = new CarbonPeriod($start_date, '1 day', $end_date);

        //Validacion por fecha y estacionamiento
        foreach ($period as $dt) {
            $newDate = $dt->format("Y-m-d");

            $register = ProgramacionModel::where("estacionamiento_id", $request->estacionamiento_id)
            ->whereDate("fecha", $newDate)
            ->first();
            if ($register) {
                if (($request->turno == "M" || $request->turno == "D") && $register->turno == "M") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate,
                        "isSuccess" => false
                    ]);
                } else if (($request->turno == "T" || $request->turno == "D") && $register->turno == "T") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate,
                        "isSuccess" => false
                    ]);
                } else if ($register->turno == "D") {
                    return response()->json([
                        "message" => "Estacionamiento ocupado el dia " . $newDate,
                        "isSuccess" => false
                    ]);
                }
            }
        }

        //validacion por usuario y fecha
        foreach ($period as $dt) {
            $newDate = $dt->format("Y-m-d");

            $register2 = ProgramacionModel::where("user_id", $request->user_id)
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

    public function update(Request $request, $id)
    {
        $register = ProgramacionModel::where("user_id", $request->user_id)
            ->where("id", "!=", $id)
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
        $estacionamiento->delete();
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
        $page = new ConfirmationParkingMail($user["nombre"], $parking["numero"]);
        Mail::to($user["email"])
            ->send($page);
        return view('requestEmail', ['message' => 'Se confirmo el estacionamiento numero '.$parking["numero"].' para el dia '.$fecha->format('d/m/Y').' de '.$payload["hora_inicio"].' a '.$payload["hora_fin"], 'error' => false]);
    }
}
