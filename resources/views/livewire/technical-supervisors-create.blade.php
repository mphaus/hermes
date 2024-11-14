<x-slot name="title">{{ __('Add Technical Supervisor') }}</x-slot>
<x-slot name="heading">{{ __('Add Technical Supervisor') }}</x-slot>
<div>
    <x-card class="max-w-screen-sm mx-auto flow">
        <p class="font-semibold">{{ __('Add Technical Supervisor') }}</p>
        <x-form class="flow">
            <div class="space-y-1">
                <x-input-label for="full-name">{{ __('Full name') }}</x-input-label>
                <x-input type="text" name="full_name" id="full-name" />
            </div>
            <div class="flex justify-end">
                <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
            </div>
        </x-form>
    </x-card>
</div>
