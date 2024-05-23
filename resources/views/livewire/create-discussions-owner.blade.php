<div class="space-y-1">
    @if ($this->members['error'])
        <x-generic-error :message="$this->members['error']" />
    @elseif (empty($this->members['data']))
        <x-card>
            <p>{{ __('There are no Users to display.') }}</p>
        </x-card>
    @else
        <x-input-label value="{{ __('Account Manager') }}" class="!text-xs" />
        <select class="block w-full" x-data="CreateDiscussionsOwner" data-members="{{ json_encode($this->members['data']) }}">
            <option value="">{{ __('Select an Account Manager') }}</option>
            @foreach ($this->members['data'] as $member)
                <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
            @endforeach
        </select>    
    @endif
</div>
