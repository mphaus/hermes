<x-form 
    class="max-w-screen-md mx-auto flow" 
    wire:submit="save" 
    x-data="UserForm"
>
    <template hidden x-effect="normalizeUsername(firstName, lastName)"></template>
    <template hidden x-effect="toggleFunctionAccess($wire.form.is_admin)"></template>
    <section class="grid gap-4 md:grid-cols-2">
        <div class="space-y-1">
            <x-input-label
                for="first_name"
                value="{{ __('First name *') }}"
            />
            <x-input
                type="text"
                id="first_name"
                wire:model="form.first_name"
                x-model="firstName"
            />
            <x-input-error :messages="$errors->get('form.first_name')" />
        </div>
        <div class="space-y-1">
            <x-input-label
                for="last_name"
                value="{{ __('Last name *') }}"
            />
            <x-input
                type="text"
                id="last_name"
                wire:model="form.last_name"
                x-model="lastName"
            />
            <x-input-error :messages="$errors->get('form.last_name')" />
        </div>
        <div class="space-y-1">
            <x-input-label
                for="username"
                value="{{ __('Username *') }}"
            />
            <x-input
                type="text"
                id="username"
                wire:model="form.username"
            />
            <x-input-error :messages="$errors->get('form.username')" />
        </div>
        <div class="space-y-1">
            <x-input-label
                for="email"
                value="{{ __('Email *') }}"
            />
            <x-input
                type="email"
                id="email"
                wire:model="form.email"
            />
            <x-input-error :messages="$errors->get('form.email')" />
        </div>
    </section>
    <section class="flex items-center gap-8">
        <div class="flex items-center gap-2">
            <x-input-checkbox id="is_admin" wire:model="form.is_admin" />
            <x-input-label
                for="is_admin"
                class="cursor-pointer"
                value="{{ __('Is admin') }}"
            />
        </div>
        <div class="flex items-center gap-2">
            <x-input-checkbox id="is_enabled" wire:model="form.is_enabled" />
            <x-input-label
                for="is_enabled"
                class="cursor-pointer"
                value="{{ __('Is enabled') }}"
            />
        </div>
    </section>
    <div class="mt-6 flow">
        <p class="font-semibold">{{ __('Function access') }}</p>
        <ul class="space-y-4">
            <li class="flex items-center gap-2">
                <x-input-checkbox id="crud_users" value="crud-users" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                <x-input-label
                    for="crud_users"
                    class="cursor-pointer"
                    value="{{ __('CRUD users') }}"
                />
            </li>
            <li class="flex items-center gap-2">
                <x-input-checkbox id="equipment_import" value="access-equipment-import" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                <x-input-label
                    for="equipment_import"
                    class="cursor-pointer"
                    value="{{ __('Equipment Import') }}"
                />
            </li>
            <li class="flex items-center gap-2">
                <x-input-checkbox id="action_stream" value="access-action-stream" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                <x-input-label
                    for="action_stream"
                    class="cursor-pointer"
                    value="{{ __('Action Stream') }}"
                />
            </li>
            <li class="flex items-center gap-2">
                <x-input-checkbox id="create_default_discussions" value="create-default-discussions" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                <x-input-label
                    for="create_default_discussions"
                    class="cursor-pointer"
                    value="{{ __('Create template Discussions') }}"
                />
            </li>
            <li class="flex items-center gap-2">
                <x-input-checkbox id="update_default_discussions" value="update-default-discussions" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                <x-input-label
                    for="update_default_discussions"
                    class="cursor-pointer"
                    value="{{ __('Edit default Discussions') }}"
                />
            </li>
        </ul>
        <x-input-error :messages="$errors->get('form.permissions')" />
    </div>
    <div class="flex justify-end">
        <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
    </div>
</x-form>
