<x-layout-app>
    <x-slot name="title">{{ __('Production Administrators') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Production Administrators') }}</span>
    </x-slot>
    <div x-data="ProductionAdministratorsIndex">
        <template hidden x-if="fetching">
            <x-production-administrators-skeleton />
        </template>
        <template hidden x-if="productionAdministrators">
            <div>
                <header class="flex justify-end max-w-(--breakpoint-xl) mx-auto">
                    <x-button
                        href="{{ route('production-administrators.create') }}"
                        variant="primary"
                    >
                        <x-icon-plus class="w-4 fill-current" />
                        <span>{{ __('Add Production Administrator') }}</span>
                    </x-button>
                </header>
                <section class="mt-8">
            
                </section>
            </div>
        </template>
    </div>
</x-layout-app>
