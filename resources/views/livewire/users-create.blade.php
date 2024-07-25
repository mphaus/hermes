<x-slot name="title">{{ __('Create new user') }}</x-slot>
<x-slot name="heading">{{ __('Create new user') }}</x-slot>
<div class="flow">
    <x-form class="max-w-screen-md mx-auto flow">
        <section class="grid gap-4 md:grid-cols-2">
            <div class="space-y-1">
                <x-input-label
                    for="first-name"
                    value="{{ __('First name *') }}"
                />
                <x-input
                    type="text"
                    id="first-name"
                />
            </div>
            <div class="space-y-1">
                <x-input-label
                    for="last-name"
                    value="{{ __('Last name *') }}"
                />
                <x-input
                    type="text"
                    id="last-name"
                />
            </div>
            <div class="space-y-1">
                <x-input-label
                    for="username"
                    value="{{ __('Username *') }}"
                />
                <x-input
                    type="text"
                    id="username"
                />
            </div>
            <div class="space-y-1">
                <x-input-label
                    for="email"
                    value="{{ __('Email *') }}"
                />
                <x-input
                    type="email"
                    id="email"
                />
            </div>
        </section>
        <section class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <x-input-checkbox id="is-admin" />
                <x-input-label
                    for="is-admin"
                    class="cursor-pointer"
                    value="{{ __('Is admin') }}"
                />
            </div>
            <div class="flex items-center gap-2">
                <x-input-checkbox id="is-enabled" />
                <x-input-label
                    for="is-enabled"
                    class="cursor-pointer"
                    value="{{ __('Is enabled') }}"
                />
            </div>
        </section>
        <div class="mt-6 flow">
            <p class="font-semibold">{{ __('Function access') }}</p>
            <ul class="space-y-4">
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="crud-users" />
                    <x-input-label
                        for="crud-users"
                        class="cursor-pointer"
                        value="{{ __('CRUD users') }}"
                    />
                </li>
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="equipment-import" />
                    <x-input-label
                        for="equipment-import"
                        class="cursor-pointer"
                        value="{{ __('Equipment Import') }}"
                    />
                </li>
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="action-stream" />
                    <x-input-label
                        for="action-stream"
                        class="cursor-pointer"
                        value="{{ __('Action Stream') }}"
                    />
                </li>
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="create-template-discussions" />
                    <x-input-label
                        for="create-template-discussions"
                        class="cursor-pointer"
                        value="{{ __('Create template Discussions') }}"
                    />
                </li>
                <li class="flex items-center gap-2">
                    <x-input-checkbox id="edit-default-discussions" />
                    <x-input-label
                        for="edit-default-discussions"
                        class="cursor-pointer"
                        value="{{ __('Edit default Discussions') }}"
                    />
                </li>
            </ul>
        </div>
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
        </div>
    </x-form>
</div>
