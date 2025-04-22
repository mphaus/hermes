<x-layout-app>
    <x-slot:title>{{ __('Quarantine Intake') }}</x-slot:title>
    <x-slot:heading>
        <span>{{ __('Quarantine Intake') }}</span>
        <span class="block mt-2 text-sm font-normal">{!! __('Refer to the <a href=":url_1" target="_blank" rel="nofollow" title="Add Product to Quarantine via Hermes section">Add Product to Quarantine via Hermes section</a> of the Quarantine Intake Process for detailed instructions. Check out what\'s already in <a href=":url_2" target="_blank" rel="nofollow">Quarantine in CurrentRMS</a> (this is available to full-time MPH staff, and casuals in the warehouse via the computer at the Quarantine Intake desk). ', ['url_1' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=BkqZrw&nav=eyJoIjoiMjAwNzMzMjA1NyJ9', 'url_2' => 'https://mphaustralia.current-rms.com/quarantines']) !!}</span>
    </x-slot:heading>
    <div x-data="TechnicalSupervisorsIndex">
        <template hidden x-if="fetching">
            <div class="max-w-(--breakpoint-md) mx-auto">
                <x-quarantine-form-skeleton />
            </div>
        </template>
        <template hidden x-if="hasFetched">
            {{-- CHECK FOR THE EMPTINESS OF THE TECHNICAL SUPERVISORS ARRAY --}}
            <div class="max-w-(--breakpoint-md) mx-auto">
                <x-quarantine-form />
            </div>
        </template>
        <template hidden x-if="errorMessage">
            <div class="p-4 font-semibold text-white bg-red-600 rounded-lg" x-text="errorMessage"></div>
        </template>
    </div>
</x-layout-app>
