<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDiscussionMappings extends Component
{
    use WithFileUploads;

    // #[Validate('required')]
    public string $comments;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:1024', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:json', message: 'The file must be a file of type: :values.')]
    public $jsonfile;

    public function save()
    {
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
                    'participants' => ['array', Rule::requiredIf(fn () => $includeOpportunityOwnerAsParticipant === false)],
                    'participants.*.id' => ['numeric', Rule::requiredIf(fn () => $includeOpportunityOwnerAsParticipant === false)],
                    'participants.*.full_name' => Rule::requiredIf(fn () => $includeOpportunityOwnerAsParticipant === false),
                ];
            }),
        ]);

        dd($mappingsValidator->fails());
    }

    public function render(): View
    {
        return view('livewire.upload-discussion-mappings');
    }
}
