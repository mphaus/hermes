@use('App\Enums\JobStatus')
@use('Illuminate\Support\Js')

@php
    $opportunity_query_params = [
        'per_page' => 25,
        'q[status_eq]' => JobStatus::Reserved->value,
        'q[subject_cont]' => '?'
    ];
@endphp

<x-form 
    class="space-y-7" 
    data-current-date="{{ now()->format('Y-m-d') }}"
    wire:submit="save"
    x-data="QuarantineIntakeForm({{ Js::from($this->technicalSupervisors) }})"
    x-effect="maybeClearSerialNumber($wire.form.serial_number_status)"
    x-on:hermes:select-opportunity-change="handleSelectOpportunityChange"
    x-on:submit.prevent="if ($refs.alert) $refs.alert.remove()"
>
    <x-card class="px-8 flow">
        <div class="flow">
            <label class="block font-semibold">{{ __('Opportunity') }}</label>
            <div class="space-y-3">
                <x-input-label>{{ __('Specify the Job this item was identified as faulty on') }}</x-input-label>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                    <div class="flex items-center gap-1">
                        <input type="radio" id="production-lighting-hire" value="production-lighting-hire" wire:model="form.opportunity_type" x-on:change="$wire.form.technical_supervisor = null">
                        <x-input-label class="cursor-pointer" for="production-lighting-hire">{{ __('A Production Lighting Hire Job') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" id="dry-hire" value="dry-hire" wire:model="form.opportunity_type" x-on:change="$wire.form.technical_supervisor = null">
                        <x-input-label class="cursor-pointer" for="dry-hire">{{ __('A Dry Hire Job') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" id="not-associated" value="not-associated" wire:model="form.opportunity_type" x-on:change="$wire.form.technical_supervisor = null">
                        <x-input-label class="cursor-pointer" for="not-associated">{{ __('Not associated with a Job') }}</x-input-label>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex items-start gap-1 mt-2" x-show="$wire.form.opportunity_type === 'production-lighting-hire'">
                    <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                    <p class="text-xs">{{ __('Enter a few letters from the name of the Job and select from the shortlist.') }}</p>
                </div>
                <div class="flex items-start gap-1 mt-2" x-show="$wire.form.opportunity_type === 'dry-hire'" x-cloak>
                    <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                    <p class="text-xs">{{ __('Enter the Quote number from the Picking List for this Job (shown at the top of the first page of the Picking List).') }}</p>
                </div>
                <div class="flex items-start gap-1 mt-2" x-show="$wire.form.opportunity_type === 'not-associated'" x-cloak>
                    <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                    <div class="space-y-2">
                        <p class="text-xs">{{ __('Allocating faulty equipment to Jobs is always best, but sometimes faults are identified outside of a Job. Some examples include;') }}</p>
                        <ul class="pl-5 space-y-1 text-xs list-disc">
                            <li>{{ __('The correct Job name cannot be found and allocated') }}</li>
                            <li>{{ __('This fault was discovered after the item had been de-prepped') }}</li>
                            <li>{{ __('This fault was discovered while being Picked for a Job') }}</li>
                            <li>{{ __('This fault was discovered during Prep (that is, before the equipment was loaded onto a truck)') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <template hidden x-if="$wire.form.opportunity_type === 'production-lighting-hire'">
                <div class="relative">
                    @if (!empty($this->form->opportunity) && !$errors->has('form.opportunity'))
                        <x-icon-square-check 
                            class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                            data-element="square-check-icon"
                        />    
                    @endif
                    <div wire:ignore>
                        <x-select-opportunity
                            :params="$opportunity_query_params"
                            wire:model.live="form.opportunity" 
                        />
                    </div>
                </div>
            </template>
            <template hidden x-if="$wire.form.opportunity_type === 'dry-hire'">
                <div class="relative">
                    @if (!empty($this->form->opportunity) && !$errors->has('form.opportunity'))
                        <x-icon-square-check 
                            class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                            data-element="square-check-icon"
                        />    
                    @endif
                    <div wire:ignore>
                        <x-qi-select-dry-hire-opportunity wire:model.live="form.opportunity" />
                    </div>
                </div>
            </template>
            <x-input-error :messages="$errors->first('form.opportunity')" />
        </div>
        <template hidden x-if="$wire.form.technical_supervisor && $wire.form.opportunity_type === 'production-lighting-hire'">
            <div class="flow">
                <label class="block font-semibold">{{ __('Technical Supervisor') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                    <p class="text-xs">{{ __('The Technical Supervisor is specified in Opportunity in CurrentRMS and cannot be edited here.') }}</p>
                </div>
                <p x-text="technicalSupervisorName"></p>
            </div>
        </template>
        <x-input-error :messages="$errors->first('form.technical_supervisor')" />
    </x-card>
    <x-card class="px-8">
        <div class="flow">
            <label class="block font-semibold">{{ __('Product') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Type the first few letters of the product and pause to let the system get info from CurrentRMS. Select the exact-match product. If the item cannot be found in this listing, double-check the spelling of the item name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.') }}</p>
            </div>
            <div class="relative">
                @if (!empty($this->form->product_id) && !$errors->has('form.product_id'))
                    <x-icon-square-check 
                        class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                        data-element="square-check-icon"
                    />    
                @endif
                <div wire:ignore>
                    <x-select-product wire:model.live="form.product_id" />
                </div>
            </div>
            <x-input-error :messages="$errors->first('form.product_id')" />
        </div>
    </x-card>
    <x-card class="px-8">
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
                        <input type="radio" id="missing-serial-number" value="missing-serial-number" wire:model="form.serial_number_status" x-on:change="removeSquareCheckIcon('#serial-number-square-check-icon')">
                        <x-input-label class="cursor-pointer" for="missing-serial-number">{{ __('Missing serial number') }}</x-input-label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="radio" id="not-serialised" value="not-serialised" wire:model="form.serial_number_status" x-on:change="removeSquareCheckIcon('#serial-number-square-check-icon')">
                        <x-input-label class="cursor-pointer" for="not-serialised">{{ __('Equipment is not serialised') }}</x-input-label>
                    </div>
                </div>
                <div class="space-y-2" x-cloak x-show="$wire.form.serial_number_status === 'serial-number-exists'">
                    <div class="relative">
                        @if (!empty($this->form->serial_number) && !$errors->has('form.serial_number'))
                            <x-icon-square-check 
                                class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                                id="serial-number-square-check-icon"
                                data-element="square-check-icon"
                            />    
                        @endif
                        <x-input
                            type="text"
                            placeholder="{{ __('Serial number') }}"
                            x-on:input="serialNumberRemainingCharacters = 256 - $event.target.value.length"
                            wire:model.blur="form.serial_number"
                        />
                    </div>
                    <p
                        class="text-xs font-semibold"
                        x-bind:class="{ 'text-red-500': serialNumberRemainingCharacters <= 0 }"
                    >
                        <span x-text="serialNumberRemainingCharacters"></span>
                        {!!  __('character<span x-show="serialNumberRemainingCharacters !== 1">s</span> left') !!}
                    </p>
                    <x-input-error :messages="$errors->first('form.serial_number')" />
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
    <x-card class="px-8">
        <div class="flow">
            <label class="block font-semibold">{{ __('Ready for repairs') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Set the date this item is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty item is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.') }}</p>
            </div>
            <div class="relative">
                @if (!empty($this->form->starts_at) && !$errors->has('form.starts_at'))
                    <x-icon-square-check class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" />    
                @endif
                <div wire:ignore>
                    <x-qi-input-starts-at wire:model.live="form.starts_at" />
                </div>
            </div>
            <x-input-error :messages="$errors->first('form.starts_at')" />
        </div>
    </x-card>
    <x-card class="px-8" x-show="$wire.form.starts_at === $root.dataset.currentDate">
        <div class="flow">
            <label class="block font-semibold">{{ __('Intake location') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs ">{{ __('Specify the shelf ID of where this fixture will be placed.') }}</p>
            </div>
            <div class="relative">
                @if (!empty($this->form->intake_location) && !$errors->has('form.intake_location'))
                    <x-icon-square-check 
                        class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                        data-element="square-check-icon"
                    />    
                @endif
                <div wire:ignore>
                    <x-input
                        type="text"
                        placeholder="{{ __('Ex: A-26') }}"
                        x-mask="a-99"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                        wire:model.blur="form.intake_location"
                    />
                </div>
            </div>
            <x-input-error :messages="$errors->first('form.intake_location')" />
        </div>
    </x-card>
    <x-card class="px-8">
        <div class="flow">
            <label class="block font-semibold">{{ __('Primary fault classification') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Classify the type of primary fault with this item (that is, if an item has multiple reasons for submission to Quarantine, which is the most prominent / serious?)') }}</p>
            </div>
            <div class="relative">
                @if (!empty($this->form->classification) && !$errors->has('form.classification'))
                    <x-icon-square-check 
                        class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" 
                        data-element="square-check-icon"
                    />    
                @endif
                <div wire:ignore>
                    <x-qi-select-primary-fault-classification wire:model.live="form.classification" />
                </div>
            </div>
            <x-input-error :messages="$errors->first('form.classification')" />
        </div>
    </x-card>
    <x-card class="px-8">
        <div class="flow">
            <label class="block font-semibold">{{ __('Fault description') }}</label>
            <div class="flex items-start gap-1 mt-2">
                <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
                <p class="text-xs">{{ __('Enter a concise, meaningful and objective fault description.') }}</p>
            </div>
            <div class="relative">
                @if (!empty($this->form->description) && !$errors->has('form.description'))
                    <x-icon-square-check 
                        class="absolute w-5 h-5 -translate-x-full fill-green-500 -left-1 top-1" 
                        data-element="square-check-icon"
                    />    
                @endif
                <div wire:ignore>
                    <x-textarea
                        rows="5"
                        wire:model.blur="form.description"
                        x-on:input="descriptionRemainingCharacters = 512 - $event.target.value.length"
                    ></x-textarea>
                </div>
            </div>
            <p
                class="text-xs font-semibold"
                x-bind:class="{ 'text-red-500': descriptionRemainingCharacters <= 0 }"
            >
                <span x-text="descriptionRemainingCharacters"></span>
                {!!  __('character<span x-show="descriptionRemainingCharacters !== 1">s</span> left') !!}
            </p>
            <div class="space-y-2 text-xs">
                <p>{{ __('Other considerations') }}</p>
                <ul>
                    <li>{{ __('➡️ Your name will be added to this report automatically, so there\'s no need to add it here.') }}</li>
                    <li>{{ __('➡️ Mention if the correct Job name could not be assigned, and why') }}</li>
                    <li>{{ __('➡️ Mention if a serial number collision 💥 was reported, and what you did about it.') }}</li>
                </ul>
            </div>
            <x-input-error :messages="$errors->first('form.description')" />
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
        <x-button 
            type="submit" 
            variant="primary"
            wire:loading.attr="disabled" 
            wire:target="save"
        >
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
