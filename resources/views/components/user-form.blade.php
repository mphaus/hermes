<x-form 
    class="max-w-screen-md mx-auto flow" 
    wire:submit="save" 
    x-data="UserForm"
>
    <template hidden x-effect="normalizeUsername($wire.form.first_name, $wire.form.last_name)"></template>
    <template hidden x-effect="toggleFunctionAccess($wire.form.is_admin)"></template>
    <template hidden x-effect="toggleAdmin($wire.form.permissions.length)"></template>
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
    <section class="space-y-8">
        <div>
            <div class="flex items-center gap-2">
                <x-input-checkbox id="is_admin" wire:model="form.is_admin" />
                <x-input-label
                    for="is_admin"
                    class="cursor-pointer"
                    value="{{ __('Is admin') }}"
                />
            </div>
            <p class="mt-2 text-xs">{{ __('Gives the user full access to all current and future functions of Hermes, including CRUD of users. Typically suitable for executive staff.') }}</p>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <x-input-checkbox id="is_enabled" wire:model="form.is_enabled" />
                <x-input-label
                    for="is_enabled"
                    class="cursor-pointer"
                    value="{{ __('Is enabled') }}"
                />
            </div>
            <p class="mt-2 text-xs">{{ __('Allows this user to log in when checked.') }}</p>
        </div>
    </section>
    <div class="mt-6 flow">
        <p class="font-semibold">{{ __('Function access') }}</p>
        <ul class="space-y-4" x-ref="permissionsList">
            @foreach ($this->getPermissions() as $permission)
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="{{ $permission['key'] }}" value="{{ $permission['key'] }}" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                    <x-input-label
                        for="{{ $permission['key'] }}"
                        class="cursor-pointer"
                        value="{{ $permission['value'] }}"
                    />
                </li>
            @endforeach
        </ul>
        <x-input-error :messages="$errors->get('form.permissions')" />
    </div>
    <div class="flex items-center justify-end gap-2">
        <x-button href="{{ route('users.index') }}" variant="outline-primary" wire:navigate wire:loading.class="disabled" wire:target="save">{{ __('Cancel') }}</x-button>
        <x-button type="submit" variant="primary">
            <span wire:loading.class="hidden" wire:target="save">{{ __('Save') }}</span>
            <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
        </x-button>
    </div>
</x-form>
