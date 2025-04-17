<x-layout-app>
    <x-slot name="title">{{ __('Edit Production Administrator') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Edit Production Administrator name') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
    </x-slot>
    <div>
        {{ dd(request()->route('id')) }}
    </div>
</x-layout-app>
