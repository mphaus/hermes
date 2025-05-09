@props(['job'])

<x-card class="relative">
    <div class="flex flex-col gap-2 lg:grid lg:grid-cols-[28rem_1fr_1fr] xl:grid-cols-[45rem_1fr_1fr]">
        <a 
            href="{{ route('jobs.show', ['id' => $job['id']]) }}" 
            class="after:absolute after:inset-0 after:z-1 after:content-['']" 
            title="{{ $job['subject'] }}" 
        >
            {{ $job['subject'] }}
        </a>
        <div class="grid grid-cols-[4rem_1fr] gap-1 text-sm mt-2 lg:mt-0 lg:block">
            <p class="font-semibold lg:hidden">{{ __('Start date') }}</p>
            <time datetime="{{ $job['starts_at'] }}">{{ now()->parse($job['starts_at'])->timezone(config('app.timezone'))->format('d-M-Y') }}</time>
        </div>
        <div class="grid grid-cols-[4rem_1fr] gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('End date') }}</p>
            <time datetime="{{ $job['ends_at'] }}">{{ now()->parse($job['ends_at'])->timezone(config('app.timezone'))->format('d-M-Y') }}</time>
        </div>
    </div>
</x-card>
