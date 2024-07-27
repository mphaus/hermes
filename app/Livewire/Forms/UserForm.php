<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Form;


/**
 * GATES
 * 
 * crud-users
 * access-equipment-import
 * access-action-stream
 * create-default-discussions
 * update-default-discussions
 */

class UserForm extends Form
{
    public string $first_name = '';

    public string $last_name = '';

    public string $username = '';

    public string $email = '';

    public bool $is_admin = false;

    public bool $is_enabled = false;

    public array $permissions = [];

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
            'is_admin' => 'boolean',
            'is_enabled' => 'boolean',
            'permissions' => [
                'array',
                Rule::requiredIf(fn () => $this->is_admin === false),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'permissions.required' => __('Please indicate the Function access for this user.'),
        ];
    }

    public function store()
    {
        $validated = $this->validate();

        $user = new User;

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['username']);
        $user->permissions = $validated['permissions'];
        $user->is_admin = $validated['is_admin'];
        $user->is_enabled = $validated['is_enabled'];
        $user->permissions = $validated['permissions'];
        $user->save();
    }
}
