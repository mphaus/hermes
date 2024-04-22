@props(['qet'])

<x-card>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-8 lg:gap-2">
        <div class="flex flex-col gap-1 text-sm lg:col-span-2">
            <p class="font-semibold lg:hidden">{{ __('Coming off Job') }}</p>
            <p class="flex flex-col gap-1">
                <span>{{ $qet['unload_job']['subject'] }}</span>
                <span class="flex items-center text-xs">
                    (<x-icon-arrow-down class="w-3 h-3 fill-blue-600" />
                    <span class="block ml-1">at {{ now()->parse($qet['unload_job']['date'])->format('Hi D M d') }}</span>)
                </span>
            </p>
        </div>
        <div class="flex flex-col gap-1 text-sm lg:col-span-2">
            <p class="font-semibold lg:hidden">{{ __('Going to Job') }}</p>
            <p class="flex flex-col gap-1">
                <span>{{ $qet['load_job']['subject'] }}</span>
                <span class="flex items-center text-xs">
                    (<x-icon-arrow-up class="w-3 h-3 fill-blue-600" />
                    <span class="block ml-1">at {{ now()->parse($qet['load_job']['date'])->format('Hi D M d') }}</span>)
                </span>
            </p>
        </div>
        <div class="flex flex-col gap-1 text-sm md:col-span-2">
            <p class="font-semibold lg:hidden">{{ __('Item') }}</p>
            <p>{{ $qet['item'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Count') }}</p>
            <p>{{ $qet['count'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Time remaining') }}</p>
            <p>2h</p>
        </div>
    </div>
</x-card>
