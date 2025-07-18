@php
    $opportunity_query_params = [
        'per_page' => 25,
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
    wire:submit="save"
>
    <div class="space-y-1">
        <x-input-label>{{ __('Short Job or Project name') }}</x-input-label>
        <x-input type="text" wire:model="form.short_job_or_project_name" />
        <x-form-error :message="$errors->first('form.short_job_or_project_name')" />
        <p class="text-xs font-semibold">{!! __('The Short Job or Project Name selected here will appear in email Subjects for Discussions about this Job or Project. It must match the requirements in the <a href=":url" target="_blank" rel="nofollow">Process_ MPH Production 01 Quoting phase.docx</a>, and be the same as is specified in the Short Job or Project Name Discussion.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/In%20development/Process_%20MPH%20Production%2001%20Quoting%20phase.docx?d=w96250bcb65df4ee397314e534ca7e7e1&csf=1&web=1&e=j2aXB9&nav=eyJoIjoiODU3ODg4NDUwIn0']) !!}</p>
    </div>
    <div class="space-y-3">
        <x-input-label>{{ __('Specify the entity in which these discussions are being created') }}</x-input-label>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
            <div class="flex items-center gap-1">
                <input type="radio" id="opportunity" value="opportunity" wire:model="form.object_type" x-on:change="$wire.form.object_id = ''">
                <x-input-label class="cursor-pointer" for="opportunity">{{ __('Opportunity') }}</x-input-label>
            </div>
            <div class="flex items-center gap-1">
                <input type="radio" id="project" value="project" wire:model="form.object_type" x-on:change="$wire.form.object_id = ''">
                <x-input-label class="cursor-pointer" for="project">{{ __('Project') }}</x-input-label>
            </div>
        </div>
        <template hidden x-if="$wire.form.object_type === 'opportunity'">
            <div wire:ignore>
                <x-select-opportunity
                    :params="$opportunity_query_params"
                    wire:model="form.object_id"
                />
            </div>
        </template>
        <template hidden x-if="$wire.form.object_type === 'project'">
            <div wire:ignore>
                <x-select-project
                    :params="$project_query_params"
                    wire:model="form.object_id"
                />
            </div>
        </template>
        <x-form-error :message="$errors->first('form.object_id')" />
    </div>
    <div class="space-y-1">
        <x-input-label>{{ __('Account Manager (as listed as the Opportunity "Owner" in CurrentRMS)') }}</x-input-label>
        <div wire:ignore>
            <x-discussion-select-owner wire:model="form.user_id" />
        </div>
        <x-form-error :message="$errors->first('form.user_id')" />
    </div>
    <div class="flex justify-end">
        <x-button type="submit" variant="primary">
            <span wire:loading.class="hidden" wire:target="save">{{ __('Create Discussions') }}</span>
            <span class="items-center gap-2" wire:loading.flex wire:target="save">
                <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                <span>{{ __('Creating...') }}</span>
            </span>
        </x-button>
    </div>
</x-form>
