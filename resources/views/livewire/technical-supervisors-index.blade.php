<x-slot name="title">{{ __('Techinical Supervisors') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Techinical Supervisors') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('This lists MPH Technical Supervisors that can be associated with Opportunities in CurrentRMS (this is done during Pre-Production by the Crew and Logistics Assistant). In turn, this is used to assign Technical Supervisors to Quarantined items. Names can be edited later if necessary.') }}</span>
</x-slot>
<div class="flow">
    @if ($this->technicalSupervisors['error'])
        <x-generic-error :message="$this->technicalSupervisors['error']" />
    @else
        <header class="flex justify-end max-w-(--breakpoint-xl) mx-auto">
            <x-button
                href="{{ route('technical-supervisors.create') }}"
                variant="primary"
                wire:loading.class="disabled"
                wire:navigate
            >
                <x-icon-plus class="w-4 fill-current" />
                <span>{{ __('Add Technical Supervisor') }}</span>
            </x-button>
        </header>
        @if ($this->technicalSupervisors['people']->isNotEmpty())
            <section class="mt-8 flow">
                <div class="grid max-w-(--breakpoint-xl) gap-4 mx-auto md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->technicalSupervisors['people'] as $person)
                        <x-technical-supervisors-item :technicalSupervisor="$person" wire:key="{{ $person['id'] }}" />
                    @endforeach
                </div>
            </section>
        @else
            <div class="max-w-(--breakpoint-xl) mx-auto">
                <div class="overflow-hidden bg-white shadow-xs sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __('There are no Technical Supervisors to display.') }}
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
