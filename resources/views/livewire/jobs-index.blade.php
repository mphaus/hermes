<div>
    @if ($this->jobs['error'])
        <x-generic-error :message="$this->jobs['error']" />
    @elseif ($this->jobs['opportunities']->isNotEmpty())
        <div class="space-y-4">
            <div class="hidden lg:block">
                <div class="px-6 grid items-center grid-cols-[28rem_1fr_1fr_1fr] xl:grid-cols-[45rem_1fr_1fr_1fr] text-sm gap-2 font-semibold">
                    <p>{{ __('Subject') }}</p>
                    <p>{{ __('Start date') }}</p>
                    <p>{{ __('End date') }}</p>
                    <p>{{ __('Revenue') }}</p>
                </div>
            </div>
            @foreach ($this->jobs['opportunities'] as $job)
                <x-jobs-item :job="$job" wire:key="{{ $job['id'] }}" />
            @endforeach
        </div>
        <div class="mt-8">{{ $this->jobs['opportunities']->links('pagination') }}</div>
    @else
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('There are no active jobs to display.') }}
                </div>
            </div>
        </div>
    @endif
</div>
