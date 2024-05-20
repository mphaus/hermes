<div class="space-y-1 lg:flex-1">
    @if ($this->members['error'])
        <x-generic-error :message="$this->members['error']" />
    @elseif (empty($this->members['data']))
        <x-card>
            <p>{{ __('There are no Users to display.') }}</p>
        </x-card>
    @else
        <x-input-label value="{{ __('Owner') }}" class="!text-xs" />
        <select class="block w-full" x-data="CreateDiscussionsOwner">
            <option value="">{{ __('Select a User') }}</option>
            @foreach ($this->members['data'] as $member)
                <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
            @endforeach
        </select>    
    @endif
</div>
