<x-slot name="title">{{ __('Log') }}</x-slot>
<x-slot name="heading">{{__('Log') }}</x-slot>

<div>
    <x-card>
        <div>
            <p>{{ __('Upload by') }}</p>
            <p>{{ $this->log->user->fullName }}</p>
        </div>
        <div>
            <p>{{ __('Uploaded at') }}</p>
            <time>{{ $this->log->created_at }}</time>
        </div>
        <div>
            <p>{{ __('Status') }}</p>
            <p>{{ $this->log->status }}</p>
        </div>
        <div>
            <p>{{ __('IP address') }}</p>
            <p>{{ $this->log->ip_address }}</p>
        </div>
        <div>
            <p>{{ __('User agent') }}</p>
            <p>{{ $this->log->user_agent }}</p>
        </div>
    </x-card>
    @php
        dd($this->log->data);
    @endphp
</div>
