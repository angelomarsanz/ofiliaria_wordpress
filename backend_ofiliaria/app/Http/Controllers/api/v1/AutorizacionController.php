<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Enums\TokenAbility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AutorizacionController extends Controller
{
    public function registro(Request $request)
    {
        $email = '';
        $password = '';
        $datos = json_decode(file_get_contents('php://input'));
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && isset($datos->name) && isset($datos->wordpress_id) && isset($datos->token)) 
        {
            $email = $_SERVER['PHP_AUTH_USER'];   
            $password = $_SERVER['PHP_AUTH_PW'];   
        }
        else
        {
            return response()->json([
                'codigo_respuesta' => 1,
                'mensaje' => 'Valores nulos'
            ], 200);        
        }

        $user = User::where('email', $email)->first();
        if ($user)
        {
            return response()->json([
                'codigo_respuesta' => 2,
                'mensaje' => 'Usuario ya existe en la base de datos...',
                'email_existente' => $email
            ], 200);    
        }
        else
        {
            if ($datos->wordpress_id == 1) // Super-usuario
            {
                $vectorDatos = ['name' => $datos->name, "email" => $email, "password" => $password, 'wordpress_id' => $datos->wordpress_id];
                $user = User::create($vectorDatos);
                $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
                $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));
                $user->update(['remember_token' => $accessToken->plainTextToken]);
            }
            else
            {
                $superUsuario = User::where('wordpress_id', 1)->first(); // Super-usuario
                if ($superUsuario->remember_token == $datos->token)
                {
                    $vectorDatos = ['name' => $datos->name, "email" => $email, "password" => $password, 'wordpress_id' => $datos->wordpress_id];
                    $user = User::create($vectorDatos);
                    $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
                    $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));        
                }
                else
                {
                    return response()->json([
                        'codigo_respuesta' => 3,
                        'mensaje' => 'Token inválido'
                    ], 200);    
                }
            }                    
            
            return response()->json([
                'codigo_respuesta' => 0,
                'mensaje' => 'Usuario y tokens creados exitosamente',
                'token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
                'laravel_id' => $user->id
            ], 200);    
        }
    }
    public function login(Request $request)
    {
        $email = '';
        $password = '';
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) 
        {
            $email = $_SERVER['PHP_AUTH_USER'];   
            $password = $_SERVER['PHP_AUTH_PW'];   
        }
        else
        {
            return response()->json([
                'codigo_respuesta' => 1,
                'mensaje' => 'Valores nulos'
            ], 200);        
        }

        $user = User::where('email', $email)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json([
                'codigo_respuesta' => 2,
                'mensaje' => 'Las credenciales son incorrectas'
            ], 200);        
        }
        

        $user->tokens()->delete();
        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        if ($user->wordpress_id == 1)
        {
            $user->update(['remember_token' => $accessToken->plainTextToken]);
        }

        return response()->json([
            'codigo_respuesta' => 0,
            'mensaje' => 'Tokens creados exitosamente',
            'token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken
        ]);
    }

    public function refrescarToken(Request $request)
    {
        $email = '';
        $datos = json_decode(file_get_contents('php://input'));
        if (isset($datos->email)) 
        {
            $email = $datos->email;   
        }
        else
        {
            return response()->json([
                'codigo_respuesta' => 1,
                'mensaje' => 'No se recibió el email'
            ], 200);        
        }

        $usuario = User::where('email', $email)->first();
        if (!$usuario)
        {
            return response()->json([
                'codigo_respuesta' => 2,
                'mensaje' => 'El usuario no existe'
            ], 200);        
        }

        $usuario->tokens()->delete();
        $accessToken = $usuario->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $usuario->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        if ($usuario->wordpress_id == 1)
        {
            $usuario->update(['remember_token' => $accessToken->plainTextToken]);
        }

        return response()->json([
            'codigo_respuesta' => 0,
            'mensaje' => 'Tokens creados exitosamente',
            'token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}