<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['name', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Create another a JWT given a JWT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken(auth()->refresh());
    }


}
