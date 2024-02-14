<?php

namespace App\Http\Controllers;

use App\Models\EstacionamientoModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sede;
use App\Models\UsersSedes;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::where('status', '=', 1)->orderBy('apellido', 'ASC')->get();
        $sedes = Sede::where('deleted_at', null)->get();

        foreach ($users as $user) {
            if ($user->parking_id) {
                $user["parking"] = $user->parking;
            } else {
                $user["parking"] = [
                    "numero" => "",
                    "sede" => ""
                ];
            }
            $user["role"] = $user->role;
            $user["sede"] = $user->sede;

            foreach ($user->multisedes as $multisede) {
                $multisede['name'] = $multisede->sede->name;
            }

            $user["multisedes"] = $user->multisedes;
        }

        $roles = RoleModel::where('status', 1)->get();
        $parkings = EstacionamientoModel::where('deleted_at', null)->get();
        
        return response()->json([
            "roles" => $roles,
            "sedes" => $sedes,
            "parkings" => $parkings,
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->post();


        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'documento' => $data['documento'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'parking_id' => $data['parking_id'],
            'cargo' => $data['cargo'],
            'area' => $data['area'],
            'sede_id' => $data['multisede'][0]['sede_id'],
            'password' => Hash::make($data['password']),
            'telefono' => $data['telefono'],
            'curr_sede_id' => $data['multisede'][0]['sede_id']
        ]);

        /* 
            --------------- Start --------------------
            Guardando las sedes del usuario, un usuario puede tener mas de 1 sede
        */

        foreach ($data['multisede'] as $multisede) {
            UsersSedes::create([
                'user_id' => $user->id,
                'sede_id' => $multisede['sede_id']
            ]);
        }

        /* ------------- End ---------------- */

        if ($user->parking_id) {
            $user["parking"] = $user->parking;
        } else {
            $user["parking"] = [
                "numero" => "",
                "sede" => ""
            ];
            $user["role"] = $user->role;
        }
        return response()->json($user);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function edit($user)
    {
        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $sedes = [];

        /*
            ---------------Start----------------
            Eliminar las sedes existentes a las que pertenece el usuario e ingresar los nuevos 
        */

        UsersSedes::where('user_id', $user->id)->delete();

        foreach($request->multisede as $sede) {
            array_push($sedes, UsersSedes::create([
                'user_id' => $user->id,
                'sede_id' => $sede['sede_id']
            ]));
        }

        /*
            ---------------End----------------
        */

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->documento = $request->documento;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->parking_id = $request->parking_id;
        $user->cargo = $request->cargo;
        $user->area = $request->area;
        $user->telefono = $request->telefono;
        $user->curr_sede_id = $sedes[0]['sede_id'];
        $user->update();

        if ($request->parking_id === 'Seleccione un estacionamiento') {
            $request['parking_id'] = 0;
        } else {
            $request['parking_id'] = $request->parking_id;
        }

        $data = User::all();
        return response()->json($data);
    }

    public function updateProfile(Request $request, $id)
    {
        // validar si la contraseña es vacia
        $data = $request->all();
        $user = User::findOrFail($id);
        if (empty($request->password)) {
            $data['password'] = $user->password;
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return response()->json([
            "message" => "Se guardo correctamente",
            "isSuccess" => True
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->status = 0;
        $user->update();

        return response()->json($user);
    }
}
