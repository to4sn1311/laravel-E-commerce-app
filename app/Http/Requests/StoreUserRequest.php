<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string|max:255',
      'roles' => 'required|array|min:1',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];
  }

  public function messages(): array
  {
    return [
      'roles.required' => 'Please select at least one role',
      'roles.min' => 'Please select at least one role',
      'password.min' => 'Password must be at least 8 characters',
      'password.confirmed' => 'Password confirmation does not match',
      'avatar.image' => 'The avatar must be an image',
      'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg, gif',
      'avatar.max' => 'The avatar must not be greater than 2MB'
    ];
  }
}
