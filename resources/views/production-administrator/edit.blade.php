<x-layout-app>
    <x-slot name="title">{{ __('Edit Production Administrator') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Edit Production Administrator name') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
    </x-slot>
    <div x-data="ProductionAdministratorEdit({{ request()->route('id') }})">
        <template hidden x-if="fetching">
            <x-production-administrator-edit-skeleton />
        </template>
        <template hidden x-if="!!Object.keys(productionAdministrator).length">
            <x-card class="max-w-(--breakpoint-sm) mx-auto flow">
                <p class="font-semibold">{{ __('Edit Production Administrator') }}</p>
                <x-production-administrator-form x-init="
                    productionAdministratorId = productionAdministrator.id;
                    form.first_name = productionAdministrator.first_name;
                    form.last_name = productionAdministrator.last_name;
                " />
            </x-card>
        </template>
        <template hidden x-if="errorMessage">
            <div class="p-4 bg-red-600 text-white font-semibold rounded-lg" x-text="errorMessage"></div>
        </template>
    </div>
</x-layout-app>
