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
                'message' => __('The Discussions creation failed with this message: an error occurred while checking the existence of the participants. Please refresh the page and try again.'),
            ]);
        }

        if ($result === 'participants-validation-failed') {
            session()->flash('message-alert', [
                'type' => 'danger',
                'title' => __('Fail'),
                'message' => __('The Discussions creation failed with this message: the participants do not match those listed in CurrentRMS.'),
            ]);
        }

        if ($result === 'success') {
            $opportunityId = App::environment(['local', 'staging']) ? intval(config('app.mph.test_opportunity_id')) : $this->form->opportunityId;
            $response = Http::current()->get("opportunities/{$opportunityId}");

            if ($response->failed()) {
                $message = __('Discussions have been added to the Opportunity in CurrentRMS.');
            } else {
                ['opportunity' => $opportunity] = $response->json();
                $message = __('Discussions have been added to the Opportunity in CurrentRMS. Check to make sure they are as-expected: <a href=":url" title=":subject" class="font-semibold" target="_blank">:subject</a>.', ['url' => "https://mphaustralia.current-rms.com/opportunities/{$opportunity['id']}", 'subject' => $opportunity['subject']]);
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
