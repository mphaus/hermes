<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDiscussionMappings extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    public string $comments;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:1024', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:json', message: 'The file must be a file of type: :values.')]
    public $jsonfile;

    public function save()
    {
        $this->validate();
    }

    public function render(): View
    {
        return view('livewire.upload-discussion-mappings');
    }
}
