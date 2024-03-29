<div x-data="ActionStreamFilters" class="space-y-3">
    <div class="grid gap-2 lg:grid-cols-3 lg:items-end">
        <div class="space-y-1">
            <x-input-label value="{{ __('Members') }}" class="!text-xs" />
            <select
                class="block w-full"
                multiple
                x-ref="members"
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
                x-ref="actions"
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
        <x-button type="button" variant="primary" class="block w-full">{{ __('Search') }}</x-button>
        <x-button type="button" variant="outline-primary" class="block w-full">{{ __('This week') }}</x-button>
        <x-button type="button" variant="outline-primary" class="block w-full">{{ __('This month') }}</x-button>
        <x-button type="button" variant="outline-primary" class="block w-full">{{ __('Clear') }}</x-button>
    </div>
</div>

@script
<script>
    Alpine.data('ActionStreamFilters', () => {
        return {
            init() {
                $(this.$refs.members).select2({
                    placeholder: 'Select or type one or more members',
                    width: '100%',
                });

                $(this.$refs.actions).select2({
                    placeholder: 'Select or type one or more actions',
                    width: '100%',
                });

                flatpickr(this.$refs.dateRange, {
                    mode: 'range',
                });
            }
        };
    });
</script>
@endscript
