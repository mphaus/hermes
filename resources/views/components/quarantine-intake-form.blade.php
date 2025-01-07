@use('Illuminate\Support\Js')

<x-form 
    class="space-y-7" 
    data-current-date="{{ now()->format('Y-m-d') }}"
    wire:submit="save"
    x-data="QuarantineIntakeForm({{ Js::from($this->technicalSupervisors) }})"
    x-effect="maybeClearSerialNumber($wire.form.serial_number_status)"
    x-on:hermes:quarantine-intake-cleared.window="handleQuarantineIntakeCleared"
    x-on:hermes:qi-select-opportunity-change="handleSelectOpportunityChange"
    x-on:submit.prevent="if ($refs.alert) $refs.alert.remove()"
>
    <x-card class="flow">
        <div class="flow">
            <label class="block font-semibold">{{ __('Opportunity') }}</label>
            <div wire:ignore>
                <x-qi-select-opportunity wire:model="form.opportunity" />
            </div>
            <x-input-error :messages="$errors->get('form.opportunity')" />
        </div>
        <div class="flow" x-cloak x-show="$wire.form.technical_supervisor">
            <label class="block font-semibold">{{ __('Technical Supervisor') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('The Technical Supervisor is specified in Opportunity in CurrentRMS and cannot be edited here.') }}</p>
            </div>
            <p x-text="technicalSupervisorName"></p>
        </div>
        <x-input-error :messages="$errors->get('form.technical_supervisor')" />
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Reference') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('The item\'s serial number is used to uniquely identify the faulty item. Do not confuse this with the item\'s model number. If the serial number has hyphens (-) or slashes (/), enter them as shown on the serial number label.') }}</p>
            </div>
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
                <div 
                    class="flex items-start gap-1" 
                    x-cloak 
                    x-show="$wire.form.serial_number_status === 'missing-serial-number'"
                >
                    <x-icon-triangle-alert class="flex-shrink-0 w-4 h-4 text-yellow-500" />
                    <p class="text-xs">
                        {{ __('This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).') }}
                    </p>
                </div>
                <div
                    class="flex items-start gap-1"
                    x-cloak
                    x-show="$wire.form.serial_number_status === 'not-serialised'"
                >
                    <x-icon-triangle-alert class="flex-shrink-0 w-4 h-4 text-yellow-500" />
                    <p class="text-xs">
                        {{ __('This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.') }}
                    </p>
                </div>
            </div>
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Product') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Type the first few letters of the product and pause to let the system get info from CurrentRMS. Select the exact-match product. If the item cannot be found in this listing, double-check the spelling of the item name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.') }}</p>
            </div>
            <div wire:ignore>
                <x-select-product wire:model="form.product_id" />
            </div>
            <x-input-error :messages="$errors->get('form.product_id')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Ready for repairs') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Set the date this item is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty item is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.') }}</p>
            </div>
            <div wire:ignore>
                <x-qi-input-starts-at wire:model="form.starts_at" />
            </div>
            <x-input-error :messages="$errors->get('form.starts_at')" />
        </div>
    </x-card>
    <x-card x-show="$wire.form.starts_at === $root.dataset.currentDate">
        <div class="flow">
            <label class="block font-semibold">{{ __('Shelf location') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs ">{{ __('Specify the shelf ID of where this fixture will be placed.') }}</p>
            </div>
            <div wire:ignore>
                <x-input
                    type="text"
                    placeholder="{{ __('Ex: A-26') }}"
                    x-mask="a-99"
                    x-on:input="$event.target.value = $event.target.value.toUpperCase()" 
                    wire:model="form.shelf_location"
                />
            </div>
            <x-input-error :messages="$errors->get('form.shelf_location')" />
        </div>
    </x-card>
    <x-card>
        <div class="flow">
            <label class="block font-semibold">{{ __('Primary fault classification') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Classify the type of primary fault with this item (that is, if an item has multiple reasons for submission to Quarantine, which is the most prominent / serious?)') }}</p>
            </div>
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
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Enter a concise, meaningful and objective fault description. Your name will be added to this report automatically, so there\'s no need to type it here.') }}</p>
            </div>
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
