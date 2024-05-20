<?php

namespace App\Livewire;

use App\Models\DiscussionMapping;
use Livewire\Component;

class DiscussionsCreate extends Component
{
    public function render()
    {
        return view('livewire.discussions-create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }
}
