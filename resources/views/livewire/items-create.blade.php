<x-form 
    wire:submit="save"
    x-data="ItemsCreateForm"
    x-on:submit.prevent="submitting = true"
    x-on:items-created="submitting = false"
>
    <fieldset wire:loading.class="opacity-50 pointer-events-none" wire:target="save">
        <legend>{{ __('Upload file') }}</legend>
        <div class="mt-2 space-y-2 text-sm">
            <p>{{ __('Hermes imports a CSV list of equipment (typically rigging and cabling) into the specified CurrentRMS Opportunity, so it can be checked for stock availability and so it will appear on the Picking List.') }}</p>
            <p>{{ __('Imported CSV files must be four columns; the CurrentRMS "Item id", the associated CurrentRMS "Item name", the "Quantity", and "Group name". Errors are reported below. ') }}</p>
            <p>{{ __('Re-uploads for an Opportunity will overwrite previously uploaded CSVs, including changing counts, removing items that were zeroed out, and adding new items that previously had a zero count. ') }}</p>
            <p>{{ __('Once the upload is complete, items from the CSV will be added to the specified Group, at the bottom of the specified  Opportunity.') }}</p>
        </div>
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
            <span wire:loading.class="hidden" wire:target="save">{{ __('Upload') }}</span>
            <span class="items-center gap-2" wire:loading.flex wire:target="save">
                <x-icon-circle-notch class="w-4 h-4 fill-current animate-spin" />
                <span>{{ __('Processing...') }}</span>
            </span>
        </x-button>
    </div>
    <div class="mt-6 text-sm" wire:loading wire:target="save">
        <p class="font-semibold">{{ __('Now ingesting...') }}</p>
        <p class="mt-1">{!! __('CurrentRMS limits file uploads to a maximum of 60 rows a minute. Most CSV\'s are a few hundred rows, so this can take a few minutes. While you\'re waiting, you are encouraged to <br> <a href="https://wishlist.current-rms.com/c/52-customer-specific-api-throttling-other-api-ideas" class="font-semibold" target="_blank">ask CurrentRMS to increase this limit</a> - "Critical" is an appropriate response, because this limit is quite silly!') !!}</p>
        <p class="mt-2">{{ __('Once the import is complete, the log below will be updated and the equipment list should be added to the Opportunity. Visual confirmation is strongly recommended. ') }}</p>
        <p class="mt-2 font-semibold">{{ __('Leave this tab open until the import is completed.') }}</p>
    </div>
</x-form>
