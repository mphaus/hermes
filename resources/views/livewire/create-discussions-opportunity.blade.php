<div class="space-y-1 lg:flex-1">
    @if ($this->jobs['error'])
        <x-generic-error :message="$this->jobs['error']" />
    @elseif (empty($this->jobs['opportunities']))
        <x-card>
            <p>{{ __('There are no Opportunities to display.') }}</p>
        </x-card>
    @else
        <x-input-label value="{{ __('Opportunity') }}" class="!text-xs" />
        <select class="block w-full" x-data="CreateDiscussionsOpportunity">
            <option value="">{{ __('Select an Opportunity') }}</option>
            @foreach ($this->jobs['opportunities'] as $opportunity)
                <option value="{{ $opportunity['id'] }}">{{ $opportunity['subject'] }}</option>
            @endforeach
        </select>    
    @endif
</div>
