<?php

namespace App\Http\Controllers;

use App\Mail\PasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\UsersSedes;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

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
            $data['sede'] = $data->sede;
            $multisedes = UsersSedes::where('user_id', $data->id)->get();

            foreach($multisedes as $multisede) {
                $multisede = $multisede->sede;
            }

            $data['multisedes'] = $multisedes;

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
        return view('resetPassword', ['user' => $user->id]);
    } 
    public function updatePassword(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'repet-password' => ['required'],
            'new-password' => ['required']
        ]);
        if($request->input('new-password') != $request->input('repet-password')){
            return response()->json(['message' => 'Las Contraseñas no son iguales', 'isSuccess' => false]);
        }
        $user = User::findOrFail($request->id);
        $user->update(['password' => Hash::make($request->input('new-password'))]);
        return response()->json(['message' => 'Se restablecio la contraseña', 'isSuccess' => true]);
    }
    public function resetPass(Request $request) {
        $user = User::find($request->id_user);

        $newPass = Str::random(8);

        $user->password = Hash::make($newPass);
        $user->update();

        return response()->json([
            'pass' => $newPass
        ]);
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
            //$signature = strstr( $link , 'signature=');
            //$link = url("/reset-password?user="."25".$signature);
            Mail::to($user->email)->send($page);
        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage(), "isSuccess" => false])->setStatusCode(500);
        }
        return response()->json(["message" => "Se envio el link a tu correo", "isSuccess" => true]);
    }
}