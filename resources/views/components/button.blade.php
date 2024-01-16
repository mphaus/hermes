@props([
    'variant' => '',  
    'href' => '',
    'size' => '',
])

@php
    $classNames = [
        'button', 
        'button-primary' => $variant === 'primary',
        'button-sm' => $size === 'small'
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([...$classNames]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class([...$classNames]) }}>
        {{ $slot }}
    </button>    
@endif

