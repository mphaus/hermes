@props(['disabled' => false])

<input 
    type="checkbox"
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'text-primary-500 border-gray-300 rounded shadow-sm focus:ring-primary-500 disabled:pointer-events-none disabled:bg-gray-100/50']) !!}
>
