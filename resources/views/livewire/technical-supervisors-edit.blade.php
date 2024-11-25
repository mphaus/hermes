<x-slot name="title">{{ __('Edit Technical Supervisor') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Edit Technical Supervisor name') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
</x-slot>
<div>
    @if ($error)
        <x-generic-error :message="$error" />
    @elseif ($technical_supervisor === null) 
        <x-card>
            <p>{{ __('There\'s no Technical Supervisor to edit.') }}</p>
        </x-card>
    @else
        <x-card class="max-w-screen-sm mx-auto flow">
            <p class="font-semibold">{{ __('Edit Techical Supervisor') }}</p>
            <x-technical-supervisor-form :message="$message" />
        </x-card>
    @endif
</div>
