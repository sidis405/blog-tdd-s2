<?php

namespace Acme\Http\Controllers\Api;

use JWTAuth;
use JWTAuthException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                    'token' => 'invalid_credentials',
                ], 201);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'result' => 'success',
            'token' => $token,
        ], 201);

        return $credentials;
    }
}
