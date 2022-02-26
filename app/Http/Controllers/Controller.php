<?php

namespace App\Http\Controllers;

use http\Env\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    protected function badRequest(Request $request)
    {
        return response()->json([
            'message' => 'Bad Request'
        ], 400);
    }
}
