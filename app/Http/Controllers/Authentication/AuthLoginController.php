<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registrar']]);
    }

    public function index(Request $request) {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        try {
            $token = Auth::attempt($credentials);

            if ($token == false) {
                return response()->json([
                    'error' => 'Invalid Credentials'
                ], 401);
            } else {
                return response()->json([
                    'user' => Auth::user(),
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not create token. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create(
            [
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ],

        );

        return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user ]);
    }
}
