<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\WithFunctionAccess;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersShow extends Component
{
    use WithFunctionAccess;

    public User $user;

    public function mount(User $user): void
    {
        if ($user->username === config('app.super_user.username')) {
            abort(404);
        }

        $this->user = $user;
    }

    public function render(): View
    {
        return view('livewire.users-show');
    }
}
