<?php

namespace App\Livewire;

use App\Livewire\Forms\TechnicalSupervisorForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TechnicalSupervisorsCreate extends Component
{
    public TechnicalSupervisorForm $form;

    public string $message;

    public function save(): mixed
    {
        $this->message = '';
        $result = $this->form->store();

        if ($result === 'failed-fetching-technical-supervisors-list') {
            $this->message = __('An error occurred obtaining the list of Technical Supervisors to add the new value. Please, refresh the page and try again.');
            return null;
        }

        if ($result === 'failed-saving-new-technical-supervisor') {
            $this->message = __('An error occurred saving the new Technical Supervisor. Please, refresh the page and try again.');
            return null;
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Technical Supervisor created successfully.'),
        ]);

        return $this->redirectRoute(name: 'technical-supervisors.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.technical-supervisors-create');
    }
}
