<x-slot name="title">{{ __('Techinical Supervisors') }}</x-slot>
<x-slot name="heading">{{ __('Techinical Supervisors') }}</x-slot>
<div class="flow">
    @if ($this->technicalSupervisors['error'])
        <x-generic-error :message="$this->technicalSupervisors['error']" />
    @else
        <header class="flex justify-end max-w-screen-xl mx-auto">
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
                <div class="grid max-w-screen-xl gap-4 mx-auto md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->technicalSupervisors['people'] as $person)
                        <x-technical-supervisors-item :technicalSupervisor="$person" wire:key="{{ $person['id'] }}" />
                    @endforeach
                </div>
            </section>
        @else
            <div class="max-w-screen-xl mx-auto">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __('There are no Technical Supervisors to display.') }}
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
