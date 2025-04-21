<x-layout-app>
    <x-slot:title>{{ __('Add Technical Supervisor') }}</x-slot:title>
    <x-slot:heading>
        <span>{{ __('Add new Technical Supervisor name') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
    </x-slot:heading>
    <x-card class="max-w-(--breakpoint-sm) mx-auto flow">
        <p class="font-semibold">{{ __('Technical Supervisor') }}</p>
        <x-technical-supervisor-form />
    </x-card>
</x-layout-app>
