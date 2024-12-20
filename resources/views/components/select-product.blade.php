@props([
    'multiple' => false
])

@use('Illuminate\Support\Js')

<select 
    class="w-full"
    x-data="SelectProduct({ multiple: {{ Js::from($multiple) }} })"
    x-modelable="value"
    x-effect="checkValue(value)"
    {{ $attributes }}
    @if ($multiple)
        multiple
    @endif
></select>
