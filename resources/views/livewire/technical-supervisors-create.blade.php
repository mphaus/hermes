<x-slot name="title">{{ __('Add Technical Supervisor') }}</x-slot>
<x-slot name="heading">
    <span>{{ __('Add new Technical Supervisor name') }}</span>
    <span class="block mt-2 text-sm font-normal">{{ __('Double check the spelling of the name') }}</span>
</x-slot>
<div>
    <x-card class="max-w-screen-sm mx-auto flow">
        <p class="font-semibold">{{ __('Technical Supervisor') }}</p>
        <x-form class="flow">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <x-input-label for="first-name">{{ __('First name') }}</x-input-label>
                    <x-input type="text" name="first_name" id="first-name" />
                </div>
                <div class="space-y-1">
                    <x-input-label for="last-name">{{ __('Last name') }}</x-input-label>
                    <x-input type="text" name="last_name" id="last-name" />
                </div>
            </div>
            <div class="flex justify-end">
                <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
            </div>
        </x-form>
    </x-card>
</div>
