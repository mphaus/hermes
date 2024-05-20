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
        <x-card class="flow">
            <p class="font-semibold">{{ __('Create Discussions') }}</p>
            <form class="flex flex-col gap-4 lg:flex-row lg:items-end">
                <div class="space-y-1 lg:flex-1">
                    <x-input-label value="{{ __('Opportunity') }}" class="!text-xs" />
                    <select name="" id="" class="block w-full"></select>
                </div>
                <div class="space-y-1 lg:flex-1">
                    <x-input-label value="{{ __('Owner') }}" class="!text-xs" />
                    <select name="" id="" class="block w-full"></select>
                </div>
                <x-button type="submit" variant="primary">{{ __('Create Discussions') }}</x-button>
            </form>
        </x-card>
        <x-card class="flow">
            <p class="font-semibold">{{ __('Default user mapping') }}</p>
            <p class="text-sm">{{ __('Once the Opportunity Owner is selected above, this panel shows who will be assigned to each Discussion, based on the default assigned users. After the Discussion is created with default users, users can be added and removed from individual Discussions in this Opportunity in CurrentRMS as necessary.') }}</p>
            <p class="text-sm">{!! __('If there\'s a permanent change to who should be assigned to every Discussion created using this tool in the future (for example, a staff member joins or leaves the company), the default mappings can be edited on the <a href=":url" title=":title" wire:navigate>Edit default Discussions</a> page.', ['url' => route('discussions.edit'), 'title' => __('Edit default Discussions')]) !!}</p>
            <x-discussions-user-mapping-table class="mt-8" />
        </x-card>
    @endif
</div>
