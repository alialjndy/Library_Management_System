<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    // Instance of UserService for business logic
    protected $userService ;
    /**
     * Summary of __construct
     * @param \App\Service\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $allUser = $this->userService->getAllUser();
        // Fetch all users via UserService and return as JSON response
        return response()->json([
            'status'=>true,
            'data'=>$this->userService->getAllUser(),
        ]);
    }

    /**
     * @param  \App\Http\Requests\UserRequest
     * @return \Illuminate\Http\JsonResponse
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) : JsonResponse
    {
        // Create a new user with validated data and return JSON response
        $user = $this->userService->create($request->validated());
        return response()->json([
            'status'=>true,
            'message'=>'User created successfully',
            'user'=>[
                'name'=>$user->name,
                'email'=>$user->email
            ]
        ],201);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * Display the specified resource.
     */
    public function show(string $id) :JsonResponse
    {
        // Find user by ID or fail, and return user details or error message
        $user = User::findOrFail($id);
        if($user)
        {
            return response()->json([
                'status'=>true,
                'user'=>[
                    'name'=>$user->name,
                    'email'=>$user->email
                ]
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'data'=>'no data'
            ],422);
        }
    }

    /**
     * @param \App\Models\User
     * @param \App\Http\Requests\UserRequest
     * @return \Illuminate\Http\JsonResponse
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id) : JsonResponse
    {
        $user_id = JWTAuth::user()->id ;
        if($user_id === $id){
            $validatedData = $request->validated();

            // Update user with validated data and return updated user details
            $updateUser = $this->userService->update($validatedData,$id);

            if (!$updateUser) {
                return response()->json([
                    'success' => false,
                    'message' => $request->messages(),
                ], 404);
            }

            // Return the successful response with the updated user data
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',

            ], 200);
        }
        return response()->json([
            'status'=>'failed',
            'message'=>'Unauthorized to update this user\'s information.'
        ], 403);
    }



    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        // Delete user by ID and return success message
        $this->userService->delete($id);
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
