<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Traits\WithFunctionAccess;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsersEdit extends Component
{
    use WithFunctionAccess;

    public UserForm $form;

    public function mount(User $user): void
    {
        if ($user->id === Auth::user()->id || $user->username === config('app.super_user.username')) {
            abort(404);
        }

        $this->form->setUser($user);
    }

    public function save()
    {
        if (!usercan('crud-users')) {
            abort(403);
        }

        $this->form->update();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('User has been updated successfully.'),
        ]);

        return $this->redirectRoute(name: 'users.index');
    }

    public function render(): View
    {
        return view('livewire.users-edit');
    }
}
