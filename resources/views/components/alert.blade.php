@props(['type'])

<article 
    @class([
        'fixed',
        'z-50',
        'p-4',
        'text-white',
        'rounded',
        'shadow-lg',
        'inset-x-4',
        'bottom-6',
        'sm:left-auto',
        'sm:w-full',
        'sm:max-w-md',
        'bg-green-500' => $type === 'success',
        'bg-red-500' => $type === 'danger',
        'bg-yellow-500' => $type === 'warning',
    ])
    x-data
    x-init="setTimeout(() => $root.remove(), 4000)"
>
    {{ $slot }}
</article>
