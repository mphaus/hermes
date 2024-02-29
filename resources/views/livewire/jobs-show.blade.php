@use('Illuminate\Support\Number')

<x-slot name="title">{{ isset($this->job['opportunity']['subject']) ? $this->job['opportunity']['subject'] : __('Job not found') }}</x-slot>
<x-slot name="heading">{{ isset($this->job['opportunity']['subject']) ? $this->job['opportunity']['subject'] : __('Job not found') }}</x-slot>
<div>
    @if ($this->job['error'])
        <x-generic-error :message="$this->job['error']" />
    @else
        <div class="flow">
            <div class="mt-0" x-data x-init="window.sessionStorage.setItem('job{{ $this->job['opportunity']['id'] }}', '{{ $this->job['opportunity']['subject'] }}')"></div>
            <x-card>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
                    @if ($this->job['opportunity']['description'])
                        <div class="flex flex-col col-span-2 gap-1 md:col-span-4">
                            <p class="text-sm font-semibold">{{ __('Opportunity description') }}</p>
                            <div>{!! nl2br($this->job['opportunity']['description']) !!}</div>
                        </div>
                    @endif
                    <div class="flex flex-col col-span-2 gap-1 md:col-span-4">
                        <p class="text-sm font-semibold">{{ __('Opportunity link') }}</p>
                        <a 
                            href="https://mphaustralia.current-rms.com/opportunities/{{ $this->job['opportunity']['id'] }}" 
                            target="_blank"
                        >
                            https://mphaustralia.current-rms.com/opportunities/{{ $this->job['opportunity']['id'] }}
                        </a>
                    </div>
                    <div class="flex flex-col gap-1 text-sm">
                        <p class="font-semibold">{{ __('Start date') }}</p>
                        <time datetime="{{ $this->job['opportunity']['starts_at'] }}">{{ now()->parse($this->job['opportunity']['starts_at'])->timezone(config('app.timezone'))->format('d-M-Y') }}</time>
                    </div>
                    <div class="flex flex-col gap-1 text-sm">
                        <p class="font-semibold">{{ __('End date') }}</p>
                        <time datetime="{{ $this->job['opportunity']['ends_at'] }}">{{ now()->parse($this->job['opportunity']['ends_at'])->timezone(config('app.timezone'))->format('d-M-Y') }}</time>
                    </div>
                    <div class="flex flex-col gap-1 text-sm">
                        <p class="font-semibold">{{ __('Revenue') }}</p>
                        <p>{{ Number::currency($this->job['opportunity']['charge_total']) }}</p>
                    </div>
                    <div class="flex flex-col gap-1 text-sm">
                        <p class="font-semibold">{{ __('Participants') }}</p>
                        <ul class="space-y-1">
                            @foreach ($this->job['opportunity']['participants'] as $participant)
                                <li>{{ $participant['member_name'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </x-card>
            <x-card>
                <livewire:items-create :job-id="$this->job['opportunity']['id']" />
            </x-card>
            <div class="mt-8">
                <livewire:upload-logs-index :job-id="$this->job['opportunity']['id']" />
            </div>
        </div>
    @endif
</div>
