<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\Sede;
use App\Models\SettingModel;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\UsersSedes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    static  $roles = [
        'Admin',
        'Usuario',
        'Vigilante'
    ];

    static $sedes = [
        [
            'name' => 'MORRO',
            'email' => 'morro@gmail.com'
        ],
        [
            'name' => 'POLO',
            'email' => 'polo@gmail.com'
        ]
    ];

    public function run()
    {        
        // $users = User::all();
        
        // foreach($users as $user) {
        //     $user->password = Hash::make('12345678');
        //     $user->update();
        // }
        // return;
        
        foreach(self::$sedes as $sede) {
            $sede = Sede::create([
                'name' => $sede['name'],
                'email' => $sede['email']
            ]);

            SettingModel::insert([
                'sede_id' => $sede->id,
                'email' => $sede->email
            ]);
        }

        $curr_sede = Sede::where('name', 'MORRO')->first();

        $user =  User::create([
            'nombre' => 'Administrador',
            'apellido' => 'Admin',
            'cargo' => 'Administrador',
            'role_id' => 1,
            'sede_id' => $curr_sede->id,
            'curr_sede_id' => $curr_sede->id,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        UsersSedes::insert([
            'user_id' => $user->id,
            'sede_id' => $curr_sede->id,
        ]);

        foreach (self::$roles as $role) {
            RoleModel::insert([
                'nombre' => $role,
                'description' => $role,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
