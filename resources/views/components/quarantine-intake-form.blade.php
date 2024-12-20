<x-form 
    class="space-y-7" 
    wire:submit="save"
    x-data="QuarantineIntakeForm"
    x-effect="maybeClearSerialNumber($wire.form.serial_number_status)"
    x-on:hermes:select-product-change="$wire.form.product_id = $event.detail.value"
    x-on:hermes:quarantine-intake-cleared.window="handleQuarantineIntakeCleared"
    x-on:submit.prevent="if ($refs.alert) $refs.alert.remove()"
>
    <x-card>
        <div class="space-y-1">
            <livewire:quarantine-intake-object :technical-supervisors="$this->technicalSupervisors" />
            <x-input-error :messages="$errors->get('form.project_or_opportunity')" />
            <x-input-error :messages="$errors->get('form.technical_supervisor')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Reference') }}</label>
            <p class="mt-2 text-xs">{{ __('The item\'s serial number is used to uniquely identify the faulty item. Do not confuse this with the item\'s model number. If the serial number has hyphens (-) or slashes (/), enter them as shown on the serial number label.') }}</p>
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
                <div class="space-y-2" x-cloak x-show="$wire.form.serial_number_status === 'serial-number-exists'">
                    <x-input
                        type="text"
                        placeholder="{{ __('Serial number') }}"
                        x-on:input="serialNumberRemainingCharacters = 256 - $wire.form.serial_number.length"
                        wire:model.blur="form.serial_number"
                    />
                    <p
                        class="text-xs font-semibold"
                        x-bind:class="{ 'text-red-500': serialNumberRemainingCharacters <= 0 }"
                        >
                        <span x-text="serialNumberRemainingCharacters"></span>
                        {!!  __('character<span x-show="serialNumberRemainingCharacters !== 1">s</span> left') !!}
                    </p>
                    <x-input-error :messages="$errors->get('form.serial_number')" />
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
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Product') }}</label>
            <p class="mt-2 text-xs">{{ __('Type the first few letters of the product and pause to let the system get info from CurrentRMS. Select the exact-match product. If the item cannot be found in this listing, double-check the spelling of the item name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.') }}</p>
            <div wire:ignore>
                <x-select-product x-on:hermes:quarantine-intake-cleared.window="clear" />
            </div>
            <x-input-error :messages="$errors->get('form.product_id')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Ready for repairs') }}</label>
            <p class="mt-2 text-xs">{{ __('Set the date this item is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty item is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.') }}</p>
            <div wire:ignore>
                <x-input type="text" x-ref="startsAt" data-next-month-max-date="{{ now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d') }}" />
            </div>
            <x-input-error :messages="$errors->get('form.starts_at')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Primary fault classification') }}</label>
            <p class="mt-2 text-xs">{{ __('Classify the type of primary fault with this item (that is, if an item has multiple reasons for submission to Quarantine, which is the most prominent / serious?)') }}</p>
            <div wire:ignore>
                <select x-ref="primaryFaultClassification">
                    <option value=""></option>
                    @foreach ($this->getClassification() as $classification)
                        <option value="{{ $classification['text'] }}" data-example="{{ $classification['example'] }}">{{ $classification['text'] }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-error :messages="$errors->get('form.classification')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Fault description') }}</label>
            <p class="mt-2 text-xs">{{ __('Enter a concise, meaningful and objective fault description. Your name will be added to this report automatically, so there\'s no need to type it here.') }}</p>
            <x-textarea
                rows="5"
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
            <x-input-error :messages="$errors->get('form.description')" />
        </div>
    </x-card>
    <div class="flex items-center justify-end gap-2">
        <x-button 
            type="button" 
            variant="outline-primary" 
            wire:loading.attr="disabled" 
            wire:target="save"
            x-on:click="clear"
        >
            {{ __('Clear form') }}
        </x-button>
        <x-button type="submit" variant="primary">
            <span wire:loading.class="hidden" wire:target="save">{{ __('Submit') }}</span>
            <span class="items-center gap-2" wire:loading.flex wire:target="save">
                <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                <span>{{ __('Submitting...') }}</span>
            </span>
        </x-button>
    </div>
    @if ($alert)
        <div @class([
            'p-4 rounded-lg',
            'bg-green-100 text-green-500' => $alert['type'] === 'success',
            'bg-red-100 text-red-500' => $alert['type'] === 'error',
        ]) x-ref="alert">
            <div class="flow">{!! $alert['message'] !!}</div>
        </div>    
    @endif
</x-form>
