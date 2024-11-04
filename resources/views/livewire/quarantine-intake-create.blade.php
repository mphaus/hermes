<x-slot name="title">{{ __('Quarantine Intake') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Quarantine Intake') }}</span>
</x-slot>
<div class="flow">
    <x-card class="max-w-screen-md mx-auto flow">
        <p class="font-semibold">{{ __('Quarantine Intake') }}</p>
        <x-form 
            class="flow" 
            x-data="{ serialNumberRemainingCharacters: 256, descriptionRemainingCharacters: 512 }"
            wire:submit="save"
        >
            <livewire:quarantine-intake-object />
            <div class="flow">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                    <div class="flex items-center gap-1">
                        <input type="radio" id="serial-number-exists" value="serial-number-exists" wire:model="form.serial_number_status">
                        <x-input-label class="cursor-pointer" for="serial-number-exists">{{ __('Serial number') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" id="missing-serial-number" value="missing-serial-number" wire:model="form.serial_number_status">
                        <x-input-label class="cursor-pointer" for="missing-serial-number">{{ __('Missing serial number') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" id="not-serialised" value="not-serialised" wire:model="form.serial_number_status">
                        <x-input-label class="cursor-pointer" for="not-serialised">{{ __('Equipment is not serialised') }}</x-input-label>
                    </div>
                </div>
                <div class="space-y-1" x-cloak x-show="$wire.form.serial_number_status === 'serial-number-exists'">
                    <x-input
                        type="text"
                        placeholder="{{ __('Serial number') }}"
                        x-on:input="serialNumberRemainingCharacters = 256 - $wire.form.serial_number.length"
                        wire:model="form.serial_number"
                    />
                    <p 
                        class="text-xs font-semibold"
                        x-bind:class="{ 'text-red-500': serialNumberRemainingCharacters <= 0 }"
                    >
                        <span x-text="serialNumberRemainingCharacters"></span>
                        {!!  __('character<span x-show="serialNumberRemainingCharacters !== 1">s</span> left') !!}
                    </p>
                </div>
                <p 
                    class="text-xs font-semibold"
                    x-cloak
                    x-show="$wire.form.serial_number_status === 'missing-serial-number'"
                >
                    {{ __('This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).') }}
                </p>
                <p 
                    class="text-xs font-semibold"
                    x-cloak
                    x-show="$wire.form.serial_number_status === 'not-serialised'"
                >
                    {{ __('This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.') }}
                </p>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Product') }}</x-input-label>
                <select class="block w-full"></select>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Fault description') }}</x-input-label>
                <x-textarea 
                    rows="5" 
                    placeholder="{{ __('Enter a concise, meaningful and objective fault description.') }}" 
                    wire:model="form.description"
                    x-on:input="descriptionRemainingCharacters = 512 - $wire.form.description.length"
                ></x-textarea>
                <p 
                    class="text-xs font-semibold"
                    x-bind:class="{ 'text-red-500': descriptionRemainingCharacters <= 0 }"
                >
                    <span x-text="descriptionRemainingCharacters"></span>
                    {!!  __('character<span x-show="descriptionRemainingCharacters !== 1">s</span> left') !!}
                </p>
            </div>
            <div class="flex items-center justify-end gap-2">
                <x-button type="button" variant="outline-primary">{{ __('Clear form') }}</x-button>
                <x-button type="submit" variant="primary">{{ __('Submit') }}</x-button>
            </div>
        </x-form>
    </x-card>
</div>
