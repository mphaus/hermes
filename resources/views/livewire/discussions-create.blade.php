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
            <form class="flex flex-col gap-4 lg:flex-row lg:items-end" wire:submit="save">
                <div class="space-y-1 lg:flex-1">
                    <livewire:create-discussions-opportunity lazy />
                    <x-input-error class="mt-2" :messages="$errors->get('form.opportunityId')" />
                </div>
                <div class="space-y-1 lg:flex-1">
                    <livewire:create-discussions-owner lazy />
                    <x-input-error class="mt-2" :messages="$errors->get('form.userId')" />
                </div>
                <x-button type="submit" variant="primary">
                    <span wire:loading.class="hidden" wire:target="save">{{ __('Create Discussions') }}</span>
                    <span class="items-center gap-2" wire:loading.flex wire:target="save">
                        <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                        <span>{{ __('Creating Discussions...') }}</span>
                    </span>
                </x-button>
            </form>
            <div class="mt-6 text-sm" wire:loading wire:target="save">
                <p class="font-semibold">{{ __('Processing...') }}</p>
                <p class="mt-1">{{ __('This process typically takes ???. Do not navigate away from this page until a Success or Fail message is shown here.') }}</p>
            </div>
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
