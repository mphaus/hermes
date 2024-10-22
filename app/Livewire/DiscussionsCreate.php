<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateDiscussionsForm;
use App\Models\DiscussionMapping;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DiscussionsCreate extends Component
{
    public CreateDiscussionsForm $form;

    public function save()
    {
        if (!usercan('create-default-discussions')) {
            abort(403);
        }

        $result = $this->form->store();

        if ($result !== 'success') {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => __('The Discussions creation process failed.'),
            ]);
        }

        if ($result === 'participants-check-failed') {
            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: an error occurred while checking the existence of the participants. Please try again.'),
            ]);
        }

        if ($result === 'participants-validation-failed') {
            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: the participants do not match those listed in CurrentRMS.'),
            ]);
        }

        if ($result === 'discussions-existance-check-failed') {
            $object = $this->form->createOnProject ? 'Project' : 'Opportunity';

            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: an error occurred while checking if discussions already exist on the selected :object. Please try again.', ['object' => $object]),
            ]);
        }

        if ($result === 'success') {
            $objectId = App::environment(['local', 'staging'])
                ? (
                    $this->form->createOnProject
                    ? intval(config('app.mph.test_project_id'))
                    : intval(config('app.mph.test_opportunity_id'))
                )
                : $this->form->objectId;
            $response = $this->form->createOnProject ? Http::current()->get("projects/{$objectId}") : Http::current()->get("opportunities/{$objectId}");

            if ($response->failed()) {
                $message = $this->form->createOnProject ? __('Discussions have been added to the Project in CurrentRMS.') : __('Discussions have been added to the Opportunity in CurrentRMS.');
            } else {
                $result = $response->json();
                $message = $this->form->createOnProject
                    ? __('Discussions have been added to the Project in CurrentRMS. Check to make sure they are as-expected: <a href=":url" title=":subject" class="font-semibold" target="_blank">:subject</a>.', ['url' => "https://mphaustralia.current-rms.com/projects/{$result['project']['id']}", 'subject' => $result['project']['name']])
                    : __('Discussions have been added to the Opportunity in CurrentRMS. Check to make sure they are as-expected: <a href=":url" title=":subject" class="font-semibold" target="_blank">:subject</a>.', ['url' => "https://mphaustralia.current-rms.com/opportunities/{$result['opportunity']['id']}", 'subject' => $result['opportunity']['subject']]);
            }

            session()->flash('alert', [
                'type' => 'success',
                'message' => __('Discussions have been created.'),
            ]);

            session()->flash('message-alert', [
                'type' => 'success',
                'title' => __('Success!'),
                'message' => $message,
            ]);
        }

        return $this->redirectRoute(name: 'discussions.create', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.discussions-create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }
}
