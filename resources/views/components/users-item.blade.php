@props(['user'])

<x-card>
    <div class="grid gap-4 lg:grid-cols-10">
        <div class="grid gap-1 lg:block lg:col-span-2">
            <p class="text-sm font-semibold lg:hidden">{{ __('Name') }}</p>
            <p>{{ $user['full_name'] }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:block lg:col-span-2">
            <p class="font-semibold lg:hidden">{{ __('Username') }}</p>
            <p>{{ $user['username'] }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:col-span-3 lg:block">
            <p class="font-semibold lg:hidden">{{ __('Email') }}</p>
            <p>{{ $user['email'] }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('Is admin') }}</p>
            <p>{{ $user['is_admin'] === 1 ? __('Yes') : __('No') }}</p>
        </div>
        <div class="grid gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('Is enabled') }}</p>
            <p>{{ $user['is_enabled'] === 1 ? __('Yes') : __('No') }}</p>
        </div>
        <div class="flex items-center justify-end gap-4">
            <a href="#" title="{{ __('Edit') }}">
                <x-icon-pen-to-square class="w-5 h-5 fill-current" />
            </a>
            <button type="button" class="text-primary-500 hover:text-primary-600" title="{{ __('Delete') }}">
                <x-icon-trash-can class="w-5 h-5 fill-current" />
            </button>
        </div>
    </div>
</x-card>
