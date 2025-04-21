<x-layout-app>
    <x-slot:title>{{ __('Edit Technical Supervisor') }}</x-slot:title>
    <x-slot:heading>
        <span>{{ __('Edit Technical Supervisor name') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
    </x-slot:heading>
    <div x-data="TechnicalSupervisorEdit({{ request()->route('id') }})">
        <template hidden x-if="fetching">
            <x-technical-supervisor-edit-skeleton />
        </template>
        <template hidden x-if="!!Object.keys(technicalSupervisor).length">
            <x-card class="max-w-(--breakpoint-sm) mx-auto flow">
                <p class="font-semibold">{{ __('Edit Technical Supervisor') }}</p>
                <x-technical-supervisor-form x-init="
                    technicalSupervisorId = technicalSupervisor.id;
                    form.first_name = technicalSupervisor.first_name;
                    form.last_name = technicalSupervisor.last_name;
                " />
            </x-card>
        </template>
        <template hidden x-if="errorMessage">
            <div class="p-4 bg-red-600 text-white font-semibold rounded-lg" x-text="errorMessage"></div>
        </template>
    </div>
</x-layout-app>
