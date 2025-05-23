<?php

namespace App\Livewire\Forms;

use App\Mail\NewAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    public ?User $user = null;

    public string $first_name = '';

    public string $last_name = '';

    public string $username = '';

    public string $email = '';

    public bool $is_admin = false;

    public bool $is_enabled = true;

    public array $permissions = [];

    public function setUser(User $user): void
    {
        $this->user = $user;

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
        $this->is_enabled = $user->is_enabled;
        $this->permissions = $user->permissions === null ? [] : $user->permissions->toArray();
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'username' => [
                'required',
                'min:5',
                $this->user ? Rule::unique('users', 'username')->ignore($this->user->id) : Rule::unique('users', 'username'),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                $this->user ? Rule::unique('users', 'email')->ignore($this->user->id) : Rule::unique('users', 'email'),
            ],
            'is_admin' => 'boolean',
            'is_enabled' => 'boolean',
            'permissions' => [
                'array',
                Rule::requiredIf(fn() => $this->is_admin === false),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'permissions.required' => __('Please indicate the Function access for this user.'),
        ];
    }

    public function store(): void
    {
        $validated = $this->validate();

        $user = new User;

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['username']);
        $user->is_admin = $validated['is_admin'];
        $user->is_enabled = $validated['is_enabled'];
        $user->permissions = $validated['permissions'];
        $user->save();

        // Mail::to($user->email)->send(new NewAccount($user));
    }

    public function update(): void
    {
        if ($this->user->id === Auth::user()->id) {
            abort(403);
        }

        $validated = $this->validate();

        $this->user->first_name = $validated['first_name'];
        $this->user->last_name = $validated['last_name'];
        $this->user->username = $validated['username'];
        $this->user->email = $validated['email'];
        $this->user->is_admin = $validated['is_admin'];
        $this->user->is_enabled = $validated['is_enabled'];
        $this->user->permissions = $validated['permissions'];
        $this->user->save();
    }
}
