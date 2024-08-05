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
        $this->user = $user;
    }

    public function render(): View
    {
        return view('livewire.users-show');
    }
}
