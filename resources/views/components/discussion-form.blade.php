@use('App\Enums\JobStatus')
@use('App\Enums\JobState')

@php
    $opportunity_query_params = [
        'per_page' => 25,
        'q[status_in]' => [JobStatus::Reserved->value, JobStatus::Open->value, JobStatus::Provisional->value],
        'q[state_in]' => [JobState::Quotation->value, JobState::Order->value],
        'q[subject_cont]' => '?',
    ];

    $project_query_params = [
        'per_page' => 20,
        'filtermode' => 'active',
        'q[s]' => ['starts_at+desc'],
        'q[name_cont]' => '?',
    ];
@endphp

<x-form 
    class="space-y-8"
    x-data="DiscussionForm"
    x-on:submit.prevent="send"
>
    <div class="space-y-1">
        <x-input-label>{{ __('Short Job or Project name') }}</x-input-label>
        <x-input type="text" x-model="form.short_job_or_project_name" />
        <template hidden x-if="errors.short_job_or_project_name">
            <p class="text-sm text-red-600" x-text="errors.short_job_or_project_name"></p>
        </template>
        <p class="text-xs font-semibold">{!! __('The Short Job or Project Name selected here will appear in email Subjects for Discussions about this Job or Project. It must match the requirements in the <a href=":url" target="_blank" rel="nofollow">Process_ MPH Production 01 Quoting phase.docx</a>, and be the same as is specified in the Short Job or Project Name Discussion.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/In%20development/Process_%20MPH%20Production%2001%20Quoting%20phase.docx?d=w96250bcb65df4ee397314e534ca7e7e1&csf=1&web=1&e=j2aXB9&nav=eyJoIjoiODU3ODg4NDUwIn0']) !!}</p>
    </div>
    <div class="space-y-3">
        <x-input-label>{{ __('Specify the entity in which these discussions are being created') }}</x-input-label>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
            <div class="flex items-center gap-1">
                <input type="radio" id="opportunity" value="opportunity" x-model="form.object_type" x-on:change="form.object_id = 0">
                <x-input-label class="cursor-pointer" for="opportunity">{{ __('Opportunity') }}</x-input-label>
            </div>
            <div class="flex items-center gap-1">
                <input type="radio" id="project" value="project" x-model="form.object_type" x-on:change="form.object_id = 0">
                <x-input-label class="cursor-pointer" for="project">{{ __('Project') }}</x-input-label>
            </div>
        </div>
        <template hidden x-if="form.object_type === 'opportunity'">
            <x-select-opportunity 
                :params="$opportunity_query_params"
                x-model="form.object_id"
            />
        </template>
        <template hidden x-if="form.object_type === 'project'">
            <x-select-project 
                :params="$project_query_params"
                x-model="form.object_id"
            />
        </template>
        <template hidden x-if="errors.object_id">
            <p class="text-sm text-red-600" x-text="errors.object_id"></p>
        </template>
    </div>
    <div class="space-y-1">
        <x-input-label>{{ __('Account Manager (as listed as the Opportunity "Owner" in CurrentRMS)') }}</x-input-label>
        <x-discussion-select-owner x-model="form.user_id" />
        <template hidden x-if="errors.user_id">
            <p class="text-sm text-red-600" x-text="errors.user_id"></p>
        </template>
    </div>
    <div class="flex justify-end">
        <x-button type="submit" variant="primary" x-bind:disabled="submitting">
            <span x-show="!submitting">{{ __('Create Discussions') }}</span>
            <span x-show="submitting">{{ __('Creating...') }}</span>
        </x-button>
    </div>
    <div class="mt-6 text-sm" x-show="submitting">
        <p class="font-semibold">{{ __('Processing...') }}</p>
        <p class="mt-1">{{ __('This process typically takes less than 40 seconds. Do not navigate away from this page until a Success or Fail message is shown here.') }}</p>
    </div>
</x-form>
