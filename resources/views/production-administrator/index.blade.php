<x-layout-app>
    <x-slot name="title">{{ __('Production Administrators') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Production Administrators') }}</span>
    </x-slot>
    <header class="flex justify-end max-w-(--breakpoint-xl) mx-auto">
        <x-button
            href="#"
            variant="primary"
        >
            <x-icon-plus class="w-4 fill-current" />
            <span>{{ __('Add Production Administrator') }}</span>
        </x-button>
    </header>
</x-layout-app>
