<?php

namespace App\Http\Controllers;

use App\Models\EstacionamientoModel;
use App\Models\ProgramacionModel;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $programacionMananalist = ProgramacionModel::whereDate("fecha",$nuevafecha)->get();
        $listadohoy = ProgramacionModel::whereDate("fecha",$fecha)->get();
        $ids2= [];
        foreach ($listadohoy as $pml) {
             
            array_push($ids2,$pml->id);

            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
        }
        $estacioneslibreshoy = EstacionamientoModel::whereNotIn('id', $ids2)->get();
        
        $ids = [];
        foreach ($programacionMananalist as $pml) {
             
            array_push($ids,$pml->id);

            $pml["user"] = $pml->user;
            $pml["parking"] = $pml->parking;
        }

        $estacioneslibres = EstacionamientoModel::whereNotIn('id', $ids)->get();

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
            "programacionMananalist" => $programacionMananalist,
            "estacioneslibres" => $estacioneslibres,
            "listadohoy" => $listadohoy,
            "estacioneslibreshoy" => $estacioneslibreshoy
        ]);
    }
}
