<x-slot:title>{{ __('Create CurrentRMS Discussions') }}</x-slot:title>
<x-slot:heading>
    <span>{{ __('Create CurrentRMS Discussions') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('This tool is used to add a set of templated Discussions to the selected Opportunity in CurrentRMS. Default People will be assigned to each Discussion (but can be adjusted later). This tool is used by the Account Manager in the Quoting phase of the MPH Production process.') }}</span>
</x-slot:heading>
<div class="flow">
    @if ($config === null)
        <x-card>
            <p class="text-sm">{!! __('No default Discussion mappings are currently found. To proceed, please create a new set on the <a href=":url" title=":title">Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
        </x-card>
    @else
        <x-card class="max-w-(--breakpoint-md) mx-auto flow">
            <p class="font-semibold">{{ __('Create Discussions') }}</p>
            <x-discussion-form />
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
            x-on:hermes:discussion-select-owner-change.window="owner = $event.detail.owner.name"
        >
            <p class="font-semibold">{{ __('Default user mapping') }}</p>
            <p class="text-sm">{{ __('Once the Opportunity Owner is selected above, this panel shows who will be assigned to each Discussion, based on the default assigned users. After the Discussion is created with default users, users can be added and removed from individual Discussions in this Opportunity in CurrentRMS as necessary.') }}</p>
            <p class="text-sm">{!! __('If there\'s a permanent change to who should be assigned to every Discussion created using this tool in the future (for example, a staff member joins or leaves the company), the default mappings can be edited on the <a href=":url" title=":title">Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
            <x-discussions-user-mapping-table class="mt-8" :mappings="$config->mappings" />
        </x-card>
    @endif
</div>
