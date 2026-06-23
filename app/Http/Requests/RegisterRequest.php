<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'gender' => 'string|nullable',
            'gender_other' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 3 characters',
            'password.max' => 'Password must not exceed 60 characters',

            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',

            'username.required' => 'Username is required',
            'username.unique' => 'Username is already taken',
        ];
    }
}
