<x-slot name="title">{{ __('Loading...') }}</x-slot>
<x-slot name="heading">{{ __('Loading Job name...') }}</x-slot>

<div class="flow">
    <div class="mt-0" x-data="{
        appName: '{{ config('app.name') }}',
        init() {
            const jobName = window.sessionStorage.getItem('job{{ $this->log->job_id }}');

            if (jobName) {
                document.title = `${this.appName} - ${jobName} - Log`;
                document.querySelector('[data-element=app-heading]').textContent = jobName;
            } else {
                $wire.getJob({{ $this->log->job_id }});
            }
        },
    }"></div>
    <x-card>
        <div class="grid gap-4 text-sm sm:grid-cols-2 md:grid-cols-4 md:gap-6">
            <div class="flex flex-col gap-1">
                <p class="font-semibold">{{ __('Uploaded by') }}</p>
                <p>{{ $this->log->user->fullName }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <p class="font-semibold">{{ __('Uploaded at') }}</p>
                <time>{{ now()->parse($this->log->created_at)->timezone(config('app.timezone'))->format('d/M/Y H:i') }}</time>
            </div>
            <div class="flex flex-col gap-1">
                <p class="font-semibold">{{ __('Status') }}</p>
                <p @class([
                    'text-green-500' => $this->log->status === 'successful',
                    'text-yellow-500' => $this->log->status === 'warnings',
                ])>{{ str()->ucfirst($this->log->status) }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <p class="font-semibold">{{ __('IP address') }}</p>
                <p>{{ $this->log->ip_address }}</p>
            </div>
            <div class="flex flex-col gap-1 sm:col-span-2 md:col-span-4">
                <p class="font-semibold">{{ __('User agent') }}</p>
                <p>{{ $this->log->user_agent }}</p>
            </div>
        </div>
    </x-card>
    <div class="hidden lg:block lg:mt-8">
        <div class="px-6 grid gap-2 grid-cols-[18rem_1fr_1fr_1fr_18rem] items-center text-sm font-semibold">
            <p>{{ __('Item name') }}</p>
            <p>{{ __('Item ID') }}</p>
            <p>{{ __('Quantity') }}</p>
            <p>{{ __('Action') }}</p>
            <p>{{ __('Warnings') }}</p>
        </div>
    </div>
    @foreach ($this->log->data->toArray() as $data)
        <x-logs-data-item :data="$data" />
    @endforeach
</div>
