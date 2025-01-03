@props([
    'multiple' => false,
])

@use('Illuminate\Support\Js')

<select
    class="w-full"
    x-data="SelectObject({ multiple: {{ Js::from($multiple) }} })"
    {{ $attributes }}
    @if ($multiple)
        multiple
    @endif
></select>
