<?php

namespace App\Http\Controllers;

use App\Mail\PasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'apellido' => ['required'],
            'perfil' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'perfil' => $request->perfil,
            'documento' => $request->documento,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user = User::where("email", $request->email)->first();

        if (isset($user->id)) {
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    'status' => 0,
                    'msg' => "!Usuario logueado existosamente",
                    "access_token" => $token
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'msg' => "La password es incorrecta"
                ], 404);
            }
        }else{
            return response()->json([
                'status' => 0,
                'msg' => "El email no esta registrado"
            ], 404);
        }
    }

    public function getSession($token)
    {
        [$id, $user_token] = explode('|', $token, 2);
        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();
        if($token_data){
            $user_id = $token_data->tokenable_id;
            $data = User::find($user_id);
            return response()->json($data, 200);
        }
        return response()->json("inautente", 401);
    }
    public function logout(Request $request)
    {
        if($request->access_token){
            [$id, $user_token] = explode('|', $request->access_token, 2);
            $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();
            DB::table('personal_access_tokens')->where('tokenable_id', $token_data->tokenable_id)->delete();
        }
        Auth::logout();
    }

    public function resetPassword(Request $request, User $user)
    {
        if (!$request->hasValidSignature()) {
            return view('requestEmail', ['message' => 'Caduco el tiempo de solicitud', 'error' => true]);
        }

        return view('requestEmail', ['message' => 'Se confirmo el estacionamiento numero para el dia de mañana', 'error' => false]);
    } 

    function sendResetLinkEmail($email)
    {
        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json(["message" => "El email ingresado no existe", "isSuccess" => false]);
        }
        try{
            $event = new EventController();
            $link = $event->getLinkPassword($user);
            $page = new PasswordMail($user->nombre, $link);
            Mail::to($user->email)->send($page);
        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage(), "isSuccess" => false]);
        }
        return response()->json(["message" => $link, "isSuccess" => true]);
    }
}