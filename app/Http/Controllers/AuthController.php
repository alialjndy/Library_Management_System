<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService ;
    }
    public function register(RegisterRequest $registerRequest)
    {
        // dd($registerRequest->validated());
        $validatedData = $registerRequest->validated();

        // =====> Call the registration service and pass the verified data <=====
        $user = $this->authService->register($validatedData);

        // =====> Re-responding with user information and JWT code <=====
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status'=>'success',
            'message'=>'user register successfully',
            'user'=>$user ,
            'token'=>$token,
        ], 201);
    }
    /**
     * Summary of login
     * @param \App\Http\Requests\LoginRequest $loginRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest){
        $result = $this->authService->login($loginRequest->only('email', 'password'));
        return response()->json([
            'success'=>true ,
            'message'=>'user logged in successfully',
            'user'=>$result['data']['user'],
            'token'=>$result['data']['authorization']['token'],
            'type'=>'bearer'
        ]);
    }
    /**
     * Summary of logout
     * @return void
     */
public function logout(){
    $this->authService->logout();

    return response()->json([
        'status' => 'success',
        'message' => 'Logged out successfully'
    ]);
}
}
