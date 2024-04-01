@use('Illuminate\Support\Js')

<div x-data="ActionStreamFilters" class="space-y-3">
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

@script
<script>
    Alpine.data('ActionStreamFilters', (
        initialMemberIds = {{ Js::from($memberIds) }}, 
        initialActionTypes = {{ Js::from($_actionTypes) }},
        initialDateRange = {{ Js::from($dateRange) }},
        formattedDateRange = {{ Js::from($formattedDateRange) }},
        initialTimePeriod = {{ Js::from($timePeriod) }}
    ) => {
        return {
            memberIds: initialMemberIds,
            actionTypes: initialActionTypes,
            dateRange: initialDateRange,
            timePeriod: initialTimePeriod,
            _flatpickrInstance: null,
            init() {
                $(this.$refs.memberIds).select2({
                    placeholder: 'Select or type one or more members',
                    width: '100%',
                }).on('change.select2', () => this.memberIds = $(this.$refs.memberIds).val());

                if (this.memberIds.length > 0) {
                    $(this.$refs.memberIds)
                        .val(this.memberIds)
                        .trigger('change');
                }

                $(this.$refs.actionTypes).select2({
                    placeholder: 'Select or type one or more actions',
                    width: '100%',
                }).on('change.select2', () => this.actionTypes = $(this.$refs.actionTypes).val());

                if (this.actionTypes.length > 0) {
                    $(this.$refs.actionTypes)
                        .val(this.actionTypes)
                        .trigger('change');
                }

                this._flatpickrInstance = flatpickr(this.$refs.dateRange, {
                    mode: 'range',
                    dateFormat: 'd-M-Y',
                    maxDate: new Date,
                    defaultDate: [...formattedDateRange],
                    onChange: (selectedDates) => {
                        if (selectedDates.length === 0) {
                            this.dateRange = [];
                            return;
                        }

                        this.dateRange = selectedDates.map(selectedDate => `${selectedDate.getUTCFullYear()}-${(selectedDate.getUTCMonth() + 1).toString().padStart(2, '0')}-${(selectedDate.getUTCDate()).toString().padStart(2, '0')}`);
                    },
                });
            },
            clear() {
                this.memberIds = [];
                this.actionTypes = [];
                this.dateRange = [];
                this.timePeriod = '';

                $(this.$refs.memberIds).val([]).trigger('change');
                $(this.$refs.actionTypes).val([]).trigger('change');
                this._flatpickrInstance.clear();

                this.$wire.$parent.setFilters(this.memberIds, this.actionTypes, this.dateRange, this.timePeriod);
            }
        };
    });
</script>
@endscript
