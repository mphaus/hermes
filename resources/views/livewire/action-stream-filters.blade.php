<div x-data="ActionStreamFilters" class="space-y-2">
    <div class="grid gap-2">
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
                <option value=""></option>
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
        <x-button type="button" variant="primary" class="block w-full">{{ __('Search') }}</x-button>
    </div>
    <div class="grid gap-2">
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
                $(this.$refs.members).select2();
                $(this.$refs.actions).select2();

                flatpickr(this.$refs.dateRange, {
                    mode: 'range',
                });
            }
        };
    });
</script>
@endscript
