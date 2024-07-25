<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->exceptSuperAdmin()
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->paginate(25);
    }

    public function placeholder(): View
    {
        return view('users-skeleton');
    }

    public function render(): View
    {
        return view('livewire.users-index');
    }
}
