<x-slot name="title">{{ __('QET') }}</x-slot>
<x-slot name="heading">{{ __('QET') }}</x-slot>
<div class="flow" x-data="ActionStreamIndex">
    <div class="space-y-1 max-w-96">
        <x-input-label value="{{ __('Date') }}" class="!text-xs" />
        <x-input 
            type="text" 
            placeholder="{{ __('Select a date') }}" 
            class="block w-full" 
            x-ref="date"
        />
    </div>
    <div wire:loading.block wire:target="setDate">
        @include('qet-skeleton')
    </div>
    @if ($this->qet['items']->isNotEmpty())
        <section class="mt-8 flow" wire:loading.class="hidden" wire:target="setDate">
            <div class="flex flex-col gap-2 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p>{{ __('Quick Equipment Transfers for :date +24 hours', ['date' => now()->parse($date)->format('l d M Y')]) }}</p>
                <p>{{ __('Last update: :time', ['time' => now()->format('Hi')]) }}</p>
            </div>
            <div class="hidden mt-8 lg:block">
                <div class="grid grid-cols-8 px-6 text-sm font-semibold">
                    <p class="col-span-2">{{ __('Coming off Job') }}</p>
                    <p class="col-span-2">{{ __('Going to Job') }}</p>
                    <p class="col-span-2">{{ __('Item') }}</p>
                    <p>{{ __('Count') }}</p>
                    <p>{{ __('Time remaining') }}</p>
                </div>
            </div>
            @foreach ($this->qet['items'] as $qetItem)
                <x-qet-item :qet="$qetItem" wire:key="{{ $qetItem['id'] }}" />    
            @endforeach
        </section>
    @endif
</div>

@script
<script>
    Alpine.data('ActionStreamIndex', () => {
        return {
            init() {
                flatpickr(this.$refs.date, {
                    dateFormat: 'd-M-Y',
                    minDate: new Date,
                    onChange: (selectedDates) => {
                        const date = selectedDates.length > 0
                            ? `${selectedDates[0].getFullYear()}-${(selectedDates[0].getMonth() + 1).toString().padStart(2, '0')}-${(selectedDates[0].getDate()).toString().padStart(2, '0')}`
                            : '';
                        
                        this.$wire.setDate(date);
                    }
                });
            }
        };
    });
</script>
@endscript
