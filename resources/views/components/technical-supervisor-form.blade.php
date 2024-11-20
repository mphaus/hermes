@props(['message'])

<x-form 
    class="flow" 
    wire:submit="save"
    x-on:submit.prevent="$wire.message = ''"
>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="space-y-1">
            <x-input-label for="first-name">{{ __('First name') }}</x-input-label>
            <x-input 
                type="text" 
                name="first_name" 
                id="first-name" 
                wire:model="form.first_name"
            />
            <x-input-error :messages="$errors->get('form.first_name')" />
        </div>
        <div class="space-y-1">
            <x-input-label for="last-name">{{ __('Last name') }}</x-input-label>
            <x-input 
                type="text" 
                name="last_name" 
                id="last-name" 
                wire:model="form.last_name"
            />
            <x-input-error :messages="$errors->get('form.last_name')" />
        </div>
    </div>
    <div class="flex justify-end">
        <x-button type="submit" variant="primary">
            <span wire:loading.class="hidden" wire:target="save">{{ __('Save') }}</span>
            <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
        </x-button>
    </div>
    @if ($message)
        <x-generic-error :message="$message" x-show="$wire.message" />    
    @endif
</x-form>
