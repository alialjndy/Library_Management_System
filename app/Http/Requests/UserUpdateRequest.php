<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserUpdateRequest extends FormRequest
{
    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Validation incoming input data
        return [
            'name'=>'nullable|string|max:40|unique:users,name',
            'email'=>'nullable|email|unique:users,email',
            'password'=>'nullable'
        ];
    }
    /**
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
            'errors'=>$validator->errors()
        ]));
    }
    /**
     * Summary of attributes
     * @return string[]
     */
    public function attributes()
    {
        return [
            'name'=>'User Name',
            'email'=>'User Email',
            'password'=>'User Password'
        ];
    }
    /**
     * Summary of messages
     * @return string[]
     */
    public function messages()// Form of the error
    {
    return [
            'string' => 'The :attribute field must be a valid string.',
            'unique' => 'The :attribute field must be unique.',
            'email'  => 'Please enter a valid email address.',
            'max'    => 'The :attribute may not be greater than :max characters.',
    ];
    }
}

