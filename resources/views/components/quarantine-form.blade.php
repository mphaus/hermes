@use('App\Enums\JobStatus')

@php
    $opportunity_query_params = [
        'per_page' => 25,
        'q[status_eq]' => JobStatus::Reserved->value,
        'q[subject_cont]' => '?'
    ];
@endphp

<div class="space-y-4">
    <p class="font-semibold">{{ __('Quarantine Intake') }}</p>
    <x-form
        class="space-y-7"
        data-current-date="{{ now()->format('Y-m-d') }}"
        data-technical-supervisor-not-yet-assigned-id="{{ config('app.mph.technical_supervisor_not_yet_assigned_id') }}"
        x-data="QuarantineForm"
        x-on:hermes:select-opportunity-change="handleSelectOpportunityChange"
        x-on:submit.prevent="send"
    >
        <x-card class="px-8 space-y-4">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Opportunity') }}</label>
                <div class="space-y-3">
                    <x-input-label>{{ __('Specify the Job this Product was identified as faulty on') }}</x-input-label>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div class="flex items-center gap-1">
                            <input type="radio" id="production-lighting-hire" value="production-lighting-hire" x-model="form.opportunity_type" x-on:change="handleOpportunityTypeChange">
                            <x-input-label class="cursor-pointer" for="production-lighting-hire">{{ __('A Production Lighting Hire Job') }}</x-input-label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" id="dry-hire" value="dry-hire" x-model="form.opportunity_type" x-on:change="handleOpportunityTypeChange">
                            <x-input-label class="cursor-pointer" for="dry-hire">{{ __('A Dry Hire Job') }}</x-input-label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" id="not-associated" value="not-associated" x-model="form.opportunity_type" x-on:change="handleOpportunityTypeChange">
                            <x-input-label class="cursor-pointer" for="not-associated">{{ __('Not associated with a Job') }}</x-input-label>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-start gap-1 mt-2" x-show="form.opportunity_type === 'production-lighting-hire'">
                        <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                        <p class="text-xs">{{ __('Enter a few letters from the name of the Job and select from the shortlist.') }}</p>
                    </div>
                    <div class="flex items-start gap-1 mt-2" x-show="form.opportunity_type === 'dry-hire'" x-cloak>
                        <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                        <p class="text-xs">{{ __('Enter the Quote number from the Picking List for this Job (shown at the top of the first page of the Picking List).') }}</p>
                    </div>
                    <div class="flex items-start gap-1 mt-2" x-show="form.opportunity_type === 'not-associated'" x-cloak>
                        <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                        <div class="space-y-2">
                            <p class="text-xs">{{ __('Allocating faulty equipment to Jobs is always best, but sometimes faults are identified outside of a Job. Some examples include;') }}</p>
                            <ul class="pl-5 space-y-1 text-xs list-disc">
                                <li>{{ __('The correct Job name cannot be found and allocated') }}</li>
                                <li>{{ __('This fault was discovered after the Product had been de-prepped') }}</li>
                                <li>{{ __('This fault was discovered while being Picked for a Job') }}</li>
                                <li>{{ __('This fault was discovered during Prep (that is, before the equipment was loaded onto a truck)') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <template hidden x-if="form.opportunity_type === 'production-lighting-hire'">
                    <div class="relative">
                        <template hidden x-if="validated.opportunity">
                            <x-icon-square-check
                                class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                                data-element="square-check-icon"
                            />
                        </template>
                        <div>
                            <x-select-opportunity
                                :params="$opportunity_query_params"
                                x-model="form.opportunity"
                            />
                        </div>
                    </div>
                </template>
                <template hidden x-if="form.opportunity_type === 'dry-hire'">
                    <div class="relative">
                        <template hidden x-if="validated.opportunity">
                            <x-icon-square-check
                                class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                                data-element="square-check-icon"
                            />
                        </template>
                        <div>
                            <x-qi-select-dry-hire-opportunity x-model="form.opportunity" />
                        </div>
                    </div>
                </template>
                <template hidden x-if="errors.opportunity">
                    <p class="text-sm text-red-600" x-text="errors.opportunity"></p>
                </template>
            </div>
            <template hidden x-if="technicalSupervisorName">
                <div class="space-y-4">
                    <label class="block font-semibold">{{ __('Technical Supervisor') }}</label>
                    <div class="flex items-start gap-1 mt-2">
                        <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                        <p class="text-xs">{{ __('The Technical Supervisor is specified in Opportunity in CurrentRMS and cannot be edited here.') }}</p>
                    </div>
                    <p x-text="technicalSupervisorName"></p>
                </div>
            </template>
            <template hidden x-if="errors.technical_supervisor_id">
                <p class="text-sm text-red-600" x-text="errors.technical_supervisor_id"></p>
            </template>
        </x-card>
        <x-card class="px-8">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Product') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                    <p class="text-xs">{{ __('Type the first few letters of the Product and pause to let the system get info from CurrentRMS. Select the exact-match Product. If the Product cannot be found in this listing, double-check the spelling of the Product name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.') }}</p>
                </div>
                <div class="relative">
                    <template hidden x-if="validated.product_id">
                        <x-icon-square-check
                            class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                            data-element="square-check-icon"
                        />
                    </template>
                    <div>
                        <x-select-product x-model="form.product_id" />
                    </div>
                </div>
                <template hidden x-if="errors.product_id">
                    <p class="text-sm text-red-600" x-text="errors.product_id"></p>
                </template>
            </div>
        </x-card>
        <x-card class="px-8">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Reference') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                    <p class="text-xs">{{ __('The Product\'s serial number is used to uniquely identify the faulty Product. Do not confuse this with the Product\'s model number. If the serial number has hyphens (-) or slashes (/), enter them as shown on the serial number label.') }}</p>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div class="flex items-center gap-1">
                            <input type="radio" id="serial-number-exists" value="serial-number-exists" x-model="form.serial_number_status">
                            <x-input-label class="cursor-pointer" for="serial-number-exists">{{ __('Serial number') }}</x-input-label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" id="missing-serial-number" value="missing-serial-number" x-model="form.serial_number_status">
                            <x-input-label class="cursor-pointer" for="missing-serial-number">{{ __('Missing serial number') }}</x-input-label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" id="not-serialised" value="not-serialised" x-model="form.serial_number_status">
                            <x-input-label class="cursor-pointer" for="not-serialised">{{ __('Equipment is not serialised') }}</x-input-label>
                        </div>
                    </div>
                    <template hidden x-if="form.serial_number_status === 'serial-number-exists'">
                        <div class="space-y-2">
                            <div class="relative">
                                {{-- <x-icon-square-check
                                    class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                                    id="serial-number-square-check-icon"
                                    data-element="square-check-icon"
                                />   --}}
                                <x-input
                                    type="text"
                                    placeholder="{{ __('Serial number') }}"
                                    x-on:input="serialNumberRemainingCharacters = 256 - $event.target.value.length"
                                    x-model="form.serial_number"
                                />
                            </div>
                            <p
                                class="text-xs font-semibold"
                                x-bind:class="{ 'text-red-500': serialNumberRemainingCharacters <= 0 }"
                            >
                                <span x-text="serialNumberRemainingCharacters"></span>
                                {!!  __('character<span x-show="serialNumberRemainingCharacters !== 1">s</span> left') !!}
                            </p>
                            <template hidden x-if="errors.serial_number">
                                <p class="text-sm text-red-600" x-text="errors.serial_number"></p>
                            </template>
                        </div>
                    </template>
                    <div
                        class="flex items-start gap-1"
                        x-cloak
                        x-show="form.serial_number_status === 'missing-serial-number'"
                    >
                        <x-icon-triangle-alert class="w-4 h-4 text-yellow-500 shrink-0" />
                        <p class="text-xs">
                            {{ __('This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).') }}
                        </p>
                    </div>
                    <div
                        class="flex items-start gap-1"
                        x-cloak
                        x-show="form.serial_number_status === 'not-serialised'"
                    >
                        <x-icon-triangle-alert class="w-4 h-4 text-yellow-500 shrink-0" />
                        <p class="text-xs">
                            {{ __('This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.') }}
                        </p>
                    </div>
                </div>
            </div>
        </x-card>
        <x-card class="px-8">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Ready for repairs') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                    <p class="text-xs">{{ __('Set the date this Product is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty Product is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.') }}</p>
                </div>
                <div class="relative">
                    <template hidden x-if="validated.starts_at">
                        <x-icon-square-check class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1" />
                    </template>
                    <div>
                        <x-qi-input-starts-at x-model="form.starts_at" />
                    </div>
                </div>
                <template hidden x-if="errors.starts_at">
                    <p class="text-sm text-red-600" x-text="errors.starts_at"></p>
                </template>
            </div>
        </x-card>
        <template hidden x-if="form.starts_at === $root.dataset.currentDate">
            <x-card class="px-8" x-show="form.starts_at === $root.dataset.currentDate">
                <div class="space-y-4">
                    <label class="block font-semibold">{{ __('Intake location') }}</label>
                    <div class="flex items-start gap-1 mt-2">
                        <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                        <p class="text-xs ">{{ __('Indicate where this Product will be stored in the Quarantine Intake Area.') }}</p>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div class="flex items-center gap-1">
                            <input type="radio" id="on-a-shelf" value="on-a-shelf" x-model="form.intake_location_type">
                            <x-input-label class="cursor-pointer" for="on-a-shelf">{{ __('On a shelf') }}</x-input-label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" id="in-the-bulky-products-area" value="in-the-bulky-products-area" x-model="form.intake_location_type" x-on:change="form.intake_location = ''">
                            <x-input-label class="cursor-pointer" for="in-the-bulky-products-area">{{ __('In the bulky Products area') }}</x-input-label>
                        </div>
                    </div>
                    <template hidden x-if="form.intake_location_type === 'on-a-shelf'">
                        <div class="space-y-4">
                            <div class="relative">
                                <template hidden x-if="validated.intake_location">
                                    <x-icon-square-check
                                        class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                                        data-element="square-check-icon"
                                    />
                                </template>
                                <div>
                                    <x-input
                                        type="text"
                                        placeholder="{{ __('Ex: A-26') }}"
                                        x-mask="a-99"
                                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                                        x-model="form.intake_location"
                                    />
                                </div>
                            </div>
                            <div class="flex items-start gap-1">
                                <x-icon-triangle-alert class="w-4 h-4 text-yellow-500 shrink-0" />
                                <p class="text-xs">
                                    {{ __('Specify the Quarantine Intake shelf ID of where this fixture will be placed. Look for a vacant shelf position before entering this information. Tend to use aisles A, B, C, D E and F (in that order) first. Enter one letter for the aisle, and a number for the position on that shelf. A hyphen is added added automatically.') }}
                                </p>
                            </div>
                        </div>
                    </template>
                    <template hidden x-if="form.intake_location_type === 'in-the-bulky-products-area'">
                        <div class="flex items-start gap-1">
                            <x-icon-triangle-alert class="w-4 h-4 text-yellow-500 shrink-0" />
                            <p class="text-xs">
                                {{ __('This Product is to be placed in the Quarantine Intake area for bulky Products. Ensure the OOS sticker is facing outwards, and the Product does not cover OOS stickers on other Products in the area, or prevent access to Repairs Nally bins.') }}
                            </p>
                        </div>
                    </template>
                    <template hidden x-if="errors.intake_location">
                        <p class="text-sm text-red-600" x-text="errors.intake_location"></p>
                    </template>
                </div>
            </x-card>
        </template>
        <x-card class="px-8">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Primary fault classification') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                    <p class="text-xs">{{ __('Classify the type of primary fault with this Product (that is, if a Product has multiple reasons for submission to Quarantine, which is the most prominent / serious?)') }}</p>
                </div>
                <div class="relative">
                    <template x-if="validated.classification">
                        <x-icon-square-check
                            class="absolute w-5 h-5 -translate-x-full -translate-y-1/2 fill-green-500 top-1/2 -left-1"
                            data-element="square-check-icon"
                        />
                    </template>
                    <div>
                        <x-qi-select-primary-fault-classification x-model="form.classification" />
                    </div>
                </div>
                <template hidden x-if="errors.classification">
                    <p class="text-sm text-red-600" x-text="errors.classification"></p>
                </template>
            </div>
        </x-card>
        <x-card class="px-8">
            <div class="space-y-4">
                <label class="block font-semibold">{{ __('Fault description') }}</label>
                <div class="flex items-start gap-1 mt-2">
                    <x-icon-info class="w-4 h-4 text-blue-500 shrink-0" />
                    <p class="text-xs">{{ __('Enter a concise, meaningful and objective fault description.') }}</p>
                </div>
                <div class="relative">
                    <template hidden x-if="validated.description">
                        <x-icon-square-check
                            class="absolute w-5 h-5 -translate-x-full fill-green-500 -left-1 top-1"
                            data-element="square-check-icon"
                        />
                    </template>
                    <div>
                        <x-textarea
                            rows="5"
                            x-on:input="descriptionRemainingCharacters = 512 - $event.target.value.length"
                            x-model="form.description"
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
                <template hidden x-if="errors.description">
                    <p class="text-sm text-red-600" x-text="errors.description"></p>
                </template>
            </div>
        </x-card>
        <div class="flex items-center justify-end gap-2">
            <x-button
                type="button"
                variant="outline-primary"
                x-on:click="clear"
                x-bind:disabled="submitting"
            >
                {{ __('Clear form') }}
            </x-button>
            <x-button
                type="submit"
                variant="primary"
                x-bind:disabled="submitting"
            >
                <span x-show="!submitting">{{ __('Submit') }}</span>
                <span class="flex items-center gap-2" x-cloak x-show="submitting">
                    <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                    <span>{{ __('Submitting...') }}</span>
                </span>
            </x-button>
        </div>
        <template hidden x-if="errorMessage">
            <div class="p-4 font-semibold text-red-500 bg-red-100 rounded-md" x-html="errorMessage"></div>
        </template>
    </x-form>
</div>
