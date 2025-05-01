<x-slot name="title">{{ __('Users') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Users') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('Create, Rename, Update and Delete (CRUD) Hermes system users.') }}</span>
</x-slot>
<div class="flow">
    <header class="flex justify-end">
        <x-button 
            href="{{ route('users.create') }}" 
            variant="primary" 
            wire:loading.class="disabled"
        >
            <x-icon-plus class="w-4 h-4 fill-current" />
            <span>{{ __('Add new') }}</span>
        </x-button>
    </header>
    <section class="mt-8 flow">
        <div wire:loading.block>
            @include('users-skeleton')
        </div>
        @if ($this->users->isNotEmpty())
            <div class="flow" wire:loading.class="hidden">
                <div class="hidden lg:block">
                    <div class="grid items-center grid-cols-10 gap-2 px-6 text-sm font-semibold">
                        <p class="col-span-2">{{ __('Name') }}</p>
                        <p class="col-span-2">{{ __('Username') }}</p>
                        <p class="col-span-3">{{ __('Email') }}</p>
                        <p>{{ __('Is admin') }}</p>
                        <p>{{ __('Is enabled') }}</p>
                        <p class="text-right">{{ __('Actions') }}</p>
                    </div>
                </div>
                @foreach ($this->users as $user)
                    <x-users-item :user="$user" />
                @endforeach
                {{ $this->users->links('pagination') }}
            </div>
        @else
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xs sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __('There are no users to display.') }}
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
