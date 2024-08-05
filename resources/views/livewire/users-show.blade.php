<x-slot name="title">{{ $user->full_name }}</x-slot>
<x-slot name="heading">{{ $user->full_name }}</x-slot>
<x-card @class([
    'max-w-screen-md mx-auto',
    'grid gap-4 md:grid-cols-2' => !$user->is_admin,
    'space-y-4' => $user->is_admin,
])>
    <section class="flow">
        <div class="space-y-1">
            <p class="text-sm font-semibold">{{ __('Username:') }}</p>
            <p>{{ $user->username }}</p>
        </div>
        <div class="space-y-1">
            <p class="text-sm font-semibold">{{ __('Email:') }}</p>
            <p>{{ $user->email }}</p>
        </div>
        <div class="space-y-1">
            <p class="text-sm font-semibold">{{ __('Is admin:') }}</p>
            <p>{{ $user->is_admin ? __('Yes') : __('No') }}</p>
        </div>
        <div class="space-y-1">
            <p class="text-sm font-semibold">{{ __('Is enabled:') }}</p>
            <p>{{ $user->is_enabled ? __('Yes') : __('No') }}</p>
        </div>
    </section>
    @unless ($user->is_admin)
        <section class="space-y-1">
            <p class="text-sm font-semibold">{{ __('Function access:') }}</p>
            <ul class="space-y-1">
                @foreach ($user->permissions as $permission)
                    <li>{{ $this->getPermission($permission) }}</li>
                @endforeach
            </ul>
        </section>    
    @endunless
    <section @class([
        'flex items-center justify-end gap-4',
        'md:col-span-2' => !$user->is_admin
    ])>
        <a href="#" title="{{ __('Edit') }}">
            <x-icon-pen-to-square class="w-5 h-5 fill-current" />
        </a>
        <button type="button" class="text-primary-500 hover:text-primary-600" title="{{ __('Delete') }}">
            <x-icon-trash-can class="w-5 h-5 fill-current" />
        </button>
    </section>
</x-card>
