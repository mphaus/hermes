<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Traits\WithFunctionAccess;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersEdit extends Component
{
    use WithFunctionAccess;

    public UserForm $form;

    public function mount(User $user): void
    {
        if ($user->username === config('app.super_user.username')) {
            abort(404);
        }

        $this->form->setUser($user);
    }

    public function save(): mixed
    {
        $this->form->update();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('User has been updated successfully.'),
        ]);

        return $this->redirectRoute(name: 'users.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.users-edit');
    }
}
