@props([
    'params' => null,
])

@use('Illuminate\Support\Js')

<select
    class="w-full"
    x-data="SelectOpportunity({{ Js::from($params) }})"
    x-modelable="value"
    x-effect="checkValue(value)"
    {{ $attributes }}
></select>
