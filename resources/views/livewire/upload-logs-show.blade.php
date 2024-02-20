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
    @foreach ($this->log->data->toArray() as $data)
        <x-card>
            <div>
                <p>{{ __('Item name') }}</p>
                <p>{{ $data['item_name'] }}</p>
            </div>
            <div>
                <p>{{ __('Item ID') }}</p>
                <p>{{ $data['item_id'] }}</p>
            </div>
            <div>
                <p>{{ __('Quantity') }}</p>
                <p>{{ isset($data['quantity']) ? $data['quantity'] : __('Nil') }}</p>
            </div>
            <div>
                <p>{{ __('Action') }}</p>
                <p>{{ $data['action'] }}</p>
            </div>
            <div>
                <p>{{ __('Warnings') }}</p>
                <p>{{ empty($data['error']) ? __('Nil') : $data['error'] }}</p>
            </div>
        </x-card>
    @endforeach
</div>
