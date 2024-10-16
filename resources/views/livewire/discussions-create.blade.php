<x-slot name="title">{{ __('Create CurrentRMS Discussions') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Create CurrentRMS Discussions') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('This tool is used to add a set of templated Discussions to the selected Opportunity in CurrentRMS. Default People will be assigned to each Discussion (but can be adjusted later). This tool is used by the Account Manager in the Quoting phase of the MPH Production process.') }}</span>
</x-slot>
<div class="flow">
    @if ($config === null)
        <x-card>
            <p class="text-sm">{!! __('No default Discussion mappings are currently found. To proceed, please create a new set on the <a href=":url" title=":title" wire:navigate>Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
        </x-card>
    @else
        <x-card class="max-w-screen-md mx-auto flow">
            <p class="font-semibold">{{ __('Create Discussions') }}</p>
            <form class="space-y-8" wire:submit="save">
                <div class="space-y-1">
                    <x-input-label>{{ __('Short Job or Project name') }}</x-input-label>
                    <x-input type="text" wire:model="form.shortJoborProjectName" />
                    <x-input-error :messages="$errors->get('form.shortJoborProjectName')" />
                    <p class="text-xs font-semibold">{!! __('The Short Job or Project Name selected here will appear in email Subjects for Discussions about this Job or Project. It must match the requirements in the <a href=":url" target="_blank" rel="nofollow">Process_ MPH Production 01 Quoting phase.docx</a>, and be the same as is specified in the Short Job or Project Name Discussion.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/In%20development/Process_%20MPH%20Production%2001%20Quoting%20phase.docx?d=w96250bcb65df4ee397314e534ca7e7e1&csf=1&web=1&e=j2aXB9&nav=eyJoIjoiODU3ODg4NDUwIn0']) !!}</p>
                </div>
                <div class="space-y-2 lg:col-span-2">
                    <div class="flex items-center gap-2">
                        <x-input-checkbox 
                            id="discussions-project-check" 
                            wire:model="form.createOnProject" 
                            x-on:change="$dispatch('hermes:create-discussions-create-on-project-change', { createOnProject: $event.target.checked })"
                        />
                        <x-input-label for="discussions-project-check" value="{{ __('Create Discussions on Project instead') }}" class="!text-xs font-semibold" />
                    </div>
                    <livewire:create-discussions-object />
                    <x-input-error :messages="$errors->get('form.objectId')" />
                </div>
                <div class="space-y-1 lg:col-span-2">
                    <livewire:create-discussions-owner lazy />
                    <x-input-error :messages="$errors->get('form.userId')" />
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
            </form>
            <div class="mt-6 text-sm" wire:loading wire:target="save">
                <p class="font-semibold">{{ __('Processing...') }}</p>
                <p class="mt-1">{{ __('This process typically takes less than 40 seconds. Do not navigate away from this page until a Success or Fail message is shown here.') }}</p>
            </div>
            @if (session('message-alert'))
                <x-message-alert class="mt-6" :alert="session('message-alert')" wire:loading.class="hidden" wire:target="save" />
            @endif
        </x-card>
        <x-card 
            class="flow"
            x-data="{ owner: '' }"
            x-cloak
            x-show="owner"
            x-on:hermes:create-discussions-owner-change.window="owner = $event.detail.owner"
        >
            <p class="font-semibold">{{ __('Default user mapping') }}</p>
            <p class="text-sm">{{ __('Once the Opportunity Owner is selected above, this panel shows who will be assigned to each Discussion, based on the default assigned users. After the Discussion is created with default users, users can be added and removed from individual Discussions in this Opportunity in CurrentRMS as necessary.') }}</p>
            <p class="text-sm">{!! __('If there\'s a permanent change to who should be assigned to every Discussion created using this tool in the future (for example, a staff member joins or leaves the company), the default mappings can be edited on the <a href=":url" title=":title" wire:navigate>Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
            <x-discussions-user-mapping-table class="mt-8" :mappings="$config->mappings" />
        </x-card>
    @endif
</div>
