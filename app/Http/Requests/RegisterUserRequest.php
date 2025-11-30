<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to register
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|unique:users|regex:/^[0-9]{10,15}$/',
            'role' => 'required|in:tenant,owner',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:-18 years',
            'profile_image' => 'nullable|image|max:2048', // 2MB max
            'id_image' => 'required|image|max:2048',
            'password' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'birth_date.before' => 'You must be at least 18 years old to register.',
            'phone.regex' => 'Phone number must be between 10-15 digits.',
            'id_image.required' => 'ID image is required for verification.',
            'phone.unique' => 'This phone number is already registered.',
        ];
    }
}
