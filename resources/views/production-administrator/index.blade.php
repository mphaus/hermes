<x-layout-app>
    <x-slot name="title">{{ __('Production Administrators') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Production Administrators') }}</span>
    </x-slot>
    <div x-data="ProductionAdministratorsIndex">
        <template hidden x-if="fetching">
            <x-production-administrators-skeleton />
        </template>
        <template hidden x-if="!!productionAdministrators.length">
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
                    <div class="grid max-w-(--breakpoint-xl) gap-4 mx-auto md:grid-cols-2 lg:grid-cols-3">
                        <template x-for="productionAdministrator in productionAdministrators" x-bind:key="productionAdministrator.id">
                            <x-card class="relative">
                                <a
                                    href="#"
                                    class="after:absolute after:inset-0 after:z-1 after:content-['']"
                                    x-bind:title="productionAdministrator.name"
                                    x-text="productionAdministrator.name"
                                ></a>
                            </x-card>
                        </template>
                    </div>
                </section>
            </div>
        </template>
    </div>
</x-layout-app>
