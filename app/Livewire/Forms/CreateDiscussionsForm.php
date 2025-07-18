<?php

namespace App\Livewire\Forms;

use App\Models\DiscussionMapping;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDiscussionsForm extends Form
{
    #[Validate('required', as: 'Short Job or Project Name')]
    public string $short_job_or_project_name = '';

    #[Validate('required|in:opportunity,project', as: 'entity')]
    public string $object_type = 'opportunity';

    #[Validate('required|numeric', as: 'Opportunity or Project')]
    public int $object_id;

    #[Validate('required|numeric', as: 'owner')]
    public int $user_id;

    public function store(): string|null
    {
        $this->validate();

        $config = DiscussionMapping::latest()->first();
        $mappings = $config->mappings->toArray();
        $participants_ids = array_unique([
            ...Arr::flatten(array_reduce($mappings, function ($carry, $mapping) {
                if (empty($mapping['participants']) === false) {
                    $carry[] = array_map(fn($participant) => $participant['id'], $mapping['participants']);
                }

                return $carry;
            }, [])),
            $this->user_id,
        ]);

        $query_params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[active_eq]' => true,
            'q[id_in]' => $participants_ids,
        ])));

        $response = Http::current()->get("members?{$query_params}");

        if ($response->failed()) {
            return 'PARTICIPANTS_CHECK_FAILED';
        }

        ['members' => $members] = $response->json();

        $member_ids = array_map(fn($member) => $member['id'], $members);
        $diff_ids = array_diff($participants_ids, $member_ids);

        if (empty($diff_ids) === false) {
            return 'PARTICIPANTS_VALIDATION_FAILED';
        }

        $create_on_project = $this->object_type === 'project';

        // CHECK IF DISCUSSIONS EXIST ON THE DISCUSSABLE ID AND DELETE THEM IF NECESSARY
        $query_params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[discussable_id_eq]' => App::environment(['local', 'staging'])
                ? (
                    $create_on_project
                    ? intval(config('app.mph.test_project_id'))
                    : intval(config('app.mph.test_opportunity_id'))
                )
                : $this->object_id,
            'q[discussable_type_eq]' => $create_on_project ? 'Project' : 'Opportunity',
        ])));

        $response = Http::current()->get("discussions?{$query_params}");

        if ($response->failed()) {
            return 'DISCUSSIONS_EXISTANCE_CHECK_FAILED';
        }

        ['discussions' => $discussions] = $response->json();

        if (!empty($discussions)) {
            Http::pool(function (Pool $pool) use ($discussions) {
                return array_map(function ($discussion) use ($pool) {
                    return $pool->withHeaders([
                        'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                        'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
                    ])->delete(config('app.current_rms.host') . 'discussions/' . $discussion['id']);
                }, $discussions);
            });
        }

        foreach ($mappings as $mapping) {
            Http::current()->post('discussions', [
                'discussion' => [
                    'discussable_id' => App::environment(['local', 'staging'])
                        ? (
                            $create_on_project
                            ? intval(config('app.mph.test_project_id'))
                            : intval(config('app.mph.test_opportunity_id'))
                        )
                        : $this->object_id,
                    'discussable_type' => $create_on_project ? 'Project' : 'Opportunity',
                    'subject' => "{$mapping['title']} - {$this->short_job_or_project_name}",
                    'created_by' => $this->user_id,
                    'first_comment' => [
                        'remark' => $mapping['first_message'],
                        'created_by' => $this->user_id,
                    ],
                    'participants' => empty($mapping['participants'])
                        ? [['member_id' => $this->user_id, 'mute' => true]]
                        : ($mapping['include_opportunity_owner_as_participant']
                            ? [
                                ['member_id' => $this->user_id, 'mute' => true],
                                ...array_map(fn($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants']),
                            ]
                            : array_map(fn($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants'])),
                ],
            ]);
        }

        return null;
    }
}
