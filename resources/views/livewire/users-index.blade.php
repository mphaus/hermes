<x-slot name="title">{{ __('Users') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Users') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('New users can be created and exiting users edited (or deleted) here.') }}</span>
</x-slot>
<div class="flow">
    <header class="flex justify-end">
        <x-button href="#" variant="primary">
            <x-icon-plus class="w-4 h-4 fill-current" />
            <span>{{ __('Create user') }}</span>
        </x-button>
    </header>
    <section class="flow">
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
                        <p>{{ $user['is_admin'] }}</p>
                    </div>
                    <div class="grid gap-1 text-sm lg:block">
                        <p class="font-semibold lg:hidden">{{ __('Is enabled') }}</p>
                        <p>{{ $user['is_enabled'] }}</p>
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
        @endforeach
    </section>
</div>
