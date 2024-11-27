<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Укажите login и password'], 401, options: JSON_UNESCAPED_UNICODE);
        }

        $login = $request->login;
        $user = User::where('login', $login)->first();

        if ($user) {
            return response()->json([
                'message' => 'Логин уже используется в системе, попробуйте другой',
                'data' => [
                    'login' => $request->login,
                ],
            ], options: JSON_UNESCAPED_UNICODE);
        }

        $user = User::create([
            'login' => $login,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Вы успешно зарегистрированы',
            'data' => [
                'token' => $token
            ],
        ], options: JSON_UNESCAPED_UNICODE);
    }
}
