<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserDeleteButton extends Component
{
    public User $user;

    public function render(): View
    {
        return view('livewire.user-delete-button');
    }
}
