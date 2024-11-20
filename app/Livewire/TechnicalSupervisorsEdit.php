<?php

namespace App\Livewire;

use App\Livewire\Forms\TechnicalSupervisorForm;
use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class TechnicalSupervisorsEdit extends Component
{
    use WithHttpCurrentError;

    public TechnicalSupervisorForm $form;

    public string $message;

    public string $error;

    public array|null $technical_supervisor;

    public function mount(int $id)
    {
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            $this->error = $this->errorMessage(__('An error occurred obtaining the list of Technical Supervisors to edit with the new value. Please, refresh the page and try again.'), $response->json());
            return;
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        $filter = array_values(array_filter($list_values, fn($value) => $value['id'] === $id));

        $this->technical_supervisor = $filter ? $filter[0] : null;

        if ($this->technical_supervisor === null) {
            return;
        }

        $this->form->setTechnicalSupervisor($this->technical_supervisor);
    }

    public function save(): mixed
    {
        if (!usercan('crud-technical-supervisors')) {
            abort(403);
        }

        $this->message = '';
        $result = $this->form->store();

        if ($result === 'failed-fetching-technical-supervisors-list') {
            $this->message = __('An error occurred obtaining the list of Technical Supervisors to edit with the new value. Please, refresh the page and try again.');
            return null;
        }

        if ($result === 'failed-saving-new-technical-supervisor') {
            $this->message = __('An error occurred saving the Technical Supervisor. Please, refresh the page and try again.');
            return null;
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Technical Supervisor updated successfully.'),
        ]);

        return $this->redirectRoute(name: 'technical-supervisors.index', navigate: true);
    }

    public function placeholder(): View
    {
        return view('technical-supervisors-edit-skeleton');
    }

    public function render(): View
    {
        return view('livewire.technical-supervisors-edit');
    }
}
