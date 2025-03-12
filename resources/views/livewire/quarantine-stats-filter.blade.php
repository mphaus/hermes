<x-card 
    class="space-y-4" 
    x-data="QuarantineStatsFilter"
    x-on:hermes:select-product-change="filter.products = $event.detail.value"
    x-on:hermes:select-technical-supervisor-change="filter.technical_supervisors = $event.detail.value"
    x-on:hermes:select-object-change="filter.objects = $event.detail.value"
    x-on:hermes:select-fault-root-cause-change="filter.fault_root_causes = $event.detail.value"
>
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
        <x-button 
            type="button" 
            variant="outline-primary"
            data-time-period="last-week"
            x-on:click="toggleTimePeriod"
            x-bind:class="toggleTimePeriodClassname($el)"
        >
            {{ __('Last week') }}
        </x-button>
        <x-button 
            type="button" 
            variant="outline-primary"
            data-time-period="last-30-days"
            x-on:click="toggleTimePeriod"
            x-bind:class="toggleTimePeriodClassname($el)"
        >
            {{ __('Last 30 days') }}
        </x-button>
        <x-button 
            type="button" 
            variant="outline-primary"
            data-time-period="last-90-days"
            x-on:click="toggleTimePeriod"
            x-bind:class="toggleTimePeriodClassname($el)"
        >
            {{ __('Last 90 days') }}
        </x-button>
        <x-input type="text" x-ref="dateperiod" />
    </div>
    <div class="grid gap-2 sm:grid-cols-2">
        <div class="space-y-1">
            <x-input-label class="text-xs!">{{ __('Products') }}</x-input-label>
            <x-select-product :multiple="true" />
        </div>
        <div class="space-y-1">
            <x-input-label class="text-xs!">{{ __('Technical Supervisors') }}</x-input-label>
            <livewire:select-technical-supervisor lazy :multiple="true" />
        </div>
        <div class="space-y-1">
            <x-input-label class="text-xs!">{{ __('Opportunities or Projects') }}</x-input-label>
            <x-select-object :multiple="true" />
        </div>
        <div class="space-y-1">
            <x-input-label class="text-xs!">{{ __('Fault root cause') }}</x-input-label>
            <livewire:select-fault-root-cause lazy :multiple="true" />
        </div>
    </div>
    <div class="flex flex-col items-end gap-4">
        <div class="flex items-start gap-2">
            <x-input-checkbox id="show_items_currently_in_quarantine" class="mt-0.5" x-model="filter.show_items_currently_in_quarantine" />
            <x-input-label for="show_items_currently_in_quarantine" class="font-semibold cursor-pointer">{{ __('Show items currently in Quarantine') }}</x-input-label>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="outline-primary" href="{{ route('quarantine-stats.index') }}" wire:navigate>{{ __('Clear') }}</x-button>
            <x-button
                type="button"
                variant="primary"
                x-on:click="$wire.$parent.setFilter(filter)"
            >
                {{ __('Filter') }}
            </x-button>
        </div>
    </div>
</x-card>
