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
        $create_on_project = $this->form->object_type === 'project';

        if ($result !== null) {
            $message = match ($result) {
                'PARTICIPANTS_CHECK_FAILED' => __('The Discussions creation failed with this message: an error occurred while checking the existence of the participants. Please try again.'),
                'PARTICIPANTS_VALIDATION_FAILED' => __('The Discussions creation failed with this message: the participants do not match those listed in CurrentRMS.'),
                'DISCUSSIONS_EXISTANCE_CHECK_FAILED' => fn() => __('The Discussions creation failed with this message: an error occurred while checking if discussions already exist on the selected :object. Please try again.', ['object' => $create_on_project ? 'Project' : 'Opportunity']),
                default => '',
            };

            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => $message,
            ]);

            return $this->redirectRoute(name: 'discussions.create');
        }

        $object_id = App::environment(['local', 'staging'])
            ? (
                $create_on_project
                ? intval(config('app.mph.test_project_id'))
                : intval(config('app.mph.test_opportunity_id'))
            )
            : $this->form->object_id;

        $response = $create_on_project ? Http::current()->get("projects/{$object_id}") : Http::current()->get("opportunities/{$object_id}");

        if ($response->failed()) {
            $message = $create_on_project ? __('Discussions have been added to the Project in CurrentRMS.') : __('Discussions have been added to the Opportunity in CurrentRMS.');
        } else {
            $result = $response->json();
            $message = $create_on_project
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

        return $this->redirectRoute(name: 'discussions.create');
    }

    public function render(): View
    {
        return view('livewire.discussions-create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }
}
