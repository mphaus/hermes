@props(['type'])

<article 
    @class([
        'fixed',
        'z-50',
        'p-4',
        'pr-9',
        'text-white',
        'rounded',
        'shadow-lg',
        'inset-x-4',
        'bottom-6',
        'sm:top-4',
        'sm:bottom-auto',
        'sm:left-auto',
        'sm:w-full',
        'sm:max-w-xl',
        'bg-green-500' => $type === 'success',
        'bg-red-500' => $type === 'danger',
        'bg-yellow-500' => $type === 'warning',
    ])
    x-data="Alert"
>
    <button 
        type="button" 
        class="absolute top-2 right-2" 
        title="{{ __('Close') }}"
        x-on:click="close"
    >
        <x-icon-circle-x class="w-5 h-5" />
    </button>
    <div>{{ $slot }}</div>
</article>
