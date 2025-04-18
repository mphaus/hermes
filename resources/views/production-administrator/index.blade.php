<x-layout-app>
    <x-slot name="title">{{ __('Production Administrators') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Production Administrators') }}</span>
    </x-slot>
    <div x-data="ProductionAdministratorsIndex">
        <template hidden x-if="fetching">
            <x-production-administrators-skeleton />
        </template>
        <template hidden x-if="hasFetched">
            <div class="max-x-(--breakpoint-xl) mx-auto">
                <header class="flex justify-end">
                    <x-button
                        href="{{ route('production-administrators.create.view') }}"
                        variant="primary"
                    >
                        <x-icon-plus class="w-4 fill-current" />
                        <span>{{ __('Add New') }}</span>
                    </x-button>
                </header>
                <template hidden x-if="!!productionAdministrators.length">
                    <section class="mt-8">
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <template x-for="productionAdministrator in productionAdministrators" x-bind:key="productionAdministrator.id">
                                <x-card class="relative">
                                    <a
                                        class="after:absolute after:inset-0 after:z-1 after:content-['']"
                                        x-bind:href="route('production-administrators.edit.view', productionAdministrator.id)"
                                        x-bind:title="productionAdministrator.name"
                                        x-text="productionAdministrator.name"
                                    ></a>
                                </x-card>
                            </template>
                        </div>
                    </section>
                </template>
                <template hidden x-if="!productionAdministrators.length">
                    <x-card class="mt-8">{{ __('You have not added any Production Administrators yet.') }}</x-card>
                </template>
            </div>
        </template>
        <template hidden x-if="errorMessage">
            <div class="p-4 bg-red-600 text-white font-semibold rounded-lg" x-text="errorMessage"></div>
        </template>
    </div>
</x-layout-app>
