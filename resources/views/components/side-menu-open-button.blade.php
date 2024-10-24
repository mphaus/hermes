<x-button 
    type="button" 
    variant="primary" 
    class="fixed bottom-0 right-0 z-20 p-3 mb-3 mr-3 rounded-full shadow-lg xl:hidden"
    x-data
    x-on:click="$dispatch('hermes:toggle-side-menu', { open: true })"
>
    <x-icon-menu class="w-6 h-6" />
</x-button>
