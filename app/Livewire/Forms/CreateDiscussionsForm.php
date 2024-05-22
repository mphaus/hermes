<?php

namespace App\Livewire\Forms;

use App\Models\DiscussionMapping;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDiscussionsForm extends Form
{
    #[Validate('required|numeric', as: 'opportunity')]
    public int $opportunityId;

    #[Validate('required|numeric', as: 'owner')]
    public int $userId;

    public function store(): string
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

        foreach ($mappings as $mapping) {
            Http::current()->post('discussions', [
                'discussion' => [
                    'discussable_id' => App::environment(['local', 'staging']) ? intval(config('app.mph.test_opportunity_id')) : $this->opportunityId,
                    'discussable_type' => 'Opportunity',
                    'subject' => $mapping['title'],
                    'created_by' => $this->userId,
                    'first_comment' => [
                        'remark' => $mapping['first_message'],
                        'created_by' => $this->userId,
                    ],
                    'participants' => empty($mapping['participants'])
                        ? [['member_id' => $this->userId, 'mute' => true]]
                        : ($mapping['include_opportunity_owner_as_participant']
                            ? [
                                ['member_id' => $this->userId, 'mute' => true],
                                ...array_map(fn ($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants']),
                            ]
                            : array_map(fn ($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants'])),
                ],
            ]);
        }

        return 'success';
    }
}
