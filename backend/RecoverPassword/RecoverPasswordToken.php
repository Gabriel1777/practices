<?php

namespace App\Http\Requests\RecoverPassword;

use Illuminate\Foundation\Http\FormRequest;

class RecoverPasswordToken extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|exists:password_resets,token'
        ];
    }
}