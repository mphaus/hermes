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
        $result = $this->form->store();

        if ($result !== 'success') {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => __('The Discussions creation process failed.'),
            ]);
        }

        if ($result === 'participants-check-failed') {
            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: an error occurred while checking the existence of the participants. Please refresh the page and try again.'),
            ]);
        }

        if ($result === 'participants-validation-failed') {
            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: the participants do not match those listed in CurrentRMS.'),
            ]);
        }

        return $this->redirectRoute(name: 'discussions.create', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.discussions-create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }
}
