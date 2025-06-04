<x-layout-app>
    <x-slot:title>{{ __('Create CurrentRMS Discussions') }}</x-slot:title>
    <x-slot:heading>
        <span>{{ __('Create CurrentRMS Discussions') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('This tool is used to add a set of templated Discussions to the selected Opportunity in CurrentRMS. Default People will be assigned to each Discussion (but can be adjusted later). This tool is used by the Account Manager in the Quoting phase of the MPH Production process.') }}</span>
    </x-slot:heading>
    @if (!$config)
        <x-card>
            <p class="text-sm">{!! __('No default Discussion mappings are currently found. To proceed, please create a new set on the <a href=":url" title=":title">Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
        </x-card>
    @else
        <x-card class="max-w-(--breakpoint-md) mx-auto space-y-4">
            <p class="font-semibold">{{ __('Create Discussions') }}</p>
            <x-discussion-form />
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
            <p class="text-sm">{!! __('If there\'s a permanent change to who should be assigned to every Discussion created using this tool in the future (for example, a staff member joins or leaves the company), the default mappings can be edited on the <a href=":url" title=":title">Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
            <x-discussions-user-mapping-table class="mt-8" :mappings="$config->mappings" />
        </x-card>
    @endif
</x-layout-app>
