<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('crud-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'username' => [
                'required',
                'min:5',
                Rule::unique('users', 'username'),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|min:16',
            'is_admin' => 'boolean',
            'is_enabled' => 'boolean',
            'permissions' => [
                'array',
                Rule::requiredIf(fn() => request()->get('is_admin') !== 'on'),
            ],
        ];
    }

    public function store() {}
}
