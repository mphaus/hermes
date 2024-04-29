@use('Illuminate\Support\Js')

<div x-data="ActionStreamFilters(
        {{ Js::from($memberIds) }}, 
        {{ Js::from($_actionTypes) }},
        {{ Js::from($dateRange) }},
        {{ Js::from($formattedDateRange) }},
        {{ Js::from($timePeriod) }}
    )" class="space-y-3">
    <div class="grid gap-2 lg:grid-cols-3 lg:items-end">
        <div class="space-y-1">
            <x-input-label value="{{ __('Members') }}" class="!text-xs" />
            <select
                class="block w-full"
                multiple
                x-ref="memberIds"
            >
                @foreach ($this->members as $member)
                    <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <x-input-label value="{{ __('Actions') }}" class="!text-xs" />
            <select
                class="block w-full"
                multiple
                x-ref="actionTypes"
            >
                @foreach ($this->actionTypes as $type)
                    <option value="{{ $type['key'] }}">{{ $type['value'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <x-input-label value="{{ __('Date range') }}" class="!text-xs" />
            <x-input 
                type="text"
                class="block w-full" 
                x-ref="dateRange"
            />
        </div>
    </div>
    <div class="grid gap-2 lg:grid-cols-4">
        <x-button 
            type="button" 
            variant="primary" 
            class="block w-full"
            x-on:click="$wire.$parent.setFilters(memberIds, actionTypes, dateRange, timePeriod)"
        >
            {{ __('Search') }}
        </x-button>
        <x-button 
            type="button" 
            variant="outline-primary" 
            class="block w-full"
            x-on:click="_flatpickrInstance.clear(); timePeriod = 'this-week'; $wire.$parent.setFilters(memberIds, actionTypes, dateRange, timePeriod);"
            x-bind:class="{ 'pressed': timePeriod === 'this-week' }"
        >
            {{ __('This week') }}
        </x-button>
        <x-button 
            type="button" 
            variant="outline-primary" 
            class="block w-full"
            x-on:click="_flatpickrInstance.clear(); timePeriod = 'this-month'; $wire.$parent.setFilters(memberIds, actionTypes, dateRange, timePeriod);"
            x-bind:class="{ 'pressed': timePeriod === 'this-month' }"
        >
            {{ __('This month') }}
        </x-button>
        <x-button 
            type="button" 
            variant="outline-primary" 
            class="block w-full"
            x-on:click="clear"
        >{{ __('Clear') }}</x-button>
    </div>
</div>
