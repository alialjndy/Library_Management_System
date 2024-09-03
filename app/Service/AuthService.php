<?php
namespace App\Service;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function register(array $data)
    {
        // =====> Hach password <=====
        $data['password'] = Hash::make($data['password']);

        // =====> Create User <=====
        $user = User::create($data);
        return $user;
    }
    public function login(array $Credentials)
    {
        // =====> Attempt to authenticate the user and generate a token <=====
        if(!$token = JWTAuth::attempt($Credentials)){
            return [
                'success'=>false,
                'message'=>'Invalid Email Or Password',
                'status'=>401
            ];
        }
        //=====> If authentication is successful, get the authenticated user <=====
        $user = JWTAuth::user();
        // Return the success response with token information
        return [
            'success'=>true ,
            'status'=>200,
            'data'=> [
                'user'=>$user,
                'authorization'=>[
                    'token'=>$token ,
                    'type'=>'bearer',
                ],
            ],
        ];
    }

    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout() {

        try {
            $token = JWTAuth::getToken(); // =====> Check the presence of the token in the request <=====
            if(!$token){
                return response()->json([
                    'error'=>true,
                    'message'=>'Token Not provided'
                ],400);// =====>  <=====
            }
            // Adds token to blacklist.
            $forever = true;
            JWTAuth::invalidate($token , $forever);

            return response()->json( [
                'error'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }

}

?>
