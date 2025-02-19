<x-layout-app>
    <x-slot name="title">{{ __('Quaratine Intake Success') }}</x-slot>
    <x-slot name="heading">{{ __('Success!') }}</x-slot>
    <div class="grid max-w-screen-xl gap-4 mx-auto lg:grid-cols-3">
        <x-card class="flow lg:col-span-2">
            <p>{!! __('Your quarantine submission has been received and is logged in CurrentRMS - see <a href="#" target="_blank" rel="nofollow">submission unique Q number</a>. This link will only work for full-time MPH employees logged in to CurrentRMS. It\'s also possible for Casuals to access this from the Quarantine Intake Station in the warehouse.') !!}</p>
            <p class="font-semibold">{{ __('Submitted Quarantine item details') }}</p>
            <ul class="space-y-3 md:pl-4">
                <li class="flex flex-col">
                    <span class="font-semibold">Submitter:</span>
                    <span>username</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Submitted:</span>
                    <span>00-Feb-0000 at 0000</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">CurrentRMS Quarantine ID:</span>
                    <span>unique Q number</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Job:</span>
                    <span>job name</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Product:</span>
                    <span>product name</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Serial:</span>
                    <span>reference</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Ready for repairs:</span>
                    <span>another date</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Primary fault classification:</span>
                    <span>as submitted</span>
                </li>
                <li class="flex flex-col">
                    <span class="font-semibold">Fault description:</span>
                    <span>as submitted</span>
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
        <x-card class="space-y-3 !bg-[#333333] !text-[#FFFF00] self-start">
            <h2 class="text-2xl font-semibold">{{ __('Intake Location') }}</h2>
            <p class="text-xl">{{ __('Location data') }}</p>
        </x-card>
        <x-card class="flow lg:col-span-2">
            <p class="font-semibold">{{ __('Made a mistake?') }}</p>
            <p>{{ __('No worries. If there are errors in this data, don\'t submit it again! Let us know what needs to change...') }}</p>
            <form action="#" class="flow">
                <div class="space-y-2">
                    <x-textarea rows="4"></x-textarea>
                    <p class="text-xs font-semibold">512 characters left</p>
                </div>
                <div class="flex justify-end">
                    <x-button variant="primary" type="submit">{{ __('Send') }}</x-button>
                </div>
            </form>
            <p>{{ __('A copy of the data and your message will be provided to the SRMM Manager, and they will take action. ') }}</p>
        </x-card>
    </div>
</x-layout-app>
