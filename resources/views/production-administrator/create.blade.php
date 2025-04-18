<x-layout-app>
    <x-slot name="title">{{ __('Add Production Administrator') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Add new Production Administrator name') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
    </x-slot>
    <x-card class="max-w-(--breakpoint-sm) mx-auto flow">
        <p class="font-semibold">{{ __('Production Administrator') }}</p>
        <x-production-administrator-form />
    </x-card>
</x-layout-app>
