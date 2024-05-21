<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateDiscussionsForm;
use App\Models\DiscussionMapping;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class DiscussionsCreate extends Component
{
    public CreateDiscussionsForm $form;

    public function save()
    {
        $this->form->store();
    }

    public function render(): View
    {
        return view('livewire.discussions-create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }
}
