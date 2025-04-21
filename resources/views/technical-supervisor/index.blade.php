<x-layout-app>
    <x-slot name="title">{{ __('Technical Supervisors') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Technical Supervisors') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('This lists MPH Technical Supervisors that can be associated with Opportunities in CurrentRMS (this is done during Pre-Production by the Crew and Logistics Assistant). In turn, this is used to assign Technical Supervisors to Quarantined items. Names can be edited later if necessary.') }}</span>
    </x-slot>
    <div>
        <div x-data="TechnicalSupervisorsIndex">
            <template hidden x-if="fetching">
                <x-technical-supervisors-skeleton />
            </template>
            <template hidden x-if="hasFetched">
                <div class="max-x-(--breakpoint-xl) mx-auto">
                    <header class="flex justify-end">
                        <x-button
                            href="{{ route('technical-supervisors.create.view') }}"
                            variant="primary"
                        >
                            <x-icon-plus class="w-4 fill-current" />
                            <span>{{ __('Add New') }}</span>
                        </x-button>
                    </header>
                    <template hidden x-if="!!technicalSupervisors.length">
                        <section class="mt-8">
                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                <template x-for="technicalSupervisor in technicalSupervisors" x-bind:key="technicalSupervisor.id">
                                    <x-card class="relative">
                                        <a
                                            class="after:absolute after:inset-0 after:z-1 after:content-['']"
                                            x-bind:href="route('technical-supervisors.edit.view', technicalSupervisor.id)"
                                            x-bind:title="technicalSupervisor.name"
                                            x-text="technicalSupervisor.name"
                                        ></a>
                                    </x-card>
                                </template>
                            </div>
                        </section>
                    </template>
                    <template hidden x-if="!technicalSupervisors.length">
                        <x-card class="mt-8">{{ __('You have not added any Technical Supervisors yet.') }}</x-card>
                    </template>
                </div>
            </template>
            <template hidden x-if="errorMessage">
                <div class="p-4 bg-red-600 text-white font-semibold rounded-lg" x-text="errorMessage"></div>
            </template>
    </div>
</x-layout-app>
