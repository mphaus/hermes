<x-card wire:submit="save">
    <x-form class="flow">
        <p class="font-semibold">{{ __('Upload JSON file') }}</p>
        <x-input 
            type="file" 
            class="mt-6" 
            id="jsonfile"
            name="jsonfile"
            accept=""
            wire:model="jsonfile"
        />
        <x-input-error :messages="$errors->get('jsonfile')" class="mt-2" />
        <div class="space-y-1">
            <x-input-label 
                for="comments"
                value="{{ __('Change notes') }}" 
                class="!text-xs" 
            />
            <x-textarea 
                class="block w-full" 
                rows="3"
                name="comments"
                id="comments"
                wire:model="comments"
            ></x-textarea>
            <x-input-error :messages="$errors->get('comments')" class="mt-2" />
        </div>
        <div class="space-y-2 text-sm">
            <p>{{ __('Once a file has been updated, select it or drag and drop it on the target above. Verify the filename is correct, and enter some Change notes (describing briefly what is different). Click "Upload".') }}</p>
            <p>{{ __('The file will be ingested into Hermes and checked for validity. If valid, subsequent Discussions created will be based on the parameters in the new JSON file.') }}</p>
        </div>
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">
                <span wire:loading.class="hidden" wire:target="save">{{ __('Upload') }}</span>
                <span class="items-center gap-2" wire:loading.flex wire:target="save">
                    <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                    <span>{{ __('Processing...') }}</span>
                </span>
            </x-button>
        </div>
        <div class="mt-6 text-sm" wire:loading wire:target="save">
            <p class="font-semibold">{{ __('Ingesting and verifying...') }}</p>
            <p class="mt-1">{{ __('This process typically takes ???. Do not navigate away from this page until a Success or Fail message is shown here.') }}</p>
        </div>
    </x-form>
</x-card> 
