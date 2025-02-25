<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'required|string|max:255',
            'phoneNumber' => 'required|string|regex:/^[0-9]{10,11}$/',
            'username' => 'required|string|min:4|unique:users,username',
            'password' => 'required|min:8|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'confirmPassword' => 'required|same:password',
        ];
    }
} 