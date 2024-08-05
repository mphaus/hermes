<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Traits\WithFunctionAccess;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersCreate extends Component
{
    use WithFunctionAccess;

    public UserForm $form;

    public function save(): void
    {
        $this->form->store();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('User created successfully.'),
        ]);

        $this->redirectRoute(name: 'users.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.users-create');
    }
}
