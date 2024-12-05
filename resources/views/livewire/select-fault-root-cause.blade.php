@use('Illuminate\Support\Js')

<div>
    @if ($this->data['error'])
        <x-generic-error :message="$this->data['error']" />
    @elseif ($this->data['fault_root_causes']->isNotEmpty())
        <select
            class="w-full"
            x-data="SelectFaultRootCause({ multiple: {{ Js::from($multiple) }} })"
            @if ($multiple)
                multiple
            @endif
        >
            @unless ($multiple)
                <option value="">{{ __('Select a Fault Root cause') }}</option>
            @endunless    
            @foreach ($this->data['fault_root_causes'] as $fault_root_cause)
                <option value="{{ $fault_root_cause['id'] }}" wire:key="{{ $fault_root_cause['id'] }}">{{ $fault_root_cause['name'] }}</option>
            @endforeach
        </select>
    @else
        <p>{{ __('There are no Fault Root causes to display.') }}</p>
    @endif
</div>
