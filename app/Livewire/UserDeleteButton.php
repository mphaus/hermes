<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDeleteButton extends Component
{
    public User $user;

    public function delete()
    {
        if ($this->user->id === Auth::user()->id || $this->user->username === config('app.super_user.username')) {
            abort(403);
        }

        $this->user->delete();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('User :full_name has been deleted.', ['full_name' => $this->user->full_name]),
        ]);

        return $this->redirectRoute(name: 'users.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.user-delete-button');
    }
}
