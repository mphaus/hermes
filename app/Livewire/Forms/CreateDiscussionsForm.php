<?php

namespace App\Livewire\Forms;

use App\Models\DiscussionMapping;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDiscussionsForm extends Form
{
    #[Validate('required|numeric', as: 'opportunity')]
    public int $opportunityId;

    #[Validate('required|numeric', as: 'owner')]
    public int $userId;

    public function store(): mixed
    {
        $this->validate();

        $config = DiscussionMapping::latest()->first();
        $mappings = $config->mappings->toArray();
        $participantsIds = array_unique([
            ...Arr::flatten(array_reduce($mappings, function ($carry, $mapping) {
                if (empty($mapping['participants']) === false) {
                    $carry[] = array_map(fn ($participant) => $participant['id'], $mapping['participants']);
                }

                return $carry;
            }, [])),
            $this->userId,
        ]);

        $queryParams = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[active_eq]' => true,
            'q[id_in]' => $participantsIds,
        ])));

        $response = Http::current()->get("members?{$queryParams}");

        if ($response->failed()) {
            return 'participants-check-failed';
        }

        ['members' => $members] = $response->json();

        $memberIds = array_map(fn ($member) => $member['id'], $members);
        $diffIds = array_diff($participantsIds, $memberIds);

        if (empty($diffIds) === false) {
            return 'participants-validation-failed';
        }
    }
}
