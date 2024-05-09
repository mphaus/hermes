<x-slot name="title">{{ __('Create CurrentRMS Discussions') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Create CurrentRMS Discussions') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('This tool is used to add a set of templated Discussions to the selected Opportunity in CurrentRMS. Default People will be assigned to each Discussion (but can be adjusted later). This tool is used by the Account Manager in the Quoting phase of the MPH Production process.') }}</span>
</x-slot>
<div>
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
</div>
