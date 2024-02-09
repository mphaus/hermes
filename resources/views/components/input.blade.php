@props(['disabled' => false])

@if ($attributes->has('type') && $attributes->get('type') === 'file')
    <input 
        type="file"
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'cursor-pointer block w-full rounded-lg [&::file-selector-button]:bg-primary-500 [&::file-selector-button]:text-white [&::file-selector-button]:hover:bg-primary-600 [&::file-selector-button]:focus:bg-primary-600 [&::file-selector-button]:active:bg-primary-600 [&::file-selector-button]:border-none [&::file-selector-button]:cursor-pointer [&::file-selector-button]:px-4 [&::file-selector-button]:py-2 [&::file-selector-button]:leading-4 bg-gray-50 border-gray-400']) !!}
    >
@else
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm']) !!}>
@endif

