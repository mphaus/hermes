@props(['user'])

<x-card 
    x-data="{ userIsBeingDeleted: false }" 
    x-on:hermes:user-delete.window="userIsBeingDeleted = true" 
    x-bind:class="{ 'pointer-events-none opacity-50': userIsBeingDeleted }"
>
    <div class="grid gap-4 lg:grid-cols-10">
        <div class="grid gap-1 lg:block lg:col-span-2">
            <p class="text-sm font-semibold lg:hidden">{{ __('Name') }}</p>
            <a href="{{ route('users.show', ['user' => $user['id']]) }}" wire:navigate title="{{ $user->full_name }}">{{ $user->full_name }}</a>
        </div>
        <div class="grid gap-1 text-sm lg:block lg:col-span-2">
            <p class="font-semibold lg:hidden">{{ __('Username') }}</p>
            <p>{{ $user->username }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:col-span-3 lg:block">
            <p class="font-semibold lg:hidden">{{ __('Email') }}</p>
            <p>{{ $user->email }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('Is admin') }}</p>
            <p>{{ $user->is_admin ? __('Yes') : __('No') }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('Is enabled') }}</p>
            <p>{{ $user->is_enabled ? __('Yes') : __('No') }}</p>
        </div>
        @unless ($user->id === auth()->user()->id)
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('users.edit', ['user' => $user['id']]) }}" title="{{ __('Edit') }}" wire:navigate>
                    <x-icon-pen-to-square class="w-5 h-5 fill-current" />
                </a>
                <livewire:user-delete-button :user="$user" />
            </div>    
        @endunless
    </div>
</x-card>