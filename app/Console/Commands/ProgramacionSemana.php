<?php

namespace App\Console\Commands;
use App\Models\SettingModel;
use \Illuminate\Support\Facades\Mail;
use App\Mail\SchedulesForTomorrow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ScheduleExportController;
use App\Models\ProgramacionModel;
use App\Models\User;
use Carbon\Carbon;

class ProgramacionSemana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:programacionSemana';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar la programación de la semana siguiente para los propietarios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $martes = new Carbon('next tuesday');
        $miercoles = new Carbon('next wednesday');
        $jueves = new Carbon('next thursday');
        $rows = User::where('propietario', 1)->get();

        foreach ($rows as $row) {
            ProgramacionModel::create([
                'user_id' => $row->id,
                'estacionamiento_id' => $row->parking_id,
                'created_by' => 196,
                'hora_inicio' => '07:00:00',
                'hora_fin' => '19:00:00',
                'fecha' => $martes->format('Y-m-d'),
                'turno' => 'D',
                'observacion' => 'CREACIÓN AUTOMATICA',
                'created_at' => $date,
                'updated_at' => $date
            ]);
            ProgramacionModel::create([
                'user_id' => $row->id,
                'estacionamiento_id' => $row->parking_id,
                'created_by' => 196,
                'hora_inicio' => '07:00:00',
                'hora_fin' => '19:00:00',
                'fecha' => $miercoles->format('Y-m-d'),
                'turno' => 'D',
                'observacion' => 'CREACIÓN AUTOMATICA',
                'created_at' => $date,
                'updated_at' => $date
            ]);
            ProgramacionModel::create([
                'user_id' => $row->id,
                'estacionamiento_id' => $row->parking_id,
                'created_by' => 196,
                'hora_inicio' => '07:00:00',
                'hora_fin' => '19:00:00',
                'fecha' => $jueves->format('Y-m-d'),
                'turno' => 'D',
                'observacion' => 'CREACIÓN AUTOMATICA',
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
        return "Ejecutado";
    }
}
