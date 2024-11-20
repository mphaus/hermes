<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TechnicalSupervisorForm extends Form
{
    public int|null $id = null;

    #[Validate('required|alpha', as: 'first name')]
    public string $first_name;

    #[Validate('required|alpha', as: 'last name')]
    public string $last_name;

    public function setTechnicalSupervisor(array $technical_supervisor)
    {
        ['id' => $id, 'name' => $name] = $technical_supervisor;

        $name = explode(' ', $name);

        $this->first_name = $name[0] ? $name[0] : '';
        $this->last_name = $name[1] ? $name[1] : '';
        $this->id = $id;
    }

    public function store(): string
    {
        $validated = $this->validate();

        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            return 'failed-fetching-technical-supervisors-list';
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        if ($this->id !== null) {
            $column = array_column($list_values, 'id');
            $i = array_search($this->id, $column);
            $list_values[$i]['name'] = "{$validated['first_name']} {$validated['last_name']}";
            $data = [...$list_values];
        } else {
            $data = [
                ...$list_values,
                [
                    'list_name_id' => intval($technical_supervisors_list_id),
                    'name' => "{$validated['first_name']} {$validated['last_name']}",
                ],
            ];
        }

        $response = Http::current()->put("list_names/{$technical_supervisors_list_id}", [
            'list_name' => [
                'list_values' => $data,
            ]
        ]);

        if ($response->failed()) {
            return 'failed-saving-new-technical-supervisor';
        }

        return 'success';
    }
}
