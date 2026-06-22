<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 
            [        
            'required',
                Rule::email()
                ->rfcCompliant(strict: false)
                ->preventSpoofing(),
            ],
            'password' => 'required|min:3|max:60',
            
        ];
    }
        public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 3 characters',
            'password.max' => 'Password must not exceed 60 characters',
        ];
    }
    

}
