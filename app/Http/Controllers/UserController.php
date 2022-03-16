<?php

namespace App\Http\Controllers;

use App\Models\EstacionamientoModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use App\Models\User;
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
        $users = User::where('status', 1)->orderBy('apellido', 'ASC')->get();
        foreach ($users as $user) {
            if($user->parking_id){
                $user["parking"] = $user->parking;
            }else{
                $user["parking"] = [
                    "numero" => "",
                    "sede" => ""
                ];
            }
            $user["role"] = $user->role;
        } 
        $roles = RoleModel::where('status', 1)->get();
        $parkings = EstacionamientoModel::where('status', 1)->get();
        return response()->json([
            "roles" => $roles,
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
        if(!array_key_exists('password', $data)){
            $data['password'] = Hash::make(12345678);
        }
        $user = User::create($data);
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

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $data = User::all();
        return response()->json($data);
    }

    public function updateProfile(Request $request,User $idUser)
    {
        $data = request()->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $idUser->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        // validar si la contraseña es vacia
        if (empty($request->password)) {
            $data['password'] = $idUser->password;
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $idUser->update($data);
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
        $user->delete();
        $data = User::all();
        return response()->json($data);
    }
}
