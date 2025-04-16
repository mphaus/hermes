<x-form 
    action="{{ route('production-administrators.store') }}"
    method="POST"
    class="flow"
    x-data="ProductionAdministratorForm"
    x-on:submit.prevent="send"
    novalidate {{-- TODO: remove this attribute --}}
>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="space-y-1">
            <x-input-label for="first-name">{{ __('First name') }}</x-input-label>
            <x-input 
                type="text" 
                name="first_name" 
                id="first-name" 
                required
                x-model="form.first_name"
            />
            <template hidden x-if="errors.first_name">
                <p class="text-sm text-red-600" x-text="errors.first_name"></p>
            </template>
        </div>
        <div class="space-y-1">
            <x-input-label for="last-name">{{ __('Last name') }}</x-input-label>
            <x-input 
                type="text" 
                name="last_name" 
                id="last-name" 
                required
                x-model="form.last_name"
            />
            <template hidden x-if="errors.last_name">
                <p class="text-sm text-red-600" x-text="errors.last_name"></p>
            </template>
        </div>
    </div>
    <div class="flex items-center justify-end gap-2">
        <x-button href="{{ route('production-administrators.index') }}" variant="outline-primary">{{ __('Cancel') }}</x-button>
        <x-button type="submit" variant="primary">
            @if (request()->routeIs('production-administrators.create'))
                <span x-show="!submitting">{{ __('Add') }}</span>
                <span x-cloak x-show="submitting">{{ __('Adding...') }}</span>
            @endif
        </x-button>
</x-form>
