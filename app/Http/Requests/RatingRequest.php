<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|between:1,5'
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
            'user_id'=>'User ID',
            'book_id'=>'Book ID',
            'rating'=>'Book Rating',

        ];
    }

    /**
     * Summary of messages
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'min' => 'The :attribute must be at least :min.',
            'max' => 'The :attribute may not be greater than :max.'
        ];
    }
}
