<?php

namespace App\Livewire;

use App\Models\DiscussionMapping;
use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDiscussionMappings extends Component
{
    use WithFileUploads;
    use WithHttpCurrentError;

    #[Validate('required')]
    public string $comments;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:1024', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:json', message: 'The file must be a file of type: :values.')]
    public $jsonfile;

    public function save(): mixed
    {
        if (!usercan('update-default-discussions')) {
            abort(403);
        }

        $this->validate();

        $filename = $this->jsonfile->store();
        $mappings = Storage::json($filename);

        $mappingsValidator = Validator::make($mappings, [
            '*' => Rule::forEach(function (array $value, string $attribute) {
                $includeOpportunityOwnerAsParticipant = $value['include_opportunity_owner_as_participant'];

                return [
                    'title' => 'required',
                    'first_message' => 'required',
                    'include_opportunity_owner_as_participant' => 'required|boolean',
                    'participants' => ['array', Rule::requiredIf(fn() => $includeOpportunityOwnerAsParticipant === false)],
                    'participants.*.id' => ['numeric', Rule::requiredIf(fn() => $includeOpportunityOwnerAsParticipant === false)],
                    'participants.*.full_name' => Rule::requiredIf(fn() => $includeOpportunityOwnerAsParticipant === false),
                ];
            }),
        ]);

        if ($mappingsValidator->fails()) {
            foreach ($mappingsValidator->getMessageBag()->unique() as $message) {
                $this->addError('jsonfile', $message);
            }

            return null;
        }

        $participantsIds = array_unique(Arr::flatten(array_reduce($mappings, function ($carry, $mapping) {
            if (empty($mapping['participants']) === false) {
                $carry[] = array_map(fn($participant) => $participant['id'], $mapping['participants']);
            }

            return $carry;
        }, [])));

        $queryParams = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'q[active_eq]' => true,
            'q[id_in]' => $participantsIds,
        ])));

        $response = Http::current()->get("members?{$queryParams}");

        if ($response->failed()) {
            $this->addError('jsonfile', $this->errorMessage(__('An unexpected error occurred while ingesting the JSON file. Please refresh the page and try again.'), $response->json()));
            return null;
        }

        ['members' => $members] = $response->json();

        $memberIds = array_map(fn($member) => $member['id'], $members);
        $diffIds = array_diff($participantsIds, $memberIds);

        if (empty($diffIds) === false) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => __('The ingestion process failed.'),
            ]);

            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The ingestion failed. Either the JSON is not valid, or the users do not match those listed in CurrentRMS.')
            ]);

            return $this->redirectRoute(name: 'discussions.edit');
        }

        $discussionMapping = new DiscussionMapping;

        $discussionMapping->comments = $this->comments;
        $discussionMapping->mappings = $mappings;
        $discussionMapping->user()->associate(Auth::user());
        $discussionMapping->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The ingestion succeeded.'),
        ]);

        session()->flash('message-alert', [
            'type' => 'success',
            'title' => __('Success'),
            'message' => __('Discussions JSON template changes appear valid. Subsequent Discussions created will be based on this new JSON file. A test is recommended before assuming it\'s correct.')
        ]);

        return $this->redirectRoute(name: 'discussions.edit');
    }

    public function render(): View
    {
        return view('livewire.upload-discussion-mappings');
    }
}
