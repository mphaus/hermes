<div>
    @if ($this->logs->isNotEmpty())
        <p class="px-6">{{ __('Logs') }}</p>
        <div class="mt-4 space-y-4">
            <div class="hidden lg:block">
                <div class="grid items-center grid-cols-3 gap-2 px-6 text-sm font-semibold">
                    <p>{{ __('Uploaded by')}}</p>
                    <p>{{ __('Uploaded at') }}</p>
                    <p>{{ __('Status') }}</p>
                </div>
            </div>
            @foreach ($this->logs as $log)
                <x-logs-item :log="$log" wire:key="{{ $log->id }}" />
            @endforeach
        </div>
    @endif
</div>
