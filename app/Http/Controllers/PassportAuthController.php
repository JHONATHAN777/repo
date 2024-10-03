<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token], 200);


    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'El usuario o la contraseña no son correctos'], 401);
        }
    }
    

    public function logout()
    {

        $user = auth()->user();
        
        if ($user) {

            $tokens = $user->tokens;
    

            foreach ($tokens as $token) {
                $token->revoke();
            }
    
            return response()->json(['message' => 'Logout successful'], 200);
        }
    
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    

}
