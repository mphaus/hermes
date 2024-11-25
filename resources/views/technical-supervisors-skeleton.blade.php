<x-slot name="title">{{ __('Techinical Supervisors') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Techinical Supervisors') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('This lists MPH Technical Supervisors that can be associated with Opportunities in CurrentRMS (this is done during Pre-Production by the Crew and Logistics Assistant). In turn, this is used to assign Technical Supervisors to Quarantined items. Names can be edited later if necessary.') }}</span>
</x-slot>
<div class="grid max-w-screen-xl gap-4 mx-auto md:grid-cols-3">
    @for ($i = 0; $i < 3; $i++)
        <x-card class="animate-pulse">
            <div class="h-6 bg-gray-200 rounded-lg"></div>
        </x-card>
    @endfor
</div>
