<x-layout-app>
    <x-slot name="title">{{ __('Quaratine Intake Success') }}</x-slot>
    <x-slot name="heading">{{ __('Success!') }}</x-slot>
    <div class="mx-auto xl:grid xl:gap-4 xl:grid-cols-7 max-w-screen-2xl">
        <div class="space-y-4 xl:col-span-5">
            <x-card class="self-start">
                <p>{!! __('Your quarantine submission has been received and is logged in CurrentRMS - see <a href=":url" target="_blank" rel="nofollow">submission :quarantine_id</a>. This link will only work for full-time MPH employees logged in to CurrentRMS. It\'s also possible for Casuals to access this from the Quarantine Intake Station in the warehouse.', ['url' => "https://mphaustralia.current-rms.com/quarantines/{$quarantine['id']}", 'quarantine_id' => $quarantine['id']]) !!}</p>
            </x-card>
            @unless ($quarantine['custom_fields']['intake_location'] === 'TBC')
                <x-card class="space-y-4 !bg-[#333333] !text-[#FFFF00] xl:hidden text-center">
                    <h2 class="text-3xl font-semibold 2xl:text-4xl">{{ __('Intake Location') }}</h2>
                    <p @class([
                        'font-bold',
                        'text-7xl 2xl:text-9xl' => $quarantine['custom_fields']['intake_location'] !== 'Bulky items area',
                        'text-3xl sm:text-4xl' => $quarantine['custom_fields']['intake_location'] === 'Bulky items area',
                    ])>{{ $quarantine['custom_fields']['intake_location'] }}</p>
                    <p class="text-sm sm:text-lg">{{ __('Place the Product here right away!') }}</p>
                </x-card>
            @endunless
            <x-card class="flow">
                <p class="font-semibold">{{ __('Submitted Quarantine item details') }}</p>
                <ul class="space-y-3 md:pl-4">
                    <li class="flex flex-col">
                        <span class="font-semibold">Submitter:</span>
                        <span>{{ auth()->user()->first_name }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Submitted:</span>
                        <time datetime="{{ now()->parse($quarantine['created_at'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') }}">
                            {{ now()->parse($quarantine['created_at'])->setTimezone(config('app.timezone'))->format('d-M-Y \a\t Hi') }}
                        </time>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">CurrentRMS Quarantine ID:</span>
                        <span>{{ $quarantine['id'] }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Job:</span>
                        <span>{{ $quarantine['custom_fields']['opportunity'] }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Product:</span>
                        <span>{{ $quarantine['name'] }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Serial:</span>
                        <span>{{ $quarantine['reference'] }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Ready for repairs:</span>
                        @if ($quarantine['ready_for_repairs'] === 'Now')
                            <span>{{ $quarantine['ready_for_repairs'] }}</span>
                        @else
                            <time datetime="{{ now()->parse($quarantine['ready_for_repairs'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') }}">
                                {{ now()->parse($quarantine['ready_for_repairs'])->setTimezone(config('app.timezone'))->format('d-M-Y \a\t Hi') }}
                            </time>
                        @endif
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold">Primary fault classification:</span>
                        <span>{{ $quarantine['primary_fault_classification'] }}</span>
                    </li>
                    <li class="flex flex-col gap-2">
                        <span class="font-semibold">Fault description:</span>
                        <div>{!! nl2br(e($quarantine['description'])) !!}</div>
                    </li>
                </ul>
                <x-button
                    variant="primary"
                    href="{{ route('quarantine-intake.create') }}"
                    title="{{ __('Create a new Quarantine submission') }}"
                    class="mt-8 text-center"
                >
                    {{ __('Create a new Quarantine submission') }}
                </x-button>
            </x-card>
            <x-card class="flow">
                <p class="font-semibold">{{ __('Made a mistake?') }}</p>
                <p>{{ __('No worries. If there are errors in this data, don\'t submit it again! Let us know what needs to change...') }}</p>
                <x-qi-report-mistake-form :quarantine="$quarantine" />
                <p>{{ __('A copy of the data and your message will be provided to the SRMM Manager, and they will take action. ') }}</p>
            </x-card>
        </div>
        @unless ($quarantine['custom_fields']['intake_location'] === 'TBC')
            <x-card class="space-y-4 !bg-[#333333] !text-[#FFFF00] hidden xl:block xl:col-span-2 xl:self-start text-center">
                <h2 class="text-3xl 2xl:text-4xl">{{ __('Intake Location') }}</h2>
                <p @class([
                    'font-bold',
                    'text-7xl 2xl:text-9xl' => $quarantine['custom_fields']['intake_location'] !== 'Bulky items area',
                    'text-3xl 2xl:text-4xl' => $quarantine['custom_fields']['intake_location'] === 'Bulky items area',
                ])>{{ $quarantine['custom_fields']['intake_location'] }}</p>
                <p class="2xl:text-lg">{{ __('Place the Product here right away!') }}</p>
            </x-card>
        @endunless
    </div>
</x-layout-app>
