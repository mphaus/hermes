@props(['disabled' => false])

<textarea
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 rounded-md shadow-xs focus:border-primary-500 focus:ring-primary-500 block w-full']) !!}
>{{ $slot }}</textarea>
