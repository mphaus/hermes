<div>
    @if ($this->data['error'])
        <x-generic-error :message="$this->data['error']" />
    @elseif ($this->data['technical_supervisors']->isNotEmpty())
        <select class="w-full">
            @foreach ($this->data['technical_supervisors'] as $technical_supervisor)
                <option value="{{ $technical_supervisor['id'] }}">{{ $technical_supervisor['name'] }}</option>
            @endforeach
        </select> 
    @else
        <p>{{ __('There are no Technical Supervisors to display.') }}</p>
    @endif
</div>
