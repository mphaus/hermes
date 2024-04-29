@props(['item', 'end-date'])

<x-card x-data="QetItem(
    '{{ now()->format('Y-m-d H:i:s') }}',
    '{{ now()->parse($item['unload_job']['date'])->format('Y-m-d H:i:s') }}',
    '{{ now()->parse($endDate)->format('Y-m-d H:i:s') }}',
)">
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-8 lg:gap-2">
        <div class="flex flex-col gap-1 text-sm lg:col-span-3">
            <p class="font-semibold lg:hidden">{{ __('Coming off Job') }}</p>
            <p class="flex flex-col gap-1">
                <span>{{ $item['unload_job']['subject'] }}</span>
                <span class="flex items-center text-xs">
                    (<x-icon-arrow-down class="w-3 h-3 fill-blue-600" />
                    <span class="block ml-1">at {{ now()->parse($item['unload_job']['date'])->format('Hi D M d') }}</span>)
                </span>
            </p>
        </div>
        <div class="flex flex-col gap-1 text-sm lg:col-span-3">
            <p class="font-semibold lg:hidden">{{ __('Item') }}</p>
            <p>{{ $item['name'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Count') }}</p>
            <p>{{ $item['count'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Time remaining') }}</p>
            <p x-ref="timeRemainingElement">{{ __('Calculating...') }}</p>
        </div>
    </div>
</x-card>
