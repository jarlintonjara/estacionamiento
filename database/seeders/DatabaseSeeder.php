<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

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
        'Propietario'
    ];

    public function run()
    {
        $sedes = [
            [
                'name' => 'MORRO',
                'email' => 'morro@gmail.com'
            ],
            [
                'name' => 'OILLO',
                'email' => 'oillo@gmail.com'
            ]
        ];

        foreach($sedes as $sede) {
            \App\Models\Sede::insert([
                'name' => $sede['name'],
                'email' => $sede['email']
            ]);
        }

        \App\Models\User::insert([
            'nombre' => 'Fredy',
            'apellido' => 'Cumpa',
            'cargo' => 'Gerente',
            'role_id' => 1,
            'sede_id' => \App\Models\Sede::where('name', 'MORRO')->first()->id,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'created_at' => date('Y-m-d H:i:s')
            ]);

        foreach (self::$roles as $role) {
            \App\Models\RoleModel::insert([
                'nombre' => $role,
                'description' => $role,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
