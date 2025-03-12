<div 
    class="fixed inset-0 z-30 hidden bg-gray-900/50 max-xl:data-open:block"
    x-data="{ open: false }"
    x-on:hermes:toggle-side-menu.window="open = $event.detail.open"
    x-bind:data-open="open"
    x-on:click="open = false; $dispatch('hermes:toggle-side-menu', { open: false });"
    x-on:keyup.escape.document="open = false; $dispatch('hermes:toggle-side-menu', { open: false });"
></div>
