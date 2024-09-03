<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRequest extends FormRequest
{
    /**
     * This method checks if the user is authorized based on their JWT (JSON Web Token).
     * It tries to authenticate the user and ensure they have admin privileges.
     * Determine if the user is authorized to make this request.
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            return $user && $user->is_admin;
        }catch(Exception $e){
            return false;
        }
    }
    /**
     * Summary of prepareForValidation
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
        'email' => $this->email ? strtolower(trim($this->email)) : null,
        'name' => $this->name ? trim($this->name) : null,
    ]);
    }

    /**
     * Get the validation rules that apply to the request.
     * Define the validation rules for the incoming request data.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:40',
            'email'=>'required|email',
            'password'=>'required'
        ];
    }
    /**
     * Handle a failed validation apptempt
     * This method is triggered when validation fails.
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'=>'failed',
            'message'=>'Failed verification please confirm the input',
            'error'=>$validator->errors()
        ]));
    }
    /**
     * This method provides custom attribute names for validation error messages.
     * Summary of attributes
     * @return string[]
     */
    public function attributes()
    {
        return [
            'name' => 'User Name',
            'email' => 'User Email',
            'password' => 'User Password'
        ];
    }
    /**
     * Custom error messages for validation rules.
     * Summary of messages
     * @return string[]
     */
    public function messages()
    {
        return [
            'required'=>'The :attribute field is required.',
            'string'=>'The :attribute field must be a string.',
            'email'=>'Please Enter a valid email address.',
        ];
    }
}
