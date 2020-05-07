<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!is_null($request['email']) && !is_null($request['password'])) {
            
            $email    = $request['email'];
            $password = $request['password'];

            $user = User::where('email', $email)->first();

            if (Auth::check() || ($user && Hash::check($password, $user->password))) {

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'name'  => $user->name,
                    'email' => $user->email,
                    'token' => $token
                ], 200);
                
            }
            
        } else {

            return response()->json([
                'error' => \Lang::get('auth.failed')
            ], 401);

        }
    }

    /**
     * Refresh Token
     */
    public function refresh()
    {
        
        $token = \Auth::guard('api')->refresh();
        
        return response()->json([
            'token' => $token
        ], 200);
    }    

    /**
     * Método que faz o logout
     */
    public function logout()
    {
        \Auth::guard('api')->logout();
        return response()->json([], 204);
    }

}
