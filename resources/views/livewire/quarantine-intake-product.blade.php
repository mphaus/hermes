<div 
    class="space-y-1" 
    x-data="QuarantineIntakeProduct"
    x-on:quarantine-intake-created.window="clear"
    x-on:quarantine-intake-cleared.window="clear"
>
    <x-input-label>{{ __('Product') }}</x-input-label>
    <select class="block w-full" x-ref="product"></select>
</div>
