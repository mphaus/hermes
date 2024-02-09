<x-form wire:submit="save" wire:loading.class="opacity-50 pointer-events-none">
    <fieldset>
        <legend>{{ __('Upload file') }}</legend>
        <p class="mt-2 text-sm font-semibold">{{ __('Please select a csv file to upload items to this Job.') }}</p>
        <x-input 
            type="file" 
            class="mt-6" 
            id="csvfile"
            name="csvfile"
            accept=".csv"
            wire:model="csvfile"
        />
        <x-input-error :messages="$errors->get('csvfile')" class="mt-2" />
        <x-input-error :messages="$errors->get('item_process')" class="mt-2" />
    </fieldset>
    <div class="flex justify-end mt-6">
        <x-button variant="primary">
            <span wire:loading.class="hidden">{{ __('Upload') }}</span>
            <span class="items-center gap-2" wire:loading.flex>
                <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                <span>{{ __('Processing...') }}</span>
            </span>
        </x-button>
    </div>
</x-form>
