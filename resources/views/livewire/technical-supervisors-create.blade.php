<x-slot name="title">{{ __('Add Technical Supervisor') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Add new Technical Supervisor name') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
</x-slot>
<div>
    <x-card class="max-w-screen-sm mx-auto flow">
        <p class="font-semibold">{{ __('Technical Supervisor') }}</p>
        <x-technical-supervisor-form :message="$message" />
    </x-card>
</div>
