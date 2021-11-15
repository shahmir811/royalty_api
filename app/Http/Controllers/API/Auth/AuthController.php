<?php

namespace App\Http\Controllers\API\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\{User, Role};
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\{LoginFormRequest};

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /////////////////////////////////////////////////////////////////////////
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    /////////////////////////////////////////////////////////////////////////
    public function me()
    {
        return response()->json([
            'data' => [
                // 'user' => $this->guard()->user()
                'user' => new UserResource($this->guard()->user())
                ]
            ]
        );
    }    
    
    /////////////////////////////////////////////////////////////////////////
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }    
    
    /////////////////////////////////////////////////////////////////////////
    public function guard()
    {
        return Auth::guard();
    }    
    
    /////////////////////////////////////////////////////////////////////////    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
    
}
