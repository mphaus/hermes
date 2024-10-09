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
            <div class="flex items-start gap-2">
                <x-input-checkbox id="is_admin" class="mt-0.5" wire:model="form.is_admin" />
                <x-input-label for="is_admin" class="space-y-1 cursor-pointer">
                    <p class="!font-semibold">{{ __('Is admin') }}</p>
                    <p class="text-xs leading-5">{{ __('Gives the user full access to all current and future functions of Hermes, including CRUD of users. Typically suitable for executive staff.') }}</p>
                </x-input-label>
            </div>
        </div>
        <div>
            <div class="flex items-start gap-2">
                <x-input-checkbox id="is_enabled" class="mt-0.5" wire:model="form.is_enabled" />
                <x-input-label for="is_enabled" class="space-y-1 cursor-pointer">
                    <p class="!font-semibold">{{ __('Is enabled') }}</p>
                    <p class="text-xs leading-5">{{ __('Allows this user to log in when checked.') }}</p>
                </x-input-label>
            </div>
        </div>
    </section>
    <div class="mt-6 flow">
        <p class="font-bold">{{ __('Function access') }}</p>
        <p class="mt-2 text-xs">{!! __('See the <a href=":url" target="_blank" rel="nofollow">Hermes Guide</a> for more info on Hermes functions.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew']) !!}</p>
        <ul class="space-y-8" x-ref="permissionsList">
            @foreach ($this->getPermissions() as $permission)
                <li class="flex items-start gap-2">
                    <x-input-checkbox id="{{ $permission['key'] }}" class="mt-0.5" value="{{ $permission['key'] }}" wire:model="form.permissions" x-bind:disabled="functionAccessDisabled" />
                    <x-input-label for="{{ $permission['key'] }}" class="space-y-1 cursor-pointer">
                        <p class="!font-semibold">{{ $permission['value'] }}</span>
                        @if ($permission['description'])
                            <p class="text-xs leading-5">{{ $permission['description'] }}</p>
                        @endif
                    </x-input-label>
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
    @if (request()->routeIs('users.create'))
        <p wire:loading wire:target="save" class="text-sm">{{ __('The user will be emailed with the subject \'Welcome to MPH Hermes, your new account is ready\' with a prompt to set their password. Users can reset their password at any time.') }}</p>    
    @endif
</x-form>
