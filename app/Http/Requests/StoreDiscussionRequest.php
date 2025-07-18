<?php

namespace App\Http\Requests;

use App\Models\DiscussionMapping;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiscussionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('create-default-discussions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'short_job_or_project_name' => ['required'],
            'object_type' => ['required', 'in:opportunity,project'],
            'object_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'short_job_or_project_name' => __('Short Job or Project Name'),
            'object_type' => __('entity'),
            'object_id' => __('Opportunity or Project'),
            'user_id' => __('owner'),
        ];
    }

    public function store()
    {
        $validated = $this->validated();

        $config = DiscussionMapping::latest()->first();
        $mappings = $config->mappings->toArray();
        $participants_ids = array_unique([
            ...Arr::flatten(array_reduce($mappings, function ($carry, $mapping) {
                if (empty($mapping['participants']) === false) {
                    $carry[] = array_map(fn($participant) => $participant['id'], $mapping['participants']);
                }

                return $carry;
            }, [])),
            $validated['user_id'],
        ]);

        $query_params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[active_eq]' => true,
            'q[id_in]' => $participants_ids,
        ])));

        $response = Http::current()->get("members?{$query_params}");

        if ($response->failed()) {
            return 'participants-check-failed';
        }

        ['members' => $members] = $response->json();

        $member_ids = array_map(fn($member) => $member['id'], $members);
        $diff_ids = array_diff($participants_ids, $member_ids);

        if (empty($diff_ids) === false) {
            return 'participants-validation-failed';
        }

        $create_on_project = $validated['object_type'] === 'project';

        // CHECK IF DISCUSSIONS EXIST ON THE DISCUSSABLE ID AND DELETE THEM IF NECESSARY
        $query_params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[discussable_id_eq]' => App::environment(['local', 'staging'])
                ? (
                    $create_on_project
                    ? intval(config('app.mph.test_project_id'))
                    : intval(config('app.mph.test_opportunity_id'))
                )
                : $validated['object_id'],
            'q[discussable_type_eq]' => $create_on_project ? 'Project' : 'Opportunity',
        ])));

        $response = Http::current()->get("discussions?{$query_params}");

        if ($response->failed()) {
            return 'discussions-existance-check-failed';
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
                        : $validated['object_id'],
                    'discussable_type' => $create_on_project ? 'Project' : 'Opportunity',
                    'subject' => "{$mapping['title']} - {$validated['short_job_or_project_name']}",
                    'created_by' => $validated['user_id'],
                    'first_comment' => [
                        'remark' => $mapping['first_message'],
                        'created_by' => $validated['user_id'],
                    ],
                    'participants' => empty($mapping['participants'])
                        ? [['member_id' => $validated['user_id'], 'mute' => true]]
                        : ($mapping['include_opportunity_owner_as_participant']
                            ? [
                                ['member_id' => $validated['user_id'], 'mute' => true],
                                ...array_map(fn($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants']),
                            ]
                            : array_map(fn($participant) => ['member_id' => $participant['id'], 'mute' => true], $mapping['participants'])),
                ],
            ]);
        }

        return 'success';
    }
}
