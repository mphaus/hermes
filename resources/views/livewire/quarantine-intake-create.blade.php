<x-slot name="title">{{ __('Quarantine Intake') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Quarantine Intake') }}</span>
</x-slot>
<div class="flow">
    <x-card class="max-w-screen-md mx-auto flow">
        <p class="font-semibold">{{ __('Quarantine Intake') }}</p>
        <x-form class="flow">
            <div class="space-y-1">
                <x-input-label>{{ __('Opportunity or Project') }}</x-input-label>
                <select class="block w-full"></select>
            </div>
            <div class="flow">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                    <div class="flex items-center gap-1">
                        <input type="radio" name="" id="">
                        <x-input-label>{{ __('Serial number') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" name="" id="">
                        <x-input-label>{{ __('Missing serial number') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" name="" id="">
                        <x-input-label>{{ __('Equipment is not serialised') }}</x-input-label>
                    </div>
                </div>
                <x-input type="text" placeholder="{{ __('Serial number') }}"></x-input>
                <p class="text-xs font-semibold">{{ __('This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).') }}</p>
                <p class="text-xs font-semibold">{{ __('This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.') }}</p>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Product') }}</x-input-label>
                <select class="block w-full"></select>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Fault description') }}</x-input-label>
                <x-textarea rows="5"></x-textarea>
                <p class="text-xs font-semibold">{{ __('Enter a concise, meaningful and objective fault description.') }}</p>
            </div>
            <div class="flex items-center justify-end gap-2">
                <x-button type="button" variant="outline-primary">{{ __('Clear form') }}</x-button>
                <x-button type="submit" variant="primary">{{ __('Submit') }}</x-button>
            </div>
        </x-form>
    </x-card>
</div>
