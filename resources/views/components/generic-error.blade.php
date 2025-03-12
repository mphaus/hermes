@props(['message'])

<x-card {{ $attributes->merge(['class' => 'bg-red-100! text-red-500!']) }}>
    {{ $message }}
</x-card>
