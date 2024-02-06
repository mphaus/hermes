<x-form wire:submit="save">
    <fieldset>
        <legend>{{ __('Upload file') }}</legend>
        <p class="mt-2 text-sm font-semibold">{{ __('Please select a csv file to upload items to this Job.') }}</p>
        <x-input 
            type="file" 
            class="mt-6" 
            id="csvfile"
            name="csvfile"
            wire:model="csvfile"
        />
        <x-input-error :messages="$errors->get('csvfile')" class="mt-2" />
    </fieldset>
    <div class="flex justify-end mt-6">
        <x-button variant="primary">{{ __('Upload') }}</x-button>
    </div>
</x-form>
