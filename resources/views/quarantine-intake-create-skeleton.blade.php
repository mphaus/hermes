<div>
    <x-slot name="title">{{ __('Quarantine Intake') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Quarantine Intake') }}</span>
        <span class="block mt-2 text-sm font-normal">{!! __('Refer to the <a href=":url" target="_blank" rel="nofollow" title="Add item to Quarantine via Hermes section">Add item to Quarantine via Hermes section</a> of the Quarantine Intake Process for detailed instructions.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=BkqZrw&nav=eyJoIjoiMjAwNzMzMjA1NyJ9']) !!}</span>
    </x-slot>
    <div class="max-w-screen-md mx-auto space-y-7">
        <div class="animate-pulse">
            <div class="h-6 bg-gray-200 rounded-lg"></div>
        </div>
        @for ($i = 0; $i < 3; $i++)
            <x-card class="animate-pulse">
                <div class="space-y-1">
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-10 bg-gray-200 rounded-lg"></div>
                </div>
            </x-card>
        @endfor
        </div>
</div>
