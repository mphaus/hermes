<x-form class="flow">
    <div class="grid gap-4 md:grid-cols-2">
        <div class="space-y-1">
            <x-input-label for="first-name">{{ __('First name') }}</x-input-label>
            <x-input 
                type="text" 
                name="first_name" 
                id="first-name" 
            />
            {{-- <x-input-error :messages="$errors->get('form.first_name')" /> --}}
        </div>
        <div class="space-y-1">
            <x-input-label for="last-name">{{ __('Last name') }}</x-input-label>
            <x-input 
                type="text" 
                name="last_name" 
                id="last-name" 
            />
            {{-- <x-input-error :messages="$errors->get('form.last_name')" /> --}}
        </div>
    </div>
    <div class="flex items-center justify-end gap-2">
        <x-button href="{{ route('production-administrators.index') }}" variant="outline-primary">{{ __('Cancel') }}</x-button>
        <x-button type="submit" variant="primary">
            {{ __('Add') }}
            {{-- <span>
                @if (request()->routeIs('production-administrator.create'))
                    {{ __('Add') }}
                @else
                    {{ __('Update') }}
                @endif
            </span>
            <span>
                @if (request()->routeIs('production-administrator.create'))
                    {{ __('Adding...') }}
                @else
                    {{ __('Updating...') }}
                @endif
            </span> --}}
        </x-button>
</x-form>
