@props([
    'multiple' => false
])

@use('Illuminate\Support\Js')

<select 
    class="w-full"
    x-data="SelectProduct({ multiple: {{ Js::from($multiple) }} })"
    {{ $attributes }}
></select>
