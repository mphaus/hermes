@props(['job'])

<article class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="flex flex-col gap-2 p-6 text-gray-900 lg:grid lg:grid-cols-[28rem_1fr_1fr_1fr] lg:items-center xl:grid-cols-[45rem_1fr_1fr_1fr]">
            <a href="#" class="after:absolute after:inset-0 after:z-[1] after:content-['']" title="{{ $job['subject'] }}" wire:navigate>{{ $job['subject'] }}</a>
            <div class="grid grid-cols-[4rem_1fr] gap-1 text-sm text-gray-400 mt-2 lg:mt-0 lg:block">
                <p class="lg:hidden">{{ __('Start date') }}</p>
                <time datetime="{{ $job['starts_at'] }}">{{ now()->parse($job['starts_at'])->timezone('Australia/Melbourne')->format('d/m/Y H:i') }}</time>
            </div>
            <div class="grid grid-cols-[4rem_1fr] gap-1 text-sm text-gray-400 lg:block">
                <p class="lg:hidden">{{ __('End date') }}</p>
                <time datetime="{{ $job['ends_at'] }}">{{ now()->parse($job['ends_at'])->timezone('Australia/Melbourne')->format('d/m/Y H:i') }}</time>
            </div>
            <div class="grid grid-cols-[4rem_1fr] gap-1 text-sm text-gray-400 lg:block">
                <p class="lg:hidden">{{ __('Revenue') }}</p>
                <p>{{ \Illuminate\Support\Number::currency($job['charge_total']) }}</p>
            </div>
        </div>
    </div>
</article>
