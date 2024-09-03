<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Notifications\BorrowSuccessNotification;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class BorrowRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            return $user ? true :false;
        }catch(Exception $e){
            return false ;
        }
    }
    public function prepareForValidation()
    {
        $user = User::find($this->user_id);
        if($user){
            $user->notify(new BorrowSuccessNotification());
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id'=>'required|exists:books,id',
            'user_id'=>'required|exists:users,id',
            'borrowed_at'=>'nullable|date',
            'due_date'=>'nullable|date',
            'returned_at'=>'nullable|date'
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'=>'failed',
            'message'=>'Failed Verification please confirm the input',
            'error'=>$validator->errors()
        ]));
    }
    public function attributes()
    {
        return [
            'book_id'=>'Book ID',
            'user_id'=>'User ID',
            'borrowed_at'=>'borrowed Date',
            'due_date'=>'Due Date',
            'returned_at'=>'Returned Date'
        ];
    }
    public function messages()
    {
        return[
            'required' => 'The :attribute field is required',
            'exists' => 'The :attribute must exist in the table',
            'date' => 'The :attribute is not a valid date format'
        ];
    }
}
