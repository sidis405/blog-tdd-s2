<?php

namespace Acme\Http\Controllers\Api;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = null;
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'invalid_credentials',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'result' => 'error',
                'message' => 'general_error',
            ], 500);
        }

        return response()->json([
            'result' => 'success',
            'token' => $token,
        ], 201);

        return $credentials;
    }
}
