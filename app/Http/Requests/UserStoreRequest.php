<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\WithUserPermissions;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    use WithUserPermissions;

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
            'is_admin' => 'nullable',
            'is_enabled' => 'nullable',
            'permissions' => [
                'array',
                Rule::requiredIf(fn() => request()->get('is_admin') !== '1'),
                function (string $attribute, mixed $value, Closure $fail) {
                    $permissions = array_column($this->getPermissions(), 'value');

                    if (!in_array($value, $permissions)) {
                        $fail('One or more selected :attribute are invalid.');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'permissions.required' => 'Please set the permissions for this user.',
        ];
    }

    public function store()
    {
        $validated = $this->validate();

        return $validated;

        [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'is_admin' => $is_admin,
            'is_enabled' => $is_enabled,
            'permissions' => $permissions,
        ] = $validated;

        // $user = new User;
        // $user->first_name = $first_name;
        // $user->last_name = $last_name;
        // $user->username = $username;
        // $user->email = $email;
        // $user->password = Hash::make($password);
        // $user->is_admin = $is_admin;
        // $user->is_enabled = $is_enabled;
        // $user->permissions = $permissions;
        // $user->save();
    }
}
