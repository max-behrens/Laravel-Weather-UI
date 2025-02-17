<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Customize based on user roles/permissions (e.g., admin only)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Name is required, must be a string, max 255 characters
            'email' => 'required|string|email|max:255|unique:users,email', // Email is required, must be unique
            'password' => 'required|string|min:8', // Password is required, must be at least 8 characters (removed 'confirmed' rule)
        ];
    }

    /**
     * Customize the error messages for the validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
