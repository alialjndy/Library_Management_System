<?php

namespace App\Http\Requests;

use App\Rules\ValidBook;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class BookRequest extends FormRequest
{
    /**
     * This method checks if the user is authorized based on their JWT (JSON Web Token).
     * It tries to authenticate the user and ensure they have admin privileges.
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        try{
            // Read the token and return the user who belongs to this token
            $user = JWTAuth::parseToken()->authenticate();

            //Return the user role
            return $user && $user->is_admin;
        }catch(Exception $e)    //
        {
            return false;
        }
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
            'title'=>['required','string','max:100', new ValidBook],
            'author'=>['required','string','max:40' ,new ValidBook],
            'description'=>'nullable|string',
            'published_at'=>'required|date',
            'category'=>'required|in:Novel,Technique,Educational'
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
            'status'=>false,
            'message'=>'Failed verification please confirm the input',
            'errors'=>$validator->errors()
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
            'title'=>'Book Title',
            'author'=>'Author Name',
            'description'=>'Book Description',
            'published_at'=>'Published Date',
            'category'=>'Book Category'
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
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ];
    }
}
